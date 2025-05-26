<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seances</title>
   
</head>
<body>
<button class="mobile-toggle" id="toggleSidebar"><i class="bi bi-list"></i></button>
<div class="container-fluid p-0">
    <div class="row g-0">
        
      <?php if ($_SESSION['role'] === 'admin'): ?>
            <?php include __DIR__ . '/../partials/sidebar.html'; ?>
        <?php endif; ?>
        <?php if ($_SESSION['role'] === 'gestionnaire'): ?>
            <?php include __DIR__ . '/../partials/gestionnaireSidebar.html'; ?>
        <?php endif; ?>

        <div class="col-12" id="content">
            <nav class="navbar navbar-expand navbar-light bg-white py-1" style="border-bottom: 1px solid black;margin: 10px;">
                <div class="container-fluid">
                    <span id="path" class="navbar-brand mb-0 h1"><i class="bi bi-cpu"></i> System</span>
                    <div class="ms-auto">
                        <span class="text-muted" id="User"></span>
                    </div>
                </div>
            </nav>
            <main class="main-content p-2">
                <h2 class="mb-4" style="color: blue"><i class="bi bi-calendar-check"></i> Historique d'absence</h2>
                <!-- Champ de recherche -->
                <div class="mb-3">
                    <input type="text" id="searchInput" class="form-control" placeholder="Rechercher par nom complet...">
                </div>

            
                <div>
                    <table class="table table-striped table-bordered">
                        <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Groupe</th>
                            <th>Formateur</th>
                            <th>Module</th>
                            <th>Séance</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($seances as $seance): ?>
                            <tr>
                                <td><?= htmlspecialchars($seance['seance_id']) ?></td>
                                <td><?= htmlspecialchars($seance['groupe_name']) ?></td>
                                <td><?= htmlspecialchars($seance['enseignant_first_name'])." ".htmlspecialchars($seance['enseignant_last_name']) ?></td>
                                <td><?= htmlspecialchars($seance['module_name']) ?></td>
                                <td>
                                    <?php if ($seance['seance_time'] == 1): ?>
                                        <?= 'S1 - 8:00/10:00' ?>
                                    <?php elseif ($seance['seance_time'] == 2): ?>
                                        <?= 'S2 - 10:00/12:00' ?>
                                    <?php elseif ($seance['seance_time'] == 3): ?>
                                        <?= 'S3 - 14:00/16:00' ?>
                                    <?php elseif ($seance['seance_time'] == 4): ?>
                                        <?= 'S4 - 16:00/18:00' ?>
                                    <?php else: ?>
                                        <?= "Unknown" ?>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($seance['seance_date']) ?></td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="/ABS-ISTA/seance/delete?seance_id=<?= urlencode($seance['seance_id']) ?>" 
                                           class="btn btn-danger" 
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette séance ?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                        <a href="/ABS-ISTA/seance/details?seance_id=<?= urlencode($seance['seance_id']) ?>" 
                                           class="btn btn-primary text-white">
                                            <i class="bi bi-plus"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</div>

</body>
</html>
