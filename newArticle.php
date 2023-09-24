
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/newArticle.css">
    <link rel="stylesheet" href="./css/dashboard.css">
    <title>Create New Article</title>
    <script src="https://cdn.emailjs.com/dist/email.min.js"></script>
</head>
<body>
<nav class="dashboard-nav">
    <ul>
      <li><a href="edit_profile.php">Update Profile</a></li>
      <li><a href="dash.php">Manage Authors</a></li>
      <li><a href="index.php">View Articles</a></li>
      <li><a href="./processes/logout.php">Logout</a></li>
    </ul>
  </nav>

    <div class="container">
        <h1>Create New Article</h1>
        <form action="./processes/create_Article_process.php" method="post" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            
            <label for="content">Content:</label>
            <textarea id="content" name="content" rows="6" required></textarea>
            
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*">
            
            <label for="display">Display:</label>
            <select id="display" name="display">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
            
            <input type="submit" value="Create Article">
        </form>
    </div>
</body>
</html>
