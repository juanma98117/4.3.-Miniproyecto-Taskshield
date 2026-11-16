<?php
require_once __DIR__ . '/conexion.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_SPECIAL_CHARS);
    $prioridad = filter_input(INPUT_POST, 'prioridad', FILTER_SANITIZE_SPECIAL_CHARS);
    $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($titulo && $descripcion && $prioridad && $estado) {
        try {
            $stmt = $pdo->prepare("UPDATE incidencias SET titulo = :titulo, descripcion = :descripcion, prioridad = :prioridad, estado = :estado WHERE id = :id");
            $stmt->execute([
                ':titulo'      => $titulo,
                ':descripcion' => $descripcion,
                ':prioridad'   => $prioridad,
                ':estado'      => $estado,
                ':id'          => $id
            ]);

        } catch (PDOException $e) {
            error_log($e->getMessage());
            die('Error al actualizar la incidencia.');
        }
    }
}

try {
    $stmt = $pdo->prepare("SELECT id, titulo, descripcion, prioridad, estado FROM incidencias WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $incidencia = $stmt->fetch();

} catch (PDOException $e) {
    error_log($e->getMessage());
    die('Error al obtener la incidencia.');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>TaskShield - Editar Incidencia</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Editar Incidencia #<?= htmlspecialchars($incidencia['id']) ?></h1>
    <a href="index.php">← Volver al Panel</a>

    <form action="" method="POST">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($incidencia['titulo']) ?>" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4" required><?= htmlspecialchars($incidencia['descripcion']) ?></textarea>

        <label for="prioridad">Prioridad:</label>
        <select id="prioridad" name="prioridad" required>
            <option value="">Seleccione una prioridad</option>
            <option value="Alta" <?= $incidencia['prioridad'] === 'Alta' ? 'selected' : '' ?>>Alta</option>
            <option value="Media" <?= $incidencia['prioridad'] === 'Media' ? 'selected' : '' ?>>Media</option>
            <option value="Baja" <?= $incidencia['prioridad'] === 'Baja' ? 'selected' : '' ?>>Baja</option>
        </select>

        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
            <option value="Pendiente" <?= $incidencia['estado'] === 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
            <option value="En Proceso" <?= $incidencia['estado'] === 'En Proceso' ? 'selected' : '' ?>>En Proceso</option>
            <option value="Resuelta" <?= $incidencia['estado'] === 'Resuelta' ? 'selected' : '' ?>>Resuelta</option>
        </select>

        <button type="submit">Actualizar Incidencia</button>
    </form>
</body>

</html>