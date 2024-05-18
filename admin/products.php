<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">PRODUCTS</h4>
            <a href="create-products.php" class="btn btn-primary float-end">ADD PRODUCT</a>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>IMAGE</th>
                            <th>NAME</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $products = getAll('products');

                        if ($products->num_rows > 0) {
                            while ($item = $products->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $item['id'] ?></td>
                                    <td>
                                        <img src= "../<?= $item['image'];?>" style= "width:50px;height:50px;" alt="Img"</td>
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
                                    <a href="products-edit.php?id=<?= $item['id'];?>" class="btn btn-success btn-sm me-2">EDIT</a>
                                        <a href="delete-products.php?id=<?= $item['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">DELETE</a>
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