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
    <h2>Editar roles del proyecto <?php echo isset($project) ? $project['name'] : '' ?></h2>
    <div class="container-small">
        <?php if (isset($usersInProject) && isset($roles)): ?>
            <?php foreach ($usersInProject as $user): ?>
                <form action="" method="POST">
                    <div class="input-container">
                        <label for="user_<?= $user['user_id'] ?>">
                            <strong>
                                User: <?= $user['email'] ?>
                            </strong>
                            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                        </label>
                    </div>
                    <div class="input-container">
                        <label for="role_id">
                            <strong>
                                Rol
                            </strong>
                            <br/>
                            <select name="role_id" id="role_<?= $user->user_id ?>" required>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= $role['role_id'] ?>" <?= $user['role_id'] == $role['role_id'] ? 'selected' : '' ?>><?= $role['name'] . ' - ' . $role['description'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                    </div>

                    <div style="width: 300px; margin-bottom: 2rem">
                        <button type="submit" class="app-btn">Actualizar rol</button>
                    </div>
                </form>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (isset($projectId)): ?>
            <br>
            <br>
            <a href="/projects?id=<?= $projectId ?>"><h4>Regresar</h4></a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>



