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
    public function getNotes($id_eleve)
    {
        $noteModel = new Note();
        return $noteModel->getNotesByEleve($id_eleve);
    }

    public function MoyenneEleve($id_eleve, $semestre)
    {
        $noteModel = new Note();
        $notes = $noteModel->getNotesByEleve($id_eleve);

        $sommeTotal = 0;
        $sommeCreditTotal = 0;

        foreach ($notes as $note) {
            if (($note['semestre'] ?? null) !== $semestre) {
                continue;
            }

            $sommeTotal += (float) ($note['valeur'] ?? 0) * (float) ($note['credit'] ?? 0);
            $sommeCreditTotal += (float) ($note['credit'] ?? 0);
        }

        return $sommeCreditTotal > 0 ? $sommeTotal / $sommeCreditTotal : 0;
    }
}

?>

