<?php
require_once "config.php";
require_once "Usuario.php";

$usuario = new Usuario($pdo);

$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
if ($id <= 0) die("ID inválido.");

$usuario->eliminar($id);
header("Location: list.php?del=1");
exit;