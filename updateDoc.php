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
    $docID = $_POST["docID"];
    $password = $_POST["password"];
    $name = $_POST["name"];
    $dob = $_POST["dob"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $qualification = $_POST["qualification"];
    $address = $_POST["address"];
    $achievements = $_POST["achievements"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM doctors WHERE id = '$docID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $updateQuery = "UPDATE doctors SET name='$name', dob='$dob', email='$email', phone='$phone', qualification='$qualification', address='$address', achievements='$achievements' WHERE id='$docID'";

        if ($conn->query($updateQuery) === TRUE) {
            $fetchPatient = $conn->prepare("SELECT * FROM doctors WHERE id = ?");
                $fetchPatient->bind_param("s", $docID);
                $fetchPatient->execute();
                $result = $fetchPatient->get_result();
                $docDetails = $result->fetch_assoc();
    
               // Displaying patient details in a presentable format
               echo '<div style="background-color: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); margin-top: 20px;">';
               echo '<h2 style="margin-bottom: 15px;">Record Updated Successfully!</h2>';
               echo '<h3 style="margin-bottom: 10px;">Doctor Details:</h3>';
               echo '<div>';
               foreach ($docDetails as $key => $value) {
                $key = ucwords($key);
                   echo "<strong>$key:</strong> $value<br>";
               }
               echo '</div>';
               
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Doctor ID not found in the database";
    }

    $conn->close();
}
?>
