<?php

class DashboardModel {

    public function getStats(): array {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE role = ?");
        $stmt->execute(['surveillant']);
        $surv = (int)$stmt->fetchColumn();

        return [
            [
                'title' => 'Total stagiaires',
                'icon'  => 'bi-people-fill',
                'color' => 'primary',
                'value' => (int)$db->query("SELECT COUNT(*) FROM stagiaire")->fetchColumn()
            ],
            [
                'title' => 'Total formateurs',
                'icon'  => 'bi-person-badge-fill',
                'color' => 'info',
                'value' => (int)$db->query("SELECT COUNT(*) FROM enseignant")->fetchColumn()
            ],
            [
                'title' => 'Surveillants',
                'icon'  => 'bi-shield-lock-fill',
                'color' => 'success',
                'value' => $surv
            ]
        ];
    }

    public function getWeekData(): array {
        $db = Database::getInstance()->getConnection();

        $month = date('Y-m');
        $sql = "
        SELECT
            CASE
                WHEN DAY(recorded_at) BETWEEN 1 AND 7 THEN 1
                WHEN DAY(recorded_at) BETWEEN 8 AND 14 THEN 2
                WHEN DAY(recorded_at) BETWEEN 15 AND 21 THEN 3
                WHEN DAY(recorded_at) >= 22 THEN 4
            END AS semaine,
            COUNT(*) AS total
        FROM absences
        WHERE DATE_FORMAT(recorded_at,'%Y-%m') = ?
        AND status != 'Justifiée'
        GROUP BY semaine
        ORDER BY semaine
    ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$month]);
        $data = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $labels = $values = [];
        for ($w = 1; $w <= 4; $w++) {
            $labels[] = "Semaine $w";
            $values[] = $data[$w] ?? 0;
        }
        return [$labels, $values];
    }

    public function getTopAbsents(): array {
        $db = Database::getInstance()->getConnection();
        return $db->query("
          SELECT s.stagiaire_id AS id,
                 CONCAT(s.first_name,' ',s.last_name) AS nom,
                 g.groupe_name AS classe,
                 s.phone,
                 COUNT(a.absence_id)*1.5 AS heures
            FROM absences a
            JOIN stagiaire s ON a.stagiaire_id=s.stagiaire_id
            JOIN groupes g ON s.groupe_id=g.groupe_id
            WHERE a.status != 'Justifiée'
           GROUP BY s.stagiaire_id
           ORDER BY heures DESC
           LIMIT 6
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecentAbsences(): array {
        $db = Database::getInstance()->getConnection();

        return $db->query("
          SELECT a.recorded_at AS date,
                 CONCAT(s.first_name,' ',s.last_name) AS nom,
                 g.groupe_name AS groupe,
                 CONCAT(se.seance_time,' - ',m.module_name) AS seance,
                 a.status AS motif
            FROM absences a
            JOIN stagiaire s ON a.stagiaire_id=s.stagiaire_id
            JOIN groupes g ON s.groupe_id=g.groupe_id
            JOIN seance se ON a.seance_id=se.seance_id
            JOIN module m ON se.module_id=m.module_id
            WHERE a.status != 'Justifiée'
           ORDER BY a.recorded_at DESC
           LIMIT 5
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopPresents(): array {
        $db = Database::getInstance()->getConnection();
        return $db->query("
          SELECT CONCAT(s.first_name,' ',s.last_name) AS nom,
                 g.groupe_name AS groupe,
                 ROUND(((SELECT COUNT(*) FROM seance)-COUNT(CASE WHEN a.status != 'Justifiée' THEN a.absence_id ELSE NULL END))/
                       (SELECT COUNT(*) FROM seance)*100,0) AS taux_val,
                 CONCAT(
                   ROUND(((SELECT COUNT(*) FROM seance)-COUNT(CASE WHEN a.status != 'Justifiée' THEN a.absence_id ELSE NULL END))/
                         (SELECT COUNT(*) FROM seance)*100,0),'%'
                 ) AS taux
            FROM stagiaire s
            JOIN groupes g ON s.groupe_id=g.groupe_id
            LEFT JOIN absences a ON s.stagiaire_id=a.stagiaire_id
           GROUP BY s.stagiaire_id
           ORDER BY taux_val DESC
           LIMIT 6
        ")->fetchAll(PDO::FETCH_ASSOC);
    }
}