<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    header("Location: signin.php"); // Redirect to the login page
    exit();
}
require_once "./includes/dbconn.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="./css/dashboard.css"> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
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
 
  
  <main>
  
  <table class="authors-table">
    <caption>Authors</caption>
    <thead>
      <tr>
        <th>Name</th>
        <th class="action">Actions</th>
      </tr>
    </thead>
    <tbody>
      
      <?php
     
      $sql = "SELECT * FROM users where UserType='Author'";
      $result = $conn->query($sql);
      $counter = 1;


      while ($row = $result->fetch_assoc()) {
        $authorId = $row["userId"];
        $authorName = $row["User_Name"];
        ?>
        <tr>
          <td><?php echo $counter; ?></td>
          <td><?php echo $authorName; ?></td>
          <td class="actions-cell">
  <a href="Edit_Authors.php?id=<?php echo $authorId; ?>" class="edit-btn">Edit</a>
  <a href="delete_author.php?id=<?php echo $authorId; ?>" class="delete-btn" onclick="return deleteAuthor(<?php echo $authorId; ?>)">Delete</a>
</td>


        </tr>
        <?php
        $counter++;
      }
      ?>
    </tbody>
  </table>

  <br>
  <br>
  <br>
  <div class="export-button">
      <a href="export_user.php?type=excel" class="export-link">Export Users to Excel</a>



  </div>
  </main>

  
  <script>
    function deleteAuthor(authorId) {
        if (confirm("Are you sure you want to delete this author?")) {
            window.location.href = "delete_author.php?id=" + authorId;
        }

    }
</script>

</body>
</html>
