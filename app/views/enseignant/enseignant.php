<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Enseignants</title>
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
            <nav class="navbar navbar-expand navbar-light bg-white py-1" style="border-bottom: 1px solid black; margin: 10px;">
                <div class="container-fluid">
                    <span id="path" class="navbar-brand mb-0 h1"><i class="bi bi-person-vcard"></i> Gestion des Enseignants</span>
                    <div class="ms-auto"><span class="text-muted" id="User"></span></div>
                </div>
            </nav>

            <main class="main-content p-2">
                <div class="mb-3">
                    <button id="downloadCanvasBtn" class="btn btn-primary me-2">
                        <i class="bi bi-download"></i> Télécharger un canva
                    </button>
                    <button id="importCanvasBtn" class="btn btn-secondary me-2">
                        <i class="bi bi-upload"></i> Importer un canva
                    </button>
                    <input type="file" id="canvasFileInput" accept=".xlsx,.xls" style="display: none;">
                </div>

                <div class="mb-3">
                    <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un enseignant...">
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>enseignant_id</th>
                            <th>first_name</th>
                            <th>last_name</th>
                            <th>email</th>
                            <th>phone</th>
                        </tr>
                    </thead>
                    <tbody id="enseignantsTableBody">
                        <!-- Contenu injecté par JavaScript -->
                    </tbody>
                </table>
            </main>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    let enseignants = [];
    const tableBody = document.getElementById('enseignantsTableBody');
    const searchInput = document.getElementById('searchInput');
    const importBtn = document.getElementById('importCanvasBtn');
    const downloadBtn = document.getElementById('downloadCanvasBtn');

    function fetchEnseignants() {
        fetch('/ABS-ISTA/enseignant/listEnseignants')
            .then(response => response.json())
            .then(data => {
                enseignants = data;
                renderEnseignants(enseignants);
            });
    }

    function renderEnseignants(list) {
        tableBody.innerHTML = '';
        list.forEach(e => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${e.enseignant_id}</td>
                <td>${e.first_name}</td>
                <td>${e.last_name}</td>
                <td>${e.email}</td>
                <td>${e.phone}</td>
            `;
            tableBody.appendChild(tr);
        });
    }

    searchInput.addEventListener('input', () => {
        const keyword = searchInput.value.toLowerCase();
        const filtered = enseignants.filter(e =>
            e.first_name.toLowerCase().includes(keyword) ||
            e.last_name.toLowerCase().includes(keyword) ||
            e.email.toLowerCase().includes(keyword)
        );
        renderEnseignants(filtered);
    });

    downloadBtn.addEventListener('click', () => {
        window.location.href = '/ABS-ISTA/enseignant/downloadModelCanva';
    });

    importBtn.addEventListener('click', () => {
        document.getElementById('canvasFileInput').click();
    });

    document.getElementById('canvasFileInput').addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('excelFile', file);

        fetch('/ABS-ISTA/enseignant/importModelCanva', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message || 'Importation réussie.');
            fetchEnseignants();
        })
        .catch(err => {
            console.error(err);
            alert("Erreur lors de l'importation.");
        });
    });

    fetchEnseignants();
});
</script>

</body>
</html>
