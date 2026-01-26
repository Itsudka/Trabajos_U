<?php
// Usuario.php
class Usuario {
  private PDO $db;

  public function __construct(PDO $pdo) {
    $this->db = $pdo;
  }

  // INSERTAR
  public function insertar(array $data): bool {
    $sql = "INSERT INTO usuarios (nombres, apellidos, email, telefono)
            VALUES (:nombres, :apellidos, :email, :telefono)";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
      ":nombres" => trim($data["nombres"] ?? ""),
      ":apellidos" => trim($data["apellidos"] ?? ""),
      ":email" => trim($data["email"] ?? ""),
      ":telefono" => trim($data["telefono"] ?? "")
    ]);
  }

  // LISTAR
  public function listar(): array {
    $stmt = $this->db->query("SELECT * FROM usuarios ORDER BY id DESC");
    return $stmt->fetchAll();
  }

  // OBTENER UNO (para editar)
  public function obtenerPorId(int $id): ?array {
    $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->execute([":id" => $id]);
    $row = $stmt->fetch();
    return $row ?: null;
  }

  // MODIFICAR
  public function modificar(int $id, array $data): bool {
    $sql = "UPDATE usuarios
            SET nombres = :nombres,
                apellidos = :apellidos,
                email = :email,
                telefono = :telefono
            WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
      ":nombres" => trim($data["nombres"] ?? ""),
      ":apellidos" => trim($data["apellidos"] ?? ""),
      ":email" => trim($data["email"] ?? ""),
      ":telefono" => trim($data["telefono"] ?? ""),
      ":id" => $id
    ]);
  }

  // ELIMINAR
  public function eliminar(int $id): bool {
    $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id = :id");
    return $stmt->execute([":id" => $id]);
  }
}
