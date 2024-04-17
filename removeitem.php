<?php
session_start(); // Start the session

// Check if the value of the product id to be deleted (which was posted through the hidden field) is set
if (isset($_POST['del_prodid'])) {
    // Capture the posted product id and assign it to a local variable $delprodid
    $delprodid = $_POST['del_prodid'];
    // Unset the cell of the session for this posted product id variable
    unset($_SESSION['basket'][$delprodid]);
    // Redirect back to the basket page after removing the item
    header("Location: basket.php");
    exit(); // Stop further execution of the script
}
?>
