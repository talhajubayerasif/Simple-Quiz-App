<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <style>
        table { width:100%; border-collapse:collapse; margin:20px 0; }
        th, td { border:1px solid #ddd; padding:8px; text-align:center; }
        th { background:#237bdb; color:white; }
        a { text-decoration:none; color:#237bdb; }
        .btn { padding:6px 12px; border-radius:5px; }
        .btn-danger { background:#d9534f; color:#fff; }
        .btn-primary { background:#237bdb; color:#fff; }
    </style>
</head>
<body>
    <h1>Manage Users</h1>
    <a href="/QuizApp/add-user" class="btn btn-primary">Add New User</a>
    <table>
        <tr>
            <th>ID</th><th>Full Name</th><th>Username</th>
            <th>Email</th><th>Gender</th><th>Role</th><th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['full_name']) ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['gender']) ?></td>
            <td><?= htmlspecialchars($user['user_type']) ?></td>
            <td>
                <a href="/QuizApp/delete-user/<?= $user['id'] ?>" class="btn btn-danger"
                   onclick="return confirm('Delete this user?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
