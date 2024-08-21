<?php
if (isset($_POST['forgot'])) {
    $email = trim($_POST['email']);

    if (!empty($email)) {
        $host = "localhost";
        $dbname = "Save";
        $dbusername = "root";
        $dbpassword = "";

        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

        if ($conn->connect_error) {
            die('Connection Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
        }

        // Check if email exists in the database
        $SELECT = "SELECT id, name FROM users WHERE email = ?";
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($userId, $userName);
        $stmt->fetch();

        if ($stmt->num_rows > 0) {
            // Email exists, send reset link
            $resetToken = bin2hex(random_bytes(16)); // Generate a secure token
            $expiryTime = date("Y-m-d H:i:s", strtotime('+1 hour')); // Token valid for 1 hour

            // Store the reset token and its expiry in the database (implement this part as needed)
            $INSERT = "INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)
                      ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at)";
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sss", $userId, $resetToken, $expiryTime);
            $stmt->execute();

            // Send the reset link via email
            $resetLink = "http://yourdomain.com/reset_password.php?token=" . $resetToken;
            $subject = "Password Reset Request";
            $message = "Hi $userName,\n\nWe received a request to reset your password. Click the link below to reset it:\n\n$resetLink\n\nIf you did not request a password reset, please ignore this email.";
            $headers = "From: no-reply@yourdomain.com";

            if (mail($email, $subject, $message, $headers)) {
                echo "Password reset link has been sent to your email address.";
            } else {
                echo "Failed to send email. Please try again.";
            }
        } else {
            echo "No account found with that email address.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Email address is required.";
    }
}
?>
