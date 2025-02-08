<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $Email = $_POST['email'];
    $input_password = $_POST['password']; 

    $stmt = $conn->prepare("SELECT Password FROM Informations WHERE Email = ?");
    $stmt->bind_param("s", $Email);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($stored_hashed_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($input_password, $stored_hashed_password)) {
            header("Location: welcome.php");
            exit();
        } else {
            $error = "❌ Incorrect password!";
        }
    } else {
        $error = "❌ Email not found!";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In -- Sign Up</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }
        section {
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #4E598C;
            margin-bottom: 20px;
        }
        .labels {
            margin-bottom: 20px;
        }
        .labels label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .labels input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .labels input:focus {
            border-color: #4E598C;
            outline: none;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4E598C;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #3b4874;
        }
        p {
            text-align: center;
            margin-top: 10px;
        }
        p a {
            color: #4E598C;
            text-decoration: none;
        }
        p a:hover {
            text-decoration: underline;
        }
        #togglePassword {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            position: absolute;
            top: 50%;
            right: 20px;
            width: 25px;
            margin-left: -10px;
            transform: translateY(-50%);
        }
        .password-container {
            position: relative;
        }
        .error {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <section>
        <div class="container">
            <h1>Sign In</h1>
            <form method="POST" action="">
                <div class="labels">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="youremail@example.com" required>
                </div>

                <div class="labels password-container">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Your password" minlength="10" maxlength="16" required>
                    <button type="button" id="togglePassword">👁️</button>
                </div>
                <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
                <?php endif; ?>

                <p><a href="signup.php">Don't have an account?</a></p>
                <p><a href="forgetpassword.php">Forgot Password?</a></p>
                <button type="submit">Sign In</button>
            </form>
        </div>
    </section>

    <script>
        document.getElementById("togglePassword").addEventListener("click", function () {
            let passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                this.textContent = "🙈"; 
            } else {
                passwordField.type = "password";
                this.textContent = "👁️";
            }
        });
    </script>
</body>
</html>
