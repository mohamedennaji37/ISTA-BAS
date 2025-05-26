<?php

class AnneeUniversitaire
{
    private $annee_id;
    private $anneeUniversitaire;

    public static function create($data)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO annee_universitaire (anneeUniversitaire) VALUES (?)");
        return $stmt->execute([$data['anneeUniversitaire']]);
    }

    public static function read($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM annee_universitaire WHERE annee_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($id, $data)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE annee_universitaire SET anneeUniversitaire = ? WHERE annee_id = ?");
        return $stmt->execute([$data['anneeUniversitaire'], $id]);
    }

    public static function delete($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM annee_universitaire WHERE annee_id = ?");
        return $stmt->execute([$id]);
    }
    public function getAnneeId()
    {
        return $this->annee_id;
    }

    public function setAnneeId($annee_id)
    {
        $this->annee_id = $annee_id;
    }

    public function getAnneeUniversitaire()
    {
        return $this->anneeUniversitaire;
    }

    public function setAnneeUniversitaire($anneeUniversitaire)
    {
        $this->anneeUniversitaire = $anneeUniversitaire;
    }

}
