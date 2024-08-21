<?php
if (isset($_POST['signup'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($name) && !empty($email) && !empty($password)) {
        $host = "localhost";
        $dbname = "save";
        $dbusername = "root";
        $dbpassword = "";

        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

        if ($conn->connect_error) {
            die('Connection Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
        }

        $SELECT = "SELECT email FROM signup WHERE email = ?";
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Email is already registered. Please use a different email.']);
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $INSERT = "INSERT INTO signup (name, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sss", $name, $email, $hashed_password);

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Signup successful.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
            }
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
    }
}
?>






































































































