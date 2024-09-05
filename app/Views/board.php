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
<?php if (isset($project)) : ?>
    <div class="project-board-container">
        <a href="/dashboard"><h3>Regresar</h3></a>
        <br/>
        <h2><?= $project['name'] ?></h2>
        <br/>
        <div class="main-board-content">
            <?php if (isset($separated_tasks) && isset($status)) : ?>
                <?php foreach ($status as $status_section) : ?>
                    <div class="section-task dropzone" id="<?php echo $status_section['project_task_status'] ?>">
                        <stong><?php echo $status_section['name'] ?></stong>
                        <?php foreach ($separated_tasks[$status_section['project_task_status']] as $task) : ?>
                            <div class="card-task" draggable="true" id="<?php echo $task['task_id'] ?>">
                                <div class="card-header">
                                    <h3>
                                        <?php
                                        echo $task['name'];
                                        ?>
                                    </h3>
                                </div>
                                <p>
                                    <?php
                                    echo $task['description'];
                                    ?>
                                </p>
                                <small>
                                    Fecha de entrega:
                                    <?php
                                    echo $task['due_date'];
                                    ?>
                                </small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<script>
    let dragged = null;
    const cards = Array.from(document.getElementsByClassName('card-task'));
    const sections = Array.from(document.getElementsByClassName('section-task'));

    cards.forEach((element) => element.addEventListener("dragstart", (event) => {
        dragged = event.target;
    }));

    sections.forEach((element) => element.addEventListener("dragover", (event) => {
        event.preventDefault();
    }));

    sections.forEach((element) => element.addEventListener("drop", (event) => {
        event.preventDefault();
        updateEntity(event.target.id, dragged.id, () => {
            if (event.target.className === "section-task dropzone") {
                dragged.parentNode.removeChild(dragged);
                event.target.appendChild(dragged);
            }
        })
    }));


    function updateEntity(status_id, task_id, onSuccess) {
        fetch('/task/update-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                project_id: <?php echo $project['project_id'] ?>,
                task_id: parseInt(task_id),
                status_id: parseInt(status_id),
            }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Entity updated successfully!");
                    onSuccess();
                } else {
                    console.log("Error updating entity.");
                    alert('No se pudo actualizar la información. Revise sus permisos')
                }
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    }

</script>
</body>
</html>


