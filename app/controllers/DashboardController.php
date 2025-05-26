<?php


class DashboardController {
    public function index(): void {
        $dm   = new DashboardModel();
        $stats       = $dm->getStats();
        [$labels, $dataset] = $dm->getWeekData();
        $topAbsents  = $dm->getTopAbsents();
        $recentAbsences = $dm->getRecentAbsences();
        $topPresents = $dm->getTopPresents();
        $userName = $_SESSION['username'] ?? 'Guest';
        include __DIR__ . '/../views/home/dashboard.php';
    }
}
