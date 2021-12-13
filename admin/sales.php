<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php

$sales = find_all_orders();
$k = 4;
include_once("header.php")
?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Sales List</h2>

        <div class="right-wrapper text-right">
            <ol class="breadcrumbs" style="margin-right: 50px;">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Sales</span></li>
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

                                </div>
                            </div>
                        </div>

                    </div>

                    <h2 class="card-title">Sales Activity</h2>
                </header>
                <div class="card-body">
                    <?php echo art_message(); ?>

                    <table class="table table-bordered table-striped mb-0" id="datatable-tabletools">
                        <thead>
                        <tr>
<!--                            <th>Sales Id</th>-->
                            <th>Customer</th>
                            <th>Tin Number</th>
                            <th>Product Code</th>
                            <th>Product Title</th>
                            <th>Price Group</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Sales</th>
                            <th>Sales Date</th>
                            <th>Branch</th>
                            <th>Vat Type</th>
                            <th>Payment</th>
                            <th>Sales By</th>
<!--                            <th>Actions</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($sales)) {
                            ?>
                            <tr>
                                <td><?php echo $row["name"]; ?></td>
                                <td><?php echo $row["tin"]; ?></td>
                                <td><?php echo $row["code"]; ?></td>
                                <td><?php echo $row["title"]; ?></td>
                                <td><?php echo find_price_category_by_id($row["price_group"])["title"]; ?></td>
								<td><?php echo $row["price"] . " ETB"; ?></td>
                                <td><?php echo $row["qty"] . " " . $row["uom"]; ?></td>
                                <td><?php echo number_format($row["total"],2,'.',','); ?></td>
                                <td><?php echo $row["created_at"]; ?></td>
                                <td><?php echo find_branch_by_id($row["branch"])["title"]; ?></td>
                                
                                <td><?php echo (($row["vat_type"] == 0)?"With":"Without"); ?></td>
                                <td><?php echo $row["payment_type"]; ?></td>

                                <td><?php echo find_user_by_id($row["created_by"])["name"]; ?></td>
<!--                                <td class="actions">-->
<!--                                    <a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>-->
<!--                                    <a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>-->
<!--                                </td>-->
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

</body>

</html>