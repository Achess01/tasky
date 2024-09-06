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
    <h2><?php echo isset($task) && isset($is_edit) && $is_edit ? 'Editar ' . $task['name'] : 'Nueva tarea' ?></h2>
    <div class="container-small">
        <form method="POST" action="/projects/task?id=<?php echo isset($project) ? $project['project_id'] : 0 ?><?php echo isset($task_id) && $task_id != null ? '&task_id=' . $task_id : '' ?>">
            <?php if (isset($error)) : ?>
                <p style="color:red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <?php if (isset($project)) : ?>
                <input type="text" name="project_id" hidden value="<?php echo $project['project_id'] ?>">
            <?php endif; ?>
            <?php if (isset($task) && $task != null) : ?>
                <input type="text" name="task_id" hidden value="<?php echo $task['task_id'] ?>">
            <?php endif; ?>
            <div class="input-container">
                <label for="name">
                    <strong>Nombre</strong>
                    <br/>
                    <input type="text" name="name" required maxlength="100"
                           value="<?php echo (isset($task)) ? $task['name'] : '' ?>">
                </label>
            </div>
            <div class="input-container">
                <label for="description">
                    <strong>Descripción</strong>
                    <br/>
                    <input type="text" name="description" required
                           value="<?php echo (isset($task)) ? $task['description'] : '' ?>">
                </label>
            </div>
            <?php if (isset($users)) : ?>

                <div class="input-container">
                    <label for="assigned_user_id">
                        <strong>Usuario asignado</strong>
                        <br/>
                        <select name="assigned_user_id">
                            <option value=''>-----</option>
                            <?php foreach ($users
                                           as $user) : ?>
                                <option value="<?php echo $user['user_id'] ?>"
                                    <?php echo (isset($task) && $user['user_id'] == $task['assigned_user_id']) ? 'selected' : '' ?>
                                    ><?php echo $user['email'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>

            <?php endif; ?>

            <?php if (isset($status)) : ?>

                <div class="input-container">
                    <label for="project_task_status">
                        <strong>Estado de la tarea</strong>
                        <br/>
                        <select name="project_task_status" required>
                            <?php foreach ($status
                                           as $st) : ?>
                                <option value="<?php echo $st['project_task_status'] ?>" <?php echo (isset($task) && $st['project_task_status'] == $task['project_task_status']) ? 'selected' : '' ?>><?php echo $st['name'] . ' - ' . $st['description'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>

            <?php endif; ?>

            <?php if (isset($tasks)) : ?>

                <div class="input-container">
                    <label for="parent_id">
                        <strong>Tarea padre</strong>
                        <br/>
                        <select name="parent_id">
                            <option value=''>-----</option>
                            <?php foreach ($tasks
                                           as $t) : ?>
                                <option value="<?php echo $t['task_id'] ?>"
                                    <?php echo (isset($task) && $t['parent_id'] == $task['parent_id']) ? 'selected' : '' ?>
                                ><?php echo $t['name'] . ' - ' . $t['description'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>

            <?php endif; ?>
            <div class=" input-container
                        ">
                <label for="start_date">
                    <strong>Fecha de inicio</strong>
                    <br/>
                    <input type="date" name="start_date" required
                           value="<?php echo (isset($task)) ? $task['start_date'] : '' ?>"
                    >
                </label>
            </div>
            <div class="input-container">
                <label for="due_date">
                    <strong>Fecha estimada de finalización</strong>
                    <br/>
                    <input type="date" name="due_date" required
                           value="<?php echo (isset($task)) ? $task['due_date'] : '' ?>"
                    >
                </label>
            </div>
            <div class="button-container">
                <button type="submit"
                        class="app-btn"><?php echo isset($task) && isset($is_edit) && $is_edit ? 'Editar ' . $task['name'] : 'Crear' ?></button>
            </div>
        </form>
    </div>
</div>
</body>
</html>


