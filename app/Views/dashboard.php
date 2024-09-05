<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css" type="text/css">
    <title>Dashboard</title>
</head>
<body>
<div class="header">
    <div class="header-content">
        <h1>Tasky</h1>
        <a href="/logout">Cerrar sesión</a>
    </div>
</div>
<div class="dashboard-container">
    <main class="main-dashboard-content">
        <h1>DASHBOARD</h1>
        <h2><?php echo $_SESSION['name'] ?? '' ?></h2>
        <h2 class="current-projects-title">Proyectos actuales</h2>
        <div class="projects">
            <?php if (isset($projects)) : ?>
                <?php foreach ($projects as $project) : ?>
                    <div class="card-project">
                        <div class="card-header">
                            <h3>
                                <?php
                                echo $project['name'];
                                ?>
                            </h3>
                        </div>
                        <p>
                            <?php
                            echo $project['description'];
                            ?>
                        </p>
                        <div class="footer-card">
                            <small>
                                Fecha de entrega:
                                <?php
                                echo $project['estimate_end_date'];
                                ?>
                            </small>
                            <a href="/projects?id=<?php echo $project['project_id'] ?>">Ver</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

</div>
</body>
</html>

