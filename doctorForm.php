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

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["docID"]) &&
        isset($_POST["name"]) &&
        isset($_POST["dob"]) &&
        isset($_POST["email"]) &&
        isset($_POST["phone"]) &&
        isset($_POST["qualification"]) &&
        isset($_POST["address"]) &&
        isset($_POST["password"]) &&
        isset($_POST["achievements"])
    ) {
        // Get user input and sanitize it
        $docID = mysqli_real_escape_string($conn, $_POST["docID"]);
        $name = mysqli_real_escape_string($conn, $_POST["name"]);
        $dob = mysqli_real_escape_string($conn, $_POST["dob"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
        $qualification = mysqli_real_escape_string($conn, $_POST["qualification"]);
        $address = mysqli_real_escape_string($conn, $_POST["address"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);
        $achievements = mysqli_real_escape_string($conn, $_POST["achievements"]);

        // Insert user data into the doctors table using a prepared statement
        $stmt = $conn->prepare("INSERT INTO doctors (id, name, dob, email, phone, qualification, address, achievements) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        if ($stmt) {
            $stmt->bind_param("ssssssss", $docID, $name, $dob, $email, $phone, $qualification, $address, $achievements);
            
            if ($stmt->execute()) {
                // Registration successful! Now fetch and display all details of the registered patient
                $fetchPatient = $conn->prepare("SELECT * FROM doctors WHERE id = ?");
                $fetchPatient->bind_param("s", $docID);
                $fetchPatient->execute();
                $result = $fetchPatient->get_result();
                $docDetails = $result->fetch_assoc();
    
               // Displaying patient details in a presentable format
               echo '<div style="background-color: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); margin-top: 20px;">';
               echo '<h2 style="margin-bottom: 15px;">Registration successful!</h2>';
               echo '<h3 style="margin-bottom: 10px;">Doctor Details:</h3>';
               echo '<div>';
               foreach ($docDetails as $key => $value) {
                $key = ucwords($key);
                   echo "<strong>$key:</strong> $value<br>";
               }
               echo '</div>';
               
                // Close the statement

                // Insert id and password into the doctor_id table
                $passwordStmt = $conn->prepare("INSERT INTO doctor_id (doc_id, doc_password) VALUES (?, ?)");
                
                if ($passwordStmt) {
                    $passwordStmt->bind_param("ss", $docID, $password);

                    if ($passwordStmt->execute()) {
                        echo "Doctor's ID and password also inserted successfully.";

                    } else {
                        echo "Error inserting password: " . $passwordStmt->error;
                    }

                    $passwordStmt->close();
                } else {
                    echo "Error in password statement: " . $conn->error;
                }
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error in prepared statement: " . $conn->error;
        }
    }
}
echo '</div>';
// Close the database connection
$conn->close();
?>
