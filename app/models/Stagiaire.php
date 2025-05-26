<?php

class Stagiaire
{
    private $stagiaire_id;
    private $first_name;
    private $last_name;
    private $email;
    private $phone;
    private $groupe_id;

    public static function findAll()
    {
        $db = Database::getInstance()->getConnection();
        $query = $db->query("SELECT * FROM stagiaire s join groupes g on s.groupe_id = g.groupe_id");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findByGroupeId($groupe_id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM stagiaire WHERE groupe_id = :groupe_id");
        $stmt->bindParam(':groupe_id', $groupe_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findByGroupeName($groupe_name)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT *
            FROM stagiaire s
             JOIN groupes g ON s.groupe_id =g.groupe_id 
            WHERE g.groupe_name = :groupe_name
            Order by s.last_name asc
        ");
        $stmt->bindParam(':groupe_name', $groupe_name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById($stagiaire_id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM stagiaire WHERE stagiaire_id = :stagiaire_id");
        $stmt->bindParam(':stagiaire_id', $stagiaire_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function bulkInsert($rows) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO stagiaire ( first_name, last_name, email, phone , groupe_id) VALUES (?, ?, ?, ?, ?)");
        foreach ($rows as $row) {
            $stmt->execute([ $row['first_name'], $row['last_name'], $row['email'], $row['phone'], $row['groupe_id']]);
        }
    }

    public function getStagiaireId()
    {
        return $this->stagiaire_id;
    }

    public function setStagiaireId($stagiaire_id)
    {
        $this->stagiaire_id = $stagiaire_id;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getGroupeId()
    {
        return $this->groupe_id;
    }

    public function setGroupeId($groupe_id)
    {
        $this->groupe_id = $groupe_id;
    }
}
