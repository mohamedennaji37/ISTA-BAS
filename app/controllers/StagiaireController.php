<?php

class StagiaireController {

    // 1. Retourner tous les stagiaires en JSON
    public function listStagiaires() {
        $stagiaire = new Stagiaire();
        header('Content-Type: application/json');
        echo json_encode($stagiaire->findAll());
    }

    // 2. Charger la vue de gestion des stagiaires
    public function stagiaireView() {
        require_once __DIR__ . '/../views/stagiaire/stagiaire.php';
        exit();
    }

    // 3. Télécharger un modèle Excel pour les stagiaires
    public function downloadModelCanva() {
        $filePath = __DIR__ . '/../resources/canvas/stagiaire-canva.xlsx'; 
        if (file_exists($filePath)) {
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
            echo json_encode(["error" => "Fichier modèle non trouvé."]);
        }
    }

    // 4. Importer un fichier Excel pour insérer des stagiaires
    public function importModelCanva() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excelFile'])
             && $_FILES['excelFile']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../resources/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $filePath = $uploadDir . basename($_FILES['excelFile']['name']);
            if (move_uploaded_file($_FILES['excelFile']['tmp_name'], $filePath)) {
                require_once __DIR__ . '/../../vendor/autoload.php'; 
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $stagiaire = new Stagiaire();
                $rows = [];
                foreach ($sheetData as $index => $row) {
                    if ($index === 1) continue; 
                      $result = Filiere::findByFiliereName($row['E']);
                      if (!$result) {
                          continue; 
                      }
                    $rows[] = [
                        'first_name' => $row['A'] ?? '',
                        'last_name' => $row['B'] ?? '',
                        'email' => $row['C'] ?? '',
                        'phone' => $row['D'] ?? '',
                        'filiere_id' => $result['filiere_id']            
                     ];
                }
                if (!empty($rows)) {
                    $stagiaire->bulkInsert($rows);
                    echo json_encode(["message" => "Les stagiaires ont été importés avec succès."]);
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
?>++
