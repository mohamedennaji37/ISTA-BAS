<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Users</title>
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
        <h2 style="border-bottom: blue solid 5px;margin-bottom: 10px; margin-top: 5px;"> <i class="bi bi-person-lines-fill"></i>Gestion de compte</h2>

        <!-- Button to add a new user -->
        <div class="mb-3">
          <a href="/ABS-ISTA/addUser" class="btn btn-primary" id="addUserButton"><i class="bi bi-person-plus"></i> Ajouter Utilisateur</a>
        </div>

        <!-- Search bar for nom complet -->
        <div class="mb-3">
          <input type="text" id="searchInput" class="form-control" placeholder="Rechercher par nom complet">
        </div>

        <!-- Table displaying accounts -->
        <table class="table table-striped">
          <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Type de compte</th>
            <th>Droits d'acces</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody id="accountsTableBody">
          <?php foreach ($users as $user): ?>
          <tr>
            <td><?= htmlspecialchars($user['user_id']) ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['role']) ?></td>
            <td><?= $user['username'] == 'admin' ? 'Tout les droits' : 'Developpement Info' ?></td>
            <td>
              <form method="POST" action="/ABS-ISTA/toggleAccountStatus" style="display:inline;" onsubmit="return confirm('Voulez-vous vraiment changer le statut de ce user ?');">
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
                <input type="hidden" name="blockedNum" value="<?= htmlspecialchars($user['blocked']) ?>">
                <button type="submit" class="btn btn-sm <?= $user['blocked'] ? 'btn-success' : 'btn-danger' ?>">
                  <?= $user['blocked'] ? 'Unblock' : 'Block' ?>
                </button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </main>
    </div>
  </div>
</div>


</body>
</html>
