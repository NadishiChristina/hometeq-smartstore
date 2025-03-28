<?php
session_start();

if (isset($_POST['remove_prodid'])) {
    $remove_prodid = $_POST['remove_prodid'];

    // Check if the product exists in the basket
    if (isset($_SESSION['basket'][$remove_prodid])) {
        unset($_SESSION['basket'][$remove_prodid]); // Remove item from basket
    }
}

// Redirect back to the basket page
header("Location: basket.php");
exit();
?>
