<?php

class SecteurController {

    // Retourner tous les secteurs (JSON)
    public function listSecteurs() {
        $secteurs = new Secteur();  // modèle Secteur
        header('Content-Type: application/json');
        echo json_encode($secteurs->findAll());
    }

    // Afficher la vue HTML
    public function secteurView() {
        require_once __DIR__ . '/../views/secteur/secteur.php';
        exit();
    }

    // Télécharger le modèle Excel de secteur
    public function downloadModelCanva() {
        $filePath = __DIR__ . '/../../app/resources/canvas/secteur-canva.xlsx';

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
            echo json_encode(["error" => "File not found"]);
        }
    }

    // Importer un fichier Excel
    public function importModelCanva() {
        if ($_FILES['excelFile']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../resources/uploads/';
            $filePath = $uploadDir . basename($_FILES['excelFile']['name']);

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($_FILES['excelFile']['tmp_name'], $filePath)) {
                require_once __DIR__ . '/../../vendor/autoload.php'; // PhpSpreadsheet installé via Composer
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                $secteur = new Secteur();
                $rows = [];

                foreach ($sheetData as $index => $row) {
                    if ($index === 1) continue; // Ignorer l'entête
                    $rows[] = [
                        'secteur_name' => $row['A']   // colonne B
                    ];
                }
                

                $secteur->bulkInsert($rows);
                echo json_encode(["message" => "Data imported successfully."]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Failed to upload file."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "No file uploaded or upload error."]);
        }
    }
}
?>
