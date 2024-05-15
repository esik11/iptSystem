<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
       <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">ADMINS</h4>
            <a href="create-admin.php" class="btn btn-primary float-end">ADD ADMIN</a>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                        </tr>
                    </tbody>
            </div>
        </div>
       </div>
  </div>


<?php include('includes/footer.php'); ?>