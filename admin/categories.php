<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Item Categories</h4>
            <a href="create-categories.php" class="btn btn-primary float-end">ADD ITEM CATEGORY</a>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $categories = getAll('categories');

                        if ($categories->num_rows > 0) {
                            while ($item = $categories->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $item['id'] ?></td>
                                    <td><?= $item['name'] ?></td>
                                    <td>
                                        <?php
                                            if($item['status'] == 1)
                                            {
                                                echo  '<span class="badge bg-danger">HIDDEN</span>';
                                            }else{
                                                echo  '<span class="badge bg-success">VISIBLE</span>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="edit-category.php?id=<?= $item['id']; ?>" class="btn btn-success btn-sm me-2">EDIT</a>
                                        <a href="delete-category.php?id=<?= $item['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">DELETE</a>
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