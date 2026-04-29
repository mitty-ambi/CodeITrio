<?php

namespace App\Controllers;
error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\Controllers\BaseController;
use App\Models\CRUDEleves;
use App\Models\Eleves;
use App\Models\Matiere;
use App\Models\Note;

class ElevesController extends BaseController
{
    public function create()
    {
        return view('createeleve');
    }
    public function store()
    {
        $nom = $this->request->getPost('nom');
        $prenom = $this->request->getPost('prenom');
        $matricule = $this->request->getPost('matricule');
        $parcours = $this->request->getPost('parcours');
        $data = [
            'nom' => $nom,
            'prenom' => $prenom,
            'matricule' => $matricule,
            'parcours' => $parcours
        ];
        $crudEleves = new CRUDEleves();
        $crudEleves->createEleve($data);

        return redirect()->to('/eleve/success');
    }
    public function notesEleve($id_eleve = 1)
    {
        $db = \Config\Database::connect();
        $eleve = $db->table('Eleves')->where('id', $id_eleve)->get()->getRowArray();

        if (!$eleve) {
            return redirect()->to('/')->with('error', 'Élève non trouvé');
        }

        $noteModel = new Note();
        $notesBySemestre = $noteModel->getNotesByEleveGroupedByUE($id_eleve);

        // Calculer les moyennes
        $eleveModel = new Eleves();
        $eleveModel->id = $id_eleve;
        $moyennesBySemestre = [];
        foreach (array_keys($notesBySemestre) as $semestre) {
            $moyennesBySemestre[$semestre] = $eleveModel->MoyenneEleve($semestre);
        }

        return view('liste_notes', [
            'eleve' => $eleve,
            'notesBySemestre' => $notesBySemestre,
            'moyennesBySemestre' => $moyennesBySemestre
        ]);
    }
}

?>