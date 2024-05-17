<?php include ('includes/header.php'); 

if(isset($_SESSION['loggedIn'])){
    ?>
    <script>window.location/.href = 'index.php'</script>
    <?php

}

?>


<div class="py-5 bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow rounded-4">
                </div>             
                <?php alertMessage(); ?>
                <div class="p-5">
                    <h4 class ="text-dark mb-3">Sign in your Cashiering System</h4>
                    <form action="login-code.php" method= "POST">

                    <div class="mb3">
                        <label>ENTER EMAIL</label>
                        <input type="email" name= "email" class="form-control" required>
                    </div>
                    <div class="mb3">
                        <label>ENTER PASSWORD</label>
                        <input type="password" name= "password" class="form-control" required>
                    </div>
                    <div class = "my-3">
                         <button type="submit" name= "loginBtn" class ="btn btn-primary w-100 mt-2">
                                SIGN IN
                         </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 
 
    <?php include ('includes/footer.php');