<?php
namespace App\Models;

use CodeIgniter\Database\Config;

class Eleves 
{
    protected $db;
    protected $table = "Eleves";
    protected $primaryKey = 'id';
    protected $allowedFields = ['Matricule', 'Nom', 'Prenom', 'Parcours'];
    protected $useTimestamps = false;

    public function __construct()
    {
        
        $this->db = Config::connect();
    }

    // Votre méthode getAll
    public function getAll()
    {
        $builder = $this->db->table($this->table);
        $query = $builder->get();
        return $query->getResultArray();
    }
    public function findbyid($id)
    {
        $builder = $this->db->table($this->table);
        $builder->where($this->primaryKey, $id);
        $query = $builder->get();
        return $query->getRowArray();
    }
    
    public function delete($id)
    {
        $builder = $this->db->table($this->table);
        $builder->where($this->primaryKey, $id);
        return $builder->delete();
    }
    public function findbycritere($critere)
    {
        $builder = $this->db->table($this->table);
        $builder->like('Matricule', $critere);
        $builder->orLike('Nom', $critere);
        $builder->orLike('Prenom', $critere);
        $builder->orLike('Parcours', $critere);
        $query = $builder->get();
        return $query->getResultArray();
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

