<?php
session_start();
require "config.php";

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgetpassword.php");
    exit();
}

if (isset($_POST['reset'])) {
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Password validation
    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match!";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $new_password)) {
        $error = "Password must be at least 8 characters, include a capital letter, a small letter, a number, and a special character.";
    } else {
        $email = $_SESSION['reset_email'];
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        $query = "UPDATE Informations SET Password = '$hashed_password' WHERE Email = '$email'";
        mysqli_query($conn, $query);

//         $query: This query updates the Password field in the Informations table with the new hashed password for the user whose Email matches the one stored in the session.
//         mysqli_query($conn, $query): This function executes the query. It sends the SQL statement to the database server identified by the connection object $conn.

        
        // Clear session
        unset($_SESSION['reset_email']);
        unset($_SESSION['reset_code']);

        header("Location: resetsuccess.php"); // Redirect to login
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script>
        function togglePassword() {
            var passInput = document.getElementById("password");
            var passConfirm = document.getElementById("confirm_password");
            if (passInput.type === "password") {
                passInput.type = "text";
                passConfirm.type = "text";
            } else {
                passInput.type = "password";
                passConfirm.type = "password";
            }
        }
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f5f5;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: white;
            padding: 40px 50px;
            border-radius: 12px;
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
            font-size: 24px;
            font-weight: 500;
            margin-bottom: 30px;
        }

        .labels {
            margin-bottom: 20px;
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
            margin-top: 10px;
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

        .btn {
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

        .btn:hover {
            background-color: #3b4874;
        }

        .error {
            color: red;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .show-password {
            margin-top: 15px;
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #777;
        }

        .show-password input {
            margin-right: 10px;
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
        <h2>Reset Your Password</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <div class="labels">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" placeholder="New password" required>
            </div>
            <div class="labels">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password" required>
            </div>
            <div class="show-password">
                <input type="checkbox" onclick="togglePassword()"> <span>Show Password</span>
            </div>
            <button type="submit" name="reset" class="btn">Reset Password</button>
        </form>
        <div class="footer">
            <p>Remembered your password? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>
