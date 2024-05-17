<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">ADD A CATEGORY
            <a href="categories.php" class="btn btn-primary float-end">BACK</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <form action="saveCategory.php" method="POST">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" required class="form-control"/>
                    </div>
                    <div class="col-md-12   mb-3">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label>Status (Unchecked = Available, Checked = Hidden)</label>
                        <br>
                        <input type="checkbox" name="status" value="1" style="width:30px;height:30px;">
                    </div>
                    <div class="col-md-6 mb-3 text-end">
                        <br>
                        <button type="submit" name="saveCategory" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
