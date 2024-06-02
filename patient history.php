<?php
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_db = 'project';

$mysqli = new mysqli($db_host, $db_user, $db_password, $db_db);

if ($mysqli->connect_error) {
    echo 'Errno: ' . $mysqli->connect_errno;
    echo '<br>';
    echo 'Error: ' . $mysqli->connect_error;
    exit();
}

if (isset($_GET['id'])) {
    $doctorID = $_GET['id'];
   
    
    
    // Rest of your code
} else {
    echo "No 'id' parameter provided.";
    exit();
}

    // Prepare and execute the query to fetch doctor details
    $stmt = $mysqli->prepare("SELECT * FROM doctors WHERE id = ?");
    $stmt->bind_param("s", $doctorID);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Display doctor's information
        while ($row = $result->fetch_assoc()) {
            echo "<h2>Doctor Information</h2>";
            echo "<div style='background-color: #fff; padding: 20px; border-radius: 10px;'>";
            echo "<p>Doctor ID: " . $row['id'] . "</p>";
            echo "<p>Doctor Name: " . $row['name'] . "</p>";
            echo "<p>Doctor DOB: " . $row['dob'] . "</p>";
            echo "<p>Doctor Email: " . $row['email'] . "</p>";
            echo "<p>Doctor Phone: " . $row['phone'] . "</p>";
            echo "<p>Doctor Qualification: " . $row['qualification'] . "</p>";
            echo "<p>Doctor Address: " . $row['address'] . "</p>";
            echo "<p>Doctor Achievements: " . $row['achievements'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "Doctor not found.";
    }

    $stmt->close();


$mysqli->close();
?>
