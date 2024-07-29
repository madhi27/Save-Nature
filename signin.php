<?php

if (isset($_POST['signin'])) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        
        if (!empty($email) && !empty($password)) {
            $host = "localhost"; // Replace with your database host
            $dbname = "Save"; // Replace with your database name
            $dbusername = "root"; // Replace with your database user
            $dbpassword = ""; // Replace with your database password

            $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

            if ($conn->connect_error) {
                die('Connection Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
            } else {
                $SELECT = "SELECT id, name, password FROM signin WHERE email = ?";
            }

            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $name, $hashed_password);
            $stmt->fetch();

            if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
                // Start a new session and save user data
                session_start();
                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $name;
                echo "Signin Successfully";
                // Redirect to the dashboard or another page
                // header('Location: dashboard.php');
            } else {
                echo "Invalid email or password";
            }

            $stmt->close();
            $conn->close();
        }
    }
?>
