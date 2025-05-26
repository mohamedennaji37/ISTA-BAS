<?php

class AbsenceController {
    // Method to render the view for adding an absence
    public function addView() {
        $groupeName = $_GET['groupeName'] ?? null; 
        $stagiaires = Stagiaire::findByGroupeName($groupeName); 
        $module = new Module();
        $modules = $module->findByGroupeName($groupeName);
        require_once __DIR__ . '/../views/absence/add.php';
        exit();
    }

    // Method to redirect to the filiere selection view
    public function adminView() {
        $filiere = new Filiere();
        $filieres = $filiere->findAll(); // Fetch all filieres
        require_once __DIR__ . '/../views/absence/filiere.php';
        exit();
    }
    public function gestionnaireView() {
        $groups = Groups::findByUserId($_SESSION['user_id']);
        require_once __DIR__ . '/../views/absence/gestionnaire.php';
    }


    // Method to redirect to the stagiaire view
    public function groupDetails() {
        $groupeName = $_GET['groupeName'] ?? null; // Corrected to get groupeName from the query string
        $stagiaire = new Stagiaire();
        $stagiaires = $stagiaire->findByGroupeName($groupeName); // Fetch stagiaires based on groupeName
        require_once __DIR__ . '/../views/absence/stagiaire.php';
        exit();
    }

    // the creation of multiple absences
    //for a single session (Seance).
    public function createAbsences() {

        $absencesData = $_POST['absences'] ?? [];
        $seanceDate = $_POST['seanceDate'] ?? null;
        $seanceTime = $_POST['seanceTime'] ?? null;
        $module_id = $_POST['module_id'] ?? null;

        // Check if the seance already exists
        $existingSeance = Seance::seanceExists($seanceDate, $seanceTime, $module_id);
        if ($existingSeance) {
            // Redirect to the add view with a parameter indicating the seance already exists
            header('Location: /ABS-ISTA/absence/addView?seanceExists=true&seanceId=' . $existingSeance['seance_id']);
            exit();
        }

        // Create a new Seance
        $seance = new Seance();
        $seance->setSeanceDate($seanceDate);
        $seance->setSeanceTime($seanceTime);
        $seance->setModuleId($module_id);
        $seance->setAnneeId(1);
        $seanceId = $seance->add(); // Save the seance and get its ID

        foreach ($absencesData as $absenceData) {
            // Process only if the checkbox (status) is marked
            if (isset($absenceData['status']) && $absenceData['status'] === '1') {
                // Create a new Absence
                $absence = new Absences();
                $absence->setStagiaireId($absenceData['stagiaireId']);
                $absence->setSeanceId($seanceId); // Reference the created seance
                $userId = $_SESSION['user_id'] ?? null;
                $absence->setUserId($userId); // Set the valid user ID
                $absence->setStatus('Absent');
                $absence->setRecordedAt(date('Y-m-d H:i:s'));
                $absence->add();
            }
        }

        header('Location: /ABS-ISTA/seance');
        exit();
    }

    // Method to redirect to the details view
    public function detailsView() {
        $stagiaireId = $_GET['stagiaire_id'] ?? null; // Extract stagiaire_id from the URL
        if (!$stagiaireId) {
            header('Location: /ABS-ISTA/absence/stagiaireView');
            exit();
        }

        $stagiaire = new Stagiaire();
        $stagiaireDetails = $stagiaire->findById($stagiaireId); // Fetch stagiaire details

        $absence = new Absences();
        $absences = $absence->findByStagiaireId($stagiaireId); // Fetch absences for the stagiaire

        require_once __DIR__ . '/../views/absence/details.php';
        exit();
    }

    // Method to justify all absences for a stagiaire
    public function justifyAllAbsences() {
        $stagiaireId = $_GET['stagiaire_id'] ?? null;
        $confirm = $_GET['confirm'] ?? 'no';

        if (!$stagiaireId) {
            header('Location: /ABS-ISTA/absence/stagiaireView');
            exit();
        }

        // If not confirmed, redirect back to details with a message
        if ($confirm !== 'yes') {
            header('Location: /ABS-ISTA/absence/stagiare/details?stagiaire_id=' . $stagiaireId);
            exit();
        }

        // Get all absences for the stagiaire
        $absence = new Absences();
        $absences = $absence->findByStagiaireId($stagiaireId);

        // Update each absence status to 'Justifiée'
        foreach ($absences as $absenceData) {
            $absenceId = $absenceData['absence_id'];
            $data = [
                'stagiaire_id' => $absenceData['stagiaire_id'],
                'seance_id' => $absenceData['seance_id'],
                'user_id' => $absenceData['user_id'],
                'status' => 'Justifiée',
                'recorded_at' => $absenceData['recorded_at']
            ];
            Absences::update($absenceId, $data);
        }

        // Redirect back to the details page
        header('Location: /ABS-ISTA/absence/stagiare/details?stagiaire_id=' . $stagiaireId . '&justified=true');
        exit();
    }
}