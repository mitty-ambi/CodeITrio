Projet notes to_do:
- Liste des eleves(dave et alan):
## affichage :
. listes des eleves pagines (on peut defiler les pages)(dave)
. filtre par nom, par matricule, par classe(dave)
. actions de crud (creer, delete et modifier)(alan)

- (ok)creation d'eleves(alan)
## affichage :
. (ok)formulaire de creation d'une eleve
. (ok)validation
## service :
. ElevesController::create() -> affiche le formulaire
. ElevesController::store() -> recupere nom/prenom/matricule/parcours puis insert
. ElevesController::success() -> affiche le message de succes
. CRUDEleves::createEleve($data) -> insert dans la table Eleves
## routage lie :
. GET /eleve/create -> ElevesController::create
. POST /eleve/create -> ElevesController::store
. GET /eleve/success -> ElevesController::success
## vues :
. app/Views/createeleve.php

- modification d'eleves(alan)
## affichage :
. affichage de l'eleve en question(alan)
. formulaire avec champ predefinis
. validation
## service :
. ElevesController::update($id) -> charge un eleve par id et affiche le formulaire
. ElevesController::updateStore($id) -> recupere les champs puis update en base
. CRUDEleves::updateEleve($id, $data) -> update dans la table Eleves
## routage lie :
. GET /eleve/update/(:num) -> ElevesController::update/$1
. POST /eleve/update/(:num) -> ElevesController::updateStore/$1
## vues :
. app/Views/update.php

- notes par eleves(ambinintsoa)
## affichage : 
. a propos de l'eleve
. notes par semestre
. filtre de semestre
. filtre de matiere

- dashboard(alan)
## affichage :
- nombres d'eleves 
- moyenne generale par semestre
- taux de reussite
- nombre etudiants par intervalle de notes
- donnees par filiere
- moyenne par ue