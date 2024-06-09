<?php
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

$search_query = $_GET['query'];
$search_query = "%" . $search_query . "%";

$sql = $conn->prepare("SELECT id, title, description, company, location, salary, education FROM jobs WHERE title LIKE ? OR description LIKE ? OR company LIKE ? OR location LIKE ? OR education LIKE ?");
$sql->bind_param("sssss", $search_query, $search_query, $search_query, $search_query, $search_query);

$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="job-card">';
        echo '<h3>' . $row["title"] . '</h3>';
        echo '<p>Company: ' . $row["company"] . '</p>';
        echo '<p>Location: ' . $row["location"] . '</p>';
        echo '<p>Salary: ' . $row["salary"] . '</p>';
        echo '<p>Education: ' . $row["education"] . '</p>';
        echo '<p>' . $row["description"] . '</p>';
        echo '</div>';
    }
} else {
    echo "No results found.";
}
$conn->close();
