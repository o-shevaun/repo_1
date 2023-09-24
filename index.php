<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    header("Location: signin.php"); // Redirect to the login page
    exit();
}
require_once "./includes/dbConn.php";


// Fetch articles from the database, sorted by publication_date in descending order
$sql = "SELECT articles.*, users.User_Name, users.profile_Image 
        FROM articles 
        JOIN users ON articles.author_id = users.userId 
        WHERE articles.article_display = 'yes' 
        ORDER BY articles.article_created_date DESC LIMIT 6";

$result = $conn->query($sql);

// Initialize an array to store the fetched articles
$articles = array();

// Fetch the articles and store them in the $articles array
while ($row = $result->fetch_assoc()) {
    $articles[] = $row;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Page</title>
   <link rel="stylesheet" href="./css/style.css">

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

    <section class="blog-section">
        <div class="blog-container">
            <div class="blog-title">
                <h2>Blog</h2>
            </div>
            <div class="view-blog">
                <a href="index.php" class="btn-create-blog">All Blogs</a>

                <a href="newArticle.php" class="btn-create-blog">Create New Blog</a>

            </div>
          


<div class="blog-posts">
    <?php foreach ($articles as $article) : ?>
        <div class="blog-post">
            <h3><?php echo $article['article_title']; ?></h3>
            <?php if (!empty($article['article_image'])) : ?>
                <img src="<?php echo $article['article_image']; ?>" alt="Blog Image">
            <?php endif; ?>
            <p class="article-full-text"><?php echo $article['article_full_text']; ?></p>
         <div class="read">
         <a href="article.php?id=<?php echo $article['article_id']; ?>" class="btn-read-more">Read More</a>
         </div>

            </div>

            
      
    <?php endforeach; ?>
</div>


    </section>

  <?php
require_once "./templates/footer.php";
  ?>

    <script src="index.js"></script>
</body>
</html>

