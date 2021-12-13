<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$k = 1;
$item = find_all_item_code();

include_once("header.php")
?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Item Code</h2>

        <div class="right-wrapper text-right">
            <ol class="breadcrumbs" style="margin-right: 50px;">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Item Code</span></li>
            </ol>
        </div>
    </header>

    <!-- start: page -->
    <div class="row">
        <div class="col">
            <section class="card">

                <div class="row">
                    <div class="col">
                        <section class="card">
                            <header class="card-header">
                                <div class="card-actions col-md-6">

                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <a href="addItemCode.php">
                                                <button class="btn btn-info col-md-5 mr-2 mb-1">
                                                    Create Item Code
                                                </button>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6 te">
                                    <h2 class="card-title">Item Code List</h2>
                                </div>
                            </header>
                            <div class="card-body">
                                <?php echo art_message(); ?>

                                <table class="table table-bordered table-striped mb-0" id="datatable-tabletools">
                                    <thead>
                                    <tr>
                                        <th>Item Code</th>
                                        <th>Item Sample</th>
                                        <th>Created By</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($item)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row["code"]; ?></td>
                                            <td><img src="<?php echo $row["image"]; ?>"
                                                     style="height: 70px;width: auto">
                                            </td>
                                            <td><?php echo find_user_by_id($row["created_by"])["name"]; ?></td>
                                            <td class="actions">

                                                <a href="#" class="on-default edit-row p-1"><i class="fa fa-pencil"></i></a>

                                                <a href="deleteItemCode.php?id=<?php echo urldecode($row["id"]); ?>"
                                                   onclick="return confirm('Are you sure?');"
                                                   class="on-default remove-row p-1"><i
                                                        class="fa fa-trash-o"></i></a>
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