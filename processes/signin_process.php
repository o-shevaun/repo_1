<?php
session_start();

require_once "../includes/dbconn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signin'])) {
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    // Validate input
    $user_name = validate($user_name);
    $password = validate($password);

    // Check if username and password are provided
    if (empty($user_name) || empty($password)) {
        header("Location: ../Signin.php?error=Username and password are required");
        exit();
    }

    // Retrieve user details from the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE User_Name = ?");
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];

        if ($password === $storedPassword) {
            $_SESSION['user_name'] = $row['User_Name'];
            $_SESSION['user_id'] = $row['userId'];
            $_SESSION['user_type'] = $row['UserType']; // Store user type in session
            header("Location: ../dash.php");
            exit();
        } else {
            // Incorrect password
            header("Location: ../Signin.php?error=Incorrect username or password");
            exit();
        }
    } else {
        // Incorrect username
        header("Location: ../Signin.php?error=Incorrect username or password");
        exit();
    }
} else {
    header("Location: ../dash.php");
    exit();
}

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
