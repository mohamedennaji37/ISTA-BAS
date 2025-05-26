<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Filières</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<button class="mobile-toggle" id="toggleSidebar"><i class="bi bi-list"></i></button>
<div class="container-fluid p-0">
  <div class="row g-0">
    
  <?php include __DIR__ . '/../partials/layout.html'; ?>

    <div class="col-md-9 offset-md-3 offset-lg-2" id="content">
      <nav class="navbar navbar-expand navbar-light bg-white py-1" style="border-bottom: 1px solid black;margin: 10px;">
        <div class="container-fluid">
          <span id="path" class="navbar-brand mb-0 h1"><i class="bi bi-cpu"> System</i></span>
          <div class="ms-auto">
            <span class="text-muted" id="User"></span>
          </div>
        </div>
      </nav>
      <main class="main-content p-2">
      <h1 class="mb-4">Gestion des Filières </h1>
            <!-- Section boutons : Télécharger / Importer -->
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
                <input type="text" id="searchInput" class="form-control" placeholder="Rechercher une filière...">
            </div>

            <!-- Tableau affichage des filières -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>filiere_id</th>
                        <th>Filiere</th>
                        <th>Secteur</th>
                    </tr>
                </thead>
                <tbody id="filieresTableBody">
                    <!-- Rempli dynamiquement en JavaScript -->
                </tbody>
            </table>
      </main>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// JavaScript pour gérer toutes les fonctionnalités

document.addEventListener('DOMContentLoaded', () => {
    let filieres = [];
    const tableBody = document.getElementById('filieresTableBody');
    const searchInput = document.getElementById('searchInput');
    const importBtn = document.getElementById('importCanvasBtn');
    const downloadBtn = document.getElementById('downloadCanvasBtn');

    // 1. Charger les filières depuis l'API
    function fetchFilieres() {
        fetch('/ABS-ISTA/filiere/listFiliere')
            .then(response => response.json())
            .then(data => {
                filieres = data;
                renderFilieres(filieres);
            });
    }

    // 2. Afficher les filières dans le tableau
    function renderFilieres(list) {
        tableBody.innerHTML = '';
        list.forEach(filiere => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${filiere.filiere_id}</td>
                <td>${filiere.filiere_name}</td>
                <td>${filiere.secteur_name}</td>
            `;
            tableBody.appendChild(tr);
        });
    }

    // 3. Bloquer une filière
    window.blockFiliere = function(id) {
        if (confirm('Voulez-vous vraiment bloquer cette filière ?')) {
            fetch(`../`, { method: 'POST' })
                .then(response => response.json())
                .then(data => {
                    alert(data.message || 'Filière bloquée');
                    fetchFilieres(); // Recharger
                });
        }
    };

    // 4. Rechercher dans les filières
    searchInput.addEventListener('input', () => {
        const keyword = searchInput.value.toLowerCase();
        const filtered = filieres.filter(f =>
            f.titre.toLowerCase().includes(keyword) ||
            f.secteur.toLowerCase().includes(keyword)
        );
        renderFilieres(filtered);
    });

    // 5. Télécharger un modèle Excel (canva-model.xlsx)
    downloadBtn.addEventListener('click', () => {
        window.location.href = '/ABS-ISTA/downloadModelCanva';
    });

    // 6. Importer un fichier Excel
    importBtn.addEventListener('click', () => {
        const fileInput = document.getElementById('canvasFileInput');
        fileInput.click();
    });

    document.getElementById('canvasFileInput').addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('excelFile', file); // Corrected key to match server-side expectation

        fetch('/ABS-ISTA/importModelCanva', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message || 'Importation réussie.');
            fetchFilieres(); // Recharger après import
        })
        .catch(err => {
            console.error(err);
            alert('Erreur lors de l\'importation.');
        });
    });

    fetchFilieres(); // Charger au démarrage
});
</script>

</body>
</html>