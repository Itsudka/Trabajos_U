<?php
require_once "config.php";
require_once "Usuario.php";

$usuario = new Usuario($pdo);
$msg = "";
$msgType = "danger";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (empty($_POST["nombres"]) || empty($_POST["apellidos"]) || empty($_POST["email"])) {
    $msg = "Completa nombres, apellidos y email.";
  } else {
    try {
      $usuario->insertar($_POST);
      header("Location: list.php?ok=1");
      exit;
    } catch (PDOException $e) {
      $msg = $e->getCode() == 23000
        ? "Ese email ya está registrado."
        : ("Error: " . $e->getMessage());
    }
  }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro de Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <nav class="navbar navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="list.php">CRUD Usuarios</a>
    </div>
  </nav>

  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="card shadow-sm border-0">
          <div class="card-body p-4">
            <h1 class="h4 mb-3">Registrar usuario</h1>
            <p class="text-muted mb-4">Completa la información para crear un nuevo registro.</p>

            <?php if ($msg): ?>
              <div class="alert alert-<?= $msgType ?> mb-3" role="alert">
                <?= htmlspecialchars($msg) ?>
              </div>
            <?php endif; ?>

            <form method="POST" class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Nombres</label>
                <input name="nombres" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Apellidos</label>
                <input name="apellidos" class="form-control" required>
              </div>

              <div class="col-12">
                <label class="form-label">Email</label>
                <input name="email" type="email" class="form-control" placeholder="correo@ejemplo.com" required>
              </div>

              <div class="col-12">
                <label class="form-label">Teléfono (opcional)</label>
                <input name="telefono" class="form-control" placeholder="3001234567">
              </div>

              <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                  Registrar
                </button>
                <a href="list.php" class="btn btn-outline-secondary">
                  Ver lista
                </a>
              </div>
            </form>

          </div>
        </div>

        <div class="text-center text-muted small mt-3">
          Hecho con PHP + MySQL + Bootstrap
        </div>
      </div>
    </div>
  </div>
</body>
</html>
