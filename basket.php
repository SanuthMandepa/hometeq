<?php
session_start(); // Start the session

include ("db.php"); // Include db.php file to connect to DB

$pagename = "smart basket"; // Create and populate a variable called $pagename
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; // Call in stylesheet
echo "<title>" . $pagename . "</title>"; // Display name of the page as window title
echo "<body>";
include ("headfile.html"); // Include header layout file 
echo "<h4>" . $pagename . "</h4>"; // Display name of the page on the web page

// Check if basket session variable is set, initialize if not
if (!isset($_SESSION['basket'])) {
    $_SESSION['basket'] = array(); // Initialize basket as an empty array
}
// Check if the posted ID of the new product is set i.e., if the user is adding a new product into the basket
if (isset($_POST['h_prodid'])) { 
    // Capture the ID of selected product using the POST method and the $_POST superglobal variable
    // and store it in a new local variable called $newprodid
    $newprodid = $_POST['h_prodid'];
    // Capture the required quantity of selected product using the POST method and $_POST superglobal variable 
    // and store it in a new local variable called $reququantity
    $reququantity = $_POST['p_quantity'];
    // Create a new cell in the basket session array. Index this cell with the new product id.
    // Inside the cell store the required product quantity 
    // $_SESSION['basket'][$newprodid] = $reququantity;
    // Add product to basket or update quantity if already exists
    if (isset($_SESSION['basket'][$newprodid])) {
        $_SESSION['basket'][$newprodid] += $reququantity; // Increment quantity if product already exists
    } else {
        $_SESSION['basket'][$newprodid] = $reququantity; // Add new product to basket
    }


    // Display "1 item added to the basket" message
    echo "<p>1 item added";
}
// Else
// Display "Current basket unchanged" message
else {
    echo "<p>Basket unchanged";
}

$total = 0; // Create a variable $total and initialize it to zero
// Create HTML table with header to display the content of the basket: prod name, price, selected quantity, and subtotal
echo "<p><table id='baskettable'>";
echo "<tr>";
echo "<th>Product Name</th><th>Price</th><th>Quantity</th><th>Subtotal</th>";
echo "</tr>";
// If the session array $_SESSION['basket'] is set
if (isset($_SESSION['basket'])) {
    // Loop through the basket session array for each data item inside the session using a foreach loop 
    // to split the session array between the index and the content of the cell
    // For each iteration of the loop, store the id in a local variable $index & store the required quantity into a local variable $value
    foreach($_SESSION['basket'] as $index => $value) {
        // SQL query to retrieve from Product table details of selected product for which id matches $index
        // Execute query and create an array of records $arrayp
        $SQL = "select prodId, prodName, prodPrice from Product where prodId=" . $index;
        $exeSQL = mysqli_query($conn, $SQL) or die (mysql_error());
        $arrayp = mysqli_fetch_array($exeSQL);
        echo "<tr>";
        // Display product name & product price using array of records $arrayp
        echo "<td>".$arrayp['prodName']."</td>";
        echo "<td>&pound".number_format($arrayp['prodPrice'],2)."</td>";
        // Display selected quantity of product retrieved from the cell of session array and now in $value
        echo "<td style='text-align:center;'>".$value."</td>";
        // Calculate subtotal, store it in a local variable $subtotal and display it
        $subtotal = $arrayp['prodPrice'] * $value;
        echo "<td>&pound".number_format($subtotal,2)."</td>";
        echo "</tr>";
        // Increase total by adding the subtotal to the current total
        $total = $total + $subtotal;
    }
}
// Else, display empty basket message
else {
    echo "<p>Empty basket";
}
// Display total
echo "<tr>";
echo "<td colspan=3>TOTAL</td>";
echo "<td>&pound".number_format($total,2)."</td>";
echo "</tr>";
echo "</table>";


// //if the posted ID of the new product is set i.e. if the user is adding a new product into the basket
// if (isset($_POST['h_prodid']))
// { 
//     //capture the ID of selected product using the POST method and the $_POST superglobal variable
//     //and store it in a new local variable called $newprodid
//     $newprodid=$_POST['h_prodid'];
    
//     //capture the required quantity of selected product using the POST method and $_POST superglobal variable 
//     //and store it in a new local variable called $reququantity
//     $reququantity=$_POST['p_quantity'];
    
    
//     //Display id of selected product
//     echo "<p>Id of selected product: ".$newprodid;
//     //Display quantity of selected product
//     echo "<br>Quantity of selected product: ".$reququantity;
//     //create a new cell in the basket session array. Index this cell with the new product id.
//     //Inside the cell store the required product quantity 
//     $_SESSION['basket'][$newprodid]=$reququantity;
//     echo "<b><p>1 item added";
// }
// //else
// //Display "Current basket unchanged " message
// else
// {
// echo "<p>Basket unchanged";

// }


include("footfile.html"); //include head layout
echo "</body>";
?>