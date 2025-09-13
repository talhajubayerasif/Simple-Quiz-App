<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="/QuizApp/assets/css/style.css">
</head>
<body>
<div class="form-container">
    <h2>Edit Profile</h2>
    <form method="POST" action="/QuizApp/profile-update">
        <!-- Use full_name instead of fullname -->
        <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']); ?>" required>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']); ?>" required>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
        <select name="gender" required>
            <option value="male" <?= $user['gender'] === 'male' ? 'selected' : ''; ?>>Male</option>
            <option value="female" <?= $user['gender'] === 'female' ? 'selected' : ''; ?>>Female</option>
            <option value="other" <?= $user['gender'] === 'other' ? 'selected' : ''; ?>>Other</option>
        </select>
        <button type="submit">Update</button>
    </form>
    <a href="/QuizApp/profile" class="btn">Cancel</a>
</div>
</body>
</html>