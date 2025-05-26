<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du stagiaire</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 text-gray-800">
<button class="mobile-toggle" id="toggleSidebar"><i class="bi bi-list"></i></button>

        <?php if ($_SESSION['role'] === 'admin'): ?>
            <?php include __DIR__ . '/../partials/sidebar.html'; ?>
        <?php endif; ?>
        <?php if ($_SESSION['role'] === 'gestionnaire'): ?>
            <?php include __DIR__ . '/../partials/gestionnaireSidebar.html'; ?>
        <?php endif; ?>


    <div id="content" class="container mx-30 flex justify-center  min-h-screen">
        <div class="w-full max-w-6xl">
            <div class="container mx-auto p-6">
                <div class="bg-white shadow-md rounded p-6">
                    <h1 class="text-2xl font-bold mb-4">Détails du stagiaire</h1>

                    <!-- Personal Information -->
                    <h2 class="text-xl font-semibold mb-2">Informations personnelles</h2>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div><strong>Nom :</strong> <?= htmlspecialchars($stagiaireDetails['first_name'].$stagiaireDetails['last_name']) ?></div>
                        <div><strong>ID :</strong> <?= htmlspecialchars($stagiaireDetails['stagiaire_id']) ?></div>
                        <div><strong>Email :</strong> <?= htmlspecialchars($stagiaireDetails['email']) ?></div>
                        <div><strong>Telephone :</strong> <?= htmlspecialchars($stagiaireDetails['phone']) ?></div>
                    </div>

                    <!-- Absence History -->
                    <h2 class="text-xl font-semibold mb-2">Historique de l'absence</h2>
                    <table class="table-auto w-full border-collapse border border-blue-200 mb-4">
                        <thead class="bg-blue-100">
                            <tr>
                                <th class="border border-blue-200 px-4 py-2">Date</th>
                                <th class="border border-blue-200 px-4 py-2">Module</th>
                                <th class="border border-blue-200 px-4 py-2">Seance</th>
                                <th class="border border-blue-200 px-4 py-2">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($absences as $absence): ?>
                                <tr>
                                    <td class="border border-blue-200 px-4 py-2"><?= htmlspecialchars($absence['seance_date']) ?></td>
                                    <td class="border border-blue-200 px-4 py-2"><?= htmlspecialchars($absence['module_name']) ?></td>
                                    <td class="border border-blue-200 px-4 py-2"><?= htmlspecialchars($absence['seance_time']) ?></td>
                                    <td class="border border-blue-200 px-4 py-2">
                                        <?php if ($absence['status'] === 'Justifiée'): ?>
                                            <span class="bg-green-500 text-white px-2 py-1 rounded">Justifiée</span>
                                        <?php elseif ($absence['status'] === 'Absent'): ?>
                                            <span class="bg-red-500 text-white px-2 py-1 rounded">Absent</span>
                                        <?php else: ?>
                                            <?= htmlspecialchars($absence['status']) ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-4">
                        <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600" onclick="confirmJustifyAll()">Justifier tout</button>
                        <button class="bg-red-300 text-gray-800 px-4 py-2 rounded hover:bg-red-400" onclick="history.back()">Fermer</button>
                    </div>

                    <script>
                        function confirmJustifyAll() {
                            if (confirm("Êtes-vous sûr de vouloir justifier toutes les absences de ce stagiaire? Cette action changera le statut de toutes les absences à 'Justifiée'.")) {
                                window.location.href = "/ABS-ISTA/absence/justifyAll?stagiaire_id=<?= $stagiaireDetails['stagiaire_id'] ?>&confirm=yes";
                            }
                        }

                        // Show success message if absences were justified
                        <?php if (isset($_GET['justified']) && $_GET['justified'] === 'true'): ?>
                            alert("Toutes les absences ont été justifiées avec succès!");
                        <?php endif; ?>
                    </script>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
