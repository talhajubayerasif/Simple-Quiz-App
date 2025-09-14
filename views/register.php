<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_type = $_POST['user_type'];

    $stmt = $conn->prepare("INSERT INTO users (full_name, username, gender, email, password, user_type) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $full_name, $username, $gender, $email, $password, $user_type);

    if ($stmt->execute()) {
        header("Location: register.php?success=true");
    } else {
        header("Location: register.php?error=true");
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <h2>Signup</h2>
    <?php if (isset($_GET['success'])): ?>
        <div class="message success">✅ Registration successful! <a href="login.php">Login here</a></div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="message error">❌ Registration failed. Try again.</div>
    <?php endif; ?>
    <form action="register.php" method="POST">
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="text" name="username" placeholder="Username" required>
        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="user_type" required>
            <option value="student">Student</option>
            <option value="quiz_author">Quiz Author</option>
        </select>
        <button type="submit">Sign Up</button>
    </form>
</div>
</body>
</html>
