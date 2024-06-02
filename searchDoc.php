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

        // Search for doctors in the database based on the search term (name or ID)
        $sql = "SELECT * FROM doctors WHERE name LIKE '%$searchTerm%' OR id = '$searchTerm'";

        $result = $conn->query($sql);
        echo "<h2>Doctor Details</h2>";
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<h2>Doctor Details</h2>";
                echo "<p>Doctor ID: " . $row["id"] . "</p>";
                echo "<p>Name: " . $row["name"] . "</p>";
                echo "<p>Date of Birth: " . $row["dob"] . "</p>";
                echo "<p>Email: " . $row["email"] . "</p>";
                echo "<p>Phone: " . $row["phone"] . "</p>";
                echo "<p>Qualification: " . $row["qualification"] . "</p>";
                echo "<p>Address: " . $row["address"] . "</p>";
                // Display other doctor details here as needed
            }
        } else {
            echo "No doctors found.";
        }
    }
}

// Close the database connection
$conn->close();
?>
