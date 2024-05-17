<?php
require '../config/function.php';
?>



<?php

if(isset($_POST['saveCategory']))
{
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1:0;

    $data= [
        'name' => $name,
        'description' => $description,
        'status' => $status
    ];
    $result = insert('categories', $data);

    if($result){
        redirect('categories.php','CATEGORY  CREATED');
    }else{
        redirect('create-categories.php','SOMETHING WENT WRONG');
    }
}
?>