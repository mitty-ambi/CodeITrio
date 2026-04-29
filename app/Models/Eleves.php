<?php
namespace App\Models;
use CodeIgniter\Model;

class Eleves extends Model
{
    protected $table = "Eleves";
    protected $primaryKey = 'id';
    protected $allowedFields = ['Matricule', 'Nom', 'Prenom', 'Parcours'];
    protected $useTimestamps = false;
    
}
?>