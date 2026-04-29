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
    }
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

