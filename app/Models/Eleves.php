<?php
namespace App\Models;
use CodeIgniter\Model;

class Eleves extends Model
{
    protected $table = "Eleves";
    protected $primaryKey = 'id';
    protected $allowedFields = ['Matricule', 'Nom', 'Prenom', 'Parcours'];
    protected $useTimestamps = false;

    public function getNotes()
    {
        $noteModel = new Notes();
        $notes = $noteModel->where('id_eleve', $this->id)->findAll();

        $result = [];
        foreach ($notes as $note) {
            $matiere = $note->getMatiere();
            $result[$matiere->codeMatiere] = $note->valeur;
        }

        return $result;
    }
    public function MoyenneEleve($semestre)
    {
        $noteModel = new Note();
        $notes = $noteModel->getNotesByEleveGroupedByUE($this->id);

        $sommeTotal = 0;
        $sommeCreditTotal = 0;

        if (isset($notes[$semestre])) {
            foreach ($notes[$semestre] as $note) {
                $sommeTotal += $note['valeur'] * $note['credit'];
                $sommeCreditTotal += $note['credit'];
            }
        }

        return $sommeCreditTotal > 0 ? $sommeTotal / $sommeCreditTotal : 0;
    }
}
?>