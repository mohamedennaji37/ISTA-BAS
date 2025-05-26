<?php


class SeanceController {

    public function seanceView() {
        $seance = new Seance();
        $seances = $seance->findByEnseignant(); // Fetch all seances dynamically
        require_once __DIR__ . '/../views/seance/gestion-seance.php';
        exit();
    }

    public function detailsView(){
        $seanceModel = new Seance();
        $absence = new Absences();
        $seanceId = $_GET['seance_id'] ?? null;

        if (!$seanceId) {
            http_response_code(400);
            echo "Seance ID is required.";
            exit();
        }

        $seance = $seanceModel->findById($seanceId); // Fetch specific seance details
        $absences = $absence->getBySeanceId($seanceId); // Fetch attendees for the seance

        require_once __DIR__ . '/../views/seance/seance-details.php';
        exit();
    }

    public function deleteSeance() {
       
        $seance = new Seance();
        $result = $seance->delete($_GET['seance_id']);

        if ($result) {
            header('Location: /ABS-ISTA/seance');
            exit();
        } else {
            http_response_code(500);
            echo "Failed to delete the seance.";
            exit();
        }
    }

}

?>
