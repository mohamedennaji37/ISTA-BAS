<?php

class Secteur
{
    private $secteur_id;
    private $secteur_name;

    public function bulkInsert($rows) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO secteur (secteur_name) VALUES ( ?)");
        foreach ($rows as $row) {
            $stmt->execute([ $row['secteur_name']]);
        }
    }


    public static function findAll()
    {
        $db = Database::getInstance()->getConnection();
        $query = $db->query("SELECT * FROM secteur");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function findBySecteurName($secteur_name)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT secteur_id FROM secteur WHERE secteur_name = ?");
        $stmt->execute([$secteur_name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getSecteurId()
    {
        return $this->secteur_id;
    }

    public function setSecteurId($secteur_id)
    {
        $this->secteur_id = $secteur_id;
    }

    public function getSecteurName()
    {
        return $this->secteur_name;
    }

    public function setSecteurName($secteur_name)
    {
        $this->secteur_name = $secteur_name;
    }
}
