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
        $liste_notes = new Note();
        return $liste_notes->where("id_eleve", $this->id)->where("id")->findAll();
    }
    public function getNotesBySemestre($semestreNom)
    {
        $notes = $this->getNotes();
        $result = [];

        foreach ($notes as $note) {
            $semestre = $note->getSemestre();
            if ($semestre && $semestre->nom === $semestreNom) {
                $result[] = $note;
            }
        }

        return $result;
    }
}
?>