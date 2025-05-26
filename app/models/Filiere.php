<?php

class Filiere
{
    private $filiere_id;
    private $filiere_name;
    private $secteur_id;
    

    public static function findAll()
    {
        $db = Database::getInstance()->getConnection();
        $query = $db->query("SELECT * FROM filiere f join secteur s on f.secteur_id = s.secteur_id");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findByFiliereName($filiere_name)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT filiere_id FROM filiere WHERE filiere_name = ?");
        $stmt->execute([$filiere_name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function bulkInsert($rows) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO filiere (filiere_name, secteur_id) VALUES (?, ?)");
        foreach ($rows as $row) {
            $stmt->execute([$row['filiere_name'], $row['secteur_id']]);
        }
    }

    public function getFiliereId()
    {
        return $this->filiere_id;
    }

    public function setFiliereId($filiere_id)
    {
        $this->filiere_id = $filiere_id;
    }

    public function getFiliereName()
    {
        return $this->filiere_name;
    }

    public function setFiliereName($filiere_name)
    {
        $this->filiere_name = $filiere_name;
    }

    public function getSecteurId()
    {
        return $this->secteur_id;
    }

    public function setSecteurId($secteur_id)
    {
        $this->secteur_id = $secteur_id;
    }

    
}
