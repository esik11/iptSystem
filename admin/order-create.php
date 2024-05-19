<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">CREATE AN ORDER
                <a href="" class="btn btn-primary float-end">BACK</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <form action="orders-code.php" method="POST">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="name"> Select Products</label>
                        <select name="product_id" class="form-select mySelect2">
                            <option value="">==Select Product==</option>
                            <?php
                            $products = getAll('products');
                            if ($products) {
                                if (mysqli_num_rows($products) > 0) {
                                    foreach ($products as $productItem) {
                                        ?>
                                        <option value="<?= $productItem['id']; ?>"><?= $productItem['name']; ?></option>
                                        <?php
                                    }
                                } else {
                                    echo '<option value="">NO PRODUCT FOUND</option>';
                                }
                            } else {
                                echo '<option value="">SOMETHING WENT WRONG</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="">Quantity</label>
                        <input type="number" name="quantity" value="1" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3 text-end">
                        <br>
                        <button type="submit" name="addItem" class="btn btn-primary">Add Item</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="card mt-3">
    <div class="card-header">
        <h4 class="mb-0">Products</h4>
    </div>
    <div class="card-body" id="productArea">
        <?php
        if (isset($_SESSION['productItems'])) {
            $sessionProducts = $_SESSION['productItems'];
            ?>
            <div class="table-responsive mb-3" id ="productContent">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>PRODUCT NAME</th>
                            <th>PRICE</th>
                            <th>QUANTITY</th>
                            <th>TOTAL PRICE</th>
                            <th>REMOVE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        foreach ($sessionProducts as $key => $item) :
                        ?>
                        <tr>
                            <td> <?= $i++; ?></td>
                            <td> <?= $item['name']; ?></td>
                            <td> <?= $item['price']; ?></td>
                            <td>
                                <div class="input-group qtyBox">
                                    <input type="hidden" value="<?= $item['product_id']; ?>" class="prodId"/>
                                    <button class="input-group-text decrement">-</button>
                                    <input type="text" value="<?= $item['quantity']; ?>" class="qty quantityInput">
                                    <button class="input-group-text increment">+</button>
                                </div>
                            </td>
                            <td> <?= number_format($item['price'] * $item['quantity'], 0); ?></td>
                            <td>
                                <a href="order-item-delete.php?index=<?= $key; ?>" class="btn btn-danger">REMOVE</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php
        } else {
            echo '<h5>NO ITEMS/PRODUCTS ADDED</h5>';
        }
        ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>
