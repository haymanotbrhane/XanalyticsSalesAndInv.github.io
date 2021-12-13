<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php

$pending = find_pending_productionPlan();
$complete = find_complete_productionPlan();

include_once("header.php")
?>

<section role="main" class="content-body">
<header class="page-header">
    <h2>Production Plan</h2>

    <div class="right-wrapper text-right">
        <ol class="breadcrumbs" style="margin-right: 50px;">
            <li>
                <a href="#">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><span>Production Plan</span></li>
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
                                <a href="addProductionPlan.php">
                                    <button class="btn btn-primary">Add <i class="fa fa-plus"></i>
                                    </button>
                                </a>

                            </div>
                        </div>
                    </div>

                </div>

                <h2 class="card-title">Production Plan List</h2>
            </header>
            <div class="tabs">
                <ul class="nav nav-tabs">
                    <li class="nav-item active">
                        <a class="nav-link" href="#pending" data-toggle="tab" style="color: #000000"> Pending Plan</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#complete" data-toggle="tab" style="color: #000000">Completed Plan</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="pending" class="tab-pane active">
                        <div class="card-body">
                            <?php echo art_message(); ?>

                            <table class="table table-responsive-lg table-bordered table-striped mb-0"
                                   id="datatable-tabletools">
                                <thead>
                                <tr>
                                    <th>Production Date</th>
                                    <th>Line</th>
                                    <th>Shift</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Approved Qty</th>
                                    <th>Created by</th>
                                    <th>Created at</th>
                                    <th>Request Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($pending)) {
                                    ?>
                                    <tr>
                                        <td><?php echo substr($row["production_date"], 0, 10); ?></td>
                                        <td><?php echo find_ProductionLine_by_id($row["line_id"])["title"]; ?></td>
                                        <td><?php echo find_ProductionShift_by_id($row["shift_id"])["title"]; ?></td>
                                        <td><?php echo find_product_by_id($row["item_id"])["code"] . ' / ' . find_product_by_id($row["item_id"])["title"]; ?></td>
                                        <td><?php echo number_format($row["quantity"], 2, '.', ','); ?></td>
                                        <td><?php echo number_format($row["approved_quantity"], 2, '.', ','); ?></td>
                                        <td><?php echo find_user_by_id($row["created_by"])["name"]; ?></td>
                                        <td><?php echo substr($row["creation_date"], 0, 10); ?></td>
                                        <td><?php
                                            echo ($row["request_status"] == 0) ? "<span style='background: #ff0202;padding: 5px 15px;color: white'>Pending</span>" :
                                                (($row["request_status"] == 1) ? "<span style='background: #ffff00;padding: 5px 10px;'>Requested</span>" :
                                                    "<span style='background: green;padding: 5px 10px;color: white'>Realised</span>"); ?></td>

                                        <td class="actions text-center">
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
                                                <a class="dropdown-item"
                                                   onclick="return confirm('Are you sure?');" <?php if ($row["request_status"] != 0) echo "hidden"; ?>
                                                   href="requestProductionPlan.php?id=<?php echo $row["id"] . ''; ?>">
                                                    Request Raw Material</a>
                                                <?php if ($row["request_status"] == 2 && $row["approved_quantity"] > 0) { ?>
                                                    <a class="dropdown-item"
                                                       href="completProductionPlan.php?id=<?php echo $row["id"] . ''; ?>">
                                                        Complete Production
                                                    </a>

                                                    <!--                                                    onclick="productionCookie('--><?php //echo $row["id"]; ?><!--//')"-->
                                                <?php } ?>
                                            </div>

                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div id="complete" class="tab-pane">
                        <div class="card-body">

                            <table class="table table-responsive-lg table-bordered table-striped mb-0"
                                   id="datatable-tabletools1">
                                <thead>
                                <tr>
                                    <th>Production Date</th>
                                    <th>Line</th>
                                    <th>Shift</th>
                                    <th>Item</th>
                                    <th>Approved Qty</th>
                                    <th>Produced Qty</th>
                                    <th>Damaged Qty</th>
                                    <th>Returned Qty</th>
                                    <th>damage /produced</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($complete)) {
                                    ?>
                                    <tr>
                                        <td><?php echo substr($row["production_date"], 0, 10); ?></td>
                                        <td><?php echo find_ProductionLine_by_id($row["line_id"])["title"]; ?></td>
                                        <td><?php echo find_ProductionShift_by_id($row["shift_id"])["title"]; ?></td>
                                        <td><?php echo find_product_by_id($row["item_id"])["title"]; ?></td>
                                        <td><?php echo number_format($row["approved_quantity"], 2, '.', ','); ?></td>
                                        <td><?php echo number_format($row["finished_qty"], 2, '.', ','); ?></td>
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
                                        <td><?php echo ($row["finished_qty"] == 0) ? "0" : number_format($row["damage_qty"] / $row["finished_qty"] * 100, 2, '.', ',') . "%"; ?>
                                        </td>
                                        <td class="actions text-center">
                                            <a href="#" class="on-editing save-row p-1"><i class="fa fa-info"></i></a>
                                            <a href="#" class="hidden on-editing cancel-row p-2"><i
                                                    class="fa fa-times"></i></a>
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
                    <header class="card-header" id="completproduction" style="padding: 0;">

                        <h2 class="card-title">Production Quantity</h2>
                    </header>

                </section>
            </div>
            <footer class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-success" onclick="saveProduction()">Complete Production
                        </button>
                        <button class="btn btn-default modal-dismiss" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </footer>
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

    function productionCookie(id) {
        document.cookie = "ProductionPlaneID=" + id;
        displayBomComponent();
    }

    function displayBomComponent() {

        var bom = "";

        var allcookies = document.cookie;

        // Get all the cookies pairs in an array
        cookiearray = allcookies.split(';');

        // Now take key value pair out of this array
        for (var i = 0; i < cookiearray.length; i++) {
            name = cookiearray[i].split('=')[0].toString().trim();
            value = cookiearray[i].split('=')[1];

            if (name == "ProductionPlaneID") {
                bom = value.toString();
            }

        }

        $.ajax({
            type: "POST",
            url: "generated/production.php",
            data: "productionPlan=" + bom,
            success: function (response) {
                var resp = $.trim(response);
                $("#completproduction").html(resp);
            }

        });
    }


    function saveProduction() {
        var p_id = "";

        var allcookies = document.cookie;

        // Get all the cookies pairs in an array
        cookiearray = allcookies.split(';');

        // Now take key value pair out of this array
        for (var i = 0; i < cookiearray.length; i++) {
            name = cookiearray[i].split('=')[0].toString().trim();
            value = cookiearray[i].split('=')[1];

            if (name == "ProductionPlaneID") {
                p_id = value.toString();
            }
        }

        var finish_qty = $('#pr_qty').val();
        var damege_qty = $('#da_qty').val();
        var return_qty = $('#re_qty').val();

        $.ajax({
            type: "POST",
            url: "generated/production.php",
            data: "production_plan=" + p_id + "&finished_quantity=" + finish_qty + "&damaged_quantity=" + damege_qty + "&returned_quantity=" + return_qty,
            success: function (response) {
                window.location = "productionPlan.php";
            }

        });
    }

</script>
</body>

</html>