<?php
// Database credentials
$hostname = 'localhost:3307';
$username = 'root';
$password = '';
$database = 'blog_app_db';

// Create a new mysqli connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
