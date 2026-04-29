<?php
namespace App\Models;
use CodeIgniter\Model;

class Note extends Model
{
    protected $table = "Note";
    protected $primaryKey = 'id_note';
    protected $allowedFields = ['valeur', 'id_eleve', 'id_matiere'];
    protected $useTimestamps = false;
}
?>