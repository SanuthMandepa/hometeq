<?php

session_start(); // Start the session

include("db.php"); // Include db.php file to connect to DB

$pagename="sign up results"; //Create and populate a variable called $pagename
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; //Call in stylesheet
echo "<title>".$pagename."</title>"; //display name of the page as window title
echo "<body>";
include ("headfile.html"); //include header layout file 
echo "<h4>".$pagename."</h4>"; //display name of the page on the web page

//Capture and trim the 7 inputs entered in the the 7 fields of the form using the $_POST superglobal variable
//Store these details into a set of 7 new local variables
$fname=trim($_POST['r_firstname']);
$lname=trim($_POST['r_lastname']);
$address=trim($_POST['r_address']);
$postcode=trim($_POST['r_postcode']);
$telno=trim($_POST['r_telno']);
$email=trim($_POST['r_email']);
$password1=trim($_POST['r_password1']);
$password2=trim($_POST['r_password2']);
//Write a SQL query to insert a new user into Users table 
$SQL="insert into Users (userType, userFName, userSName, userAddress, userPostCode, userTelNo, userEmail, userPassword)
values ('C','".$fname."','".$lname."','".$address."','".$postcode."', '".$telno."', '".$email."', '".$password1."')";
//Execute the INSERT INTO SQL query
mysqli_query($conn, $SQL);

include("footfile.html"); //include head layout
echo "</body>";
?>