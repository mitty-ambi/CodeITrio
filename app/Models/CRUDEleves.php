<?php
namespace App\Models;
class CRUDEleves extends Eleves
{
    public function createEleve($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function updateEleve($id, $data)
    {
        $builder = $this->db->table($this->table);
        $builder->where($this->primaryKey, $id);
        return $builder->update($data);
    }

    public function deleteEleve($id)
    {
        return $this->delete($id);
    }

    public function find($id)
    {
        return $this->findbyid($id);
    }

    public function getEleves(string $q = ''): array
    {
        if ($q !== '') {
            return $this->findbycritere($q);
        }

        return $this->getAll();
    }
}


?>