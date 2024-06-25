<?php
require '../config/function.php'; // Include the functions file
?>

<?php

// Check if the 'saveCategory' form has been submitted
if (isset($_POST['saveCategory'])) {
    // Validate the form inputs
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    // Set the status based on the checkbox value
    $status = isset($_POST['status']) == true ? 1 : 0;

    // Prepare data array for insertion
    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status
    ];

    // Insert the new category into the database
    $result = insert('categories', $data);

    // Redirect based on the result of the insertion
    if ($result) {
        redirect('categories.php', 'CATEGORY CREATED'); // Redirect if creation is successful
    } else {
        redirect('create-categories.php', 'SOMETHING WENT WRONG'); // Redirect if creation failed
    }
}
?>
