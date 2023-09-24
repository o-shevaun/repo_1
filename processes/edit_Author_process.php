<?php
session_start();

// Include your database connection here
require_once "../includes/dbconn.php";

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    header("Location: signin.php");
    exit();
}

if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'Admin') {
    $adminId = $_SESSION['user_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_id = $_POST['user_id'];
        $new_username = $_POST['username'];
        $new_email = $_POST['email'];

        $update_sql = "UPDATE users SET username = '$new_username', email = '$new_email' WHERE id = $user_id";

        if ($conn->query($update_sql) === TRUE) {
            echo "User details updated successfully.";
        } else {
            echo "Error updating user details: " . $conn->error;
        }
    }

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
    } else {
        echo "User not found";
        exit;
    }
} else {
    echo "Unauthorized access";
    echo '<script>
    setTimeout(function() {
        window.location.href = "../dash.php";
    }, 1200); 
</script>';
    exit;
}

$conn->close();
?>
