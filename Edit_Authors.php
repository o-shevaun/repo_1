<?php
session_start();

require_once "./includes/dbconn.php";

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Admin') {
  echo "Unauthorized access";
  echo '<script>
  setTimeout(function() {
      window.location.href = "dash.php"; // Redirect to dash.php after 3 seconds
  }, 1200); 
</script>';
exit;
}

if (isset($_GET['id'])) {
    $authorId = $_GET['id'];

    // Retrieve author details from the database
    $sql = "SELECT * FROM users WHERE userId = $authorId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $author = $result->fetch_assoc();
    } else {
        echo "Author not found";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $address = $_POST['address'];

        // Update author details in the database
        $update_sql = "UPDATE users SET 
                       Full_Name = '$full_name', 
                       Email = '$email', 
                       Phone_Number = '$phone_number', 
                       Address = '$address' 
                       WHERE userId = $authorId";

        if ($conn->query($update_sql) === TRUE) {
            echo "Author details updated successfully.";
            echo '<script>
                setTimeout(function() {
                    window.location.href = "dash.php"; // Redirect to dash.php after 3 seconds
                }, 1200); 
            </script>';
            exit;
        } else {
            echo "Error updating author details: " . $conn->error;
        }
    }
} else {
    echo "Author ID not provided";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Author</title>
    <link rel="stylesheet" href="./css/editAuthor.css">
    <link rel="stylesheet" href="./css/dashboard.css"> 
</head>
<body>
    <header>
        <h1>Welcome to Admin Dashboard</h1>
    </header>
    <nav class="dashboard-nav">
        <ul>
            <li><a href="edit_profile.php">Update Profile</a></li>
            <li><a href="dash.php">Manage Authors</a></li>
            <li><a href="index.php">View Articles</a></li>
            <li><a href="./processes/logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="signup-box">
        <h1>Update Author</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="full_name">Full Name</label>
            <input type="text" name="full_name" id="full_name" value="<?php echo isset($author['Full_Name']) ? $author['Full_Name'] : ''; ?>" required>
            
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo isset($author['email']) ? $author['email'] : ''; ?>" required>
            
            <label for="phone_number">Phone Number</label>
            <input type="tel" name="phone_number" id="phone_number" value="<?php echo isset($author['phone_Number']) ? $author['phone_Number'] : ''; ?>" required>
            
            <label for="address">Address</label>
            <textarea name="address" id="address" placeholder="Address"><?php echo isset($author['Address']) ? $author['Address'] : ''; ?></textarea>

            <button type="submit" name="update">Update</button>
        </form>
    </div>
</body>
</html>
