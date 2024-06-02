<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["searchTerm"])) {
        $searchTerm = mysqli_real_escape_string($conn, $_POST["searchTerm"]);

        // Search for patients in the database based on the search term (name or ID)
        $sql = "SELECT * FROM patients WHERE name LIKE '%$searchTerm%' OR id = '$searchTerm'";

        $result = $conn->query($sql);
        echo "<h2>Patient Details</h2>";
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               
                echo "<p>Patient ID: " . $row["id"] . "</p>";
                echo "<p>Name: " . $row["name"] . "</p>";
                echo "<p>Date of Birth: " . $row["dob"] . "</p>";
                echo "<p>Email: " . $row["email"] . "</p>";
                echo "<p>Phone: " . $row["phone"] . "</p>";
                echo "<p>Address: " . $row["address"] . "</p>";
                echo "<p>Ailment: " . $row["ailment"] . "</p>";
                echo "<p>Patient Type: " . $row["type"] . "</p>";
                echo "<p>Patient Status: " . $row["pstatus"] . "</p>";
                

                // Display other patient details here as needed
            }
        } else {
            echo "No patients found.";
        }
    }
}

// Close the database connection
$conn->close();
?>
