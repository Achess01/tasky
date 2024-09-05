<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css" type="text/css">
    <title>Proyecto <?php if (isset($project)) echo $project['name'] ?></title>
</head>
<body>
<div class="header">
    <div class="header-content">
        <h1>Tasky</h1>
        <a href="/logout">Cerrar sesión</a>
    </div>
</div>
<div class="project-board-container">
    <a href="/dashboard"><h3>Regresar</h3></a>
    <h2>Crear proyecto</h2>
    <div class="container-small">
        <form method="POST" action="/projects/create">
            <?php if (isset($error)) : ?>
                <p style="color:red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <div class="input-container">
                <label for="name">
                    <strong>Nombre</strong>
                    <br/>
                    <input type="text" name="name" required>
                </label>
            </div>
            <div class="input-container">
                <label for="description">
                    <strong>Descripción</strong>
                    <br/>
                    <input type="text" name="description" required>
                </label>
            </div>
            <div class="input-container">
                <label for="start_date">
                    <strong>Fecha de inicio</strong>
                    <br/>
                    <input type="date" name="start_date" required>
                </label>
            </div>
            <div class="input-container">
                <label for="estimate_end_date">
                    <strong>Fecha estimada de finalización</strong>
                    <br/>
                    <input type="date" name="estimate_end_date" required>
                </label>
            </div>
            <div class="button-container">
                <button type="submit" class="app-btn">Crear</button>
            </div>
        </form>
    </div>

</div>
</body>
</html>


