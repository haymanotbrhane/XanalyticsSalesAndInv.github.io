<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php

$request = find_all_purchase_request();
$ap_request = find_all_approved_purchase_request();

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
            <li><span>Request</span></li>
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

                <h2 class="card-title">Request List</h2>
            </header>
            <div class="tabs">
                <ul class="nav nav-tabs">
                    <li class="nav-item active">
                        <a class="nav-link" href="#popular" data-toggle="tab" style="color: #000000"> Pending Request</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#recent" data-toggle="tab" style="color: #000000">Approved Request</a>
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
                                    <th>Request Number</th>
                                    <th>Requested Item</th>
                                    <th>Requested Quantity</th>
                                    <th>Approved Quantity</th>
                                    <th>Requested At</th>
                                    <th>Updated By</th>
                                    <th>Approved By</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($request)) {
                                    ?>
                                    <tr>
                                        <td><?php echo "PR-" . substr($row["creation_date"], 0, 4) . "-" . $row["id"]; ?></td>
                                        <td><?php echo find_product_by_id($row["item_id"])["title"]; ?></td>
                                        <td><?php echo number_format($row["quantity"], 2, '.', ',') . " " . find_product_by_id($row["item_id"])["measurment"]; ?></td>
                                        <td><?php echo number_format($row["approved_quantity"], 2, '.', ',') . " " . find_product_by_id($row["item_id"])["measurment"]; ?></td>
                                        <td><?php echo substr($row["creation_date"], 0, 10); ?></td>
                                        <td><?php echo find_user_by_id($row["last_update_by"])["name"]; ?></td>
                                        <td><?php echo ($row["approved_by"] != 0) ? find_user_by_id($row["approved_by"])["name"] : "-"; ?></td>
                                        <td><?php echo ($row["approved_quantity"] == 0) ? '<span style="background: #ffff00;padding: 5px">Pending</span>' : '<span style="background: green;color: white;padding: 5px">Partial</span>'; ?></td>
                                        <td class="actions">
                                            <a href="#" class="on-editing save-row p-1"><i class="fa fa-info"></i></a>
                                            <a href="#" class="hidden on-editing cancel-row p-1"><i
                                                    class="fa fa-times"></i></a>
                                            <a href="editPuRequest.php?id=<?php echo urldecode($row["id"]); ?>"
                                               class="on-default edit-row p-1"><i class="fa fa-pencil"></i></a>
                                            <a href="#" data-toggle="modal" data-target="#myModal1"
                                               onclick="requestCookie('<?php echo $row["id"]; ?>')"
                                               class="on-default remove-row p-1"><i class="fa fa-plus"></i></a>
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
                                    <th>Request Number</th>
                                    <th>Requested Item</th>
                                    <th>Requested Quantity</th>
                                    <th>Approved Quantity</th>
                                    <th>Requested At</th>
                                    <th>Updated By</th>
                                    <th>Approved By</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($ap_request)) {
                                    ?>
                                    <tr>
                                        <td><?php echo "PR-" . substr($row["creation_date"], 0, 4) . "-" . $row["id"]; ?></td>
                                        <td><?php echo find_product_by_id($row["item_id"])["title"]; ?></td>
                                        <td><?php echo number_format($row["quantity"], 2, '.', ',') . " " . find_product_by_id($row["item_id"])["measurment"]; ?></td>
                                        <td><?php echo number_format($row["approved_quantity"], 2, '.', ',') . " " . find_product_by_id($row["item_id"])["measurment"]; ?></td>
                                        <td><?php echo substr($row["creation_date"], 0, 10); ?></td>
                                        <td><?php echo find_user_by_id($row["last_update_by"])["name"]; ?></td>
                                        <td><?php echo ($row["approved_by"] != 0) ? find_user_by_id($row["approved_by"])["name"] : "-"; ?></td>
                                        <td><?php echo ($row["approved_quantity"] != $row["quantity"]) ? '<span style="background: #ffff00;padding: 5px">Pending</span>' : '<span style="background: green;color: white;padding: 5px">Approved</span>'; ?></td>
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

                        <h2 class="card-title">Create Purchase Request</h2>
                    </header>
                    <div class="card-body">
                        <?php
                        echo art_message();
                        $item = find_all_product();
                        ?>
                        <form class="form-horizontal form-bordered" action="#" method="post">

                            <div class="form-group row">
                                <label class="col-lg-3 control-label text-lg-right pt-2">Item</label>

                                <div class="col-lg-8">
                                    <select name="item" id="item" data-plugin-selectTwo
                                            class="form-control populate" style="width: 100%">
                                        <?php
                                        echo "<option value=''>------- Select --------</option>";
                                        while ($row = mysqli_fetch_assoc($item)) {
                                            ?>
                                            <option
                                                value='<?php echo $row["id"]; ?>'><?php echo $row["title"]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 control-label text-lg-right pt-2">Quantity</label>

                                <div class="col-lg-8">
                                    <input type="text" name="quantity" id="quantity" class="form-control"
                                           data-plugin-maxlength
                                           maxlength="100" required/>

                                </div>

                            </div>

                        </form>
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="saveData()">Create Request
                </button>
                <button class="btn btn-default modal-dismiss" data-dismiss="modal">Cancel</button>

            </div>
        </div>
    </div>
</div>

<!-- Modal Approve-->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <section class="card">
                    <header class="card-header">

                        <h2 class="card-title">Approve Purchase Request</h2>
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
    function requestCookie(id) {
        document.cookie = "purchaseRequest=" + id;
        displayApproveRequest();
    }

    function saveData() {

        var item = $('#item').val();
        var quantity = $('#quantity').val();

        $.ajax({
            type: "POST",
            url: "generated/purchase.php",
            data: "item=" + item + "&quantity=" + quantity,
            success: function (response) {
                window.location = "pu_request.php";
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
</script>
</body>

</html>