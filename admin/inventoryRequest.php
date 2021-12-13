<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$k = 3;
$inv_order = find_all_received_purchase_order();
$damage_inv = find_all_inventory_request("damage");
$transfer_inv = find_all_inventory_request("transfer");
$return_inv = find_all_inventory_request("return");
$production = find_requested_productionPlan();
$complete = find_untransfer_productionPlan();

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
    <div class="card-actions col-md-6">

        <div class="row">
            <div class="col-md-12">
                <div class="mb-3 row pull-right" style="width: 70%">

                    <!--                                <button class="btn btn-info col-md-3 mr-2 mb-1" data-toggle="modal"-->
                    <!--                                        data-target="#myModal">-->
                    <!--                                    Return Item-->
                    <!--                                </button>-->
                    <button class="btn btn-info col-md-5 mr-2 mb-1" data-toggle="modal"
                            data-target="#myModal">
                        Transfer Item
                    </button>
                    <button class="btn btn-info col-md-6 mr-2 mb-1" data-toggle="modal"
                            data-target="#myModal1">
                        Damaged Item
                    </button>
                    <!--                                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Finished Goods <i-->
                    <!--                                        class="fa fa-plus"></i>-->
                    <!--                                </button>-->

                </div>
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <h2 class="card-title">Inventory Request</h2>
    </div>
</header>
<div class="tabs">
<ul class="nav nav-tabs">
    <li class="nav-item active">
        <a class="nav-link" href="#p_request" data-toggle="tab" style="color: #000000">Production Request</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#completed_p" data-toggle="tab" style="color: #000000">Completed Production</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#transfer" data-toggle="tab" style="color: #000000">Transfer Request</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#return" data-toggle="tab" style="color: #000000">Return Request</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#damagerequest" data-toggle="tab" style="color: #000000">Damage Request</a>
    </li>
</ul>

<div class="tab-content">

<div id="p_request" class="tab-pane active">
    <div class="card-body">
        <?php echo art_message(); ?>
        <table class="table table-responsive-lg table-bordered table-striped mb-0"
               id="datatable-tabletools1">
            <thead>
            <tr>
                <th>Production Date</th>
                <th>Line / Shift</th>
                <th>Item</th>
                <th>Requested Quantity</th>
                <th>Requested Quantity</th>
                <th>Request Item</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($production)) {
                ?>
                <tr>
                    <td><?php echo substr($row["production_date"], 0, 10); ?></td>
                    <td><?php echo find_ProductionLine_by_id($row["line_id"])["title"] . " / " . find_ProductionShift_by_id($row["shift_id"])["title"]; ?></td>
                    <td><?php echo find_product_by_id($row["item_id"])["title"]; ?></td>
                    <td><?php echo number_format($row["quantity"], 2, '.', ',') . ' ' . find_product_by_id($row["item_id"])["measurment"]; ?></td>
                    <td><a href="#" data-toggle="modal" data-target="#myModal2"
                           onclick="componentCookie('<?php echo $row["item_id"]; ?>','<?php echo $row["id"]; ?>')"
                           style="color: #007bff;font-size: 15px;padding: 10px;">
                            <?php echo 'View Items'; ?></a></td>
                    <td><?php echo find_user_by_id($row["requested_by"])["name"]; ?></td>
                    <td class="actions">
                        <a href="#" class="on-editing save-row p-1"><i class="fa fa-info"></i></a>
                        <a href="#" data-toggle="modal" data-target="#myModal"
                           onclick="requestedCookie('<?php echo $row["id"]; ?>')"
                           style="color: white;padding: 1px 5px;"
                           class="btn btn-success on-default remove-row">Approve</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<div id="completed_p" class="tab-pane">
    <div class="card-body">

        <table class="table table-responsive-lg table-bordered table-striped mb-0"
               id="datatable-tabletools2">
            <thead>
            <tr>
                <th>Production Date</th>
                <th>Line / Shift</th>
                <th>Item</th>
                <th>Approved Qty</th>
                <th>Produced Qty</th>
                <th>Damaged Qty</th>
                <th>Returned Qty</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($complete)) {
                ?>
                <tr>
                    <td><?php echo substr($row["production_date"], 0, 10); ?></td>
                    <td><?php echo find_ProductionLine_by_id($row["line_id"])["title"] . '/' . find_ProductionShift_by_id($row["shift_id"])["title"]; ?></td>
                    <td><?php echo find_product_by_id($row["item_id"])["title"]; ?></td>
                    <td><?php echo number_format($row["approved_quantity"], 2, '.', ',') . ' ' . find_product_by_id($row["item_id"])["measurment"]; ?></td>
                    <td><?php echo number_format($row["finished_qty"], 2, '.', ',') . ' ' . find_product_by_id($row["item_id"])["measurment"]; ?></td>
                    <td><?php
                        $d_qty = array();
                        $d_qty = $row["damage_qty"];
                        $d_qty = str_replace("{", "", $d_qty);
                        $d_qty = str_replace('}', "", $d_qty);
                        $d_qty = str_replace('"', "", $d_qty);

                        $d_qty = explode(',', $d_qty);

                        $damage = "";

                        foreach ($d_qty as $value) {
                            $key = explode(':', $value);
                            $damage .= find_product_by_id($key[0])["title"] . " = " . number_format($key[1], 0, '.', ',') . "</br>";
                        }
                        echo $damage;
                        ?>
                    <td><?php
                        $r_qty = array();
                        $r_qty = $row["return_qty"];
                        $r_qty = str_replace("{", "", $r_qty);
                        $r_qty = str_replace('}', "", $r_qty);
                        $r_qty = str_replace('"', "", $r_qty);

                        $r_qty = explode(',', $r_qty);

                        $return = "";

                        foreach ($r_qty as $value) {
                            $key = explode(':', $value);
                            $return .= find_product_by_id($key[0])["title"] . " = " . number_format($key[1], 0, '.', ',') . "</br>";
                        }
                        echo $return;
                        ?>
                    </td>
                    <td class="actions">
                        <a href="addReceiveProduct.php?id=<?php echo urldecode($row["id"]); ?>"
                           style="color: white;padding: 1px 5px;"
                           class="btn btn-success on-default remove-row">Receiving</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<div id="transfer" class="tab-pane">
    <div class="card-body">

        <table class="table table-responsive-lg table-bordered table-striped mb-0"
               id="datatable-tabletools4">
            <thead>
            <tr>
                <th>Item List</th>
                <th>From Location</th>
                <th>To Location</th>
                <th>Quantity</th>
                <th>Approved Qty</th>
                <th>Requested by</th>
                <th>Requested At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($transfer_inv)) {
                ?>
                <tr>
                    <td><?php echo find_product_by_id($row["item"])["code"] . " / " . find_product_by_id($row["item"])["title"]; ?></td>
                    <td><?php echo find_warehouse_by_id($row["from_location"])["title"]; ?></td>
                    <td><?php echo find_warehouse_by_id($row["to_location"])["title"]; ?></td>
                    <td><?php echo number_format($row["quantity"], 2, '.', ','); ?></td>
                    <td><?php echo number_format($row["approved_quantity"], 2, '.', ','); ?></td>
                    <td><?php echo find_user_by_id($row["req_by"])["name"]; ?></td>
                    <td><?php echo $row["req_at"]; ?></td>
                    <td class="actions">
                        <a href="#" class="on-editing save-row p-1"><i class="fa fa-info"></i></a>
                        <a href="#" class="hidden on-editing cancel-row p-2"><i
                                class="fa fa-times"></i></a>
                        <a href="editPuRequest.php?id=<?php echo urldecode($row["id"]); ?>"
                           class="on-default edit-row p-1"><i class="fa fa-pencil"></i></a>

                        <button tabindex="-1" data-toggle="dropdown"
                                class="btn btn-primary dropdown-toggle" type="button">
                            <span class="caret"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" style="width: 200px">
                            <?php if ($row["quantity"] > $row["approved_quantity"]) { ?>
                                <a href="#" data-toggle="modal" data-target="#myModal1"
                                   onclick="requestApprovalCookie('<?php echo $row["id"]; ?>')"
                                   class="dropdown-item">
                                    Approve Request
                                </a>

                            <?php
                            }
                            if ($row["approved_quantity"] > $row["rec_qty"]) {
                                ?>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#myModal3"
                                   onclick="transferReceivingCookie('<?php echo $row["id"]; ?>')">
                                    Receive Transfer
                                </a>

                            <?php } ?>
                        </div>

                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<div id="return" class="tab-pane">
    <div class="card-body">
        <?php echo art_message(); ?>

        <table class="table table-responsive-lg table-bordered table-striped mb-0"
               id="datatable-tabletools5">

            <thead>
            <tr>
                <th>Plan No</th>
                <th>Item List</th>
                <th>Item Category</th>
                <th>From Location</th>
                <th>To Location</th>
                <th>Quantity</th>
                <th>Requested by</th>
                <th>Requested at</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($return_inv)) {
                ?>
                <tr>
                    <td><?php echo $row["plan_no"]; ?></td>
                    <td><?php echo find_product_by_id($row["item"])["code"] . " / " . find_product_by_id($row["item"])["title"]; ?></td>
                    <td><?php echo find_category_by_id($row["category"])["title"]; ?></td>
                    <td><?php echo find_warehouse_by_id($row["from_location"])["title"]; ?></td>
                    <td><?php echo find_warehouse_by_id($row["to_location"])["title"]; ?></td>
                    <td><?php echo number_format($row["quantity"], 2, '.', ','); ?></td>
                    <td><?php echo find_user_by_id($row["req_by"])["name"]; ?></td>
                    <td><?php echo $row["req_at"]; ?></td>
                    <td class="actions">
                        <a href="#" class="on-editing save-row p-1"><i class="fa fa-info"></i></a>
                        <a href="#" class="hidden on-editing cancel-row p-2"><i
                                class="fa fa-times"></i></a>
                        <a href="editPuRequest.php?id=<?php echo urldecode($row["id"]); ?>"
                           class="on-default edit-row p-1"><i class="fa fa-pencil"></i></a><br/>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<div id="damagerequest" class="tab-pane">
    <div class="card-body">
        <?php echo art_message(); ?>

        <table class="table table-responsive-lg table-bordered table-striped mb-0"
               id="datatable-tabletools6">
            <thead>
            <tr>
                <th>Item List</th>
                <th>Item Category</th>
                <th>Quantity</th>
                <th>Warehouse Location</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($damage_inv)) {
                ?>
                <tr>
                    <td><?php echo find_product_by_id($row["item"])["code"] . " / " . find_product_by_id($row["item"])["title"]; ?></td>
                    <td><?php echo find_category_by_id(find_product_by_id($row["item"])["category"])["title"]; ?></td>
                    <td><?php echo number_format($row["quantity"], 2, '.', ','); ?></td>
                    <td><?php echo find_warehouse_by_id($row["to_location"])["title"]; ?></td>
                    <td class="actions">
                        <a href="#" class="on-editing save-row p-1"><i class="fa fa-info"></i></a>
                        <a href="#" class="hidden on-editing cancel-row p-2"><i
                                class="fa fa-times"></i></a>
                        <a href="editPuRequest.php?id=<?php echo urldecode($row["id"]); ?>"
                           class="on-default edit-row p-1"><i class="fa fa-pencil"></i></a><br/>
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

<!-- Modal Approve Production Material-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <section class="card">
                    <header class="card-header">

                        <h2 class="card-title">Approve Production Material Requested</h2>
                    </header>
                    <div class="card-body" id="approve_qty">
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="saveApproved()">Approve Item</button>
                <button class="btn btn-info" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>

<!-- Modal Production Components-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <section class="card" id="receiveOrder">
                    <header class="card-header">
                        <h2 class="card-title">Production Components List</h2>
                    </header>
                    <div class="card-body">

                        <div></div>

                    </div>
                </section>
            </div>
            <footer class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-default modal-dismiss" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>

<!-- Modal Approve Transfer Request-->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <section class="card">
                    <header class="card-header">

                        <h2 class="card-title">Approve Transfer Request</h2>
                    </header>
                    <div class="card-body" id="approveRequest"></div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="approveRequest()">Approve Request
                </button>
                <button class="btn btn-default modal-dismiss" data-dismiss="modal">Cancel</button>

            </div>
        </div>
    </div>
</div>

<!-- Modal Receive Transfer-->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <section class="card">
                    <header class="card-header">

                        <h2 class="card-title">Receive Transfer Item</h2>
                    </header>
                    <div class="card-body" id="receiveTransfer"></div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="transferReceiving()">Receive Transfer
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
<script>
//production request
function requestedCookie(id) {
    document.cookie = "requestedID=" + id;
    displayApproveQty();
}

//production component or row material
function componentCookie(item, id) {
    document.cookie = "bomComponentID=" + id;
    document.cookie = "proItem=" + item;
    displayBomComponent();
}

//display production row material
function displayBomComponent() {

    var bom = "";
    var item = "";

    var allcookies = document.cookie;

    // Get all the cookies pairs in an array
    cookiearray = allcookies.split(';');

    // Now take key value pair out of this array
    for (var i = 0; i < cookiearray.length; i++) {
        name = cookiearray[i].split('=')[0].toString().trim();
        value = cookiearray[i].split('=')[1];

        if (name == "bomComponentID") {
            bom = value.toString();
        }

        if (name == "proItem") {
            item = value.toString();
        }
    }
    var qty = $('#ap_quantity').val();

    $.ajax({
        type: "POST",
        url: "generated/inventory.php",
        data: "bomId=" + bom + "&proItem=" + item + "&qty=" + qty,
        success: function (response) {
            var resp = $.trim(response);
            $("#receiveOrder").html(resp);
        }

    });
}

//production request approval
function saveApproved() {

    var p_id = "";

    var allcookies = document.cookie;

    // Get all the cookies pairs in an array
    cookiearray = allcookies.split(';');

    // Now take key value pair out of this array
    for (var i = 0; i < cookiearray.length; i++) {
        name = cookiearray[i].split('=')[0].toString().trim();
        value = cookiearray[i].split('=')[1];

        if (name == "requestedID") {
            p_id = value.toString();
        }
    }

    var quantity = $('#ap_quantity').val();

    $.ajax({
        type: "POST",
        url: "generated/inventory.php",
        data: "production_plan_id=" + p_id + "&ap_quantity=" + quantity,
        success: function (response) {
            window.location = "inventoryRequest.php";
        }

    });
}

//display production aproval
function displayApproveQty() {

    var id = "";

    var allcookies = document.cookie;

    // Get all the cookies pairs in an array
    cookiearray = allcookies.split(';');

    // Now take key value pair out of this array
    for (var i = 0; i < cookiearray.length; i++) {
        name = cookiearray[i].split('=')[0].toString().trim();
        value = cookiearray[i].split('=')[1];

        if (name == "requestedID") {
            id = value.toString();
        }
    }

    $.ajax({
        type: "POST",
        url: "generated/inventory.php",
        data: "ApprovedQtyId=" + id,
        success: function (response) {
            var resp = $.trim(response);
            $("#approve_qty").html(resp);
        }

    });
}

//transfer request approval
function requestApprovalCookie(id) {
    document.cookie = "requestApprovalCookie=" + id;
    displayApproveRequest();
}

//display transfer request pop up
function displayApproveRequest() {

    var request = "";

    var allcookies = document.cookie;

    // Get all the cookies pairs in an array
    cookiearray = allcookies.split(';');

    // Now take key value pair out of this array
    for (var i = 0; i < cookiearray.length; i++) {
        name = cookiearray[i].split('=')[0].toString().trim();
        value = cookiearray[i].split('=')[1];

        if (name == "requestApprovalCookie") {
            request = value.toString();
        }
    }

    $.ajax({
        type: "POST",
        url: "generated/inventory.php",
        data: "transferRequestId=" + request,
        success: function (response) {
            var resp = $.trim(response);
            $("#approveRequest").html(resp);
        }

    });
}

//approval transfer request
function approveRequest() {
    var pr_id = "";

    var allcookies = document.cookie;

    // Get all the cookies pairs in an array
    cookiearray = allcookies.split(';');

    // Now take key value pair out of this array
    for (var i = 0; i < cookiearray.length; i++) {
        name = cookiearray[i].split('=')[0].toString().trim();
        value = cookiearray[i].split('=')[1];

        if (name == "requestApprovalCookie") {
            pr_id = value.toString();
        }
    }

    var re_quantity = $('#re_quantity').val();
    var ap_quantity = $('#ap_quantity').val();

    $.ajax({
        type: "POST",
        url: "generated/inventory.php",
        data: "tr_id=" + pr_id + "&re_quantity=" + re_quantity + "&ap_quantity=" + ap_quantity,
        success: function (response) {
            window.location = "inventoryRequest.php";
        }

    });

}

//transfer receiving cookie
function transferReceivingCookie(id) {
    document.cookie = "transferReceiving=" + id;
    displayTransferReceiving();
}

//display transfer receiving pop up
function displayTransferReceiving() {

    var request = "";

    var allcookies = document.cookie;

    // Get all the cookies pairs in an array
    cookiearray = allcookies.split(';');

    // Now take key value pair out of this array
    for (var i = 0; i < cookiearray.length; i++) {
        name = cookiearray[i].split('=')[0].toString().trim();
        value = cookiearray[i].split('=')[1];

        if (name == "transferReceiving") {
            request = value.toString();
        }
    }

    $.ajax({
        type: "POST",
        url: "generated/inventory.php",
        data: "receiveTransferId=" + request,
        success: function (response) {
            var resp = $.trim(response);
            $("#receiveTransfer").html(resp);
        }

    });
}

//transfer receiving
function transferReceiving() {
    var pr_id = "";

    var allcookies = document.cookie;

    // Get all the cookies pairs in an array
    cookiearray = allcookies.split(';');

    // Now take key value pair out of this array
    for (var i = 0; i < cookiearray.length; i++) {
        name = cookiearray[i].split('=')[0].toString().trim();
        value = cookiearray[i].split('=')[1];

        if (name == "transferReceiving") {
            pr_id = value.toString();
        }
    }

    var re_quantity = $('#receive_quantity').val();
    var damage_quantity = $('#damage_quantity').val();

    $.ajax({
        type: "POST",
        url: "generated/inventory.php",
        data: "tr_id=" + pr_id + "&re_quantity=" + re_quantity + "&damage_quantity=" + damage_quantity,
        success: function (response) {
            window.location = "inventoryRequest.php";
        }

    });

}

</script>
</body>

</html>