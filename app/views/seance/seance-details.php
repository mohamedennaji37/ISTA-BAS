<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seance Details</title>
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

        <div class="col-md-9 offset-md-3 offset-lg-2" id="content">

            <nav class="navbar navbar-expand navbar-light bg-white py-1" style="border-bottom: 1px solid black;margin: 10px;">
                <div class="container-fluid">
                    <span id="path" class="navbar-brand mb-0 h1"><i class="bi bi-cpu"></i> System</span>
                    <div class="ms-auto">
                        <span class="text-muted" id="User"></span>
                    </div>
                </div>
            </nav>
            <main class="main-content p-2">
                <h2 style="color: blue; margin-bottom: 20px;">Plus d'informations </h2>

                <div id="div1" class="info-box p-4 bg-white shadow rounded mb-4">
                    <p><strong>Filiere :</strong> <?= htmlspecialchars($seance['groupe_name']) ?></p>
                    <p><strong>Module :</strong> <?= htmlspecialchars($seance['module_name']) ?></p>
                    <p><strong>Professeur :</strong> <?= htmlspecialchars($seance['enseignant_first_name'])." ".htmlspecialchars($seance['enseignant_last_name']) ?></p>
                    <p><strong>Seance :</strong> <?= htmlspecialchars($seance['seance_time']) ?></p>
                    <p><strong>Date :</strong> <?= htmlspecialchars($seance['seance_date']) ?></p>
                </div>

                <div class="d-flex justify-content-end mb-4">
                    <button class="btn btn-outline-primary custom-btn" onclick="history.back()">
                        <i class="bi bi-arrow-left"></i> Retour
                    </button>
                </div>

                <div class="table-container">
                    <table class="table table-bordered table-striped table-hover text-center">
                        <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nom Complet</th>
                            <th>Statut</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($absences as $absence): ?>
                            <tr>
                                <td><?= htmlspecialchars($absence['stagiaire_id']) ?></td>
                                <td><?= htmlspecialchars($absence['last_name'])." ".htmlspecialchars($absence['first_name']) ?></td>
                                <td class="<?= $absence['status'] === 'Absent' ? 'text-danger' : 'text-success' ?>">
                                    <?= htmlspecialchars($absence['status']) ?>
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
