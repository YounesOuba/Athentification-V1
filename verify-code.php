<?php
session_start();    //This starts a new session or resumes an existing session.



//This checks if the reset_email session variable is set. If not, it redirects the user to the forgot-password.php page and exits the script.
if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot-password.php");
    exit();
}

//This checks if the form has been submitted by checking if the verify button was pressed. It then retrieves the code entered by the user.
if (isset($_POST['verify'])) {
    $user_code = $_POST['code'];


    //This compares the code entered by the user with the code stored in the session. If they match, the user is redirected to the reset-password.php page. If they don't match, an error message is set.
    if ($user_code == $_SESSION['reset_code']) {
        header("Location: reset-password.php");
        exit();
    } else {
        $error = "Invalid code!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code</title>
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
        <h2>Enter Verification Code</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <div class="labels">
                <label for="code">Verification Code</label>
                <input type="text" name="code" id="code" placeholder="Enter the code" required>
            </div>
            <button type="submit" name="verify">Verify</button>
        </form>
        <div class="footer">
            <p>Didn't receive the code? <a href="forgot-password.php">Resend it</a></p>
        </div>
    </div>
</body>
</html>
