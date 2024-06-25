<?php
    require '../config/function.php'; // Include the functions file

    // Check if 'id' parameter is present and valid
    $paraResultId = checkParamId('id');
    if (is_numeric($paraResultId)) {

        // Validate the product ID
        $productId = validate($paraResultId);

        // Get product data by ID
        $product = getById('products', $productId);
        if ($product['status'] == 200) {
            // Delete the product if found
            $response = delete('products', $productId);
            if ($response) {
                // Delete the product image if it exists
                $deleteImage = "../" . $product['data']['image'];
                if (file_exists($deleteImage)) {
                    unlink($deleteImage);
                }
                redirect('products.php', 'PRODUCT DELETED SUCCESSFULLY'); // Redirect if deletion is successful
            } else {
                redirect('products.php', 'Something WENT WRONG'); // Redirect if deletion failed
            }
        } else {
            redirect('products.php', $product['message']); // Redirect if product not found
        }

    } else {
        redirect('products.php', 'Something WENT WRONG'); // Redirect if 'id' parameter is invalid
    }
?>
