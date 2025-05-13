<?php
$conn = new mysqli("localhost", "root", "", "shopseva-lite");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();
?>
