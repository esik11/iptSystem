<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">ADD A PRODUCT
            <a href="products.php" class="btn btn-primary float-end">BACK</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <form action="code.php" method="POST" enctype ="multipart/form-data">

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>SELECT CATEGORY</label>
                        <select name="category_id" class="form-select">
                            <option value="">Select a Category</option>
                            <?php
                            $categories = getAll('categories');
                            if($categories){
                                    if(mysqli_num_rows($categories) > 0){
                                        foreach($categories as $cateItems){
                                            echo '<option value="'.$cateItems['id'].'">'.$cateItems['name'].'</option>';
                                        }

                                    }else{
                                        echo '<option value="">NO CATEGORY FOUND</option>';
                                    }
                            }else{
                                echo '<option value="">SOMETHIGN WENT WRONG</option>';
                            }
                            ?>

                        </select>

                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="name">ProductName</label>
                        <input type="text" name="name" required class="form-control"/>
                    </div>
                    <div class="col-md-12   mb-3">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="name">Product Price</label>
                        <input type="text" name="price" required class="form-control"/>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="name">Quanntity</label>
                        <input type="text" name="quantity" required class="form-control"/>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="name">Image</label>
                        <input type="file" name="image" class="form-control"/>
                    </div>
                    <div class="col-md-6">
                        <label>Status (Unchecked = Available, Checked = Hidden)</label>
                        <br>
                        <input type="checkbox" name="status" value="1" style="width:30px;height:30px;">
                    </div>
                    <div class="col-md-6 mb-3 text-end">
                        <br>
                        <button type="submit" name="saveProduct" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
