<?php


namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CRUDEleves;
class ElevesController extends BaseController{
    public function create(){
        return view('createeleve');
    }
    public function store(){
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
    public function success(){
        return view('createelve', ['message' => 'Élève créé avec succès !']);
    }
}

?>