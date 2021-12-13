<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$k = 3;
$inv = find_raw_inventory();
$f_inv = find_finish_inventory();
$d_inv = find_damage_inventory();
$inv_order = find_all_received_purchase_order();
$damage_inv = find_damage_inventory_detail();
$purchase_inv = find_purchase_inventory_detail();
$transfer_inv = find_all_inventory_request("transfer");
$transfer_out_inv = find_all_inventory_request("transferOut");

$item = find_all_product();
$item1 = find_all_product();
$warehouse = find_all_branch();
$warehouse1 = find_all_branch();
$warehouse3 = find_all_branch();
$user = find_all_users();
$user1 = find_all_users();
$user2 = find_all_users();

$safe_year = date("Y");
$safe_month = date("m");
$safe_day = date("d");
$dates = $safe_year . "-" . $safe_month . "-" . $safe_day;

if (isset($_POST["transferin"])) {
    $item_id = trim($_POST["item"]);
    $qty = trim($_POST["quantity"]);
    $branch = trim($_POST["warehouse"]);
    $branch1 = trim($_POST["warehouse1"]);
    $transfer = trim($_POST["transferby"]);
    $admin = trim($_SESSION["admin_id"]);
    $type = "transfer";

    if ($branch !== $branch1 && $qty > 0) {
        $category = find_category_by_id(find_product_by_id($item_id)['category'])['category'];

        $inv_qty = find_Inventory_by_Item($item_id, $branch);

        if ($inv_qty >= $qty) {
            $trf = create_transfer($item_id, $type, $qty, $category, $branch, $branch1, $transfer, $admin);
            if ($trf) {
                $inv = create_inventory($item_id, $type, $qty, $category, $branch1, $admin, "");
                if ($inv) {
                    $inv1 = create_inventory($item_id, $type, -($qty), $category, $branch, $admin, "");
                    if ($inv1) {
                        $_SESSION["art_message"] = "Item Transferred.";
                        redirect_to("inv_activity.php");
                    } else
                        $_SESSION["art_error"] = "Item Transfer Failed.";
                } else
                    $_SESSION["art_error"] = "Item Transfer Failed.";
            } else
                $_SESSION["art_error"] = "Item Transfer Failed.";
        } else {
            $_SESSION["art_error"] = "Please check your inventory.";
        }
    } else {
        $_SESSION["art_error"] = "Please fill form correctly.";
    }
}

if (isset($_POST["transferout"])) {
    $item_id = $_POST["item1"];
    $qty = $_POST["quantity1"];
    $branch = $_POST["warehouse3"];
    $remark = $_POST["remark"];
    $transfer = $_POST["transferby1"];
    $admin = $_SESSION["admin_id"];
    $type = "transferOut";

    if ($qty > 0) {
        $category = find_category_by_id(find_product_by_id($item_id)['category'])['category'];

        $inv_qty = find_Inventory_by_Item($item_id, $branch);

        if ($inv_qty >= $qty) {
            $trf = create_transfer_out($item_id, $type, $qty, $category, $branch, $transfer, $admin, $remark);
            if ($trf) {
                $inv = create_inventory_out($item_id, $type, -$qty, $category, $branch, $admin, $remark);
                if ($inv) {
                    $_SESSION["art_message"] = "Item Transferred.";
                    redirect_to("inv_activity.php");
                } else
                    $_SESSION["art_error"] = "Item Transfer Failed.";
            } else {
                $_SESSION["art_error"] = "Item Transfer Failed.";
            }
        } else {
            $_SESSION["art_error"] = "Please check your inventory.";
        }
    } else {
        $_SESSION["art_error"] = "Please fill form correctly.";
    }
}

if (isset($_POST["receiveitem"])) {
    $item_id = $_POST["rec_item"];
    $qty = $_POST["rec_qty"];
    $branch = $_POST["rec_branch"];
    $edate = $_POST["p_date"];
    $admin = $_SESSION["admin_id"];
    $type = "purchase";
  

    if ($qty > 0) {
        $category = find_category_by_id(find_product_by_id($item_id)['category'])['category'];

        $val = create_inventory($item_id, $type, $qty, $category, $branch, $admin, $edate);
        // $val = create_inventory_expiration($item_id, $qty, $edate, $admin, $branch);

        if ($val) {
            $_SESSION["art_message"] = "Item added to stock.";
            redirect_to("inv_activity.php");
        } else
            $_SESSION["art_error"] = "Please try again. ";
    } else {
        $_SESSION["art_error"] = "Please fill form correctly.";
    }
}

if (isset($_POST["damageitem"])) {
    $item_id = $_POST["item_id"];
    $qty = $_POST["damage_quantity"] * -1;
    $branch = $_POST["warehouse_location"];
    $admin = $_SESSION["admin_id"];
    $type = "damage";
    $edate = $_POST["exp_date"];

    if ($qty != 0) {
        $category = find_category_by_id(find_product_by_id($item_id)['category'])['category'];

        $inv_qty = find_Inventory_by_Item_ExpireDate($item_id, $branch, $edate);

        if ($inv_qty >= $qty * -1) {
            $val = create_inventory($item_id, $type, $qty, $category, $branch, $admin, $edate, "");
            if ($val) {
                $_SESSION["art_message"] = "Damage added to stock.";
                redirect_to("inv_activity.php");
            } else
                $_SESSION["art_error"] = "Please try again. ";
        } else
            $_SESSION["art_error"] = "Please check your inventory.";
    } else {
        $_SESSION["art_error"] = "Please fill form correctly.";
    }
}

include_once("header.php")
?>

<section role="main" class="content-body">
<header class="page-header">
    <h2>Inventory</h2>

    <div class="right-wrapper text-right">
        <ol class="breadcrumbs" style="margin-right: 50px;">
            <li>
                <a href="#">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><span>Inventory</span></li>
        </ol>
    </div>
</header>

<!-- start: page -->
<div class="row">
<div class="col">
<section class="card">


<header class="card-header">

    <div class="col-md-12">
        <h2 class="card-title">Stock Activities</h2>
    </div>

</header>

<div class="tabs">

<ul class="nav nav-tabs">

    <li class="nav-item active">
        <a class="nav-link" href="#purchase" data-toggle="tab" style="color: #000000">Received
            Item</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#damage" data-toggle="tab" style="color: #000000">Damaged Item</a>
    </li>
</ul>

<div class="tab-content">

<div id="purchase" class="tab-pane active">
    <div class="card-body pt-0">

        <section class="card" style="box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.15);margin-bottom: 2rem;">

            <div class="card-body pt-0">
                <?php
                echo art_message();
                $item = find_all_product();
                $warehouse = find_all_branch();
                $user = find_all_users();

                ?>
                <form class="form-horizontal form-bordered" action="" method="post">

                    <div class="form-group row">
                        <div class="col-lg-4">
                            <div class="form-group">

                                <label class="control-label text-lg-left pt-2">Item</label>

                                <select name="rec_item" id="rec_item" data-plugin-selectTwo
                                        class="form-control populate" style="width: 100%" autofocus required>
                                    <?php
                                    echo "<option value=''>Select Item</option>";
                                    while ($row = mysqli_fetch_assoc($item)) {

                                        ?>
                                        <option
                                            value='<?php echo $row["id"]; ?>'>
                                            <?php echo $row["code"] . " / " . $row["title"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="control-label text-lg-left pt-2">Quantity</label>

                                <input type="text" name="rec_qty" id="rec_qty" class="form-control"
                                       data-plugin-maxlength maxlength="100" required/>
                            </div>

                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="control-label text-lg-left pt-2">Warehouse</label>

                                <select name="rec_branch" id="rec_branch" data-plugin-selectTwo
                                        class="form-control populate" style="width: 100%" required>
                                    <?php
                                    echo "<option value=''>Select Warehouse</option>";
                                    while ($row = mysqli_fetch_assoc($warehouse)) {

                                        ?>
                                        <option
                                            value='<?php echo $row["id"]; ?>'>
                                            <?php echo $row["title"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="control-label text-lg-right pt-2">Expired Date</label>

                                <div class="input-group">
                                    <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                                    <input type="text" name="p_date" id="p_date" required
                                           class="form-control" value="<?php echo $dates; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="control-label text-lg-left pt-2" style="width: 100%">Save Receive
                                    Item</label>
                                <input name="receiveitem" type="submit" class="btn btn-success" value="Receive Item">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <table class="table table-responsive-lg table-bordered table-striped mb-0"
               id="datatable-tabletools1">
            <thead>
            <tr>
                <th>Date</th>
                <th>Item Code/Title</th>
                <th>Item Category</th>
                <th>Quantity</th>
                <th>Warehouse</th>
                <th>Expired Date</th>
                <th>Created By</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($purchase_inv)) {
                ?>
                <tr>
                    <td><?php echo $row["creation_date"]; ?></td>
                    <td><?php echo find_product_by_id($row["item_id"])["code"] . " / " . find_product_by_id($row["item_id"])["title"]; ?></td>
                    <td><?php echo ($row["category"] == 1) ? "Finished Product" : "Raw Material"; ?></td>
                    <td><?php echo number_format($row["quantity"], 2, '.', ',') . ' ' . find_product_by_id($row["item_id"])["measurment"]; ?></td>
                    <td><?php echo find_branch_by_id($row["warehouse_id"])["title"]; ?></td>
                    <td><?php echo $row["expiered_date"]; ?></td>
                    <td><?php echo find_user_by_id($row["created_by"])["name"]; ?></td>
                    <td class="actions">
                        <a href="#" class="on-editing save-row p-1"><i class="fa fa-info"></i></a>
                        <a href="#" class="hidden on-editing cancel-row p-2"><i
                                class="fa fa-times"></i></a>
                        <a href="editPuRequest.php?id=<?php echo urldecode($row["id"]); ?>"
                           class="hidden on-default edit-row p-1"><i class="fa fa-pencil"></i></a><br/>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>

</div>

<div id="damage" class="tab-pane">
    <div class="card-body pt-0">

        <section class="card" style="box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.15);margin-bottom: 2rem;">

            <div class="card-body pt-0">
                <?php
                echo art_message();
                $item = find_all_product();
                $warehouse = find_all_branch();
                ?>
                <form class="form-horizontal form-bordered" action="" method="post">

                    <div class="form-group row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="control-label text-lg-right pt-2">Item</label>

                                <select name="item_id" id="item_id" data-plugin-selectTwo
                                        class="form-control populate" style="width: 100%" autofocus required>
                                    <?php
                                    echo "<option value=''>Select Item</option>";
                                    while ($row = mysqli_fetch_assoc($item)) {
                                        ?>
                                        <option
                                            value='<?php echo $row["id"]; ?>'><?php echo $row["code"] . "/" . $row["title"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="control-label text-lg-right pt-2">Quantity</label>

                                <input type="text" name="damage_quantity" id="damage_quantity" class="form-control"
                                       data-plugin-maxlength maxlength="100" required/>
                            </div>

                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="control-label text-lg-right pt-2">Warehouse</label>

                                <select name="warehouse_location" id="warehouse_location" data-plugin-selectTwo
                                        class="form-control populate" style="width: 100%" required>
                                    <?php
                                    echo "<option value=''>Select Warehouse</option>";
                                    while ($row = mysqli_fetch_assoc($warehouse)) {
                                        ?>
                                        <option
                                            value='<?php echo $row["id"]; ?>'><?php echo $row["title"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="control-label text-lg-right pt-2">Expire Date</label>

                                <select name="exp_date" id="exp_date" data-plugin-selectTwo
                                        class="form-control populate" style="width: 100%" required>
                                    <?php
                                    echo "<option value=''>Select Expire Date</option>";
                                    
                                       $expire_inv =find_purchase_inventory_ED();
                                    //_item($item);
                                       while ($row1 = mysqli_fetch_assoc($expire_inv)) {
                                        ?>
                                        <option
                                            value="<?php echo $row1["expiered_date"] ?>"><?php echo $row1["expiered_date"]; ?></option>
                                    <?php }?>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="control-label text-lg-left pt-2" style="width: 100%">Save Damage
                                    Item</label>
                                <input name="damageitem" type="submit" class="btn btn-success" value="Record Damage">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </section>

        <table class="table table-responsive-lg table-bordered table-striped mb-0"
               id="datatable-tabletools2">
            <thead>
            <tr>
                <th>Date</th>
                <th>Item Code/Title</th>
                <th>Item Category</th>
                <th>Quantity</th>
                <th>Warehouse</th>
                <th>Expired Date</th>
                <th>Created By</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($damage_inv)) {
                ?>
                <tr>
                    <td><?php echo $row["creation_date"]; ?></td>
                    <td><?php echo find_product_by_id($row["item_id"])["code"] . " / " . find_product_by_id($row["item_id"])["title"]; ?></td>
                    <td><?php echo ($row["category"] == 1) ? "Finished Product" : "Raw Material"; ?></td>
                    <td><?php echo number_format($row["quantity"] * -1, 2, '.', ',') . ' ' . find_product_by_id($row["item_id"])["measurment"]; ?></td>
                    <td><?php echo find_branch_by_id($row["warehouse_id"])["title"]; ?></td>
                    <td><?php echo $row["expiered_date"]; ?></td>
                    <td><?php echo find_user_by_id($row["created_by"])["name"]; ?></td>
                    <td class="actions">
                        <a href="#" class="on-editing save-row p-1"><i class="fa fa-info"></i></a>
                        <a href="#" class="hidden on-editing cancel-row p-2"><i
                                class="fa fa-times"></i></a>
                        <a href="editPuRequest.php?id=<?php echo urldecode($row["id"]); ?>"
                           class="hidden on-default edit-row p-1"><i class="fa fa-pencil"></i></a><br/>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>

</div>

</div>
</div>

</section>
</div>
</div>

</section>

</div>

</section>

<!-- Vendor -->
<script src="vendor/jquery/jquery.js"></script>
<script src="vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
<script src="vendor/jquery-cookie/jquery-cookie.js"></script>
<script src="master/style-switcher/style.switcher.js"></script>
<script src="vendor/popper/umd/popper.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.js"></script>
<script src="vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="vendor/common/common.js"></script>
<script src="vendor/nanoscroller/nanoscroller.js"></script>
<script src="vendor/magnific-popup/jquery.magnific-popup.js"></script>
<script src="vendor/jquery-placeholder/jquery-placeholder.js"></script>

<!-- Specific Page Vendor -->
<script src="vendor/jquery-ui/jquery-ui.js"></script>
<script src="vendor/select2/js/select2.js"></script>
<script src="vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/media/js/dataTables.bootstrap4.min.js"></script>
<script src="vendor/datatables/extras/TableTools/Buttons-1.4.2/js/dataTables.buttons.min.js"></script>
<script src="vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.html5.min.js"></script>
<script src="vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.print.min.js"></script>
<script src="vendor/datatables/extras/TableTools/JSZip-2.5.0/jszip.min.js"></script>
<script src="vendor/datatables/extras/TableTools/pdfmake-0.1.32/pdfmake.min.js"></script>
<script src="vendor/datatables/extras/TableTools/pdfmake-0.1.32/vfs_fonts.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="js/theme.js"></script>

<!-- Theme Custom -->
<script src="js/custom.js"></script>

<!-- Theme Initialization Files -->
<script src="js/theme.init.js"></script>

<script src="js/examples/examples.datatables.default.js"></script>
<script src="js/examples/examples.datatables.row.with.details.js"></script>
<script src="js/examples/examples.datatables.tabletools.js"></script>
<script src="js/examples/examples.advanced.form.js"></script>
<script>

    $(document).ready(function () {
        $("#p_date").datepicker({
            minDate: 0
        });
    });


    function saveTransfer() {

        var item = $('#item').val();
        var quantity = $('#quantity').val();
        var fromL = $('#warehouse').val();
        var toL = $('#warehouse1').val();
        var transfer = $('#transferby').val();

        alert("Transfer in " + item + " " + quantity + " " + fromL + " " + toL + " " + transfer);

        $.ajax({
            type: "POST",
            url: "generated/inventory.php",
            data: "item=" + item + "&quantity=" + quantity + "&froml=" + fromL + "&tol=" + toL + "&transferby=" + transfer,
            success: function (response) {
                window.location = "inv_activity.php";
            }

        });
    }

    function saveTransferOut() {

        var item1 = $('#item1').val();
        var quantity1 = $('#quantity1').val();
        var fromL1 = $('#warehouse3').val();
        var remark1 = $('#remark').val();
        var transfer1 = $('#transferby1').val();

        alert("Transfer out " + item1 + " " + quantity1 + " " + fromL1 + " " + remark1 + " " + transfer1);

        $.ajax({
            type: "POST",
            url: "generated/inventory.php",
            data: "item1=" + item1 + "&quantity1=" + quantity1 + "&froml=" + fromL1 + "&remark=" + remark1 + "&transferby=" + transfer1,
            success: function (response) {
                window.location = "inv_activity.php";
            }

        });
    }

    function saveReceive() {

        var item2 = $('#rec_item').val();
        var quantity2 = $('#rec_qty').val();
        var warehouse2 = $('#rec_branch').val();

        alert("Receive " + item2 + " " + quantity2 + " " + warehouse2);

        $.ajax({
            type: "POST",
            url: "generated/inventory.php",
            data: "rec_item=" + item2 + "&rec_quantity=" + quantity2 + "&rec_branch=" + warehouse2,
            success: function (response) {
                window.location = "inv_activity.php";
            }

        });
    }

    function saveDamage() {

        var item3 = $('#item_id').val();
        var quantity3 = $('#damage_quantity').val();
        var warehouse3 = $('#warehouse_location').val();
        var edate = $('#exp_date').val();

        alert("Damage " + item3 + " " + quantity3 + " " + warehouse3);

        $.ajax({
            type: "POST",
            url: "generated/inventory.php",
            data: "item_id=" + item3 + "&damage_quantity=" + quantity3 + "&warehouse_location=" + warehouse3 + "&exp_date=" + edate,
            success: function (response) {
                window.location = "inv_activity.php";
            }

        });
    }

</script>
</body>

</html>