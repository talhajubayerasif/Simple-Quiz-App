<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    header("Location: /QuizApp/login");
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['user_type']; // admin, quizauthor, or student
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        /* ===== Global ===== */
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }
        a { text-decoration: none; }

        /* ===== Container ===== */
        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
        }
        header {
            background: #237bdb;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }
        header h1 { margin: 0; }
        header p { margin: 5px 0 0; font-size: 1.1em; }

        /* ===== Card ===== */
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin: 20px 0;
        }
        .card h2 {
            margin-top: 0;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            color: #333;
        }

        /* ===== Features Grid ===== */
        .features {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 15px;
        }
        .feature {
            flex: 1 1 calc(50% - 15px);
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            transition: 0.3s;
        }
        .feature:hover { background: #e8f0fe; }
        .feature a {
            color: #237bdb;
            font-weight: bold;
            display: block;
        }

        /* ===== Logout Button ===== */
        .logout {
            display: inline-block;
            margin: 20px 0;
            padding: 12px 25px;
            background: #d9534f;
            color: #fff;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
        }
        .logout:hover { background: #c9302c; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome, <?php echo htmlspecialchars($username); ?> ðŸ‘‹</h1>
            <p>Role: <strong><?php echo ucfirst($role); ?></strong></p>
        </header>

        <!-- Common Features -->
        <div class="card">
            <h2>Common Features</h2>
            <div class="features">
                <div class="feature"><a href="/QuizApp/change-password">Change / Reset Password</a></div>
                <div class="feature"><a href="/QuizApp/profile">Manage Profile</a></div>
            </div>
        </div>

        <!-- Role-Specific Features -->
<div class="card">
    <h2>Specific Features</h2>
    <div class="features">
        <?php if ($role === 'admin'): ?>
            <div class="feature"><a href="/QuizApp/manage-users">Manage Users<br><small>Approve, block, or delete user accounts</small></a></div>
            <div class="feature"><a href="/QuizApp/manage-quizzes">Edit Quizzes</a></div>
            <div class="feature"><a href="/QuizApp/feedback">Give Feedback to Quiz Authors</a></div>

        <?php elseif ($role === 'quizauthor'): ?>
            <div class="feature"><a href="/QuizApp/create-quiz">Create Quiz</a></div>
            <div class="feature"><a href="/QuizApp/manage-quizzes">Manage Quizzes</a></div>

        <?php elseif ($role === 'student'): ?>
            <div class="feature"><a href="/QuizApp/take-quiz">Take Quiz</a></div>
            <div class="feature"><a href="/QuizApp/view-results">View Results</a></div>
        <?php endif; ?>
    </div>
</div>


        <!-- Logout -->
        <a href="/QuizApp/logout" class="btn logout">Logout</a>

    </div>
</body>
</html>