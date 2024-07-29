<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    if (isset($_POST['signup'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        
        if (!empty($name) && !empty($email) && !empty($password)) {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $host = "localhost"; // Replace with your database host
            $dbname = "Save"; // Replace with your database name
            $dbusername = "root"; // Replace with your database user
            $dbpassword = ""; // Replace with your database password

            $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

            if ($conn->connect_error) {
                die('Connection Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
            } else {
                $SELECT = "SELECT email FROM signup WHERE email = ? LIMIT 1";
                $INSERT = "INSERT INTO signup (name, email, password) VALUES (?, ?, ?)";
            }

            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($email);
            $stmt->store_result();
            $runm = $stmt->num_rows;

            if ($runm == 0) {
                $stmt->close();
                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("sss", $name, $email, $hashed_password);
                $stmt->execute();
                echo "index.html";
            } else {
                echo "Already Registered";
            }

            $stmt->close();
            $conn->close();
        }
    }

?>






























































































