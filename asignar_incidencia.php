<?php
require_once __DIR__ . '/conexion.php';

$incidenciaId = filter_input(INPUT_POST, 'incidencia_id', FILTER_VALIDATE_INT);
$tecnicoId = filter_input(INPUT_POST, 'tecnico_id', FILTER_VALIDATE_INT);

if (!$incidenciaId || !$tecnicoId) {
    header('Location: index.php?error=datos_invalidos');
    exit;
}

try {
    $pdo->beginTransaction();

    $sqlAsignar = "UPDATE incidencias 
                   SET estado = 'En Proceso', tecnico_id = :tecnico_id 
                   WHERE id = :incidencia_id";

    $stmt = $pdo->prepare($sqlAsignar);
    $stmt->execute([
        ':tecnico_id' => $tecnicoId,
        ':incidencia_id' => $incidenciaId
    ]);

    // Línea de prueba para simular un error y verificar que la transacción se revierte correctamente,
   // descomenta la siguiente línea y asigna un técnico cualquiera. Lo he comprobado asi porque me daba fallo ejecutar.

     //$pdo->query("SELECT * FROM tabla_que_no_existe");

    $pdo->commit();

    header('Location: index.php?asignada=' . $incidenciaId);
    exit;
} catch (Exception $e) {
    $pdo->rollBack();

    error_log('Error en la asignación: ' . $e->getMessage());

    echo "Error en la asignación. Los cambios han sido anulados: " . htmlspecialchars($e->getMessage());
}
