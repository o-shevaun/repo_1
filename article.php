<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="article.css">
    <link rel="stylesheet" href="./css/dashboard.css">
    <style>
        .btn-edit-blog{
            display: inline-block;
            float:right;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
        }
    </style>
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

<?php

require_once "./includes/dbConn.php";
$articleId = $_GET['id'];

$sql = "SELECT articles.*, users.User_Name, users.profile_Image 
        FROM articles 
        JOIN users ON articles.author_id = users.userId 
        WHERE articles.article_id = $articleId";
$result = $conn->query($sql);
$article = $result->fetch_assoc();
?>

<div class="article-container">
<a href="./processes/update_article.php?id=<?php echo $articleId; ?>" class="btn-edit-blog">Edit blog</a>
    <div class="article-header">
        <div class="author-info">
            <img src="<?php echo $article['profile_Image']; ?>" alt="Author Profile" class="profile-image">
            <span class="author-name">Author: <?php echo $article['User_Name']; ?></span>
        </div>
    </div>
    <h1 class="article-title"><?php echo $article['article_title']; ?></h1>
    <?php if (!empty($article['article_image'])) : ?>
        <img src="<?php echo $article['article_image']; ?>" alt="Article Image" class="article-image">
    <?php endif; ?>
    <div class="article-body">
        <?php echo $article['article_full_text']; ?>
    </div>
</div>

<?php
require_once "./templates/footer.php";
  ?>



</body>
</html>
