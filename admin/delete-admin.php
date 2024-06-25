<?php
    require '../config/function.php'; // Include the functions file

    // Check if 'id' parameter is present and valid
    $paraResultId = checkParamId('id');
    if (is_numeric($paraResultId)) {

        // Validate the admin ID
        $adminId = validate($paraResultId);

        // Get admin data by ID
        $admin = getById('admins', $adminId);
        if ($admin['status'] == 200) {
            // Delete the admin if found
            $adminDelete = delete('admins', $adminId);
            if ($adminDelete) {
                redirect('admins.php', 'ADMIN DELETED SUCCESSFULLY'); // Redirect if deletion is successful
            } else {
                redirect('admins.php', 'Something WENT WRONG'); // Redirect if deletion failed
            }
        } else {
            redirect('admins.php', $admin['message']); // Redirect if admin not found
        }

    } else {
        redirect('admins.php', 'Something WENT WRONG'); // Redirect if 'id' parameter is invalid
    }
?>
