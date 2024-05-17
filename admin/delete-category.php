<?php
    require '../config/function.php';

    $paraResultId = checkParamId('id');
    if(is_numeric($paraResultId)){

        $categoryId =  validate($paraResultId);

        $category = getById('categories', $categoryId);
        if($category ['status'] == 200)
        {
            $response = delete('categories', $categoryId);
            if($response)
            {
                redirect('categories.php', 'CATEGORY DELETED SUCCESSFULLY');
            }
            else
            {
                redirect('categories.php', 'Something WENT WRONG');
            }
        }else
        {
            redirect('categories.php', $category ['message']);
        }


    

    }else{
        redirect('categories.php', 'Something WENT WRONG');
    }
 
?>