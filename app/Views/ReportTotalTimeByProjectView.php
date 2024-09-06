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
    <h2>Reporte: Tiempo total gastado en cada proyecto</h2>
    <div class="container-small">
        <?php if (isset($data)): ?>
            <table>
                <thead>
                <tr>
                    <th>Proyecto</th>
                    <th>Tiempo Total (Horas)</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= $row->project_name ?></td>
                        <td><?= $row->total_time ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        <?php endif; ?>
    </div>
</div>
</body>
</html>

