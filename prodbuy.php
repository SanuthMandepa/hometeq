<?php
include("db.php");
$pagename="a smart buy for a smart home"; //Create and populate a variable called $pagename
echo "<link rel='stylesheet' type='text/css' href='mystylesheet.css'>"; //Call in stylesheet
echo "<title>".$pagename."</title>"; //display name of the page as window title
echo "<body>";
include("headfile.html"); //include header layout file 
echo "<h4>".$pagename."</h4>"; //display name of the page on the web page
//retrieve the product id passed from previous page using the GET method and the $_GET superglobal variable
//applied to the query string u_prod_id
//store the value in a local variable called $prodid
$prodid=$_GET['u_prod_id'];
//display the value of the product id, for debugging purposes
//echo "<p>Selected product Id: ".$prodid;
//create a $SQL variable and populate it with a SQL statement that retrieves details for the selected product
$SQL="select prodId, prodName, prodPicNameLarge, prodDescripLong, prodPrice, prodQuantity 
from Product
where prodId=".$prodid;
$exeSQL=mysqli_query($conn, $SQL) or die (mysqli_error());
$arrayp=mysqli_fetch_array($exeSQL);
echo "<table style='border: 0px'>";
echo "<tr>";
echo "<td style='border: 0px'>";
echo "<img src=images/".$arrayp['prodPicNameLarge']." height=350 width=350>";
echo "</td>";
echo "<td style='border: 0px'>";
echo "<p><h5>".$arrayp['prodName']."</h5></p>";
echo "<br><p>".$arrayp['prodDescripLong']."</p>";
echo "<br><p><b>&pound".$arrayp['prodPrice']."</b></p>";
echo "<br><p>Number left in stock: ".$arrayp['prodQuantity'] ."</p>";
echo "</td>";
echo "</tr>"; 
echo "</table>";

echo "<br><p>Number to be purchased: ";
//create form made of one text field and one button for user to enter quantity
//the value entered in the form will be posted to the basket.php to be processed
echo "<form action=basket.php method=post>";
echo "<input type=text name=p_quantity size=5 maxlength=3>";
echo "<input type=submit name='submitbtn' value='ADD TO BASKET' id='submitbtn'>";
//pass the product id to the next page basket.php as a hidden value
echo "<input type=hidden name=h_prodid value=".$prodid.">";
echo "</form>";
echo "</p>";

//display random text

include("footfile.html"); //include head layout
echo "</body>";
?>
