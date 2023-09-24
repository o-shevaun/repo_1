<?php
require_once "../includes/dbconn.php";
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    header("Location: signin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $authorId = $_SESSION["user_id"];
    $title = $_POST["title"];
    $content = $_POST["content"];
    $display = $_POST["display"];

    $target_dir = "../../uploaded_images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    $query = "INSERT INTO articles (author_id, article_title, article_full_text, article_image, article_display)
              VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issss", $authorId, $title, $content, $target_file, $display);
    
    if ($stmt->execute()) {
        echo "Article created successfully!";
        
        // Fetch admin emails from the database
        $adminEmailQuery = "SELECT email FROM users WHERE UserType = 'Admin' AND userId != ?";
        $adminEmailStmt = $conn->prepare($adminEmailQuery);
        $adminEmailStmt->bind_param("i", $authorId);
        $adminEmailStmt->execute();

        $adminEmailResult = $adminEmailStmt->get_result();

        if ($adminEmailResult && $adminEmailResult->num_rows > 0) {
            // Include the emailjs library
            echo '<script src="https://cdn.jsdelivr.net/npm/emailjs-com/dist/email.min.js"></script>';
            
            // Initialize emailjs
            echo '<script>';
            echo '  emailjs.init("tBMyJBu72aLrSK9OH");'; // Initialize email.js with your user ID
            
            // Loop through admin emails
            while ($adminEmailRow = $adminEmailResult->fetch_assoc()) {
                $adminEmail = $adminEmailRow['email'];
                
                // Debugging: Print the email address
                echo '  console.log("Sending email to: ' . $adminEmail . '");';
                
                echo '  emailjs.send("service_fa5urny", "template_va06kk9", {';
                echo '      to_name: "Admin",'; // Receiver's name
                echo '      user_name: "' . $_SESSION["user_name"] . '",'; // Person who added the article
                echo '      message: "A new article has been created: ' . $title . '"';
                echo '  }).then(function(response) {';
                echo '      console.log("Email sent:", response);';
                echo '  }, function(error) {';
                echo '      console.error("Email error:", error);';
                echo '  });';
            }
            echo '</script>'; // Place the script block here
            
        } else {
            echo "Admin emails not found.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
