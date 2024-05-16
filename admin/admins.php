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
                        <?php
                        $admins = getAll('admins');
                     
                        if ($admins->num_rows > 0) {
                            while ($adminItem = $admins->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $adminItem['id'] ?></td>
                                    <td><?= $adminItem['name'] ?></td>
                                    <td><?= $adminItem['email'] ?></td>
                                    <td>
                                    <a href="edit-admin.php?id=<?= $adminItem['id']; ?>" class="btn btn-success btn-sm">EDIT ADMIN</a>
                                        <a href="delete-admin.php?id=<?= $adminItem['id']; ?>" class="btn btn-danger btn-sm">DELETE ADMIN</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="4">NO RECORD FOUND</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>