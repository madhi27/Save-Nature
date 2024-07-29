<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['forgot password'])) {
        $email = trim($_POST['email']);

        if (!empty($email)) {
            $host = "localhost"; // Replace with your database host
            $dbname = "Save"; // Replace with your database name
            $dbusername = "root"; // Replace with your database user
            $dbpassword = ""; // Replace with your database password

            $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

            if ($conn->connect_error) {
                die('Connection Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
            }

            // Check if the email exists
            $SELECT = "SELECT id FROM signup WHERE email = ?";
            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            $userExists = $stmt->num_rows > 0;

            if ($userExists) {
                // Generate a password reset token
                $token = bin2hex(random_bytes(32)); // Generate a secure random token
                $expires = date("U") + 3600; // Token expires in 1 hour

                // Save the token and expiration in the database
                $UPDATE = "UPDATE signup SET reset_token = ?, reset_expires = ? WHERE email = ?";
                $stmt = $conn->prepare($UPDATE);
                $stmt->bind_param("sis", $token, $expires, $email);
                $stmt->execute();

                // Send the reset email
                $resetLink = "http://yourdomain.com/reset-password.php?token=$token";
                $subject = "Password Reset Request";
                $message = "Click the following link to reset your password: $resetLink";
                $headers = "From: no-reply@yourdomain.com";

                mail($email, $subject, $message, $headers);

                echo "Password reset instructions have been sent to your email.";
            } else {
                echo "No account found with that email.";
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Email is required.";
        }
    }
}
?>
