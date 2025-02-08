<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f7f7f7;
        }

        .container {
            text-align: center;
            background-color: #fff;
            padding: 60px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 60%;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .signin, .signup {
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 10px;
            font-size: 18px;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hey, this is the main page.</h1>

        <div class="signin">
            <h2>Have an account?</h2>
            <a href="signin.php">Login</a>
        </div>
        
        <div class="signup">
            <h2>Don't have an account?</h2>
            <a href="signup.php">Sign up</a>
        </div>
    </div>
</body>
</html>