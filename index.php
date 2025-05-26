<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/core/Router.php';

$router = new Router();

// Middleware to protect routes
if (!AuthController::isAuthenticated()) {
    $router->get('/', [AuthController::class, 'redirectToLogin']);
    $router->get('/login', [AuthController::class, 'redirectToLogin']);
    $router->post('/check', [AuthController::class, 'login']);
}
 elseif (!empty($_SESSION['blocked']) && $_SESSION['blocked'] == 1) {
    $router->get('/', [AuthController::class, 'redirectToLogin']);
    $router->get('/login', [AuthController::class, 'redirectToLogin']);
    $router->post('/check', [AuthController::class, 'login']);
    $router->get('/', [AuthController::class, 'redirectToLogin']);
    $router->get('/blocked', [AuthController::class, 'redirectToLogin']);
}
 else {
    if($_SESSION['role'] == 'gestionnaire') {

        $router->get('/', [DashboardController::class, 'index']);
        $router->get('/dashboard', [DashboardController::class, 'index']);
        $router->get('/absence/addView', [AbsenceController::class, 'addView']);
        $router->get('/absence/gestionnaireView', [AbsenceController::class, 'gestionnaireView']);
        $router->get('/absence/groupDetails', [AbsenceController::class, 'groupDetails']);
        $router->get('/absence/stagiare/details', [AbsenceController::class, 'detailsView']);
        $router->get('/absence/justifyAll', [AbsenceController::class, 'justifyAllAbsences']);
        $router->post('/absence/create', [AbsenceController::class, 'createAbsences']);

         // gestion seances
        $router->get('/seance', [SeanceController::class, 'seanceView']);
        $router->get('/seance/delete', [SeanceController::class, 'deleteSeance']);
        $router->get('/seance/details', [SeanceController::class, 'detailsView']);

        // Gestion Stagiaires
        $router->get('/stagiaire', [StagiaireController::class, 'stagiaireView']);
        $router->get('/stagiaire/listStagiaires', [StagiaireController::class, 'listStagiaires']);
        $router->get('/stagiaire/downloadModelCanva', [StagiaireController::class, 'downloadModelCanva']);
        $router->post('/stagiaire/importModelCanva', [StagiaireController::class, 'importModelCanva']);

        $router->get('/group', [AuthController::class, 'unauthorizedPage']);
        $router->get('/enseignant', [AuthController::class, 'unauthorizedPage']);
        $router->get('/users', [AuthController::class, 'unauthorizedPage']);
        $router->get('/secteur', [AuthController::class, 'unauthorizedPage']);
        $router->get('/filiere', [AuthController::class, 'unauthorizedPage']);
        $router->get('/module', [AuthController::class, 'unauthorizedPage']);


        $router->get('/logout', [AuthController::class, 'logout']);
    }else{
    $router->get('/', [DashboardController::class, 'index']);
    $router->get('/dashboard', [DashboardController::class, 'index']);
    $router->get('/absence/addView', [AbsenceController::class, 'addView']);
    $router->get('/absence/adminView', [AbsenceController::class, 'adminView']);
    $router->get('/absence/groupDetails', [AbsenceController::class, 'groupDetails']);
    $router->get('/absence/stagiare/details', [AbsenceController::class, 'detailsView']);
    $router->get('/absence/justifyAll', [AbsenceController::class, 'justifyAllAbsences']);
    $router->post('/absence/create', [AbsenceController::class, 'createAbsences']);

    // gestion seances
    $router->get('/seance', [SeanceController::class, 'seanceView']);
    $router->get('/seance/delete', [SeanceController::class, 'deleteSeance']);
    $router->get('/seance/details', [SeanceController::class, 'detailsView']);

    // Gestion Stagiaires
    $router->get('/stagiaire', [StagiaireController::class, 'stagiaireView']);
    $router->get('/stagiaire/listStagiaires', [StagiaireController::class, 'listStagiaires']);
    $router->get('/stagiaire/downloadModelCanva', [StagiaireController::class, 'downloadModelCanva']);
    $router->post('/stagiaire/importModelCanva', [StagiaireController::class, 'importModelCanva']);

    // Gestion Module
    $router->get('/module', [ModuleController::class, 'moduleView']);
    $router->get('/module/listModules', [ModuleController::class, 'listModules']);
    $router->get('/module/downloadModelCanva', [ModuleController::class, 'downloadModelCanva']);
    $router->post('/module/importModelCanva', [ModuleController::class, 'importModelCanva']);

    //gestion filieres
    $router->get('/filiere', [FiliereController::class, 'filiereView']);
    $router->get('/filiere/listFiliere', [FiliereController::class, 'listFilieres']);
    $router->get('/downloadModelCanva', [FiliereController::class, 'downloadModelCanva']);
    $router->post('/importModelCanva', [FiliereController::class, 'importModelCanva']);

    // Gestion Secteur
    $router->get('/secteur', [SecteurController::class, 'secteurView']);
    $router->get('/secteur/listSecteurs', [SecteurController::class, 'listSecteurs']);
    $router->get('/secteur/downloadModelCanva', [SecteurController::class, 'downloadModelCanva']);
    $router->post('/secteur/importModelCanva', [SecteurController::class, 'importModelCanva']);

    // gestion comptes
    $router->get('/users', [AuthController::class, 'usersView']);
    $router->get('/addUser', [AuthController::class, 'addUserView']);
    $router->post('/createUser', [AuthController::class, 'createUser']);
    $router->post('/blockAccount', [AuthController::class, 'blockAccount']);
    $router->post('/toggleAccountStatus', [AuthController::class, 'toggleAccountStatus']);

    // Gestion Enseignant
    $router->get('/enseignant', [EnseignantController::class, 'enseignantsView']);
    $router->get('/enseignant/listEnseignants', [EnseignantController::class, 'listEnseignants']);
    $router->get('/enseignant/downloadModelCanva', [EnseignantController::class, 'downloadModelCanva']);
    $router->post('/enseignant/importModelCanva', [EnseignantController::class, 'importModelCanva']);

    // Gestion Groupes
    $router->get('/group', [GroupController::class, 'groupView']);
    $router->get('/group/listGroups', [GroupController::class, 'listGroups']);
    $router->get('/group/downloadModelCanva', [GroupController::class, 'downloadModelCanva']);
    $router->post('/group/importModelCanva', [GroupController::class, 'importModelCanva']);
    $router->get('/group/groupManagement', [GroupController::class, 'groupManagement']);
    $router->post('/group/assignManager', [GroupController::class, 'assignManager']);

    $router->get('/logout', [AuthController::class, 'logout']);
    }
}
// Dispatch the request
$router->dispatch();
