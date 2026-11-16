<?php
require_once __DIR__ . '/conexion.php';

$stmt = $pdo->prepare("SELECT id, titulo, descripcion, prioridad, estado, tecnico_id, fecha_creacion FROM incidencias WHERE estado != 'Resuelta' ORDER BY fecha_creacion DESC");
$stmt->execute();
$incidencias = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT id, nombre FROM tecnicos ORDER BY nombre");
$stmt->execute();
$tecnicos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Panel de Incidencias</h1>
    <a href="nueva_incidencia.php">Nueva Incidencia</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Prioridad</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Técnico</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($incidencias as $incidencia): ?>
                <tr>
                    <td><?= $incidencia['id'] ?></td>
                    <td><?= htmlspecialchars($incidencia['titulo']) ?></td>
                    <td><?= htmlspecialchars($incidencia['descripcion']) ?></td>
                    <td><?= htmlspecialchars($incidencia['prioridad']) ?></td>
                    <td><?= htmlspecialchars($incidencia['estado']) ?></td>
                    <td><?= $incidencia['fecha_creacion'] ?></td>
                    <td>
                        <form action="asignar_incidencia.php" method="POST">
                            <input type="hidden" name="incidencia_id" value="<?= $incidencia['id'] ?>">
                            <select name="tecnico_id" onchange="this.form.submit()">
                                <?php foreach ($tecnicos as $tecnico): ?>
                                    <option value="<?= $tecnico['id'] ?>" <?= (int) $incidencia['tecnico_id'] === (int) $tecnico['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($tecnico['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </td>
                    <td>
                        <a href="editar_incidencia.php?id=<?= $incidencia['id'] ?>">Editar</a>
                        <form action="eliminar_incidencia.php" method="POST">
                            <input type="hidden" name="id" value="<?= $incidencia['id'] ?>">
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>