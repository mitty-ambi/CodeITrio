<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CRUDEleves;
use App\Models\Note;

class ElevesController extends BaseController
{
    public function index()
    {
        $q = trim((string) $this->request->getGet('q'));
        $crudEleves = new CRUDEleves();

        return view('List_eleve', [
            'eleves' => $crudEleves->getEleves($q),
            'q' => $q,
            'message' => session('message'),
        ]);
    }

    public function create()
    {
        return view('createeleve', ['message' => session('message')]);
    }

    public function store()
    {
        $data = [
            'Nom' => $this->request->getPost('nom'),
            'Prenom' => $this->request->getPost('prenom'),
            'Matricule' => $this->request->getPost('matricule'),
            'Parcours' => $this->request->getPost('parcours'),
        ];

        $crudEleves = new CRUDEleves();
        $inserted = $crudEleves->createEleve($data);

        if ($inserted === false) {
            return redirect()->back()->withInput()->with('message', 'Erreur lors de la creation de l\'eleve.');
        }

        return redirect()->to('/eleve/success');
    }

    public function notesEleve($id_eleve = 1)
    {
        $db = \Config\Database::connect();
        $eleve = $db->table('Eleves')->where('id', $id_eleve)->get()->getRowArray();

        if (!$eleve) {
            return redirect()->to('/eleve')->with('message', 'Élève non trouvé');
        }

        $noteModel = new Note();
        $notes = $noteModel->getNotesByEleve($id_eleve);
        $notesBySemestre = [];

        foreach ($notes as $note) {
            $semestre = $note['semestre'] ?? 'Sans semestre';
            $notesBySemestre[$semestre][] = $note;
        }

        $moyennesBySemestre = [];
        foreach ($notesBySemestre as $semestre => $listeNotes) {
            $sommeTotal = 0;
            $sommeCreditTotal = 0;

            foreach ($listeNotes as $note) {
                $valeur = (float) ($note['valeur'] ?? 0);
                $credit = (float) ($note['credit'] ?? 0);
                $sommeTotal += $valeur * $credit;
                $sommeCreditTotal += $credit;
            }

            $moyennesBySemestre[$semestre] = $sommeCreditTotal > 0 ? $sommeTotal / $sommeCreditTotal : 0;
        }

        return view('liste_notes', [
            'eleve' => $eleve,
            'notesBySemestre' => $notesBySemestre,
            'moyennesBySemestre' => $moyennesBySemestre,
        ]);
    }

    public function success()
    {
        return view('createeleve', ['message' => 'Élève créé avec succès !']);
    }

    public function update($id)
    {
        $crudEleves = new CRUDEleves();
        $eleve = $crudEleves->find($id);

        if (!$eleve) {
            return redirect()->to('/eleve')->with('message', 'Élève non trouvé.');
        }

        return view('update', [
            'eleve' => $eleve,
            'message' => session('message'),
        ]);
    }

    public function updateStore($id)
    {
        $data = [
            'Nom' => $this->request->getPost('nom'),
            'Prenom' => $this->request->getPost('prenom'),
            'Matricule' => $this->request->getPost('matricule'),
            'Parcours' => $this->request->getPost('parcours'),
        ];

        $crudEleves = new CRUDEleves();
        $updated = $crudEleves->updateEleve($id, $data);

        if ($updated === false) {
            return redirect()->back()->withInput()->with('message', 'Erreur lors de la mise à jour de l\'élève.');
        }

        return redirect()->to('/eleve');
    }

    public function delete($id)
    {
        $crudEleves = new CRUDEleves();
        $deleted = $crudEleves->deleteEleve((int) $id);

        if ($deleted === false) {
            return redirect()->to('/eleve')->with('message', 'Erreur lors de la suppression de l\'eleve.');
        }

        return redirect()->to('/eleve')->with('message', 'Eleve supprime avec succes.');
    }
}