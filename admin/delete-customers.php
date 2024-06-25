<?php
    require '../config/function.php'; // Include the functions file

    // Check if 'id' parameter is present and valid
    $paraResultId = checkParamId('id');
    if (is_numeric($paraResultId)) {

        // Validate the customer ID
        $customerId = validate($paraResultId);

        // Get customer data by ID
        $customer = getById('customers', $customerId);
        if ($customer['status'] == 200) {
            // Delete the customer if found
            $response = delete('customers', $customerId);
            if ($response) {
                redirect('customers.php', 'CUSTOMER DELETED SUCCESSFULLY'); // Redirect if deletion is successful
            } else {
                redirect('customers.php', 'Something WENT WRONG'); // Redirect if deletion failed
            }
        } else {
            redirect('customers.php', $customer['message']); // Redirect if customer not found
        }

    } else {
        redirect('customers.php', 'Something WENT WRONG'); // Redirect if 'id' parameter is invalid
    }
?>
