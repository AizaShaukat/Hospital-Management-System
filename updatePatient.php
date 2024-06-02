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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patientID = $_POST["patientID"];
    $name = $_POST["name"];
    $dob = $_POST["dob"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $ailment = $_POST["ailment"];
    $type = $_POST["type"];
    $status = $_POST["status"];
    $docID = $_POST["docID"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM patients WHERE id = '$patientID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $updateQuery = "UPDATE patients SET name='$name', dob='$dob', email='$email', phone='$phone', address='$address', ailment='$ailment', type='$type', pstatus='$status', doctor_id='$docID' WHERE id='$patientID'";

        if ($conn->query($updateQuery) === TRUE) {
              // Registration successful! Now fetch and display all details of the registered patient
              $fetchPatient = $conn->prepare("SELECT * FROM patients WHERE id = ?");
              $fetchPatient->bind_param("s", $patientID);
              $fetchPatient->execute();
              $result = $fetchPatient->get_result();
              $patientDetails = $result->fetch_assoc();
  
             // Displaying patient details in a presentable format
             echo '<div style="background-color: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); margin-top: 20px;">';
             echo '<h2 style="margin-bottom: 15px;">Record Updated Successfully!</h2>';
             echo '<h3 style="margin-bottom: 10px;">Patient Details:</h3>';
             echo '<div>';
             foreach ($patientDetails as $key => $value) {
              $key = ucwords($key);
                 echo "<strong>$key:</strong> $value<br>";
             }
             echo '</div>';
             echo '</div>';
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Patient ID not found in the database";
    }

    $conn->close();
}
?>
