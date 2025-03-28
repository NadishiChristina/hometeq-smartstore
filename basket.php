<?php
session_start();

$pagename = "Smart Basket"; //Create and populate a variable called $pagename
include("db.php");

echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; //Call in stylesheet
echo "<title>" . $pagename . "</title>"; //display name of the page as window title
echo "<body>";
include("headfile.html"); //include header layout file
include ("detectlogin.php");
echo "<h4>" . $pagename . "</h4>"; //display name of the page on the web page


if(isset($_POST['h_prodid'])){
    $newprodid = $_POST['h_prodid'];
    $reququantity = $_POST['p_quantity'];

    //echo "<p>Id of selected product: " . $newprodid;
    //echo "<br>Quantity of selected product: " . $reququantity;

    $_SESSION['basket'][$newprodid]=$reququantity;
    echo "<p><b>1 item added</b>";
}else{
    echo "<p><b>Basket unchanged</b>";
}


$total= 0; //Create a variable $total and initialize it to zero
//Create HTML table with header to display the content of the basket: prod name, price, selected quantity and subtotal
echo "<p><table id='baskettable'>";
echo "<tr>";
echo "<th>Product Name</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Remove</th>";
echo "</tr>";
//if the session array $_SESSION['basket'] is set
if (isset($_SESSION['basket']))
{

//loop through the basket session array for each data item inside the session using a foreach loop
//to split the session array between the index and the content of the cell
//for each iteration of the loop
//store the id in a local variable $index & store the required quantity into a local variable $value
foreach($_SESSION['basket'] as $index => $value)
{
    $SQL="SELECT prodId, prodName, prodPrice FROM Product WHERE prodId=".$index;
    $exeSQL=mysqli_query($conn, $SQL) or die (mysqli_error($conn));
    $arrayp=mysqli_fetch_array($exeSQL);

    echo "<tr>";
    echo "<td>".$arrayp['prodName']."</td>";
    echo "<td>&pound".number_format($arrayp['prodPrice'],2)."</td>";
    echo "<td style='text-align:center;'>".$value."</td>";

    $subtotal = $arrayp['prodPrice'] * $value;
    echo "<td>&pound".number_format($subtotal,2)."</td>";

    // Remove button
    echo "<td>
            <form method='post' action='removefrombasket.php'>
                <input type='hidden' name='remove_prodid' value='".$index."'>
                <input type='submit' value='Remove'>
            </form>
          </td>";
    echo "</tr>";

    $total += $subtotal;
}

}
//else display empty basket message
else
{
echo "<p>Empty basket";
}
// Display total
echo "<tr>";
echo "<td colspan=3>TOTAL</td>";
echo "<td>&pound".number_format($total,2)."</td>";
echo "</tr>";
echo "</table>";

echo "<br><p><a href='clearbasket.php'>CLEAR BASKET</a></p>";

if (isset($_SESSION['userid']))
{
echo "<br><p><a href=checkout.php>CHECKOUT</a></p>";
}
else
{
echo "<br><p>New homteq customers: <a href='signup.php'>Sign up</a></p>";
echo "<p>Returning homteq customers: <a href='login.php'>Login</a></p>";
}


include("footfile.html"); //include head layout
echo "</body>";
