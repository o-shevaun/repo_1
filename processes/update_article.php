<?php
session_start(); 

require_once "../includes/dbconn.php";

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    header("Location: signin.php");
    exit();
}

$articleId = $_GET['id'];

// Fetch the article data from the database based on the provided article ID
$sql = "SELECT * FROM articles WHERE article_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $articleId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $article = $result->fetch_assoc();
} else {
    echo "Article not found";
    exit;
}

// Process the form submission for updating the article
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $newTitle = $_POST['title'];
    $newContent = $_POST['content'];
    $newDisplay = $_POST['display'];

    // Perform the update in the database using prepared statement
    $updateSql = "UPDATE articles SET article_title = ?, article_full_text = ?, article_display = ? WHERE article_id = ?";
    
    $stmtUpdate = $conn->prepare($updateSql);
    $stmtUpdate->bind_param("sssi", $newTitle, $newContent, $newDisplay, $articleId);
    
    if ($stmtUpdate->execute()) {
        echo "Article updated successfully.";
      
        echo '<script>
        setTimeout(function() {
            window.location.href = "../index.php"; // Redirect to dash.php after 3 seconds
        }, 1200); 
      </script>';
    } else {
        echo "Error updating article: " . $stmtUpdate->error;
    }

    // Handle image update
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $newImageName = basename($_FILES["image"]["name"]);
        $newImageTmp = $_FILES["image"]["tmp_name"];


        $target_dir = "../../uploaded_images/";
        $target_file = $target_dir . $newImageName;
        move_uploaded_file($newImageTmp, $target_file);


        $updateImageSql = "UPDATE articles SET article_image = ? WHERE article_id = ?";
        $stmtImage = $conn->prepare($updateImageSql);
        $stmtImage->bind_param("si", $target_file, $articleId);

        if ($stmtImage->execute() !== TRUE) {
            echo "Error updating article image: " . $stmtImage->error;
        }

        $stmtImage->close();
    }

    $stmtUpdate->close();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=".././css/newArticle.css">
    <link rel="stylesheet" href=".././css/dashboard.css">
    <style>
        .btn{
            width: 200px;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-color:transparent;
    border-radius: 5px;
   
        }
    </style>
    <title>Update Article</title>
</head>
<body>
<nav class="dashboard-nav">
    <ul>
      <li><a href="../edit_profile.php">Update Profile</a></li>
      <li><a href="../dash.php">Manage Authors</a></li>
      <li><a href="../index.php">View Articles</a></li>
      <li><a href="../processes/logout.php">Logout</a></li>
    </ul>
</nav>

<div class="container">
    <h1>Update Article</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo $article['article_title']; ?>" required>
        
        <label for="content">Content:</label>
        <textarea id="content" name="content" rows="6" required><?php echo $article['article_full_text']; ?></textarea>
        
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*">
        
        <label for="display">Display:</label>
        <select id="display" name="display">
            <option value="yes" <?php if ($article['article_display'] === 'yes') echo 'selected'; ?>>Yes</option>
            <option value="no" <?php if ($article['article_display'] === 'no') echo 'selected'; ?>>No</option>
        </select>
        
        <button type="submit" name="update" class="btn">Update Article</button>
    </form>
</div>
</body>
</html>
