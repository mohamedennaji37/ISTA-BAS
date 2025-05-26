<?php // views/login.php ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ISTA-ABS Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="/ABS-ISTA/app/views/auth/login.css" rel="stylesheet">
</head>
<body>
  <div class="container login-container">
    <div class="login-header text-center mb-4">
      <h1>ISTA-ABS</h1>
      <p>Système de Suivi des Absences</p>
    </div>
    <div class="card login-card mx-auto" style="max-width:400px;">
      <div class="card-header">
        <h2 class="card-title h5">Connexion</h2>
        <p class="card-subtitle text-muted">Connexion au système</p>
      </div>
      <div class="card-body">
      <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" role="alert">
          <?php echo htmlspecialchars(urldecode($_GET['error'])); ?>
        </div>
      <?php elseif (isset($_GET['blocked'])): ?>
        <div class="alert alert-warning" role="alert">
          <?php echo htmlspecialchars(urldecode($_GET['blocked'])); ?>
        </div>
      <?php endif; ?>
        <form method="post" action="/ABS-ISTA/check">
          <div class="mb-3">
            <label for="username" class="form-label">Nom d’utilisateur</label>
            <input type="text" id="username" name="username" class="form-control">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" id="password" name="password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Se connecter</button>
        </form>
      </div>
    </div>
    <div class="footer text-center mt-4">
      <p>&copy; <?= date('Y') ?> ISTA-ABS. Tous droits réservés.</p>
    </div>
  </div>
  <script src="script.js"></script>
</body>
</html>
