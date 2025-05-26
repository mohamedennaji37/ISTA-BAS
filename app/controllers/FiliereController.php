<?php

class FiliereController {

    // Retourner toutes les filières (JSON)
    public function listFilieres() {
        $filieres = new Filiere();
        header('Content-Type: application/json');
        echo json_encode($filieres->findAll());
    }

    public function filiereView() {
        require_once __DIR__ . '/../views/filiere/filiere.php';
        exit();
    }

    // method for download model canva
    public function downloadModelCanva() {
        $filePath = __DIR__ . '/../../app/resources/canvas/filiere-canva.xlsx'; // Adjust the file name and extension as needed
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

    // method for import excel file
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

                $filiere = new Filiere();
                $rows = [];
                
                foreach ($sheetData as $index => $row) {
                    if ($index === 1) continue; // Skip header row
                    
                    // Get secteur_id from secteur_name using the model method
                    $result = Secteur::findBySecteurName($row['B']);
                    
                    if (!$result) {
                        continue; // Skip if secteur not found
                    }
                    
                    $rows[] = [
                        'filiere_name' => $row['A'],
                        'secteur_id' => $result['secteur_id']
                    ];
                }

                if (!empty($rows)) {
                    $filiere->bulkInsert($rows);
                    echo json_encode(["message" => "Data imported successfully."]);
                } else {
                    echo json_encode(["error" => "No valid data found to import."]);
                }
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
