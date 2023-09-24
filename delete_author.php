<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    header("Location: signin.php"); // Redirect to the login page
    exit();
}

require_once "./includes/dbconn.php";
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'Admin') {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $authorId = $_GET['id'];
    
        // Delete author from the database
        $delete_sql = "DELETE FROM users WHERE userId = $authorId";
    
        if ($conn->query($delete_sql) === TRUE) {
            header("Location: dash.php"); // Redirect back to the admin dashboard after deletion
            exit();
        } else {
            echo "Error deleting author: " . $conn->error;
        }
    } 
} else {
    echo "Unauthorized access";
    echo '<script>
    setTimeout(function() {
        window.location.href = "dash.php"; // Redirect to dash.php after 3 seconds
    }, 1200); 
</script>';
exit;
   
}

?>
