<?php
require_once __DIR__ . '/conexion.php';

$idPersona = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

$mensaje = "";

try {
    $sql = "DELETE FROM incidencias
    WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':id' => $idPersona
    ]);

    if ($stmt->rowCount() > 0) {
        $mensaje = "Registro #" . htmlspecialchars($idPersona) . " eliminado correctamente.";
    } else {
        $mensaje = "No se encontró el registro en la base de datos.";
        $error = true;
    }

} catch (PDOException $e) {
    error_log($e->getMessage());
    $mensaje = "Error al eliminar el registro de la base de datos.";
    $error = true;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskShield - Eliminar Incidencia</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Eliminar Incidencia</h1>
        <a href="index.php" class="btn-volver">Volver al Panel</a>
    </header>

    <div class="formulario">
            <?= $mensaje ?>
        </p>
    </div>
</div>
</body>
</html>