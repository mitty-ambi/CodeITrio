<?php
namespace App\Models;
use CodeIgniter\Model;

class Matiere extends Model
{
    protected $table = "Matiere";
    protected $primaryKey = 'id_matiere';
    protected $allowedFields = ['codeMatiere', 'nom', 'credit'];
    protected $useTimestamps = false;

}
?>