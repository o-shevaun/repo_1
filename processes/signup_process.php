<?php
require_once "../includes/dbconn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $phone_number = $_POST["phone_number"];
    $user_name = $_POST["user_name"];
    $password1 = $_POST["password"];
    $password2 = $_POST["confirm_password"];
    $user_type = $_POST["user_type"];
    $address = $_POST["address"];

    if ($password1 !== $password2) {
        header("Location: ../signup.php?error=Passwords do not match");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../Signup.php?error=Invalid email");
        exit();
    }

    // Check if email already exists in the database
    $stmt = $conn->prepare("SELECT * FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: ../Signup.php?error=Email already exists");
        exit();
    }

    // Generate current time for AccessTime
    $access_time = date("Y-m-d H:i:s");

    // Specify your upload directory
    $target_dir = "../../uploaded_images/";
    $profile_image = $_FILES["profile_image"]["name"];
    $target_file = $target_dir . basename($profile_image);
  
    // Move the uploaded file to the specified directory
    move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);

    // Insert user data into the database, including image path and access time
    $sql = "INSERT INTO Users (Full_Name, email, phone_Number, User_Name, Password, UserType, AccessTime, profile_Image, Address)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $full_name, $email, $phone_number, $user_name, $password1, $user_type, $access_time, $target_file, $address);

    if ($stmt->execute()) {
        header("Location: ../Signin.php");
        exit();
    } else {
        header("Location: ../Signup.php?error=Error occurred while signing up");
        exit();
    }

    $stmt->close();
    $conn->close();
}
