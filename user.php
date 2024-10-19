<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web-project";

$conn = new mysqli($servername, $username, $password, $dbname);

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in and return the user name from the login page
if (isset($_SESSION['username'])) {
    $loginUsername = $_SESSION['username'];
    $registerQuery = "SELECT * FROM register WHERE username = '$loginUsername'";
    $registerResult = $conn->query($registerQuery);

    if ($registerResult->num_rows > 0) {
        $userInfo = $registerResult->fetch_assoc();
    }
}

$newUsername = isset($_POST['username']) ? $_POST['username'] : null;
$newPassword = isset($_POST['password']) ? $_POST['password'] : null;
$newEmail = isset($_POST['Email']) ? $_POST['Email'] : null;
$newABSHER = isset($_POST['ABSHER']) ? $_POST['ABSHER'] : null;
$newBirthday = isset($_POST['birthday']) ? $_POST['birthday'] : null;
$newLocation = isset($_POST['location']) ? $_POST['location'] : null;

// Check if the update form is submitted
if (isset($_POST['update'])) {
    // Update the register table with the new information
    $updateQuery = "UPDATE register SET 
        username='$newUsername',
        password='$newPassword',
        email='$newEmail',
        ID='$newABSHER',
        birthdate='$newBirthday',
        location='$newLocation'
        WHERE username = '$loginUsername'";

    if ($conn->query($updateQuery) === TRUE) {
        // Update successful
        $updtamsg = "Update successful";
    } else {
        // Update failed
        $errorupdtamsg = "Error updating record: " . $conn->error;
    }
}

// Check if the delete form is submitted
if (isset($_POST['delete'])) {
    // Delete user data from the register table
    $deleteQuery = "DELETE FROM register WHERE username = '$loginUsername'";
    if ($conn->query($deleteQuery) === TRUE) {
        // Delete successful, redirect the user or perform other actions
        header("Location: ./Login page.php");
        exit();
    } else {
        // Delete failed
        $deleteErrorMsg = "Error deleting account: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="./img/logo.jpg" type="image/x-icon" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Account info</title>
    <style>
        body {
            font-family: "Arial", sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("https://th.bing.com/th/id/R.7c49c1eb8fb425b6a02c65b7c9119d80?rik=3mqGBkhhrZWCqA&riu=http%3a%2f%2fcdn.wallpapersafari.com%2f45%2f91%2fWTF0EG.jpg&ehk=pXDTkSu4JMfztvqnMcHEJlg40%2bP5ryv28LdMISnNa%2f4%3d&risl=&pid=ImgRaw&r=0");
            background-size: cover;
            background-position: center;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .form {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            margin: 20px 0;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            text-align: center;
        }

        img {
            display: block;
            margin: 0 auto 20px;
        }

        label {
            display: block;
            margin-top: 10px;
            font-size: 14px;
        }

        input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #ffc107;
            color: #333;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: calc(100% - 20px);
            margin-top: 10px;
        }

        .delete-button {
            width: 100%;
            margin-top: 10px;
            font-size: 16px;
            background-color: transparent;
            color: red;
            border: none;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div style="display: flex; flex-direction: column; align-items: center; max-width: 400px; width: 100%;">
        <form action="" method="post" class="form">
            <img src="https://th.bing.com/th/id/R.d268b238932809e18b85a7820184220f?rik=jPzzn6O89g8oJQ&pid=ImgRaw&r=0" alt="Profile pic" width="90" />
    
            <h2><?php echo isset($userInfo['username']) ? $userInfo['username'] : ''; ?></h2>
    
            <label for="username">Username:</label>
            <input type="username" value="<?php echo isset($userInfo['username']) ? $userInfo['username'] : ''; ?>" name="username" />
    
            <label for="password">Password:</label>
            <input type="username" value="<?php echo isset($userInfo['password']) ? $userInfo['password'] : ''; ?>" name="password" />
    
            <label for="ُEmail">Email:</label>
            <input type="email" value="<?php echo isset($userInfo['email']) ? $userInfo['email'] : ''; ?>" name="Email" />
    
            <label for="ABSHER">ABSHER account:</label>
            <input type="text" value="<?php echo isset($userInfo['ID']) ? $userInfo['ID'] : ''; ?>" name="ABSHER"  />
    
            <label for="Birthday">Birthday:</label>
            <input type="date" name="birthday" value="<?php echo isset($userInfo['birthdate']) ? $userInfo['birthdate'] : ''; ?>"/>
    
            <label for="location">Current location:</label>
            <input type="text" name="location" value="<?php echo isset($userInfo['location']) ? $userInfo['location'] : ''; ?>" />
    
            <button type="submit" name="update">Update information</button>
    
            <button type="submit" name="delete" class="delete-button" onclick="alarm()">Delete my account</button>
        </form>
    </div>
    <script>
        function alarm() {
            alert("Are you sure you want to delete your account?");
        }
    </script>
</body>
</html>
