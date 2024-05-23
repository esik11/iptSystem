<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0"> PRINT ORDER</h4>
            <a href="orders.php" class="btn btn-danger btn-sm float-end">Back</a>

        </div>
        <div class="card-body">
            <?php
            if(isset($_GET['track'])) {
                $trackingNo = validate($_GET['track']);
                if($trackingNo == '') {
            ?>
                    <div class="text-center py-5">
                        <h5>No tracking number found</h5>
                        <a href="orders.php" class="btn btn-primary mt-4 w-25">Go back to orders</a>
                    </div>
            <?php
                    return false;
                } else {
                    $orderQuery = "SELECT o.*, c.* FROM orders o, customers c WHERE c.id=o.customer_id AND tracking_no='$trackingNo' LIMIT 1";
                    $orderQueryRes = mysqli_query($conn, $orderQuery);
                    if(!$orderQueryRes) {
                        echo '<h5>Something went wrong</h5>';
                        return false;
                    }

                    if(mysqli_num_rows($orderQueryRes) > 0) {
                        $orderDataRow = mysqli_fetch_assoc($orderQueryRes);
            ?>
                        <table style="width: 100%; margin-bottom: 20px;">
                            <tbody>
                                <tr>
                                    <td style="text-align: center;" colspan="2">
                                        <h4 style="font-size: 23px; line-height: 30px; margin: 2px; padding: 0;">IPT THRIFT</h4>
                                        <p style="font-size: 16px; line-height: 24px; margin: 2px; padding: 0;">SAMPLE ADDRESS..(RMMC)</p>
                                        <p style="font-size: 16px; line-height: 24px; margin: 2px; padding: 0;">IPT THRIFT (RMMC)</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5 style="font-size: 23px; line-height: 30px; margin: 2px; padding: 0;">Customer Details</h5>
                                        <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Customer Name: <?= $orderDataRow['name'] ?></p>
                                        <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Customer Phone: <?= $orderDataRow['phone'] ?></p>
                                        <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Customer Email: <?= $orderDataRow['email'] ?></p>
                                    </td>
                                    <td align="end">
                                        <h5 style="font-size: 20px; line-height: 30px; margin: 2px; padding: 0;">Invoice Details</h5>
                                        <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Invoice No: <?= $orderDataRow['tracking_no'] ?></p>
                                        <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Invoice Date: <?= date('d M Y') ?></p>
                                        <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Address: RMMC (SAMPLE)</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

            <?php
                    } else {
                        echo '<h5>No data found</h5>';
                        return false;
                    }
                    $orderItemQuery = "SELECT oi.quantity as orderItemQuantity, oi.price as orderItemPrice, o.*, oi.*, p.* FROM orders o, order_items oi, products p WHERE oi.order_id=o.id AND p.id=oi.product_id AND o.tracking_no='$trackingNo' ";

                    $orderItemQueryRes = mysqli_query($conn, $orderItemQuery);
                    if($orderItemQueryRes) {
                        if(mysqli_num_rows($orderItemQueryRes) > 0) {
            ?>
                            <div id="myBillingArea" class="table-responsive mb-3">
                                <table style="width:100%;" cellpadding="5">
                                    <thead>
                                        <tr>
                                            <th style="border-bottom: 1px solid #ccc;" width="5%">ID</th>
                                            <th style="border-bottom: 1px solid #ccc;" width="30%">Product Name</th>
                                            <th style="border-bottom: 1px solid #ccc;" width="20%">Price</th>
                                            <th style="border-bottom: 1px solid #ccc;" width="10%">Quantity</th>
                                            <th style="border-bottom: 1px solid #ccc;" width="20%">Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;

                                        while($row = mysqli_fetch_assoc($orderItemQueryRes)) {
                                        ?>
                                            <tr>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $i++ ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $row['name'] ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= number_format($row['orderItemPrice'], 0) ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $row['orderItemQuantity'] ?></td>
                                                <td style="border-bottom: 1px solid #ccc;" class="fw-bold"><?= number_format($row['orderItemPrice'] * $row['orderItemQuantity'], 0) ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="4" align="end" style="font-weight: bold;">Grand Total</td>
                                            <td style="font-weight: bold;">
                                                <?php
                                                mysqli_data_seek($orderItemQueryRes, 0);
                                                $totalAmount = 0;
                                                while($row = mysqli_fetch_assoc($orderItemQueryRes)) {
                                                    $totalAmount += $row['orderItemPrice'] * $row['orderItemQuantity'];
                                                }
                                                echo number_format($totalAmount, 0);
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">Payment mode: 
                                                <?php
                                                mysqli_data_seek($orderItemQueryRes, 0);
                                                $row = mysqli_fetch_assoc($orderItemQueryRes);
                                                echo $row['payment_mode'];
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                        } else {
                            echo '<h5>Something went wrong!</h5>';
                            return false;
                        }
                    } else {
                        echo '<h5>Something went wrong!</h5>';
                        return false;
                    }
                }
            } else {
            ?>
                <div class="text-center py-5">
                    <h5>No tracking number found</h5>
                    <a href="orders.php" class="btn btn-primary mt-4 w-25">Go back to orders</a>
                </div>
                <div id="myBillingArea"></div>
            <?php
            }
            ?>
            <div class="mt-4 text-end">
                <button class="btn btn-info px-4 mx-1" onclick="printMyBillingArea()">Print</button>
                <button class="btn btn-primary px-4 mx-1" onclick="downloadPDF()">Download PDF</button>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
