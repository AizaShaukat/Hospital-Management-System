<?php


// Output the HTML with CSS and font links
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

$sql = "SELECT * FROM patients WHERE pstatus = 'Current' AND doctor_id = ?";
$stmt = $mysqli->prepare($sql);

if ($stmt) {
    // Bind the parameter
    $stmt->bind_param("i", $doctorID);

    // Execute the statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();
    $i = 1;
    if ($result->num_rows > 0) {
        // Display the information for each current patient
        echo "<h2>Current Patients</h2>";
        while ($row = $result->fetch_assoc()) {
            
            echo "<div style='background-color: #fff; padding: 20px; border-radius: 10px;'>";
            echo $i;
            echo "<br>";
echo "<p ><strong>Name:</strong> " . $row['name'] . "</p>";
echo "<p><strong>Date of Birth:</strong> " . $row['dob'] . "</p>";
echo "<p ><strong>Email:</strong> " . $row['email'] . "</p>";
echo "<p><strong>Phone:</strong> " . $row['phone'] . "</p>";
echo "<p><strong>Address:</strong> " . $row['address'] . "</p>";
echo "<p><strong>Ailment:</strong> " . $row['ailment'] . "</p>";
echo "<p><strong>Type:</strong> " . $row['type'] . "</p>";
  // Check if prescriptions are recorded for the patient in the prescriptions table
  $checkPrescriptions = $mysqli->prepare("SELECT * FROM prescriptions WHERE patientID = ?");
  $checkPrescriptions->bind_param("i", $row['id']);
  $checkPrescriptions->execute();
  $prescriptionsResult = $checkPrescriptions->get_result();
  
  if ($prescriptionsResult->num_rows === 0) {
      // Show the prescription form only if prescriptions are not recorded
      echo "<form id='prescriptionForm' method='POST'>";
echo "<input type='hidden' name='patientID' value='" . $row['id'] . "'>";
echo "<label for='prescription'>Prescription:</label><br>";
echo "<textarea id='prescription' name='prescription' rows='4' cols='50' required></textarea><br>";
echo "<input type='submit' value='Record Prescription' onclick='submitForm()'>";
echo "</form>";

// JavaScript function to submit the form and reload the page
echo "<script>
function submitForm() {
    document.getElementById('prescriptionForm').submit();
    location.reload();
}
</script>";

  } else {
   
    if ($prescriptionsResult->num_rows > 0) {
        echo "<p><strong>Current Prescriptions:</strong></p>";
        while ($prescriptionRow = $prescriptionsResult->fetch_assoc()) {
            echo "<p>" . $prescriptionRow['prescription'] . "</p>";
        }
    }
    
    echo "<form method='POST'>";
    echo "<input type='hidden' name='patientID' value='" . $row['id'] . "'>";
    echo "<label for='prescription'>Update Prescription:</label><br>";
    echo "<textarea id='prescription' name='prescription' rows='4' cols='50' required></textarea><br>";
    echo "<input type='submit' value='Record Prescription'>";
    echo "</form>";
     
  }

  $checkPrescriptions->close();
 echo "</div>";
        echo "<hr>";
          
            $i++;
            
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["patientID"], $_POST["prescription"])) {
            $patientID = $_POST["patientID"];
            $prescriptions = explode(',', $_POST["prescription"]); // Split prescriptions by comma
        
            // Insert each non-empty prescription separately into the 'prescriptions' table
            $insertPrescription = $mysqli->prepare("INSERT INTO prescriptions (patientID, prescription) VALUES (?, ?)");
            $insertPrescription->bind_param("is", $patientID, $singlePrescription);
        
            foreach ($prescriptions as $singlePrescription) {
                $singlePrescription = trim($singlePrescription); // Remove any leading/trailing spaces
        
                if (!empty($singlePrescription)) {
                    $insertPrescription->execute();
                }
            }
        
            // Close the statement
            $insertPrescription->close();
        }
        
    } else {
        echo "No Current Patients Found.";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error in preparing the SQL statement.";
}

// Close the database connection
$mysqli->close();
?>
