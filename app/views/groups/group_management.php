<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Groupes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 删除: <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- 删除: <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

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
      <main class="main-content">
        <!-- <h1 class="text-2xl font-bold mb-4">Gestion des Groupes</h1> -->

        <!-- Group Information -->
        <div class="mb-4">
            <h2 class="text-xl text-blue-700 font-bold">Informations du Groupe</h2>
            <p><strong>Nom du Groupe:</strong> <?= htmlspecialchars($group['groupe_name']) ?></p>
            <p><strong>Filière:</strong> <?= htmlspecialchars($group['filiere_name']) ?></p>
        </div>

        <!-- Dropdown to select user as manager -->
        <div class="mb-4">
            <form action="/ABS-ISTA/group/assignManager" method="POST" class="max-w-md">
                <input type="hidden" name="groupe_id" value="<?= htmlspecialchars($group['groupe_id']) ?>">
                <label for="user_id" class="block text-sm font-medium text-gray-700">Sélectionnez un gestionnaire:</label>
                <select class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="user_id" name="user_id" required>
                    <option value="">-- Sélectionnez un utilisateur --</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= htmlspecialchars($user['user_id']) ?>" <?= $user['user_id'] == $group['user_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($user['username']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Assigner</button>
            </form>
        </div>
      </main>
    </div>
  </div>
  </div>
</div>

</body>
</html>


