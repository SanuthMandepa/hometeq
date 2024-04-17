<?php
session_start(); // Start the session

include("db.php");
$pagename = "smart basket";
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";
echo "<title>" . $pagename . "</title>";
echo "<body>";
include("headfile.html");
echo "<h4>" . $pagename . "</h4>";

if (!isset($_SESSION['basket'])) {
    $_SESSION['basket'] = array(); // Initialize basket if not already set
}

if (isset($_POST['h_prodid'])) {
    $newprodid = $_POST['h_prodid'];
    $reququantity = $_POST['p_quantity'];
    
    // Add product to basket or update quantity if already exists
    if (isset($_SESSION['basket'][$newprodid])) {
        $_SESSION['basket'][$newprodid] += $reququantity;
    } else {
        $_SESSION['basket'][$newprodid] = $reququantity;
    }
    
    echo "<p>1 item added";
} else {
    echo "<p>Basket unchanged";
}

$total = 0;
echo "<p><table id='baskettable'>";
echo "<tr>";
echo "<th>Product Name</th><th>Price</th><th>Quantity</th><th>Subtotal</th>";
echo "</tr>";

if (isset($_SESSION['basket'])) {
    foreach ($_SESSION['basket'] as $index => $value) {
        $SQL = "select prodId, prodName, prodPrice from Product where prodId=" . $index;
        $exeSQL = mysqli_query($conn, $SQL) or die(mysql_error());
        $arrayp = mysqli_fetch_array($exeSQL);
        echo "<tr>";
        echo "<td>" . $arrayp['prodName'] . "</td>";
        echo "<td>&pound" . number_format($arrayp['prodPrice'], 2) . "</td>";
        echo "<td style='text-align:center;'>" . $value . "</td>";
        $subtotal = $arrayp['prodPrice'] * $value;
        echo "<td>&pound" . number_format($subtotal, 2) . "</td>";
        echo "</tr>";
        $total = $total + $subtotal;
    }
} else {
    echo "<p>Empty basket";
}

echo "<tr>";
echo "<td colspan=3>TOTAL</td>";
echo "<td>&pound" . number_format($total, 2) . "</td>";
echo "</tr>";
echo "</table>";

include("footfile.html");
echo "</body>";
?>
