
<?php
include('check.php'); // Include the file that retrieves doctor information
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Info</title>
    <link rel="stylesheet" type="text/css" href="patient.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
</head>
(`name`, `dob`, `email`, `phone`, `address`, `id`, `ailment`, `type`, `pstatus`, `doctor_id`) VALUES
<body>
    <h2>Patient Information</h2>
    <p>Patient ID: <?php echo $row['id']; ?></p>
    <p>Doctor ID: <?php echo $row['doctor_id']; ?></p>
    <p>Name: <?php echo $row['name']; ?></p>
    <p>Date of Birth: <?php echo $row['dob']; ?></p>
    <p>Email: <?php echo $row['email']; ?></p>
    <p>Phone: <?php echo $row['phone']; ?></p>
    <p>Ailment: <?php echo $row['ailment']; ?></p>
    <p>Address: <?php echo $row['address']; ?></p>
    <p>Type: <?php echo $row['type']; ?></p>
    <p>Patient Status: <?php echo $row['pstatus']; ?></p>
    <!-- Add more fields as needed -->
</body>
</html>
