<?php
echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    
    <!-- CSS files -->
    <link rel="stylesheet" type="text/css" href="docOptions.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Your PHP-generated content with HTML here -->
</body>
</html>';
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
            echo "<h2>My Achievements</h2>";
            echo "<div style='background-color: #fff; padding: 20px; border-radius: 10px; '>";
            echo $row['achievements'];
            echo "</div>";
        }
    } else {
        echo "Doctor not found.";
    }

    $stmt->close();


$mysqli->close();
?>
