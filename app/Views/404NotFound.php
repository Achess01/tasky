<!DOCTYPE>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css" type="text/css">
    <title>404</title>
</head>
<body>
<div class="container-404">
    <h1>404 No encontrado</h1>
    <a href="/dashboard">Regresar</a>
    <?php if (isset($error)) echo $error ?>
</div>
</body>
</html>
