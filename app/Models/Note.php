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
            ->select('n.valeur, m.codeMatiere, m.nom, m.credit, s.id_semestre, s.nom as semestre')
            ->join('Matiere as m', 'n.id_matiere = m.id_matiere', 'left')
            ->join('SemestreFille as sf', 'm.id_matiere = sf.id_matiere', 'left')
            ->join('Semestre as s', 'sf.id_mere = s.id_semestre', 'left')
            ->where('n.id_eleve', $id_eleve)
            ->orderBy('s.id_semestre', 'ASC')
            ->orderBy('m.codeMatiere', 'ASC')
            ->get()
            ->getResultArray();
    }
}
?>