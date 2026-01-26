<?php
require_once "config.php";
require_once "Usuario.php";

$usuario = new Usuario($pdo);
$usuarios = $usuario->listar();

$ok = isset($_GET["ok"]);
$del = isset($_GET["del"]);
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Usuarios</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <nav class="navbar navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="list.php">CRUD Usuarios</a>
      <a class="btn btn-outline-light btn-sm" href="register.php">+ Nuevo</a>
    </div>
  </nav>

  <div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <div>
        <h1 class="h4 mb-0">Usuarios registrados</h1>
        <div class="text-muted">Total: <?= count($usuarios) ?></div>
      </div>
      <a class="btn btn-primary" href="register.php">Registrar usuario</a>
    </div>

    <?php if ($ok): ?>
      <div class="alert alert-success">✅ Operación realizada correctamente.</div>
    <?php endif; ?>
    <?php if ($del): ?>
      <div class="alert alert-warning">🗑️ Usuario eliminado.</div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
              <tr>
                <th style="width: 70px;">ID</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th style="width: 190px;" class="text-end">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($usuarios)): ?>
                <tr>
                  <td colspan="6" class="text-center py-4 text-muted">
                    No hay usuarios registrados todavía.
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($usuarios as $u): ?>
                  <tr>
                    <td><?= (int)$u["id"] ?></td>
                    <td><?= htmlspecialchars($u["nombres"]) ?></td>
                    <td><?= htmlspecialchars($u["apellidos"]) ?></td>
                    <td><?= htmlspecialchars($u["email"]) ?></td>
                    <td><?= htmlspecialchars($u["telefono"] ?? "") ?></td>
                    <td class="text-end">
                      <a class="btn btn-sm btn-outline-primary"
                         href="edit.php?id=<?= (int)$u["id"] ?>">
                        Editar
                      </a>
                      <a class="btn btn-sm btn-outline-danger"
                         href="delete.php?id=<?= (int)$u["id"] ?>"
                         onclick="return confirm('¿Seguro que deseas eliminar este usuario?');">
                        Eliminar
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="text-muted small mt-3">
      Tip: usa “Editar” para actualizar y “Eliminar” para borrar un registro.
    </div>
  </div>
</body>
</html>
