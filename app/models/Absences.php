<?php

class Absences
{
    private $absence_id;
    private $stagiaire_id;
    private $seance_id;
    private $user_id;
    private $status;
    private $recorded_at;


    public static function create($data)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO absences (stagiaire_id, seance_id, user_id, status, recorded_at) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$data['stagiaire_id'], $data['seance_id'], $data['user_id'], $data['status'], $data['recorded_at']]);
    }

    public static function read($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM absences WHERE absence_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll()
    {
        $db = Database::getInstance()->getConnection();
        $query = $db->query("SELECT * FROM absences");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function update($id, $data)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE absences SET stagiaire_id = ?, seance_id = ?, user_id = ?, status = ?, recorded_at = ? WHERE absence_id = ?");
        return $stmt->execute([$data['stagiaire_id'], $data['seance_id'], $data['user_id'], $data['status'], $data['recorded_at'], $id]);
    }

    public static function delete($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM absences WHERE absence_id = ?");
        return $stmt->execute([$id]);
    }

    public function add()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO absences (stagiaire_id, seance_id, user_id, status, recorded_at) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$this->stagiaire_id, $this->seance_id, $this->user_id, $this->status, $this->recorded_at]);
    }

    public static function findByStagiaireId($stagiaire_id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT a.*, s.seance_time, s.seance_date, m.module_name 
            FROM absences a
            JOIN seance s ON a.seance_id = s.seance_id
            JOIN module m ON s.module_id = m.module_id
            WHERE a.stagiaire_id = :stagiaire_id
            ORDER BY a.recorded_at DESC
        ");
        $stmt->bindParam(':stagiaire_id', $stagiaire_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getBySeanceId($seanceId)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT a.status, st.first_name, st.last_name, st.stagiaire_id 
            FROM absences a
            JOIN stagiaire st ON a.stagiaire_id = st.stagiaire_id
            WHERE a.seance_id = ?
        ");
        $stmt->execute([$seanceId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAbsenceId()
    {
        return $this->absence_id;
    }

    public function setAbsenceId($absence_id)
    {
        $this->absence_id = $absence_id;
    }

    public function getStagiaireId()
    {
        return $this->stagiaire_id;
    }

    public function setStagiaireId($stagiaire_id)
    {
        $this->stagiaire_id = $stagiaire_id;
    }

    public function getSeanceId()
    {
        return $this->seance_id;
    }

    public function setSeanceId($seance_id)
    {
        $this->seance_id = $seance_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getRecordedAt()
    {
        return $this->recorded_at;
    }

    public function setRecordedAt($recorded_at)
    {
        $this->recorded_at = $recorded_at;
    }
}
