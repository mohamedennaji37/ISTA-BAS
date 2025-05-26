<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stagiaire Absences</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
<button class="mobile-toggle" id="toggleSidebar"><i class="bi bi-list"></i></button>
    <?php if ($_SESSION['role'] === 'admin'): ?>
        <?php include __DIR__ . '/../partials/sidebar.html'; ?>
    <?php endif; ?>
    <?php if ($_SESSION['role'] === 'gestionnaire'): ?>
        <?php include __DIR__ . '/../partials/gestionnaireSidebar.html'; ?>
    <?php endif; ?>

<div id="content" class="container mx-30 flex justify-center  min-h-screen">
<div class="w-full max-w-6xl">

    <h1 class="text-2xl font-bold mb-6 text-center"><?= htmlspecialchars($groupeName) ?></h1>
    
    <!-- Mark Absences Form -->
    <form action="/ABS-ISTA/absence/addView" method="get">
        <input type="hidden" name="groupeName" value="<?= htmlspecialchars($groupeName) ?>">
        <div class="mb-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Ajout absence
            </button>
        </div>
    </form>

    <!-- Table -->
    <div class="bg-white shadow-md rounded overflow-hidden">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2  text-gray-600">N</th> <!-- New column for incrementing number -->
                    <th class="px-4 py-2  text-gray-600">Nom</th>
                    <th class="px-4 py-2  text-gray-600">Prenom</th>
                    <th class="px-4 py-2  text-gray-600">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($stagiaires)): ?>
                    <?php $counter = 1; // Initialize counter ?>
                    <?php foreach ($stagiaires as $stagiaire): ?>
                        <tr class="border-b">
                            <td class="px-4 py-2"><?= $counter++ ?></td> <!-- Display and increment counter -->
                            <td class="px-4 py-2"><?= htmlspecialchars($stagiaire['last_name']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($stagiaire['first_name']) ?></td>
                            <td class="px-4 py-2">
                                 <a href="/ABS-ISTA/absence/stagiare/details?stagiaire_id=<?= urlencode($stagiaire['stagiaire_id']) ?>" 
                                    class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 no-underline">
                                    Plus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center text-gray-500">No stagiaires found.</td> <!-- Updated colspan to 4 -->
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>