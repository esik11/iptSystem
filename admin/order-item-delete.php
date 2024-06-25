<?php
require '../config/function.php'; // Include the functions file

// Check if 'index' parameter is present and valid
$paramResult = checkParamId('index');
if (is_numeric($paramResult)) {

    // Validate the index value
    $indexValue = validate($paramResult);

    // Check if session variables 'productItems' and 'productItemIds' are set
    if (isset($_SESSION['productItems']) && isset($_SESSION['productItemIds'])) {

        // Remove the item and its ID from the session arrays
        unset($_SESSION['productItems'][$indexValue]);
        unset($_SESSION['productItemIds'][$indexValue]);

        // Redirect to order-create.php with a success message
        redirect('order-create.php', 'ITEM REMOVED');
    } else {
        // Redirect to order-create.php with a message indicating no item was found
        redirect('order-create.php', 'NO ITEM');
    }

} else {
    // Redirect to order-create.php with an error message if 'index' parameter is not numeric
    redirect('order-create.php', 'Not Numeric');
}
?>
