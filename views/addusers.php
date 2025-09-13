<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
</head>
<body>
    <h1>Create New User</h1>
    <form method="POST" action="">
        <label>Full Name:</label><br>
        <input type="text" name="full_name" required><br>

        <label>Username:</label><br>
        <input type="text" name="username" required><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br>

        <label>Gender:</label><br>
        <select name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br>

        <label>Role:</label><br>
        <select name="user_type" required>
            <option value="student">Student</option>
            <option value="quizauthor">Quiz Author</option>
            <option value="admin">Admin</option>
        </select><br><br>

        <button type="submit">Create User</button>
        <a href="/QuizApp/addusers.php" class="btn btn-primary mb-3">Add New User</a>

    </form>
</body>
</html>
