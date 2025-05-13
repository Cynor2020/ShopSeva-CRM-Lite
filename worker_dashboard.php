<?php
include 'db.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'Worker') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Worker Dashboard</title>
    <style>
        body { font-family: sans-serif; background: #eef6f9; padding: 40px; text-align: center; }
        .card { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); display: inline-block; }
        a { margin-top: 20px; display: inline-block; background: #c0392b; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Hello Worker, <?= $_SESSION['user']['name'] ?>!</h1>
        <p>This is the <strong>Worker Dashboard</strong>.</p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
