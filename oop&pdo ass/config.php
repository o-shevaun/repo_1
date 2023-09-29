<?php

require_once 'Database.php';


$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'oopdb';

$database = new Database($host, $username, $password, $dbname);

$pdo = $database->getConnection();


try {
    $stmt = $pdo->prepare("SELECT * FROM ooptb");
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    foreach ($result as $row) {
        echo $row['column_name'] . "<br>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Store data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $sql = "INSERT INTO ooptb (name, email) VALUES (:name, :email)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);

    if ($stmt->execute()) {
        echo "Data inserted successfully.";
    } else {
        echo "Error inserting data: " . $stmt->errorInfo()[2];
    }
}

// Read  data
$sql = "SELECT * FROM ooptb";
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($results as $row) {
    echo "name: " . $row['name'] . "<br>";
    echo "email: " . $row['email'] . "<br>";
    echo "<hr>";
}

?>