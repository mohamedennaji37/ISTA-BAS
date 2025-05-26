<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Groupes</title>
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
      <h1 class="mb-4">Gestion des Groupes </h1>
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
                <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un groupe...">
            </div>

            <!-- Tableau affichage des groupes -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Groupe</th>
                        <th>Filière</th>
                        <th>Gestionnaire</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="groupsTableBody">
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
    let groups = [];
    const tableBody = document.getElementById('groupsTableBody');
    const searchInput = document.getElementById('searchInput');
    const importBtn = document.getElementById('importCanvasBtn');
    const downloadBtn = document.getElementById('downloadCanvasBtn');

    // 1. Charger les groupes depuis l'API
    function fetchGroups() {
        fetch('/ABS-ISTA/group/listGroups')
            .then(response => response.json())
            .then(data => {
                groups = data;
                renderGroups(groups);
            });
    }

    // 2. Afficher les groupes dans le tableau
    function renderGroups(list) {
        tableBody.innerHTML = '';
        list.forEach(group => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${group.groupe_id}</td>
                <td>${group.groupe_name}</td>
                <td>${group.filiere_name}</td>
                <td>${group.username}</td>
                <td>
                    ${group.username === "pas encore affecté" ? '<button class="btn btn-warning" onclick="window.location.href=\'/ABS-ISTA/group/groupManagement?id=' + group.groupe_id + '\'">Affecter</button>' : ''}
                </td>
            `;
            tableBody.appendChild(tr);
        });
    }

    // 3. Rechercher dans les groupes
    searchInput.addEventListener('input', () => {
        const keyword = searchInput.value.toLowerCase();
        const filtered = groups.filter(g =>
            g.groupe_name.toLowerCase().includes(keyword) ||
            g.filiere_name.toLowerCase().includes(keyword)
        );
        renderGroups(filtered);
    });

    // 4. Télécharger un modèle Excel (canva-model.xlsx)
    downloadBtn.addEventListener('click', () => {
        window.location.href = '/ABS-ISTA/group/downloadModelCanva';
    });

    // 5. Importer un fichier Excel
    importBtn.addEventListener('click', () => {
        const fileInput = document.getElementById('canvasFileInput');
        fileInput.click();
    });

    document.getElementById('canvasFileInput').addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('excelFile', file); // Corrected key to match server-side expectation

        fetch('/ABS-ISTA/group/importModelCanva', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message || 'Importation réussie.');
            fetchGroups(); // Recharger après import
        })
        .catch(err => {
            console.error(err);
            alert('Erreur lors de l\'importation.');
        });
    });

    fetchGroups(); // Charger au démarrage
});
</script>

</body>
</html>