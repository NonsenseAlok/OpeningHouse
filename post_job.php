<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "job_portal";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO jobs (title, description, company, location, salary, education) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error in prepare statement: " . $conn->error);
    }
    $stmt->bind_param("ssssss", $title, $description, $company, $location, $salary, $education);

    // Set parameters and execute
    $title = $_POST['title'];
    $description = $_POST['description'];
    $company = $_POST['company'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];
    $education = $_POST['education'];
    if ($stmt->execute() === false) {
        die("Error in execute statement: " . $stmt->error);
    }

    echo "New job posted successfully";

    $stmt->close();
    $conn->close();

    header("Location: jobs.html");
    exit();
} else {
    echo "Invalid request method.";
}
?>
