<?php
include_once('../config.php'); // Adjust path as needed

class Bitacora {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Log an action to the bitacora table.
     *
     * @param int $usuarioId The ID of the user performing the action.
     * @param string $descripcion A description of the action performed.
     * @return void
     */
    public function logAction($usuarioId, $descripcion) {
        $sql = "INSERT INTO bitacora (usuario_id, descripcion) VALUES (:usuario_id, :descripcion)";
        $query = $this->pdo->prepare($sql);
        $query->execute([
            ':usuario_id' => $usuarioId,
            ':descripcion' => $descripcion
        ]);
    }
}
?>
