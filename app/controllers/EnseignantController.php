<?php

class EnseignantController {

    // Retourner tous les enseignants (en JSON)
    public function listEnseignants() {
        $enseignant = new Enseignant();
        header('Content-Type: application/json');
        echo json_encode($enseignant->findAll());
    }

    // Afficher la vue de gestion des enseignants
    public function enseignantsView() {
        require_once __DIR__ . '/../views/enseignant/enseignant.php';
        exit();
    }

    // Télécharger le modèle Excel pour les enseignants
    public function downloadModelCanva() {
        $filePath = __DIR__ . '/../../app/resources/canvas/enseignant-canva.xlsx';
        if (file_exists($filePath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit();
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Fichier modèle enseignant non trouvé."]);
        }
    }

    // Importer un fichier Excel pour les enseignants
    public function importModelCanva() {
        if ($_FILES['excelFile']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../resources/uploads/';
            $filePath = $uploadDir . basename($_FILES['excelFile']['name']);

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($_FILES['excelFile']['tmp_name'], $filePath)) {
                require_once __DIR__ . '/../../vendor/autoload.php';
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                $enseignant = new Enseignant();
                $rows = [];

                foreach ($sheetData as $index => $row) {
                    if ($index === 1) continue; // Ignorer l'en-tête
                    $rows[] = [
                        'first_name' => $row['A'],
                        'last_name' => $row['B'],
                        'email' => $row['C'],
                        'phone' => $row['D']
                    ];
                }

                $enseignant->bulkInsert($rows);
                echo json_encode(["message" => "Les enseignants ont été importés avec succès."]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Erreur lors du déplacement du fichier."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Aucun fichier envoyé ou erreur d'upload."]);
        }
    }

} // ← Fin de la classe correctement ajoutée

?>
