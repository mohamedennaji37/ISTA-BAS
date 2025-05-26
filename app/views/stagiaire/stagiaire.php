<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Stagiaires</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
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
        <h1 class="mb-4"><i class="bi bi-people"></i> Gestion des stagiaires</h1>

        <!-- Boutons Import/Export -->
        <div class="mb-3">
            <button id="downloadCanvasBtn" class="btn btn-primary me-2">
                <i class="bi bi-download"></i> Télécharger un canva
            </button>

            <button id="importCanvasBtn" class="btn btn-secondary me-2">
                <i class="bi bi-upload"></i> Importer un canva
            </button>

            <input type="file" id="canvasFileInput" accept=".xlsx,.xls" style="display: none;">
        </div>

        <!-- Champ de recherche -->
        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Rechercher par nom complet...">
        </div>

        <!-- Tableau des stagiaires -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Prenom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Numero de telephone</th>
                    <th>Groupe</th>
                </tr>
            </thead>
            <tbody id="stagiairesTableBody">
                <!-- Contenu dynamique injecté -->
            </tbody>
        </table>
      </main>

    </div>
  </div>
</div>

<!-- Bootstrap + Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Gestion JS des stagiaires
document.addEventListener('DOMContentLoaded', () => {
    let stagiaires = [];
    const tableBody = document.getElementById('stagiairesTableBody');
    const searchInput = document.getElementById('searchInput');
    const importBtn = document.getElementById('importCanvasBtn');
    const downloadBtn = document.getElementById('downloadCanvasBtn');

    // Charger les stagiaires
    function fetchStagiaires() {
        fetch('/ABS-ISTA/stagiaire/listStagiaires')
            .then(response => response.json())
            .then(data => {
                stagiaires = data;
                renderStagiaires(stagiaires);
            });
    }

    // Afficher les stagiaires dans le tableau
    function renderStagiaires(list) {
        tableBody.innerHTML = '';
        list.forEach(stagiaire => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${stagiaire.stagiaire_id}</td>
                <td>${stagiaire.first_name}</td>
                <td>${stagiaire.last_name}</td>
                <td>${stagiaire.email}</td>
                <td>${stagiaire.phone}</td>
                <td>${stagiaire.groupe_name}</td>
            `;
            tableBody.appendChild(tr);
        });
    }

    // Voir détails stagiaire
    window.viewDetails = function(id) {
        alert('Afficher les détails du stagiaire ID: ' + id);
        // tu peux aussi faire ici : ouvrir une modale ou rediriger
    };

    // Recherche
    searchInput.addEventListener('input', () => {
        const keyword = searchInput.value.toLowerCase();
        const filtered = stagiaires.filter(s =>
            s.nom_complet.toLowerCase().includes(keyword)
        );
        renderStagiaires(filtered);
    });

    // Télécharger modèle Excel
    downloadBtn.addEventListener('click', () => {
        window.location.href = '/ABS-ISTA/stagiaire/downloadModelCanva';
    });

    // Importer fichier Excel
    importBtn.addEventListener('click', () => {
        document.getElementById('canvasFileInput').click();
    });

    document.getElementById('canvasFileInput').addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('excelFile', file);

        fetch('/ABS-ISTA/stagiaire/importModelCanva', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message || 'Importation réussie.');
            fetchStagiaires();
        })
        .catch(err => {
            console.error(err);
            alert('Erreur lors de l\'importation.');
        });
    });

    fetchStagiaires(); // Charger automatiquement
});
</script>

</body>
</html>
