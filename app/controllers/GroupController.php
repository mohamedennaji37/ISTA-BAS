<?php

class GroupController {

    // Retourner tous les groupes (JSON)
    public function listGroups() {
        $group = new Groups();
        header('Content-Type: application/json');
        echo json_encode($group->findAll());
    }

    public function groupView() {
        require_once __DIR__ . '/../views/groups/groupe.php';
        exit();
    }


    // method for group management view
    public function groupManagement() {
        $group = Groups::findById($_GET['id']);

        $user = new Users();
        $users = $user->findAll();

        require_once __DIR__ . '/../views/groups/group_management.php';
        exit();
    }

    public function assignManager() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $groupe_id = $_POST['groupe_id'];
            $user_id = $_POST['user_id'];

            $group = new Groups();
            $group->updateUserForGroup($groupe_id, $user_id);

            header('Location: /ABS-ISTA/group');
        } else {
            http_response_code(405);
            echo json_encode(["error" => "Method not allowed"]);
        }
    }

    // method for download model canva
    public function downloadModelCanva() {
        $filePath = __DIR__ . '/../../app/resources/canvas/groupe-canva.xlsx'; // Adjust the file name and extension as needed
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

                $group = new Groups();
                $rows = [];
                
                foreach ($sheetData as $index => $row) {
                    if ($index === 1) continue; // Skip header row
                    
                    // Get filiere_id from filiere_name using the model method
                    $result = Filiere::findByFiliereName($row['B']);
                    
                    if (!$result) {
                        continue; // Skip if filiere not found
                    }
                    
                    $rows[] = [
                        'group_name' => $row['A'],
                        'filiere_id' => $result['filiere_id'],
                        'user_id' => $row['C']
                    ];
                }

                if (!empty($rows)) {
                    foreach ($rows as $row) {
                        $group->setGroupName($row['group_name']);
                        $group->setFiliereId($row['filiere_id']);
                        $group->setUserId($row['user_id']);
                        $group->add();
                    }
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