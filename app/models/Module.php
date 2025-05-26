<?php

class Module
{
    private $module_id;
    private $module_name;
    private $groupe_id;
    private $enseignant_id;

    public static function findAll()
    {
        $db = Database::getInstance()->getConnection();
        $query = $db->query("SELECT * FROM module m join groupes g on m.groupe_id = g.groupe_id 
        join enseignant e on m.enseignant_id = e.enseignant_id");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByGroupeName($groupeName) 
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT *
            FROM module m JOIN groupes g ON m.groupe_id = g.groupe_id 
            JOIN enseignant e on m.enseignant_id = e.enseignant_id
            WHERE g.groupe_name = :groupe_name
        ");
        $stmt->bindParam(':groupe_name', $groupeName, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function bulkInsert($rows) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO module (module_name,groupe_id, enseignant_id) VALUES (?, ?, ?)"); 
        foreach ($rows as $row) {
            $stmt->execute([$row['module_name'], $row['groupe_id'], $row['enseignant_id']]); 
        }
    }

    public function getModuleId()
    {
        return $this->module_id;
    }

    public function setModuleId($module_id)
    {
        $this->module_id = $module_id;
    }

    public function getModuleName()
    {
        return $this->module_name;
    }

    public function setModuleName($module_name)
    {
        $this->module_name = $module_name;
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