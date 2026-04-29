<?php
class CRUDEleves extends Eleves
{
    public function createEleve($data)
    {
        return self::create($data);
    }

    public function updateEleve($id, $data)
    {
        $eleve = self::find($id);
        if ($eleve) {
            $eleve->update($data);
            return $eleve;
        }
        return null;
    }

    public function deleteEleve($id)
    {
        $eleve = self::find($id);
        if ($eleve) {
            return $eleve->delete();
        }
        return false;
    }
}


?>