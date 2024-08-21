<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signin'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $host = "localhost";
        $dbname = "save";
        $dbusername = "root";
        $dbpassword = "";

        // Create a new database connection
        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

        // Check for connection errors
        if ($conn->connect_error) {
            die('Connection Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
        }

        // Prepare and execute a query to check if the email exists and retrieve the password hash
        $SELECT = "SELECT password FROM signup WHERE email = ?";
        $stmt = $conn->prepare($SELECT);

        if (!$stmt) {
            die('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // Verify the provided password against the hashed password
            if (password_verify($password, $hashed_password)) {
                // Start a session and redirect to the home page or dashboard
                session_start();
                $_SESSION['email'] = $email;
                header("Location: index.html");
                exit();
            } else {
                // Invalid password
                echo "<div class='container center-message'>
                        <h1>Invalid email or password</h1>
                      </div>";
            }
        } else {
            // Email not found
            echo "<div class='container center-message'>
                    <h1>Email not registered</h1>
                  </div>";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        // Empty fields
        echo "<div class='container center-message'>
                <h1>All fields are required</h1>
              </div>";
    }
}
?>
