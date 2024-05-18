<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">EDIT PRODUCT
            <a href="products.php" class="btn btn-primary float-end">BACK</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <?php
            $paramValue = checkParamId('id');
            if (!is_numeric($paramValue)) {
                echo '<h5>' . $paramValue . '</h5>';
                return false;
            }

            $product = getById('products', $paramValue);
            if ($product['status'] == 200) {
                $productData = $product['data'];
            ?>

            <form action="code.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?= $productData['id']; ?>">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>SELECT CATEGORY</label>
                        <select name="category_id" class="form-select">
                            <option value="">Select a Category</option>
                            <?php
                            $categories = getAll('categories');
                            if ($categories) {
                                if (mysqli_num_rows($categories) > 0) {
                                    foreach ($categories as $cateItems) {
                                        $selected = $cateItems['id'] == $productData['category_id'] ? 'selected' : '';
                                        echo '<option value="' . $cateItems['id'] . '"' . $selected . '>' . $cateItems['name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">NO CATEGORY FOUND</option>';
                                }
                            } else {
                                echo '<option value="">SOMETHING WENT WRONG</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="name">Product Name</label>
                        <input type="text" name="name" required value="<?= $productData['name']; ?>" class="form-control"/>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" required><?= $productData['description']; ?></textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="price">Price</label>
                        <input type="number" name="price" required value="<?= $productData['price']; ?>" class="form-control"/>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" required value="<?= $productData['quantity']; ?>" class="form-control"/>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="image">Image</label>
                        <input type="file" name="image" class="form-control"/>
                        <img src="../<?= $productData['image']; ?>" alt="Img" width="300">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status (Unchecked = Available, Checked = Hidden)</label>
                        <br>
                        <input type="checkbox" name="status" <?= $productData['status'] ? 'checked' : ''; ?> style="width:30px;height:30px;">
                    </div>
                    <div class="col-md-6 mb-3 text-end">
                        <br>
                        <button type="submit" name="updateProduct" class="btn btn-primary">UPDATE</button>
                    </div>
                </div>
            </form>

            <?php
            } else {
                echo '<h5>' . $product['message'] . '</h5>';
            }
            ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
