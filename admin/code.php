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
    $emailCheck = mysqli_query($conn,"SELECT * FROM admins WHERE email= '$email'");
        if($emailCheck){
            if(mysqli_num_rows($emailCheck)>0){
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
        $result = insert('admins',$data);
        if($result){
            redirect('admins.php', 'NEW ADMIN SUCCESSFULLY CREATED! :>');

        }else{
            redirect('create-admin.php', 'SOMETHING WENT WRONG :< :>');
        }
}else{
    redirect('create-admin.php', 'PLEASE FILL ALL THE FIELDS :>');
}


?>