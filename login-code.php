<?php
require 'config/function.php';

if(isset($_POST['loginBtn']))
{
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    if($email != '' && $password != '')
    {
        $query = " SELECT * FROM admins WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($conn,$query);
        if($result){
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_assoc($result);
                $hashedPassword = $row['password'];

                if(password_verify($password,$hashedPassword)){
                    if($row ['is_ban'] == 1){
                        redirect ('login.php', 'ACCOUNT HAS BEEN BANNED!');
                    } else {
                        $_SESSION ['loggedIn'] = true;
                        $_SESSION ['loggedInUser'] = [
                            'user_id' => $row['id'],
                            'name' => $row['name'],
                            'email' => $row['email'],
                            'phone' => $row['phone'],
                        ];
                        redirect('admin/index.php', 'LOGIN SUCCESSFULL!');
                    }
                } else {
                    redirect('login.php', 'INVALID PASSWORD');
                }
            } else {
                redirect('login.php', 'INVALID EMAIL');
            }
        } else {
            redirect('login.php', 'SOMETHING WENT WRONG!');
        }
    } else {
        redirect('login.php', 'ALL FIELDS ARE REQUIRED!');
    }
}
?>