<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css" type="text/css">
    <title>Dashboard</title>
</head>
<body>
<?php
require_once './app/Views/header.php';
?>
<div class="dashboard-container">
    <main class="main-dashboard-content">
        <h1>DASHBOARD</h1>
        <h2><?php echo $_SESSION['name'] ?? '' ?></h2>
        <h2 class="current-projects-title">Proyectos actuales</h2>
        <div class="button-wrapper-dashboard">
            <button class="app-btn" id="new-project-button">Nuevo proyecto</button>
        </div>
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
        <div style="margin-top: 2rem">
            <a href="/report/taskCountByStatus"><h4>Tareas por estado</h4></a>
            <a href="/report/tasksByUserAndProject"><h4>Tareas por usuario y proyecto</h4></a>
            <a href="/report/totalTimeByProject"><h4>Tiempo total invertido en cada proyecto</h4></a>
            <a href="/report/taskStatusHistory"><h4>Historial de cambios de estado en tareas</h4></a>
        </div>
    </main>
</div>
<script>
    const buttonCreate = document.getElementById('new-project-button');
    buttonCreate.addEventListener("click", () => {
        window.location.href = '/projects/create'
    })
</script>
</body>
</html>

