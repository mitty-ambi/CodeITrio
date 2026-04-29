<?php
namespace App\Models;
use CodeIgniter\Model;

class Note extends Model
{
    protected $table = "Note";
    protected $primaryKey = 'id_note';
    protected $allowedFields = ['valeur', 'id_eleve', 'id_matiere'];
    protected $useTimestamps = false;

    public function getNotesByEleve($id_eleve)
    {
        $db = \Config\Database::connect();

        return $db->table('Note as n')
            ->select('n.valeur, m.codeMatiere, m.nom, m.credit, m.id_UE, u.nom as ue_nom, s.id_semestre, s.nom as semestre')
            ->join('Matiere as m', 'n.id_matiere = m.id_matiere', 'left')
            ->join('UE as u', 'm.id_UE = u.id', 'left')
            ->join('SemestreFille as sf', 'm.id_matiere = sf.id_matiere', 'left')
            ->join('Semestre as s', 'sf.id_mere = s.id_semestre', 'left')
            ->where('n.id_eleve', $id_eleve)
            ->orderBy('s.id_semestre', 'ASC')
            ->orderBy('u.nom', 'ASC')
            ->orderBy('n.valeur', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getNotesByEleveGroupedByUE($id_eleve)
    {
        $notes = $this->getNotesByEleve($id_eleve);

        $notesByUE = [];
        $processedUE = [];

        foreach ($notes as $note) {
            $ue_id = $note['id_UE'] ?? 'autres';
            $semestre = $note['semestre'] ?? 'Non défini';

            $ue_key = $semestre . '_' . $ue_id;

            if (!in_array($ue_key, $processedUE)) {
                if (!isset($notesByUE[$semestre])) {
                    $notesByUE[$semestre] = [];
                }
                $notesByUE[$semestre][] = $note;
                $processedUE[] = $ue_key;
            }
        }

        return $notesByUE;
    }
}
?>