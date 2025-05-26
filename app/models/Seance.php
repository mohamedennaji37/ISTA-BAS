<?php

class Seance
{
    private $seance_id;
    private $seance_date;
    private $seance_time;
    private $module_id;
    private $annee_id ;
    
    public function add()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO seance (seance_date, seance_time, module_id, anne_id) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$this->seance_date, $this->seance_time, $this->module_id, $this->annee_id])) {
            return $db->lastInsertId(); // Return the ID of the inserted record
        }
        return false; // Return false if the insertion fails
    }

    public static function read($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM seance WHERE seance_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
      // Method to check if a seance already exists
      public static function seanceExists($seanceDate, $seanceTime, $module_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM seance WHERE seance_date = ? AND seance_time = ? AND module_id = ?");
        $stmt->execute([$seanceDate, $seanceTime, $module_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function delete($id)
    {
        $db = Database::getInstance()->getConnection();
    
        // Delete absences related to the seance
        $stmtAbsence = $db->prepare("DELETE FROM absences WHERE seance_id = ?");
        $stmtAbsence->execute([$id]);
    
        // Delete the seance
        $stmtSeance = $db->prepare("DELETE FROM seance WHERE seance_id = ?");
        return $stmtSeance->execute([$id]);
    }

    public static function findAll()
    {
        $db = Database::getInstance()->getConnection();
        $query = $db->query("SELECT * FROM seance");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT s.seance_date, s.seance_time, e.first_name AS enseignant_first_name,
                                 e.last_name AS enseignant_last_name, 
                                 m.module_name, g.groupe_name 
                              FROM seance s
                              JOIN module m ON m.module_id = s.module_id
                              JOIN groupes g ON g.groupe_id = m.groupe_id
                              JOIN enseignant e ON e.enseignant_id = m.enseignant_id  
                              WHERE s.seance_id = ?"); 
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
   
    public  function findByEnseignant() {
    $db = Database::getInstance()->getConnection();
    $query = $db->query("SELECT s.*, m.module_name,  g.groupe_name, e.first_name AS enseignant_first_name,
                                 e.last_name AS enseignant_last_name
                              FROM seance s
                              JOIN module m ON m.module_id = s.module_id 
                              JOIN groupes g ON g.groupe_id = m.groupe_id
                              JOIN enseignant e ON e.enseignant_id = m.enseignant_id Order by seance_id desc");
    return $query->fetchAll(PDO::FETCH_ASSOC);
        }


    public function getSeanceId()
    {
        return $this->seance_id;
    }

    public function setSeanceId($seance_id)
    {
        $this->seance_id = $seance_id;
    }

    public function getSeanceDate()
    {
        return $this->seance_date;
    }

    public function setSeanceDate($seance_date) {
        $this->seance_date = $seance_date;
    }

    public function getSeanceTime()
    {
        return $this->seance_time;
    }

    public function setSeanceTime($seance_time) {
        $this->seance_time = $seance_time;
    }

    public function getModuleId()
    {
        return $this->module_id;
    }

    public function setModuleId($module_id) {
        $this->module_id = $module_id;
    }

    public function getAnneeId()
    {
        return $this->annee_id;
    }

    public function setAnneeId($annee_id) {
        $this->annee_id = $annee_id;
    }

   
}
