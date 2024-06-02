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

$servername = "localhost";
$username = "root";
$password = "";
$database = "project";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (
    isset($_POST["patientID"], $_POST["name"], $_POST["dob"], $_POST["email"], $_POST["phone"], $_POST["address"], $_POST["ailment"], $_POST["type"], $_POST["status"], $_POST["docID"])
) {
    // Get user input and sanitize it
    $patientID = mysqli_real_escape_string($conn, $_POST["patientID"]);
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $dob = mysqli_real_escape_string($conn, $_POST["dob"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
    $address = mysqli_real_escape_string($conn, $_POST["address"]);
    $ailment = mysqli_real_escape_string($conn, $_POST["ailment"]);
    $type = mysqli_real_escape_string($conn, $_POST["type"]);
    $status = mysqli_real_escape_string($conn, $_POST["status"]);
    $doctorID = mysqli_real_escape_string($conn, $_POST["docID"]);

    // Check if the doctor_id exists in the doctors table
    $checkDoctor = $conn->prepare("SELECT id FROM doctors WHERE id = ?");
    $checkDoctor->bind_param("s", $doctorID);
    $checkDoctor->execute();
    $checkDoctor->store_result();

    if ($checkDoctor->num_rows > 0) {
        // Doctor ID exists, proceed to insert the patient data
        $stmt = $conn->prepare("INSERT INTO patients (id, name, dob, email, phone, address, ailment, type, pstatus, doctor_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $patientID, $name, $dob, $email, $phone, $address, $ailment, $type, $status, $doctorID);

        if ($stmt->execute()) {
            // Registration successful! Now fetch and display all details of the registered patient
            $fetchPatient = $conn->prepare("SELECT * FROM patients WHERE id = ?");
            $fetchPatient->bind_param("s", $patientID);
            $fetchPatient->execute();
            $result = $fetchPatient->get_result();
            $patientDetails = $result->fetch_assoc();

           // Displaying patient details in a presentable format
           echo '<div style="background-color: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); margin-top: 20px;">';
           echo '<h2 style="margin-bottom: 15px;">Registration successful!</h2>';
           echo '<h3 style="margin-bottom: 10px;">Patient Details:</h3>';
           echo '<div>';
           foreach ($patientDetails as $key => $value) {
            $key = ucwords($key);
               echo "<strong>$key:</strong> $value<br>";
           }
           echo '</div>';
           echo '</div>';
            // Close the statement
            $stmt->close();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the doctor check statement
        $checkDoctor->close();
    } else {
        echo "Doctor ID does not exist.";
    }
} else {
    echo "Missing POST data.";
}
?>
