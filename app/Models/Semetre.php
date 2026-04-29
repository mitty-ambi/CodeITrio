<?php
namespace App\Models;
use CodeIgniter\Model;

class Semetre extends Model
{
    protected $table = "SemetreFIlle";
    protected $primaryKey = 'id_fille';
    protected $allowedFields = ['id_mere', 'id_matiere'];
    protected $useTimestamps = false;
}
?>