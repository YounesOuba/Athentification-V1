<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $Full_Name = $_POST['name'];
    $Email = $_POST['email'];
    $Password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $Terms_And_Conditions = isset($_POST['termsAndConditions']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO Informations (Full_Name, Email, Password, Terms_And_Conditions) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $Full_Name, $Email, $Password, $Terms_And_Conditions);

    if ($stmt->execute()) {
        header("Location: success.php");
        exit();
    } else {
        echo `<p class="error-message">❌ Error: ' . $stmt->error . '</p>`;
    };

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up -- Sign In</title>
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
        .error-message {
            color: red;
            font-weight: bold;
            padding: 10px;
            border: 1px solid red;
            border-radius: 5px;
            text-align: center;
            margin-top: 10px;
        }

    </style>
</head>
<body>
    <section>
        <div class="container">
            <h1>Sign Up</h1>
            <form method="POST" action="">
                <div class="labels">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" placeholder="Put your name here" required>
                </div>
                
                <div class="labels">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="youremail@example.com" required>
                </div>
                
                <div class="labels password-container">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Your password" minlength="10" maxlength="16" required
                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,16}$"
                    title="Password must be 10-16 characters long and include at least one uppercase letter, one lowercase letter, one number, 
                    and one special character."
                    >
                    <button type="button" id="togglePassword">👁️</button>
                </div>
                
                <div class="labels">
                    <label for="confirmPassword">Confirm Password:</label>
                    <input type="password" id="confirmPassword" placeholder="Confirm your password" minlength="10" maxlength="16" required> 
                </div>
                
                <div class="labels" style="display: inline-flex">
                    <input style="cursor: pointer; width:17px; margin: 2px;" type="checkbox" name="termsAndConditions" id="termsAndConditions" required>
                    <label style="cursor: pointer; margin-top: 4px; margin-left: 6px;" for="termsAndConditions">Accept Terms & Conditions</label>
                </div>

                <p><a href="signin.php">Have an account?</a></p>
                <button type="submit">Sign Up</button>
            </form>
        </div>
    </section>

    <script>
        document.querySelector("form").addEventListener("submit", function(e) {
            let password = document.getElementById("password").value;
            let confirmPassword = document.getElementById("confirmPassword").value;
            if (password !== confirmPassword) {
                alert("Passwords don't match!");
                e.preventDefault();
            }
        });

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
