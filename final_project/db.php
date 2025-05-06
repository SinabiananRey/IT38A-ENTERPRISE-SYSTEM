<?php
$host = "localhost";
$user = "root";
$pass = ""; // your MySQL password if any
$dbname = "admin_panel";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
