<?php
include 'db.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'Admin') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body { font-family: sans-serif; background: #f5f5f5; padding: 40px; text-align: center; }
        .card { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); display: inline-block; }
        a { margin-top: 20px; display: inline-block; background: #e74c3c; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Welcome Admin, <?= $_SESSION['user']['name'] ?>!</h1>
        <p>This is the <strong>Admin Dashboard</strong>.</p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
