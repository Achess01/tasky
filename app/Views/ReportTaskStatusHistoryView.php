<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css" type="text/css">
    <title>Reporte</title>
</head>
<body>
<?php
require_once './app/Views/header.php';
?>
<div class="project-board-container">
    <h2>Reporte: Historial de cambios de estado por tarea</h2>
    <div class="container-small">
        <?php if (isset($data)): ?>
            <table>
                <thead>
                <tr>
                    <th>Tarea</th>
                    <th>Fecha de Cambio</th>
                    <th>Estado Anterior</th>
                    <th>Estado Nuevo</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= $row->task_name ?></td>
                        <td><?= $row->changed_on ?></td>
                        <td><?= $row->previous_status ?></td>
                        <td><?= $row->new_status ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        <?php endif; ?>
    </div>
</div>
</body>
</html>

