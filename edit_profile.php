<?php
session_start();
require_once "./includes/dbconn.php";

// Check if the user is logged in and is an admin
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'Admin') {
    $adminId = $_SESSION['user_id'];

    // Retrieve admin details from the database
    $sql = "SELECT * FROM users WHERE userId = $adminId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
    } else {
        echo "Admin not found";
        exit;
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];

    // Update admin details in the database
    $update_sql = "UPDATE users SET 
                   Full_Name = '$full_name', 
                   Email = '$email', 
                   Phone_Number = '$phone_number', 
                   Address = '$address' 
                   WHERE userId = $adminId";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: dash.php");
    } else {
        echo "Error updating profile: " . $conn->error;
    }

    // Handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['profile_image']['name'];
        $image_tmp = $_FILES['profile_image']['tmp_name'];

        // Move the uploaded image to a desired location
        $upload_path = "./profile_images/"; // Change this to your desired upload path
        $uploaded_file = $upload_path . basename($image_name);

        if (move_uploaded_file($image_tmp, $uploaded_file)) {
            // Update the image file path in the database
            $update_image_sql = "UPDATE users SET Profile_Image = '$uploaded_file' WHERE userId = $adminId";
            if ($conn->query($update_image_sql) !== TRUE) {
                echo "Error updating profile image: " . $conn->error;
            }
        } else {
            echo "Error uploading profile image.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="./css/Update_profile.css">
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

    <div class="profile-box">
        <h1>Update Profile</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="full_name">Full Name</label>
            <input type="text" name="full_name" id="full_name" value="<?php echo isset($admin['Full_Name']) ? $admin['Full_Name'] : ''; ?>" required>
            
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo isset($admin['email']) ? $admin['email'] : ''; ?>" required>
            
            <label for="phone_number">Phone Number</label>
            <input type="tel" name="phone_number" id="phone_number" value="<?php echo isset($admin['phone_Number']) ? $admin['phone_Number'] : ''; ?>" required>
            
            <label for="address">Address</label>
            <textarea name="address" id="address" placeholder="Address"><?php echo isset($admin['Address']) ? $admin['Address'] : ''; ?></textarea>
            
            <label for="profile_image">Profile Image</label>
            <input type="file" name="profile_image" id="profile_image">

            <button type="submit" name="update">Update</button>
        </form>
    </div>
</body>
</html>
