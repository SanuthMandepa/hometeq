<?php
session_start();
include("db.php");
$pagename="your login results"; //Create and populate a variable called $pagename
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; //Call in stylesheet
echo "<title>".$pagename."</title>"; //display name of the page as window title
echo "<body>";
include ("headfile.html"); //include header layout file 
echo "<h4>".$pagename."</h4>"; //display name of the page on the web page
//capture the 2 values entered by the user in the form using the $_POST superglobal variable 
//assign these 2 values to 2 local variables
$email = $_POST['l_email'];
$password = $_POST['l_password'];

// Check if either mandatory email or password fields in the form are empty
if (empty($email) || empty($password)) {
    echo "<p><b>Login failed!</b>"; // Display login error
    echo "<br>Login form incomplete";
    echo "<br>Make sure you provide all the required details</p>";
    echo "<br><p> Go back to <a href='login.php'>login</a></p>";
} else {
    $SQL = "SELECT * FROM Users WHERE userEmail = '".$email."'"; // Retrieve record if email matches login email
    $exeSQL = mysqli_query($conn, $SQL) or die(mysqli_error($conn)); // Execute SQL query
    $nbrecs = mysqli_num_rows($exeSQL); // Retrieve the number of records

    if ($nbrecs == 0) { // If no records were located for which email matches entered email
        echo "<p><b>Login failed!</b>"; // Display login error
        echo "<br>Email not recognised</p>";
        echo "<br><p> Go back to <a href='login.php'>login</a></p>";
    } else {
        $arrayuser = mysqli_fetch_array($exeSQL); // Create array of user for this email

        if ($arrayuser['userPassword'] !== $password) { // If the password in the array matches the password entered in the form
            echo "<p><b>Login failed!</b>"; // Display login error
            echo "<br>Password not valid</p>";
            echo "<br><p> Go back to <a href='login.php'>login</a></p>";
        } else {
            echo "<p><b>Login success</b></p>"; // Display login success
            $_SESSION['userid'] = $arrayuser['userId']; // Create session variable to store the user id
            $_SESSION['fname'] = $arrayuser['userFName']; // Create session variable to store the user first name
            $_SESSION['sname'] = $arrayuser['userSName']; // Create session variable to store the user surname
            $_SESSION['usertype'] = $arrayuser['userType']; // Create session variable to store the user type
            echo "<p>Welcome, ".$_SESSION['fname']." ".$_SESSION['sname']."</p>"; // Display welcome greeting

            if ($_SESSION['usertype'] == 'C') { // If user type is C, they are a customer
                echo "<p>User Type: homteq Customer</p>";
            }
            if ($_SESSION['usertype'] == 'A') { // If user type is A, they are an admin
                echo "<p>User type: homteq Administrator</p>";
            }

            echo "<br><p>Continue shopping for <a href='index.php'>Home Tech</a>";
            echo "<br>View your <a href='basket.php'>Smart Basket</a></p>";
        }
    }
}

include("footfile.html"); // Include foot layout
echo "</body>";
?>