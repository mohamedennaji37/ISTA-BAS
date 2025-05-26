<?php // views/dashboard.php ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tableau de bord ISTA-ABS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
 <style>
    .card-custom { border-radius:1rem; box-shadow:0 0.75rem 1.5rem rgba(0,0,0,0.1); }
    .table-custom thead { background-color:#f1f3f5; }
    .section-title { font-weight:600; margin-bottom:1rem; }
    @media(min-width:1200px){ canvas#absenceChart{max-height:200px;} }
  </style>
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
        <nav class="navbar navbar-expand navbar-light bg-white py-1" style="border-bottom:1px solid black;margin:10px;">
          <div class="container-fluid">
            <span class="navbar-brand"><i class="bi bi-speedometer2"></i> Tableau de bord</span>
            <div class="ms-auto"><span class="text-muted" id="User"></span></div>
          </div>
        </nav>
        <main class="p-2">
          <div class="py-4">
            <h2 id="welcomeMessage" class="mb-4">Bienvenue, <?= htmlspecialchars($userName) ?></h2>
            <div class="row mb-4" id="statCards"></div>
            <div class="mb-5">
              <h4 class="section-title">Statistiques d'absences (ce mois)</h4>
              <canvas id="absenceChart"></canvas>
            </div>
            <!-- Top absents table -->
            <div class="mb-5">
              <h4 class="section-title">Top 6 - Stagiaires les plus absents</h4>
              <div class="table-responsive">
                <table class="table table-hover table-custom align-middle">
                  <thead><tr><th>ID</th><th>Nom complet</th><th>Groupe</th><th>Téléphone</th><th>Heures d'absence</th></tr></thead>
                  <tbody>
                    <?php foreach($topAbsents as $r): ?>
                      <tr>
                        <td><?= $r['id'] ?></td>
                        <td><?= htmlspecialchars($r['nom']) ?></td>
                        <td><?= htmlspecialchars($r['classe']) ?></td>
                        <td><?= htmlspecialchars($r['phone']) ?></td>
                        <td><?= $r['heures'] ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- Recent absences table -->
            <div class="mb-5">
              <h4 class="section-title">Dernières absences enregistrées</h4>
              <div class="table-responsive">
                <table class="table table-striped table-custom align-middle">
                  <thead><tr><th>Date</th><th>Nom</th><th>Groupe</th><th>Séance</th><th>Motif</th></tr></thead>
                  <tbody>
                    <?php foreach($recentAbsences as $r): ?>
                      <tr>
                        <td><?= htmlspecialchars($r['date']) ?></td>
                        <td><?= htmlspecialchars($r['nom']) ?></td>
                        <td><?= htmlspecialchars($r['groupe']) ?></td>
                        <td><?= htmlspecialchars($r['seance']) ?></td>
                        <td><?= htmlspecialchars($r['motif']) ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- Top presents table -->
            <div class="mb-5">
              <h4 class="section-title">Stagiaires les plus assidus</h4>
              <div class="table-responsive">
                <table class="table table-hover table-custom align-middle">
                  <thead><tr><th>#</th><th>Nom</th><th>Groupe</th><th>Présence</th></tr></thead>
                  <tbody>
                    <?php foreach($topPresents as $idx => $r): ?>
                      <tr>
                        <td><?= $idx+1 ?></td>
                        <td><?= htmlspecialchars($r['nom']) ?></td>
                        <td><?= htmlspecialchars($r['groupe']) ?></td>
                        <td><?= $r['taux'] ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </div>

  <script src="script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Stats cards
    const stats = <?= json_encode($stats) ?>;
    const statContainer = document.getElementById('statCards');
    stats.forEach(s => {
      const col = document.createElement('div');
      col.className = 'col-md-4 mb-3';
      col.innerHTML = `<div class="card card-custom text-white bg-${s.color}"><div class="card-body d-flex justify-content-between align-items-center"><div><h5>${s.title}</h5><h3>${s.value}</h3></div><i class="bi ${s.icon} fs-1"></i></div></div>`;
      statContainer.appendChild(col);
    });

    // Chart
    const labels = <?= json_encode($labels) ?>, dataSet = <?= json_encode($dataset) ?>;
    new Chart(document.getElementById('absenceChart').getContext('2d'), {
      type: 'bar',
      data: { labels, datasets: [{ label:'Absences', data:dataSet, backgroundColor:'#0d6efd' }] },
      options: {
        responsive: true,
        plugins: { legend:{ display:false } },
        scales: {
          y: { beginAtZero:true, title:{ display:true, text:"Nombre d'absences" } },
          x: { title:{ display:true, text:"Semaine du mois" } }
        }
      }
    });
  </script>
  
</body>
</html>
