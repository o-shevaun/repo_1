<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up | Secure Access</title>
  <link rel="stylesheet" href="./css/signup.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
  <div class="signup-box">
    <h1>Sign Up</h1>
    
    <form action="processes/signup_process.php" method="POST" enctype="multipart/form-data">
      <input type="text" name="full_name" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="tel" name="phone_number" placeholder="Phone Number" required>
      <input type="text" name="user_name" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="password" name="confirm_password" placeholder="Confirm Password" required>
      <select name="user_type" required>
        <option value="" disabled selected>Select User Type</option>
        <option value="Admin">Admin</option>
        <option value="Author">Author</option>
        <option value="User">User</option>
      </select>
      <textarea name="address" placeholder="Address"></textarea>
      <input type="file" id="image_file" name="profile_image" accept="image/*">
      <button type="submit" name="signup">Sign Up</button>
    </form>
    
    <div class="already-member">
      Already have an account? <a href="signin.php">Log in</a>
    </div>
  </div>
</body>
</html>
