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

    public function dashboardMetrics(): array
    {
        $metrics = [
            'total_eleves' => 0,
            'moyenne_par_semestre' => [],
            'taux_reussite' => 0,
            'distribution_intervalles' => [],
            'donnees_par_filiere' => [],
            'moyenne_par_ue' => [],
        ];

        try {
            $all = $this->getAll();
            $metrics['total_eleves'] = is_array($all) ? count($all) : 0;

            
            $builder = $this->db->table($this->table);
            $builder->select('Parcours, COUNT(*) as count')->groupBy('Parcours');
            $rows = $builder->get()->getResultArray();
            foreach ($rows as $r) {
                $metrics['donnees_par_filiere'][$r['Parcours']] = (int) $r['count'];
            }

            $note = new \App\Models\Note();
            $intervals = [
                '0-5' => [0,5],
                '5-10' => [5,10],
                '10-12' => [10,12],
                '12-14' => [12,14],
                '14-16' => [14,16],
                '16-20' => [16,20],
            ];
            foreach ($intervals as $label => [$min, $max]) {
                $metrics['distribution_intervalles'][$label] = (int) $note->nombreEtudiantsIntervalle(null, $min, $max);
            }

            $metrics['moyenne_par_semestre'] = $note->moyenneGeneraleParSemestre();
            $metrics['moyenne_par_ue'] = $note->moyenneParUE();
            $metrics['taux_reussite'] = $note->tauxReussiteGlobal();

        } catch (\Exception $e) {
        }

        return $metrics;
    }
}


?>