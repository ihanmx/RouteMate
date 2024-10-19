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

if (isset($_SESSION['username']) && isset($_POST['deleteForm'])) {
    $loginUsername = $_SESSION['username'];

    // Delete user data from the register table
    $deleteQuery = "DELETE FROM register WHERE username = '$loginUsername'";

    if ($conn->query($deleteQuery) === TRUE) {
        // Delete successful, you can redirect the user or perform other actions
        $deleteMsg = "Account deleted successfully";
        header("Location: ./Login page.html");
        exit();
    } else {
        // Delete failed
        $deleteErrorMsg = "Error deleting account: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
