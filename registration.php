<?php

$errorMessage = ""; // Initialize the variable
$registrationMessage = ""; // Initialize the variable to not get value error
$servername = "localhost"; // Change if your database is on a different server
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "web-project"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);
/*Create connection if ($conn->connect_error) {: This is an if statement that checks whether the connection
 was successful. If there is an error (i.e., if $conn->connect_error is not an empty string), the condition 
evaluates to true, and the code inside the curly braces {} will be executed.

die("Connection failed: " . $conn->connect_error);: If the connection fails, the die 
function is called. die is a language construct in PHP that prints a message and exits the current script.
 The message printed in this case is a concatenation of the string "Connection failed: " and the specific 
 error message obtained from $conn->connect_error*/

 if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $email = $_POST["email"];
  $id = $_POST["id"];
  $location = $_POST["location"];
  $password = $_POST["password"];

  // Check if the user already exists
  $sql = "SELECT * FROM register WHERE username='$username' OR email='$email' OR id='$id'";
  $result = $conn->query($sql);
//The arrow -> is used in PHP to access properties and methods of an object. It's called the arrow 
if ($result->num_rows > 0) {
  // User already exists
  $errorMessage = "User already has an account.";
} else {
  // User does not exist, insert into the database
  $sql = "INSERT INTO register (username, email, id, location, password) VALUES ('$username', '$email', '$id', '$location', '$password')";
  if ($conn->query($sql) === TRUE) {
      // Registration successful
      $registrationMessage = "Registration is successful.";
  } else {
      // Error in registration
      $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
    }
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
    <title>Registration - RouteMate</title>
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
        min-height: 100vh; /* Set a minimum height */
        overflow-y: auto; /* Enable vertical scrolling */
      }

      form {
        max-width: 400px;
        width: 100%;
        padding: 20px;
        margin: 20px; /* Add margin to the form */
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }

      /* Rest of your CSS remains unchanged */

      h2 {
        color: #333; /* Dark text color for headings */
        text-align: center;
      }

      img {
        display: block;
        margin: 20px auto 20px; /* Adjusted margin to ensure space at the top */
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
  <!--  if the php in another page then use action attribiute -->
    <form method="post">  
      <img src="./img/logo.jpg" alt="RouteMate Logo" width="90" />
      <h2>Registration</h2>
      <p style='color: red;'><?php echo $errorMessage; ?></p>
      <p style='color: green;'>
    <?php echo $registrationMessage; ?>
    <?php if (!empty($registrationMessage)): ?>
        <a href="./Login Page.php">Go to login</a>
    <?php endif; ?>
</p>


      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required />

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required />

      <label for="id">ID:</label>
      <input type="text" id="id" name="id" required />

      <label for="address">Address:</label>
      <input type="text" id="address" name="location" required />

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required />

      <br />
      <br />
      <button type="submit">Register</button>

      <p>Already have an account? <a href="Login Page.php">Sign in</a></p>
    </form>

    <!-- <script>
      function redirectToLogin() {
        window.location.href = "./Login page.php";
      }
    </script> -->
  </body>
</html>
