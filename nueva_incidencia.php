<?php
require_once __DIR__ . '/conexion.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_SPECIAL_CHARS);
    $prioridad = filter_input(INPUT_POST, 'prioridad', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if (!$titulo || !$descripcion || !$prioridad || !$email) {
        $error = "Todos los campos son obligatorios y el email debe ser válido.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO incidencias (titulo, descripcion, prioridad, email) VALUES (:titulo, :descripcion, :prioridad, :email)");
            $stmt->execute([
                ':titulo'      => ($titulo),
                ':descripcion' => ($descripcion),
                ':prioridad'   => ($prioridad),
                ':email'       => $email,
            ]);

           $incidenciaId = $pdo->lastInsertId();
    
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $error = "Error al registrar la incidencia.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>TaskShield - Nueva Incidencia</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Crear Nueva Incidencia</h1>
    <a href="index.php">← Volver al Panel</a>


    <form action="nueva_incidencia.php" method="POST">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4" required><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>

        <label for="prioridad">Prioridad:</label>
        <select id="prioridad" name="prioridad" required>
            <option value="">Seleccione una prioridad</option>
            <option value="Alta" <?= (isset($_POST['prioridad']) && $_POST['prioridad'] === 'Alta') ? 'selected' : '' ?>>Alta</option>
            <option value="Media" <?= (isset($_POST['prioridad']) && $_POST['prioridad'] === 'Media') ? 'selected' : '' ?>>Media</option>
            <option value="Baja" <?= (isset($_POST['prioridad']) && $_POST['prioridad'] === 'Baja') ? 'selected' : '' ?>>Baja</option>
        </select>

        <label for="email">Email del cliente:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

        <button type="submit">Crear Incidencia</button>
    </form>
</body>

</html>