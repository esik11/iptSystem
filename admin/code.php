<?php
require '../config/function.php';

if (isset($_POST['saveAdmin'])) {
    $name = validate($_POST['name'], true);
    $email = validate($_POST['email'], true);
    $password = validate($_POST['password'], true);
    $phone = validate($_POST['phone'], true);
    $is_ban = isset($_POST['is_ban']) ? 1 : 0;

    if ($name === false || $email === false || $password === false || $phone === false) {
        redirect('create-admin.php', 'PLEASE FILL ALL THE FIELDS :>');
    }

    $emailCheck = mysqli_query($conn, "SELECT * FROM admins WHERE email= '$email'");
    if ($emailCheck) {
        if (mysqli_num_rows($emailCheck) > 0) {
            redirect('create-admin.php', 'EMAIL IS ALREADY BEEN USED BY ANOTHER ADMIN :>');
        }
    }

    $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);
    $data = [
        'name' => $name,
        'email' => $email,
        'password' => $bcrypt_password,
        'phone' => $phone,
        'is_ban' => $is_ban
    ];

    $result = insert('admins', $data);

    if ($result) {
        redirect('admins.php', 'NEW ADMIN SUCCESSFULLY CREATED! :>');
    } else {
        redirect('create-admin.php', 'SOMETHING WENT WRONG :< :>');
    }
} else if (isset($_POST['updateAdmin'])) {
    $adminId = validate($_POST['adminId']);

    $adminData = getById('admins', $adminId);
    if ($adminData['status'] != 200) {
        redirect('edit-admin.php?id=' . $adminId, 'PLEASE FILL REQUIRED FIELDS :>');
    }

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = isset($_POST['is_ban']) ? 1 : 0;

    $emailCheckQuery = "SELECT * FROM admins WHERE email = '$email' AND id!='$adminId'";
    $checkResult = mysqli_query($conn, $emailCheckQuery);
    if ($checkResult) {
        if (mysqli_num_rows($checkResult) > 0) {
            redirect('edit-admin.php?id=' . $adminId, 'EMAIL IS ALREADY BEEN USED BY ANOTHER ADMIN!');
        }
    }

    if ($name === false || $email === false) {
        redirect('edit-admin.php?id=' . $adminId, 'PLEASE FILL REQUIRED FIELDS :>');
    }

    if ($password != '') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedPassword = $adminData['data']['password'];
    }

    $data = [
        'name' => $name,
        'email' => $email,
        'password' => $hashedPassword,
        'phone' => $phone,
        'is_ban' => $is_ban
    ];

    $result = update('admins', $adminId, $data);

    if ($result) {
        redirect('edit-admin.php?id=' . $adminId, 'ADMIN UPDATED SUCCESSFULLY! :>');
    } else {
        redirect('edit-admin.php?id=' . $adminId, 'SOMETHING WENT WRONG :< :>');
    }
} else if (isset($_POST['saveCategory'])) {
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) ? 1 : 0;

    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status
    ];

    $result = insert('categories', $data);

    if ($result) {
        redirect('categories.php', 'CATEGORY CREATED');
    } else {
        redirect('create-categories.php', 'SOMETHING WENT WRONG');
    }
} else if (isset($_POST['updateCategory'])) {
    $categoryId = validate($_POST['categoryId']);

    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) ? 1 : 0;

    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status
    ];

    $result = update('categories', $categoryId, $data);

    if ($result) {
        redirect('edit-category.php?id=' . $categoryId, 'CATEGORY UPDATED SUCCESSFULLY');
    } else {
        redirect('edit-category.php?id=' . $categoryId, 'SOMETHING WENT WRONG');
    }
} else {
    redirect('create-admin.php', 'SOMETHING WENT WRONG :< :>');
}