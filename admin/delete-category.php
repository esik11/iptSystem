<?php
    require '../config/function.php'; // Include the functions file

    // Check if 'id' parameter is present and valid
    $paraResultId = checkParamId('id');
    if (is_numeric($paraResultId)) {

        // Validate the category ID
        $categoryId = validate($paraResultId);

        // Get category data by ID
        $category = getById('categories', $categoryId);
        if ($category['status'] == 200) {
            // Delete the category if found
            $response = delete('categories', $categoryId);
            if ($response) {
                redirect('categories.php', 'CATEGORY DELETED SUCCESSFULLY'); // Redirect if deletion is successful
            } else {
                redirect('categories.php', 'Something WENT WRONG'); // Redirect if deletion failed
            }
        } else {
            redirect('categories.php', $category['message']); // Redirect if category not found
        }

    } else {
        redirect('categories.php', 'Something WENT WRONG'); // Redirect if 'id' parameter is invalid
    }
?>
