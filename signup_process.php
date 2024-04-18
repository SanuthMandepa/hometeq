<?php
session_start(); // Start the session
include("db.php"); // Include db.php file to connect to DB
mysqli_report(MYSQLI_REPORT_OFF); // Deactivate automatic error messaging
$pagename="Sign Up Results"; // Set page name
echo "<link rel='stylesheet' type='text/css' href='mystylesheet.css'>"; // Call stylesheet
echo "<title>".$pagename."</title>"; // Set window title
echo "<body>";
include ("headfile.html"); // Include header layout file
echo "<h4>".$pagename."</h4>"; // Display page name

// Create a regular expression variable for email validation
$reg = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";

// Capture and trim the inputs from the signup form
$fname = trim($_POST['r_firstname']);
$lname = trim($_POST['r_lastname']);
$address = trim($_POST['r_address']);
$postcode = trim($_POST['r_postcode']);
$telno = trim($_POST['r_telno']);
$email = trim($_POST['r_email']);
$password1 = trim($_POST['r_password1']);
$password2 = trim($_POST['r_password2']);

// Check if any of the mandatory fields are empty
if (empty($fname) || empty($lname) || empty($address) || empty($postcode) || empty($telno) || empty($email) || empty($password1) || empty($password2)) {
    echo "<p><b>Sign-up failed!</b></p>";
    echo "<br><p>Your signup form is incomplete and all fields are mandatory";
    echo "<br>Make sure you provide all the required details</p>";
    echo "<br><p>Go back to <a href='signup.php'>sign up</a></p>";
    echo "<br><br><br><br>";
} elseif ($password1 !== $password2) { // Check if passwords match
    echo "<p><b>Sign-up failed!</b></p>";
    echo "<br><p>The two passwords do not match";
    echo "<br>Make sure you enter them correctly</p>";
    echo "<br><p>Go back to <a href='signup.php'>sign up</a></p>";
    echo "<br><br><br><br>";
} elseif (!preg_match($reg, $email)) { // Check if the email matches the regular expression
    echo "<p><b>Sign-up failed!</b></p>";
    echo "<br><p>Email not valid";
    echo "<br>Make sure you enter a correct email address</p>";
    echo "<br><p>Go back to <a href='signup.php'>sign up</a></p>";
    echo "<br><br><br><br>";
}else {
    // Write SQL query to insert new user into Users table
    $SQL = "INSERT INTO Users (userType, userFName, userSName, userAddress, userPostCode, userTelNo, userEmail, userPassword)
            VALUES ('C', '$fname', '$lname', '$address', '$postcode', '$telno', '$email', '$password1')";

    // Execute the INSERT INTO SQL query
    if (mysqli_query($conn, $SQL)) {
        // Display sign up success
        echo "<p><b>Sign-up successful!</b></p>";
        echo "<br><p>To continue, please <a href='login.php'>login</a></p>";
    } else {
        // Display sign up failure
        echo "<p><b>Sign-up failed!</b></p>";
        
        // Handle specific error cases
        if (mysqli_errno($conn) === 1062) {
            echo "<br><p>Email already in use";
            echo "<br>You may be already registered or try another email address</p>";
        } elseif (mysqli_errno($conn) === 1064) {
            echo "<br><p>Invalid characters entered in the form";
            $invalidchars = "apostrophes like [ ' ] and backslashes like [ \\ ]";
            echo "<br>Make sure you avoid the following characters: $invalidchars</p>";
        }
        echo "<br><p>Go back to <a href='signup.php'>sign up</a></p>";
        echo "<br><br><br><br>";
    }
}

include("footfile.html"); // Include foot layout
echo "</body>";
?>
