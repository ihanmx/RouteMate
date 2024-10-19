<?php
session_start(); //to move information to other pages
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web-project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errorMessage = ""; // Initialize the variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];  //($_POST["Email"]) corresponds to the name
    $password = $_POST["password"];

    // checking if the user in registers data set
    $sqlcheckuser = "SELECT * FROM register WHERE username='$username' AND password='$password' ";

    // use uppercase for SQL commands
    $resultCheckUser = $conn->query($sqlcheckuser); // $conn is an object 

    if ($resultCheckUser->num_rows > 0) { // user is registered
        $sqlInsertLogin = "INSERT INTO login (username, password) VALUES ('$username', '$password')";
        $conn->query($sqlInsertLogin);
        $_SESSION['username'] = $username;
        header("Location: ./Booking page.html"); // move user to targeted page
        exit(); // Ensure that no further code is executed after the redirect
    } else {
        // User is not registered, display a message
        $errorMessage = "User is not registered.";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="./img/logo.jpg" type="image/x-icon"/>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login - RouteMate</title>
    <style>
        body {
            font-family: "Arial", sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("https://th.bing.com/th/id/R.7c49c1eb8fb425b6a02c65b7c9119d80?rik=3mqGBkhhrZWCqA&riu=http%3a%2f%2fcdn.wallpapersafari.com%2f45%2f91%2fWTF0EG.jpg&ehk=pXDTkSu4JMfztvqnMcHEJlg40%2bP5ryv28LdMISnNa%2f4%3d&risl=&pid=ImgRaw&r=0"); /* Replace with the path to your background photo */
            background-size: cover;
            background-position: center;
            color: #333; /* Text color */
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
           
        }

        h2 {
            color: #333; /* Dark text color for headings */
            text-align: center;
        }

        img {
            display: block;
            margin: 0 auto 20px; /* Center the image and add margin below */
        }

        label {
            display: block;
            margin-top: 10px;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #ffc107; /* Yellow button background color */
            color: #333; /* Text color for buttons */
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #ffca2b; /* Darker yellow on hover */
        }

        p {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
<form  method="post">
    <img src="./img/logo.jpg" alt="RouteMate Logo" width="90"/>
    <h2>Login to RouteMate</h2>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required/>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required/>
    <button type="submit" class="login-button">
        Login
    </button>
    <?php if (!empty($errorMessage)): /* check if not empty or there is an error message */ ?>
        <p style='color: red;'><?php echo $errorMessage; ?></p>
    <?php endif; ?>
    <p>Don't have an account? <a href="./registration.php">Sign up</a></p>
</form>
</body>
</html>
