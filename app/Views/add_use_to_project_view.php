<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css" type="text/css">
    <title><?php echo isset($task) && isset($is_edit) && $is_edit ? 'Editar ' . $task['name'] : 'Nueva tarea' ?></title>
</head>
<body>
<?php
require_once './app/Views/header.php';
?>
<div class="project-board-container">
    <h2>Usuarios del proyecto <?php echo isset($project) ? $project['name'] : '' ?></h2>
    <div class="container-small">
        <form action="" method="POST">
            <?php if (isset($users)) : ?>
                <div class="input-container">
                    <label for="user_id">
                        <strong>Selecciona un usuario</strong>
                        <br/>
                        <select name="user_id" required>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user['user_id'] ?>"><?= $user['email'] ?></option>
                            <?php endforeach; ?>
                        </select
                    </label>
                </div>

            <?php endif; ?>
            <?php if (isset($roles)) : ?>
                <div class="input-container">
                    <label for="role_id">
                        <strong>Selecciona un role</strong>
                        <br/>
                        <select name="role_id" required>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['role_id'] ?>"><?= $role['name'] . ' - ' . $role['description'] ?></option>
                            <?php endforeach; ?>
                        </select
                    </label>
                </div>

            <?php endif; ?>
            <button type="submit" class="app-btn">Agregar usuario</button>
        </form>
    </div>
</div>
</body>
</html>


