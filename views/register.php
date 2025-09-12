<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup</title>
    <link rel="stylesheet" href="/QuizApp/assets/css/style.css">
	
</head>
<body>
<div class="form-container">
    <h2>Signup</h2>

    <!-- Success/Error Messages -->
    <?php if (isset($_GET['success'])): ?>
        <div class="message success">✅ Registration successful!</div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="message error">❌ Registration failed. Try again.</div>
    <?php endif; ?>

    <form action="/QuizApp/register" method="POST">
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="text" name="username" placeholder="Username" required>
        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
	</form>
</div>
</body>
</html>
