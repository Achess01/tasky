<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<div class="form-container">
    <div>
        <form method="POST" action="/login">
            <h1>Tasky</h1>
            <?php if (isset($error)) : ?>
                <p style="color:red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <div class="input-container">
                <label for="email">
                    <strong>Email</strong>
                    <br/>
                    <input type="email" name="email" required>
                </label>
            </div>
            <div class="input-container">
                <label>
                    <strong>Password</strong>
                    <br/>
                    <input type="password" name="password" required>
                </label>
            </div>
            <div>
                <button type="submit" class="app-btn">Login</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
