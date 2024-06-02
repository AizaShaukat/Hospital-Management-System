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
} else {
    echo "No 'id' parameter provided.";
    exit();
}

$sql = "SELECT * FROM patients WHERE pstatus = 'Discharged' AND doctor_id = ?";
$stmt = $mysqli->prepare($sql);

if ($stmt) {
    // Bind the parameter
    $stmt->bind_param("i", $doctorID);

    // Execute the statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Display the information for each current patient
        echo "<h2>Patient History</h2>";
     $i = 1;
        while ($row = $result->fetch_assoc()) {
             
          
          echo '<div  style="background-color: #fff; border-radius: 10px; padding: 20px; ">';
          echo $i;
          echo "<br>";
          echo "<p><strong>ID:</strong> " . $row['id'] . "</p>";
          echo "<p><strong>Name:</strong> " . $row['name'] . "</p>";
          echo "<p><strong>Date of Birth:</strong> " . $row['dob'] . "</p>";
          echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
          echo "<p><strong>Phone:</strong> " . $row['phone'] . "</p>";
          echo "<p><strong>Address:</strong> " . $row['address'] . "</p>";
          echo "<p><strong>Ailment:</strong> " . $row['ailment'] . "</p>";
          echo "<p><strong>Type:</strong> " . $row['type'] . "</p>";
          $prescriptionsStmt = $mysqli->prepare("SELECT prescription FROM prescriptions WHERE patientID = ?");
        $prescriptionsStmt->bind_param("i", $row['id']);
        $prescriptionsStmt->execute();
        $prescriptionsResult = $prescriptionsStmt->get_result();

        // Display prescriptions for the patient
        if ($prescriptionsResult->num_rows > 0) {
            echo "<p><strong>Prescriptions:</strong></p>";
            echo "<ul>";
            while ($prescriptionRow = $prescriptionsResult->fetch_assoc()) {
                echo "<li>" . $prescriptionRow['prescription'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No prescriptions recorded for this patient.</p>";
        }
        $prescriptionsStmt->close();
        
          echo "</div>";
            $i++;
            echo "<hr>";
        }
    } else {
        echo "No Patient History Found.";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error in preparing the SQL statement.";
}

// Close the database connection
$mysqli->close();

?>
