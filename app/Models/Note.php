<?php
namespace App\Models;
use CodeIgniter\Model;

class Note extends Model
{
protected $table = "Note";
protected $primaryKey = 'id_note';
protected $allowedFields = ['valeur', 'id_eleve', 'id_matiere'];
protected $useTimestamps = false;

public function getNotesByEleve($id_eleve)
{
$db = \Config\Database::connect();

return $db->table('Note as n')
->select('n.valeur, m.codeMatiere, m.nom, m.credit, m.id_UE, u.nom as ue_nom, s.id_semestre, s.nom as semestre')
->join('Matiere as m', 'n.id_matiere = m.id_matiere', 'left')
->join('UE as u', 'm.id_UE = u.id', 'left')
->join('SemestreFille as sf', 'm.id_matiere = sf.id_matiere', 'left')
->join('Semestre as s', 'sf.id_mere = s.id_semestre', 'left')
->where('n.id_eleve', $id_eleve)
->orderBy('s.id_semestre', 'ASC')
->orderBy('u.nom', 'ASC')
->orderBy('n.valeur', 'DESC')
->get()
->getResultArray();
}

public function getNotesByEleveGroupedByUE($id_eleve)
{
$notes = $this->getNotesByEleve($id_eleve);

$notesByUE = [];
$processedUE = [];

foreach ($notes as $note) {
$ue_id = $note['id_UE'] ?? 'autres';
$semestre = $note['semestre'] ?? 'Non défini';

// Créer la clé unique pour chaque UE
$ue_key = $semestre . '_' . $ue_id;

// Afficher la meilleure note pour chaque UE (première de la liste après ORDER BY DESC)
if (!in_array($ue_key, $processedUE)) {
if (!isset($notesByUE[$semestre])) {
$notesByUE[$semestre] = [];
}
$notesByUE[$semestre][] = $note;
$processedUE[] = $ue_key;
}
}

return $notesByUE;
}

public function getNotesMoyenneBySemestre($semestreNom)
{
$builder = $this->db->table($this->table);
$builder->select('AVG(valeur) as moyenne');
$builder->join('Matiere', 'Note.id_matiere = Matiere.id_matiere');
if (!empty($this->id)) {
$builder->where('id_eleve', $this->id);
}
$builder->where('Matiere.semestre', $semestreNom);
$query = $builder->get();
$row = $query->getRow();
return $row && isset($row->moyenne) ? $row->moyenne : null;
}

public function getmoyennebyue($ueNom)
{
$builder = $this->db->table($this->table);
$builder->select('AVG(valeur) as moyenne');
$builder->join('Matiere', 'Note.id_matiere = Matiere.id_matiere');
if (!empty($this->id)) {
$builder->where('id_eleve', $this->id);
}
$builder->where('Matiere.ue', $ueNom);
$query = $builder->get();
$row = $query->getRow();
return $row && isset($row->moyenne) ? $row->moyenne : null;
}

public function nombreEtudiantsIntervalle($semestreNom, $min, $max)
{
$builder = $this->db->table($this->table);
$builder->select('COUNT(DISTINCT id_eleve) as nombre_etudiants');
$builder->join('Matiere', 'Note.id_matiere = Matiere.id_matiere');
if ($semestreNom !== null) {
$builder->where('Matiere.semestre', $semestreNom);
}
$builder->where('valeur >=', $min);
$builder->where('valeur <=', $max);
$query = $builder->get();
$row = $query->getRow();
return $row && isset($row->nombre_etudiants) ? (int) $row->nombre_etudiants : 0;
}

public function moyenneGeneraleParSemestre(): array
{
$builder = $this->db->table($this->table);
$builder->select('Matiere.semestre as semestre, AVG(valeur) as moyenne');
$builder->join('Matiere', 'Note.id_matiere = Matiere.id_matiere', 'left');
$builder->groupBy('Matiere.semestre');
$rows = $builder->get()->getResultArray();
$out = [];
foreach ($rows as $r) {
$out[$r['semestre'] ?? 'N/A'] = round((float) $r['moyenne'], 2);
}
return $out;
}

public function moyenneParUE(): array
{
$builder = $this->db->table($this->table);
$builder->select('Matiere.ue as ue, AVG(valeur) as moyenne');
$builder->join('Matiere', 'Note.id_matiere = Matiere.id_matiere', 'left');
$builder->groupBy('Matiere.ue');
$rows = $builder->get()->getResultArray();
$out = [];
foreach ($rows as $r) {
$out[$r['ue'] ?? 'N/A'] = round((float) $r['moyenne'], 2);
}
return $out;
}

public function tauxReussiteGlobal(float $seuil = 10.0): float
{
$builder = $this->db->table($this->table);
$builder->select('id_eleve, AVG(valeur) as avg_note');
$builder->groupBy('id_eleve');
$rows = $builder->get()->getResultArray();
$total = count($rows);
if ($total === 0) return 0.0;
$passed = 0;
foreach ($rows as $r) {
if ((float) $r['avg_note'] >= $seuil) $passed++;
}
return round($passed / $total * 100, 1);
}
}
?>
