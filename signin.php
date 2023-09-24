<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login </title>
  <link rel="stylesheet" href="./css/signin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
  <div class="login-box">
    <h1>Log in</h1>
    
    <form action="./processes/signin_process.php" method="POST">
      <input type="text" placeholder="Username" name="user_name">
      <input type="password" placeholder="Password" name="password">
      <p class="forgot-password">
        <a href="#">Forgot Password?</a>
      </p>
      <input type="submit" id="button1" value="Log in" name="signin">
    </form>

    <p class="or-divider">
      ----- or -----
    </p>
    
    <div class="new-member">
      Don't have an account? <a href="signup.php">Sign up</a>
    </div>
  </div>
</body>
</html>
