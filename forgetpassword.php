<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require 'vendor/autoload.php'; // If using Composer
require 'PHPMailer/vendor/autoload.php'; // If manually installed
// require 'PHPMailer/src/Exception.php';
// require 'PHPMailer/src/SMTP.php';

session_start();
require "config.php"; // Database connection

if (isset($_POST['submit'])) {  //This checks if the form has been submitted by checking if the submit button was pressed.
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if email exists
    $query = "SELECT * FROM Informations WHERE Email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) { //If the email exists, a random 6-digit verification code is generated.
        // Generate verification code
        $code = rand(100000, 999999);

        // Store code in session
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_code'] = $code;

        // Send email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            // SMTP settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'younes123ouba@gmail.com'; // Your Gmail
            $mail->Password = 'judt icgr enmg aqzo'; // Use App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email details
            $mail->setFrom('younes123ouba@gmail.com', 'Younes Ouba');
            $mail->addAddress($email);
            $mail->Subject = 'Password Reset Code';
            $mail->Body = "Your password reset code is: $code";

            $mail->send();
            header("Location: verify-code.php");
            exit();
        } catch (Exception $e) {
            $error = "Email could not be sent. Error: {$mail->ErrorInfo}";
        }
    } else {
        $error = "Email does not exist!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f7f7f7;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            color: #4E598C;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .labels {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 12px 18px;
            margin-top: 8px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
            color: #333;
            transition: border 0.3s ease;
        }

        input:focus {
            border-color: #4E598C;
            outline: none;
            box-shadow: 0 0 5px rgba(78, 89, 140, 0.4);
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #4E598C;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            margin-top: 20px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        button:hover {
            background-color: #3b4874;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .footer a {
            color: #4E598C;
            text-decoration: none;
            font-weight: 500;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Your Password?</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <div class="labels">
                <label for="email">Enter Your Email</label>
                <input type="email" name="email" id="email" placeholder="youremail@example.com" required>
            </div>
            <button type="submit" name="submit">Send Reset Code</button>
        </form>
        <div class="footer">
            <p>Remember your password? <a href="login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>
