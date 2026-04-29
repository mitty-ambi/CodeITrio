<?php
namespace App\Models;
class CRUDEleves extends Eleves
{
    public function createEleve($data)
    {
        return $this->insert($data);
    }

    public function updateEleve($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteEleve($id)
    {
        return $this->delete($id);
    }
}


?>