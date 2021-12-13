<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$k = 3;
$j = 1;
$inv = find_raw_inventory();

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

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <h2 class="card-title">Raw Material Inventory</h2>
                    </div>
                </header>

                <div class="card-body">
                    <?php echo art_message(); ?>

                    <table class="table table-responsive-lg table-bordered table-striped mb-0"
                           id="datatable-tabletools">
                        <thead>
                        <tr>
                            <th>Item Code/Title</th>
                            <th>Warehouse</th>
                            <th>Stock</th>
                            <th>Min Stock</th>
                            <th>Stock Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($inv)) {
                            ?>
                            <tr>
                                <td><?php echo find_product_by_id($row["item_id"])["code"] . " / " . find_product_by_id($row["item_id"])["title"]; ?></td>
                                <td><?php echo find_branch_by_id($row["warehouse_id"])["title"]; ?></td>
                                <td><?php echo number_format($row["quantity"], 2, '.', ',') . ' ' . find_product_by_id($row["item_id"])["measurment"]; ?></td>
                                <td><?php echo number_format(find_product_by_id($row["item_id"])["min_stock"], 2, '.', ',') . ' ' . find_product_by_id($row["item_id"])["measurment"]; ?></td>
                                <td>
                                    <?php echo ($row["quantity"] > find_product_by_id($row["item_id"])["min_stock"]) ? "" : "<span style='border-radius: 5px; background: red;padding: 5px 10px;color: white;'>Less Stock</span>"; ?>
                                </td>

                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
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

<script>
    $(document).ready(function () {
        $('#datatable-tabletools').DataTable({
            dom: 'Bfrtip',
            "displayLength": 25,
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>

<script src="js/examples/examples.datatables.default.js"></script>
<script src="js/examples/examples.datatables.row.with.details.js"></script>
<script src="js/examples/examples.datatables.tabletools.js"></script>
<script>

    function saveTransfer() {

        var item = $('#item').val();
        var quantity = $('#quantity').val();
        var fromL = $('#warehouse').val();
        var toL = $('#warehouse1').val();
        var plate = $('#plate').val();
        var driver = $('#driver').val();
        var mobile = $('#mobile').val();


        $.ajax({
            type: "POST",
            url: "generated/inventory.php",
            data: "item=" + item + "&quantity=" + quantity + "&froml=" + fromL + "&tol=" + toL + "&plate=" + plate + "&driver=" + driver + "&mobile=" + mobile,
            success: function (response) {
                window.location = "inventory.php";
            }

        });
    }

    function saveDamage() {

        var item = $('#item_id').val();
        var quantity = $('#damage_quantity').val();
        var warehouse = $('#warehouse_location').val();


        $.ajax({
            type: "POST",
            url: "generated/inventory.php",
            data: "item_id=" + item + "&damage_quantity=" + quantity + "&warehouse_location=" + warehouse,
            success: function (response) {
                window.location = "inventory.php";
            }

        });
    }

</script>
</body>

</html>