<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php

$order = find_all_purchase_order();
$inv_order = find_all_received_purchase_order();

include_once("header.php")
?>

<section role="main" class="content-body">
<header class="page-header">
    <h2>Purchase</h2>

    <div class="right-wrapper text-right">
        <ol class="breadcrumbs" style="margin-right: 50px;">
            <li>
                <a href="#">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><span>Order</span></li>
        </ol>
    </div>
</header>

<!-- start: page -->
<div class="row">
    <div class="col">
        <section class="card">
            <header class="card-header">
                <div class="card-actions">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">

                                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add <i
                                        class="fa fa-plus"></i>
                                </button>

                            </div>
                        </div>
                    </div>

                </div>

                <h2 class="card-title">Order List</h2>
            </header>
            <div class="tabs">
                <ul class="nav nav-tabs">
                    <li class="nav-item active">
                        <a class="nav-link" href="#popular" data-toggle="tab" style="color: #000000"> Pending Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#recent" data-toggle="tab" style="color: #000000">Received Order</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="popular" class="tab-pane active">
                        <div class="card-body">
                            <?php echo art_message(); ?>

                            <table class="table table-responsive-lg table-bordered table-striped mb-0"
                                   id="datatable-tabletools">
                                <thead>
                                <tr>
                                    <th>Ord_No</th>
                                    <th>Req_No</th>
                                    <th>Order_Item</th>
                                    <th>Ord_Quantity</th>
                                    <th>Rec_Quantity</th>
                                    <!--                                    <th>Inv_Quantity</th>-->
                                    <th>Sche_Date</th>
                                    <th>Warehouse</th>
                                    <th>Ord_By</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($order)) {
                                    ?>
                                    <tr>
                                        <td><?php echo "PO-" . substr($row["creation_date"], 0, 4) . "-" . $row["id"]; ?></td>
                                        <td><?php echo "PR-" . substr(find_purchase_request_by_id($row["pu_request_id"])["creation_date"], 0, 4) . "-" . $row["pu_request_id"]; ?></td>
                                        <td><?php echo find_product_by_id(find_purchase_request_by_id($row["pu_request_id"])["item_id"])["title"]; ?></td>
                                        <td><?php echo number_format($row["quantity"], 2, '.', ','); ?></td>
                                        <td><?php echo number_format($row["received_qty"], 2, '.', ','); ?></td>
                                        <!--                                        <td>-->
                                        <?php //echo number_format($row["invoced_qty"], 2, '.', ','); ?><!--</td>-->
                                        <td><?php echo substr($row["scheduled_date"], 0, 10); ?></td>
                                        <td><?php echo find_warehouse_by_id($row["warehouse_id"])["title"]; ?></td>
                                        <td><?php echo find_user_by_id($row["last_update_by"])["name"]; ?></td>
                                        <td><?php echo ($row["received_qty"] == 0) ? '<span style="background: #ffff00;padding: 5px">Pending</span>' : '<span style="background: green;color: white;padding: 5px">Partial</span>'; ?></td>
                                        <td class="actions text-center">
                                            <a href="#" class="on-editing save-row p-1"><i class="fa fa-info"></i></a>
                                            <a href="#" class="hidden on-editing cancel-row p-2"><i
                                                    class="fa fa-times"></i></a>
                                            <a href="editPuRequest.php?id=<?php echo urldecode($row["id"]); ?>"
                                               class="on-default edit-row p-1"><i class="fa fa-pencil"></i></a><br/>
                                            <a href="#" data-toggle="modal" data-target="#myModal1"
                                               onclick="orderCookie('<?php echo $row["id"]; ?>')"
                                               style="color: white;padding: 1px 5px;"
                                               class="btn btn-success on-default remove-row <?php echo (($row["quantity"] - $row["received_qty"]) == 0) ? 'disabled' : ""; ?>">
                                                Received</a><br/>
                                            <a href="#" data-toggle="modal" data-target="#myModal2"
                                               onclick="invoiceCookie('<?php echo $row["id"]; ?>')"
                                               style="color: white;padding: 1px 7px;"
                                               class="hidden btn btn-success on-default remove-row m-1 <?php echo (($row["received_qty"] - $row["invoced_qty"]) == 0) ? 'disabled' : ""; ?>">Invoiced</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div id="recent" class="tab-pane">
                        <div class="card-body">
                            <div class="dt-buttons mb-2 pb-1 text-right"></div>
                            <div class="dt-buttons mb-2 pb-1 text-right"></div>
                            <div class="dt-buttons mb-2 pb-1 text-right"></div>

                            <table class="table table-responsive-lg table-bordered table-striped mb-0"
                                   id="datatable-tabletools1">
                                <thead>
                                <tr>
                                    <th>Ord_No</th>
                                    <th>Req_No</th>
                                    <th>Order_Item</th>
                                    <th>Ord_Quantity</th>
                                    <th>Rec_Quantity</th>
                                    <!--                                    <th>Inv_Quantity</th>-->
                                    <th>Sche_Date</th>
                                    <th>Warehouse</th>
                                    <th>Ord_By</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($inv_order)) {
                                    ?>
                                    <tr>
                                        <td><?php echo "PO-" . substr($row["creation_date"], 0, 4) . "-" . $row["id"]; ?></td>
                                        <td><?php echo "PR-" . substr(find_purchase_request_by_id($row["pu_request_id"])["creation_date"], 0, 4) . "-" . $row["pu_request_id"]; ?></td>
                                        <td><?php echo find_product_by_id(find_purchase_request_by_id($row["pu_request_id"])["item_id"])["title"]; ?></td>
                                        <td><?php echo number_format($row["quantity"], 2, '.', ','); ?></td>
                                        <td><?php echo number_format($row["received_qty"], 2, '.', ','); ?></td>
                                        <!--                                        <td>-->
                                        <?php //echo number_format($row["invoced_qty"], 2, '.', ','); ?><!--</td>-->
                                        <td><?php echo substr($row["scheduled_date"], 0, 10); ?></td>
                                        <td><?php echo find_warehouse_by_id($row["warehouse_id"])["title"]; ?></td>
                                        <td><?php echo find_user_by_id($row["last_update_by"])["name"]; ?></td>
                                        <td><?php echo ($row["received_qty"] != $row["quantity"]) ? '<span style="background: #ffff00;padding: 5px">Pending</span>' : '<span style="background: green;color: white;padding: 5px">Received</span>'; ?></td>
                                        <td class="actions">
                                            <a href="#" class="on-editing save-row p-1"><i class="fa fa-info"></i></a>
                                            <a href="#" class="hidden on-editing cancel-row p-1"><i
                                                    class="fa fa-times"></i></a>
                                            <a href="editPuRequest.php?id=<?php echo urldecode($row["id"]); ?>"
                                               class="hidden on-default edit-row p-1"><i class="fa fa-pencil"></i></a>
                                            <a href="#" data-toggle="modal" data-target="#myModal1"
                                               onclick="requestCookie('<?php echo $row["id"]; ?>')"
                                               class="hidden on-default remove-row p-1"><i class="fa fa-plus"></i></a>
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

<!-- Modal Create-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <section class="card">
                    <header class="card-header">

                        <h2 class="card-title">Create Purchase Order</h2>
                    </header>
                    <div class="card-body">
                        <?php
                        echo art_message();
                        $pu_request = find_purchase_request_by_qty();
                        $category = find_category_category("Customers");
                        $vendor = find_all_customer();
                        $warehouse = find_all_warehouse();
                        ?>
                        <form class="form-horizontal form-bordered" action="#" method="post">

                            <div class="form-group row">
                                <label class="col-lg-4 control-label text-lg-right pt-2">Requested Number</label>

                                <div class="col-lg-8">
                                    <select name="pu_request" id="pu_request" data-plugin-selectTwo
                                            class="form-control populate" style="width: 100%">
                                        <?php
                                        echo "<option value=''>------- Select --------</option>";
                                        while ($row = mysqli_fetch_assoc($pu_request)) {
                                            ?>
                                            <option
                                                value='<?php echo $row["id"]; ?>'><?php echo "PR-" . substr($row["creation_date"], 0, 4) . "-" . $row["id"]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" id="po_quantity">

                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 control-label text-lg-right pt-2">Item Unit Price</label>

                                <div class="col-lg-8">
                                    <input type="text" name="unit_price" id="unit_price" class="form-control"
                                           data-plugin-maxlength
                                           maxlength="100" required/>

                                </div>

                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 control-label text-lg-right pt-2">Warehouse Location</label>

                                <div class="col-lg-8">
                                    <select name="warehouse" id="warehouse" data-plugin-selectTwo
                                            class="form-control populate" style="width: 100%">
                                        <?php
                                        echo "<option value=''>------- Select --------</option>";
                                        while ($row = mysqli_fetch_assoc($warehouse)) {
                                            ?>
                                            <option
                                                value='<?php echo $row["id"]; ?>'><?php echo $row["title"]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 control-label text-lg-right pt-2">Customer Category</label>

                                <div class="col-lg-8">
                                    <select name="customer_category" id="customer_category" data-plugin-selectTwo
                                            class="form-control populate" style="width: 100%">
                                        <?php
                                        echo "<option value=''>------- Select --------</option>";
                                        while ($row = mysqli_fetch_assoc($category)) {
                                            ?>
                                            <option
                                                value='<?php echo $row["id"]; ?>'><?php echo $row["title"]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" id="vendor">
                                <label class="col-lg-4 control-label text-lg-right pt-2">Customer Name</label>

                                <div class="col-lg-8">
                                    <select name="customer_name" id="customer_name" data-plugin-selectTwo
                                            class="form-control populate" style="width: 100%">
                                        <option value=''>------- Select --------</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 control-label text-lg-right pt-2">Scheduled Date</label>

                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" name="s_date" id="s_date" data-plugin-datepicker
                                               class="form-control">
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>
                </section>
            </div>
            <footer class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-success" onclick="saveData()">Create Order
                        </button>
                        <button class="btn btn-default modal-dismiss" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>

<!-- Modal Receive-->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <section class="card">
                    <header class="card-header">

                        <h2 class="card-title">Receive Ordered Item</h2>
                    </header>
                    <div class="card-body" id="receiveOrder"></div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="receiveOrder()">Receive Order
                </button>
                <button class="btn btn-default modal-dismiss" data-dismiss="modal">Cancel</button>

            </div>
        </div>
    </div>
</div>

<!-- Modal Invoice-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <section class="card">
                    <header class="card-header">

                        <h2 class="card-title">Invoice Ordered Item</h2>
                    </header>
                    <div class="card-body" id="invoiceOrder"></div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="invoiceOrder()">Invoice Order
                </button>
                <button class="btn btn-default modal-dismiss" data-dismiss="modal">Cancel</button>

            </div>
        </div>
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
<!--<script src="js/examples/examples.modals.js"></script>-->
<script>

function orderCookie(id) {
    document.cookie = "purchaseOrder=" + id;
    displayReceiveOrder();
}

function invoiceCookie(id) {
    document.cookie = "purchaseInvoice=" + id;
    displayInvoiceOrder();
}

$(document).ready(function () {
    $("#pu_request").change(function () {
        var pu_request = $(this).val();


        $.ajax({
            url: "generated/purchase.php",
            data: {pu_request: pu_request},
            type: 'POST',
            success: function (response) {
                var resp = $.trim(response);
                $("#po_quantity").html(resp);

            }
        });
    });
});

$(document).ready(function () {
    $("#customer_category").change(function () {
        var category = $(this).val();


        $.ajax({
            url: "generated/purchase.php",
            data: {customer_category: category},
            type: 'POST',
            success: function (response) {
                var resp = $.trim(response);
                $("#customer_name").html(resp);

            }
        });
    });
});

function saveData() {

    var pu_request = $('#pu_request').val();
    var quantity = $('#quantity').val();
    var vendor = $('#customer_name').val();
    var s_date = $('#s_date').val();
    var unit_price = $('#unit_price').val();
    var warehouse = $('#warehouse').val();


    $.ajax({
        type: "POST",
        url: "generated/purchase.php",
        data: "purchase_request=" + pu_request + "&order_quantity=" + quantity + "&vendor=" + vendor + "&s_date=" + s_date + "&warehouse=" + warehouse + "&unit_price=" + unit_price,
        success: function (response) {
            window.location = "pu_order.php";
        }

    });
}

function displayApproveRequest() {

    var request = "";

    var allcookies = document.cookie;

    // Get all the cookies pairs in an array
    cookiearray = allcookies.split(';');

    // Now take key value pair out of this array
    for (var i = 0; i < cookiearray.length; i++) {
        name = cookiearray[i].split('=')[0].toString().trim();
        value = cookiearray[i].split('=')[1];

        if (name == "purchaseRequest") {
            request = value.toString();
        }
    }

    $.ajax({
        type: "POST",
        url: "generated/purchase.php",
        data: "purchaseRequestId=" + request,
        success: function (response) {
            var resp = $.trim(response);
            $("#approveRequest").html(resp);
        }

    });
}

function displayReceiveOrder() {

    var order = "";

    var allcookies = document.cookie;

    // Get all the cookies pairs in an array
    cookiearray = allcookies.split(';');

    // Now take key value pair out of this array
    for (var i = 0; i < cookiearray.length; i++) {
        name = cookiearray[i].split('=')[0].toString().trim();
        value = cookiearray[i].split('=')[1];

        if (name == "purchaseOrder") {
            order = value.toString();
        }
    }

    $.ajax({
        type: "POST",
        url: "generated/purchase.php",
        data: "purchaseOrderId=" + order,
        success: function (response) {
            var resp = $.trim(response);
            $("#receiveOrder").html(resp);
        }

    });
}

function displayInvoiceOrder() {

    var order = "";

    var allcookies = document.cookie;

    // Get all the cookies pairs in an array
    cookiearray = allcookies.split(';');

    // Now take key value pair out of this array
    for (var i = 0; i < cookiearray.length; i++) {
        name = cookiearray[i].split('=')[0].toString().trim();
        value = cookiearray[i].split('=')[1];

        if (name == "purchaseInvoice") {
            order = value.toString();
        }
    }

    $.ajax({
        type: "POST",
        url: "generated/purchase.php",
        data: "purchaseInvoiceId=" + order,
        success: function (response) {
            var resp = $.trim(response);
            $("#invoiceOrder").html(resp);
        }

    });
}

function approveRequest() {
    var pr_id = "";

    var allcookies = document.cookie;

    // Get all the cookies pairs in an array
    cookiearray = allcookies.split(';');

    // Now take key value pair out of this array
    for (var i = 0; i < cookiearray.length; i++) {
        name = cookiearray[i].split('=')[0].toString().trim();
        value = cookiearray[i].split('=')[1];

        if (name == "purchaseRequest") {
            pr_id = value.toString();
        }
    }

    var re_quantity = $('#re_quantity').val();
    var ap_quantity = $('#ap_quantity').val();

    $.ajax({
        type: "POST",
        url: "generated/purchase.php",
        data: "pr_id=" + pr_id + "&re_quantity=" + re_quantity + "&ap_quantity=" + ap_quantity,
        success: function (response) {
            window.location = "pu_request.php";
        }

    });

}

function receiveOrder() {
    var po_id = "";

    var allcookies = document.cookie;

    // Get all the cookies pairs in an array
    cookiearray = allcookies.split(';');

    // Now take key value pair out of this array
    for (var i = 0; i < cookiearray.length; i++) {
        name = cookiearray[i].split('=')[0].toString().trim();
        value = cookiearray[i].split('=')[1];

        if (name == "purchaseOrder") {
            po_id = value.toString();
        }
    }

    var re_quantity = $('#receive_quantity').val();

    $.ajax({
        type: "POST",
        url: "generated/purchase.php",
        data: "por_id=" + po_id + "&receive_quantity=" + re_quantity,
        success: function (response) {
            window.location = "pu_order.php";
        }

    });

}

function invoiceOrder() {
    var pr_id = "";

    var allcookies = document.cookie;

    // Get all the cookies pairs in an array
    cookiearray = allcookies.split(';');

    // Now take key value pair out of this array
    for (var i = 0; i < cookiearray.length; i++) {
        name = cookiearray[i].split('=')[0].toString().trim();
        value = cookiearray[i].split('=')[1];

        if (name == "purchaseInvoice") {
            pr_id = value.toString();
        }
    }

    var inv_quantity = $('#invoiced_quantity').val();

    $.ajax({
        type: "POST",
        url: "generated/purchase.php",
        data: "poi_id=" + pr_id + "&invoice_quantity=" + inv_quantity,
        success: function (response) {
            window.location = "pu_order.php";
        }

    });

}

</script>
</body>

</html>