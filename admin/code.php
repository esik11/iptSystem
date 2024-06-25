<?php
require '../config/function.php'; // Include the functions file

// Check if 'saveAdmin' form is submitted
if (isset($_POST['saveAdmin'])) {
    // Validate and get form data
    $name = validate($_POST['name'], true);
    $email = validate($_POST['email'], true);
    $password = validate($_POST['password'], true);
    $phone = validate($_POST['phone'], true);
    $is_ban = isset($_POST['is_ban']) ? 1 : 0; // Check if 'is_ban' is set

    // Check if any field is invalid
    if ($name === false || $email === false || $password === false || $phone === false) {
        redirect('create-admin.php', 'PLEASE FILL ALL THE FIELDS :>');
    }

    // Check if the email is already used by another admin
    $emailCheck = mysqli_query($conn, "SELECT * FROM admins WHERE email= '$email'");
    if ($emailCheck) {
        if (mysqli_num_rows($emailCheck) > 0) {
            redirect('create-admin.php', 'EMAIL IS ALREADY BEEN USED BY ANOTHER ADMIN :>');
        }
    }

    // Hash the password using bcrypt
    $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);
    $data = [
        'name' => $name,
        'email' => $email,
        'password' => $bcrypt_password,
        'phone' => $phone,
        'is_ban' => $is_ban
    ];

    // Insert new admin data into the database
    $result = insert('admins', $data);

    // Redirect based on the result of the insert operation
    if ($result) {
        redirect('admins.php', 'NEW ADMIN SUCCESSFULLY CREATED! :>');
    } else {
        redirect('create-admin.php', 'SOMETHING WENT WRONG :< :>');
    }
} else if (isset($_POST['updateAdmin'])) { // Check if 'updateAdmin' form is submitted
    $adminId = validate($_POST['adminId']); // Validate and get admin ID

    // Get admin data by ID
    $adminData = getById('admins', $adminId);
    if ($adminData['status'] != 200) {
        redirect('edit-admin.php?id=' . $adminId, 'PLEASE FILL REQUIRED FIELDS :>');
    }

    // Validate and get form data
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = isset($_POST['is_ban']) ? 1 : 0; // Check if 'is_ban' is set

    // Check if the email is already used by another admin
    $emailCheckQuery = "SELECT * FROM admins WHERE email = '$email' AND id!='$adminId'";
    $checkResult = mysqli_query($conn, $emailCheckQuery);
    if ($checkResult) {
        if (mysqli_num_rows($checkResult) > 0) {
            redirect('edit-admin.php?id=' . $adminId, 'EMAIL IS ALREADY BEEN USED BY ANOTHER ADMIN!');
        }
    }

    // Check if required fields are invalid
    if ($name === false || $email === false) {
        redirect('edit-admin.php?id=' . $adminId, 'PLEASE FILL REQUIRED FIELDS :>');
    }

    // Check if password is provided, if not use the existing password
    if ($password != '') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedPassword = $adminData['data']['password'];
    }

    // Prepare data for updating admin
    $data = [
        'name' => $name,
        'email' => $email,
        'password' => $hashedPassword,
        'phone' => $phone,
        'is_ban' => $is_ban
    ];

    // Update admin data in the database
    $result = update('admins', $adminId, $data);

    // Redirect based on the result of the update operation
    if ($result) {
        redirect('edit-admin.php?id=' . $adminId, 'ADMIN UPDATED SUCCESSFULLY! :>');
    } else {
        redirect('edit-admin.php?id=' . $adminId, 'SOMETHING WENT WRONG :< :>');
    }
} else if (isset($_POST['saveCategory'])) { // Check if 'saveCategory' form is submitted
    // Validate and get form data
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) ? 1 : 0; // Check if 'status' is set

    // Prepare data for inserting category
    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status
    ];

    // Insert new category data into the database
    $result = insert('categories', $data);

    // Redirect based on the result of the insert operation
    if ($result) {
        redirect('categories.php', 'CATEGORY CREATED');
    } else {
        redirect('create-categories.php', 'SOMETHING WENT WRONG');
    }
} else if (isset($_POST['updateCategory'])) { // Check if 'updateCategory' form is submitted
    $categoryId = validate($_POST['categoryId']); // Validate and get category ID

    // Validate and get form data
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) ? 1 : 0; // Check if 'status' is set

    // Prepare data for updating category
    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status
    ];

    // Update category data in the database
    $result = update('categories', $categoryId, $data);

    // Redirect based on the result of the update operation
    if ($result) {
        redirect('edit-category.php?id=' . $categoryId, 'CATEGORY UPDATED SUCCESSFULLY');
    } else {
        redirect('edit-category.php?id=' . $categoryId, 'SOMETHING WENT WRONG');
    }
} else if (isset($_POST['saveProduct'])) { // Check if 'saveProduct' form is submitted
    // Validate and get form data
    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) ? 1 : 0; // Check if 'status' is set

    // Check if an image is uploaded
    if($_FILES['image']['size'] > 0)
    {   
        $path = "../assets/uploads/products/"; // Define the upload path
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION); // Get the file extension

        $filename = time().'.'.$image_ext; // Generate a unique filename

        // Move the uploaded file to the specified path
        move_uploaded_file($_FILES['image']['tmp_name'], $path.$filename);
        $finalImage = "/assets/uploads/products/".$filename; // Set the final image path
    } else {
        $finalImage = ''; // No image uploaded
    }

    // Prepare data for inserting product
    $data = [
        'category_id' => $category_id,
        'name' => $name,
        'description' =>  $description,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $finalImage,
        'status' => $status
    ];

    // Insert new product data into the database
    $result = insert('products', $data);

    // Redirect based on the result of the insert operation
    if ($result) {
        redirect('products.php', 'PRODUCT ADDED!');
    } else {
        redirect('products.php', 'SOMETHING WENT WRONG');
    }
}else if(isset($_POST['updateProduct'])) { // Check if 'updateProduct' form is submitted
    $product_id = validate($_POST['product_id']); // Validate and get product ID
    $productData = getById('products', $product_id); // Get product data by ID

    // Check if the product exists
    if(!$productData){
        redirect('products.php', 'NO SUCH PRODUCT FOUND');
    }

    // Validate and get form data
    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) ? 1 : 0; // Check if 'status' is set

    // Check if an image is uploaded
    if($_FILES['image']['size'] > 0)
    {   
        $path = "../assets/uploads/products/"; // Define the upload path
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION); // Get the file extension

        $filename = time().'.'.$image_ext; // Generate a unique filename

        // Move the uploaded file to the specified path
        move_uploaded_file($_FILES['image']['tmp_name'], $path.$filename);
        $finalImage = "/assets/uploads/products/".$filename; // Set the final image path

        // Delete the old image file if it exists
        $deleteImage = "../".$productData['data']['image'];
        if(file_exists($deleteImage)){
            unlink($deleteImage);
        }
    } else {
        $finalImage = $productData['data']['image']; // Use the existing image
    }

    // Prepare data for updating product
    $data = [
        'category_id' => $category_id,
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $finalImage,
        'status' => $status
    ];

    // Update product data in the database
    $result = update('products', $product_id, $data);

    // Redirect based on the result of the update operation
    if ($result) {
        redirect('products-edit.php?id='.$product_id, 'PRODUCT UPDATED SUCCESSFULLY!');
    } else {
        redirect('products-edit.php?id='.$product_id, 'SOMETHING WENT WRONG');
    }
}else if(isset($_POST['saveCustomer'])) { // Check if 'saveCustomer' form is submitted
    // Validate and get form data
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = isset($_POST['status']) ? 1:0; // Check if 'status' is set

    // Check if required fields are filled
    if($name != '')
    {
        // Check if the email is already used by another customer
        $emailCheck = mysqli_query($conn,"SELECT * FROM customers WHERE email = '$email'");
        if( $emailCheck)
        {
            if(mysqli_num_rows($emailCheck) > 0)
            {
                redirect('customers.php', 'EMAIL ALREADY USED BY ANOTHER CUSTOMER');
            }
        }

        // Prepare data for inserting customer
        $data = [
            'name' => $name,	
            'email' => $email,
            'phone' =>	$phone,
            'status' => $status
        ];

        // Insert new customer data into the database
        $result = insert('customers', $data);
        if( $result)
        {
            redirect('customers.php', 'CUSTOMER CREATED!');
        } else {
            redirect('customers.php', 'SOMETHING WENT WRONG');
        }
    } else {
        redirect('customers.php', 'PLEASE FILL REQUIRED FIELDS');
    }
}else if(isset($_POST['updateCustomer'])) { // Check if 'updateCustomer' form is submitted
    // Validate and get form data
    $customerId = validate($_POST['customerId']);
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = isset($_POST['status']) ? 1:0; // Check if 'status' is set

    // Check if required fields are filled
    if($name != '')
    {
        // Check if the email is already used by another customer
        $emailCheck = mysqli_query($conn,"SELECT * FROM customers WHERE email = '$email' AND id!='$customerId'");
        if( $emailCheck)
        {
            if(mysqli_num_rows($emailCheck) > 0)
            {
                redirect('edit-customers.php?id='.$customerId, 'EMAIL ALREADY USED BY ANOTHER CUSTOMER');
            }
        }

        // Prepare data for updating customer
        $data = [
            'name' => $name,	
            'email' => $email,
            'phone' =>	$phone,
            'status' => $status
        ];

        // Update customer data in the database
        $result = update('customers',$customerId, $data);
        if( $result)
        {
            redirect('edit-customers.php?id='.$customerId, 'CUSTOMER UPDATED!');
        } else {
            redirect('edit-customers.php?id='.$customerId, 'SOMETHING WENT WRONG');
        }
    } else {
        redirect('edit-customers.php?id='.$customerId, 'PLEASE FILL REQUIRED FIELDS');
    }
}
?>
