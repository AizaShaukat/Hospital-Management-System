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
// ... (database connection code)

if (isset($_POST["invoiceID"], $_POST["patientID"], $_POST["date"], $_POST["roomCharges"], $_POST["medicines"])) {
    $invoiceID = $_POST["invoiceID"];
    $patientID = $_POST["patientID"];
    $date = $_POST["date"];
    $roomCharges = $_POST["roomCharges"];
    $medicines = $_POST["medicines"];

    // Query to fetch patient's name and ailment based on patient ID
    $stmt = $conn->prepare("SELECT name, ailment FROM patients WHERE id = ?");
    $stmt->bind_param("i", $patientID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $patientName = $row['name'];
        $patientAilment = $row['ailment'];

        // Insert invoice data into the database
        $stmt = $conn->prepare("INSERT INTO invoices (invoice_id, patient_id, patient_name, ailment, date, room_charges, medicines) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("iisssss", $invoiceID, $patientID, $patientName, $patientAilment, $date, $roomCharges, $medicines);

            if ($stmt->execute()) {
                // Update patient's pstatus from Current to Discharged
                $updateStmt = $conn->prepare("UPDATE patients SET pstatus = 'Discharged' WHERE id = ?");
                $updateStmt->bind_param("i", $patientID);
                $updateStmt->execute();
                $updateStmt->close();

                // Display the generated invoice
                echo "<div style='background-color: #fff; padding: 20px; border-radius: 10px;'>";
                echo "<h2>Invoice for  $patientName</h2>";
                echo "<strong>Patient Name:</strong> $patientName<br>";
                echo "<strong>Patient Ailment:</strong> $patientAilment<br>";
                echo "<strong>Date:</strong> $date<br>";
                echo "<strong>Room Charges:</strong> $roomCharges<br>";
                echo "<strong>Medicine Charges:</strong> $medicines<br>";
                echo "<strong>Total Amount:</strong> " . ($roomCharges + $medicines) . "<br>";
                
                echo "</div>";
            } else {
                echo "Error executing query: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error in the prepared statement: " . $conn->error;
        }
    } else {
        echo "Patient with ID $patientID not found.";
    }
} else {
    echo "Missing POST data.";
}

// Close the database connection
$conn->close();
?>
