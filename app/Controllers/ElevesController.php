<?php


namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CRUDEleves;
class ElevesController extends BaseController{
    public function index(){
        $q = trim((string) $this->request->getGet('q'));
        $crudEleves = new CRUDEleves();
        $eleves = $crudEleves->getEleves($q);

        return view('list', [
            'eleves' => $eleves,
            'q' => $q,
            'message' => session('message'),
        ]);
    }

    public function create(){
        return view('createeleve', ['message' => session('message')]);
    }
    public function store(){
        $nom = $this->request->getPost('nom');
        $prenom = $this->request->getPost('prenom');
        $matricule = $this->request->getPost('matricule');
        $parcours = $this->request->getPost('parcours');
        $data = [
            'Nom' => $nom,
            'Prenom' => $prenom,
            'Matricule' => $matricule,
            'Parcours' => $parcours
        ];
        $crudEleves = new CRUDEleves();
        $inserted = $crudEleves->createEleve($data);

        if ($inserted === false) {
            return redirect()->back()->withInput()->with('message', 'Erreur lors de la creation de l\'eleve.');
        }
        
        return redirect()->to('/eleve/success');
    }
    public function success(){
        return view('createeleve', ['message' => 'Élève créé avec succès !']);
    }
    public function update($id){
        $crudEleves = new CRUDEleves();
        $eleve = $crudEleves->find($id);
        if (!$eleve) {
            return redirect()->back()->with('message', 'Élève non trouvé.');
        }
        return view('update', ['eleve' => $eleve, 'message' => session('message')]);
    }
    public function updateStore($id){
        $nom = $this->request->getPost('nom');
        $prenom = $this->request->getPost('prenom');
        $matricule = $this->request->getPost('matricule');
        $parcours = $this->request->getPost('parcours');
        $data = [
            'Nom' => $nom,
            'Prenom' => $prenom,
            'Matricule' => $matricule,
            'Parcours' => $parcours
        ];
        $crudEleves = new CRUDEleves();
        $updated = $crudEleves->updateEleve($id, $data);

        if ($updated === false) {
            return redirect()->back()->withInput()->with('message', 'Erreur lors de la mise à jour de l\'élève.');
        }
        return redirect()->to('/eleve/success');
    }

    public function delete($id){
        $crudEleves = new CRUDEleves();
        $deleted = $crudEleves->deleteEleve((int) $id);

        if ($deleted === false) {
            return redirect()->to('/eleves')->with('message', 'Erreur lors de la suppression de l\'eleve.');
        }

        return redirect()->to('/eleves')->with('message', 'Eleve supprime avec succes.');
    }
    public function dashboard(){
        $crudEleves = new CRUDEleves();
        $metrics = $crudEleves->dashboardMetrics();

        return view('dashboard', ['metrics' => $metrics]);
    }
}
?>