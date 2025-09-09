<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Quiz App</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form action="/QuizApp/authenticate" method="POST">
		<input type="text" name="username_or_email" placeholder="Username or Email" required>
		<input type="password" name="password" placeholder="Password" required>
		<button type="submit">Login</button>
		</form>

    </div>
</body>
</html>
