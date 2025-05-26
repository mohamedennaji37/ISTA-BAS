<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Filiere Selection</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function navigateToGroupDetails(groupName) {
            window.location.href = '/ABS-ISTA/absence/groupDetails?groupeName=' + encodeURIComponent(groupName); // Ensure groupName is encoded
        }
    </script>
</head>
<body class="bg-gray-100 text-gray-800">
<button class="mobile-toggle" id="toggleSidebar"><i class="bi bi-list"></i></button>
    <?php include __DIR__ . '/../partials/layout.html'; ?>
    <div id="content" class="container mx-auto p-6 flex justify-center items-center min-h-screen">
        <div class="ml-64 p-6" id="content">
            <h1 class="text-2xl font-bold mb-6 text-center">Sélectionnez votre groupe</h1>          

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Titre de la filière -->
                <?php foreach ($filieres as $filiere):  $groups = Groups::findByFiliereId($filiere['filiere_id']) ; ?>
                    <?php $fName = urlencode($filiere['filiere_name']); ?>
                    <div class="bg-white rounded-lg shadow p-6">
                        <!-- Titre de la filière -->
                        <h2 class="text-2xl font-bold text-blue-700 mb-1">
                                <?= htmlspecialchars($filiere['filiere_name']) ?>
                        </h2>
                        <!-- Sélection de classe et bouton lien -->
                        <div class="flex flex-col items-center space-y-4">
                                <select  class="w-full p-2 border border-gray-300 rounded" onchange="navigateToGroupDetails(this.value)">
                                    <option  disabled selected>Choisissez un groupe</option>
                                        <?php foreach ($groups as $groupe): ?>
                                            <option name="groupeName" value="<?= htmlspecialchars($groupe['groupe_name']) ?>"><?= htmlspecialchars($groupe['groupe_name']) ?></option>
                                        <?php endforeach; ?>
                                </select>
                            </div>
                    </div>
                <?php endforeach; ?>
            </div>
          
        </div>
    </div>
</body>
</html>