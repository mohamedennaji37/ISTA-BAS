<?php

class ModuleController {

    // 1. Retourner tous les modules en JSON
    public function listModules() {
        $module = new Module();
        header('Content-Type: application/json');
        echo json_encode($module->findAll());
    }

    // 2. Charger la vue de gestion des modules
    public function moduleView() {
        require_once __DIR__ . '/../views/module/module.php';
        exit();
    }

    // 3. Télécharger un modèle Excel pour les modules
    public function downloadModelCanva() {
        $filePath = __DIR__ . '/../resources/canvas/module-canva.xlsx'; 

        if (file_exists($filePath)) {
            // Configuration des headers HTTP pour télécharger
            header('Content-Description: File Transfer');
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));

            readfile($filePath);
            exit();
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Fichier modele non trouve."]);
        }
    }

    // 4. Importer un fichier Excel pour insérer des modules
    public function importModelCanva() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] === UPLOAD_ERR_OK) {
            
            $uploadDir = __DIR__ . '/../resources/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $filePath = $uploadDir . basename($_FILES['excelFile']['name']);

            if (move_uploaded_file($_FILES['excelFile']['tmp_name'], $filePath)) {

                require_once __DIR__ . '/../../vendor/autoload.php';
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                $module = new Module();
                $rows = [];

                foreach ($sheetData as $index => $row) {
                    if ($index === 1) continue; // Ignorer la première ligne (header)

                    // Get filiere_id from filiere_name using the model method
                    $filiereResult = Filiere::findByFiliereName($row['B']);
                    
                    // Get enseignant_id from first_name and last_name
                    $enseignantResult = Enseignant::findByEnseignantLastName($row['C']);
                    
                    if (!$filiereResult || !$enseignantResult) {
                        continue; // Skip if filiere or enseignant not found
                    }

                    $rows[] = [
                        'module_name' => $row['A'] ?? '',
                        'filiere_id' => $filiereResult['filiere_id'],
                        'enseignant_id' => $enseignantResult['enseignant_id']
                    ];
                }

                if (!empty($rows)) {
                    $module->bulkInsert($rows);
                    echo json_encode(["message" => "Les modules ont été importés avec succès."]);
                } else {
                    echo json_encode(["error" => "Le fichier Excel est vide ou incorrect."]);
                }

            } else {
                http_response_code(500);
                echo json_encode(["error" => "Erreur lors du déplacement du fichier."]);
            }

        } else {
            http_response_code(400);
            echo json_encode(["error" => "Aucun fichier envoyé ou erreur d'upload."]);
        }
    }
}
?>
