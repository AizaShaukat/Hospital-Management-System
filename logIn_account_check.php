<?php

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

    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Retrieve the selected role
    // Retrieve the selected role


   if($role == 'doctor'){
    $sql = "SELECT * FROM doctor_id WHERE doc_id = '$email' AND doc_password = '$password'";
   }
   else {
    $sql = "SELECT * FROM admin_id WHERE admin_id = '$email' AND admin_password = '$password'";
   }
    // SQL query to check if the email and password exist in the specified table

    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        // User found, display information
        while ($row = $result->fetch_assoc()) {
            if ($role == 'doctor') {
                header("Location: doctor.html?id=" . $row['doc_id']);
            } elseif ($role == 'admin') {
              
                header("Location:admin.html");
            }
        }
    } else {
        // User not found, redirect to main_index.html
        header("Location: main_index.html");
        exit();
    }

    $mysqli->close();
?>
