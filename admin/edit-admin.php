<?php include('includes/header.php'); ?>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">EDIT ADMINS</h4>
            <a href="admins.php" class="btn btn-danger float-end">BACK</a>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <form action="code.php" method="POST">

                    <?php
                        if(isset($_GET['id']))
                        {
                                if($_GET['id'] != ''){

                                    $adminId= $_GET['id'];

                                }else{
                                    echo '<h5>NO ID FOUND</h5>';
                                    return false;
                                }
                        }
                        else{
                            echo '<h5>NO ID IN PARAMETER</h5>';
                                    return false;
                        }
                            $adminsData = getById('admins', $adminId);
                            if($adminsData)
                            {
                                    if($adminsData['status'] == 200)
                                    {
                                            ?>
                             <input type="hidden" name ="adminId" value="<?=validate($adminsData['data']['id'], false); ?>">
                             <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" required value="<?=$adminsData['data']['name'];?>" class="form-control"/>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" required  value="<?=$adminsData['data']['email'];?>" class="form-control"/>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control"/>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone">Phone</label>
                        <input type="number" name="phone" required  value="<?=$adminsData['data']['phone'];?>" class="form-control"/>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="is_ban">IS BAN</label>
                        <br>
                        <input type="checkbox" name="is_ban" <?= $adminsData['data']['is_ban'] == true ? 'checked' :''; ?> style="width:30px;height:30px;"/>
                    </div>
                    <div class="col-md-12 mb-3 text-end">
                        <button type="submit" name="updateAdmin" class="btn btn-primary">UPDATE ADMIN</button>
                    </div>
                </div>
           <?php
                                   }
                                    else
                                    {
                                      echo '<h5>'.$adminsData['message'].'</h5>';
                                    }
                            }
                            else
                            {
                                echo '<h5>Something Went wrong</h5>';
                                return false;
                            }


                    ?>


               
            </form>
        </div>
    </div>

<?php include('includes/footer.php'); ?>