<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php

$goods = find_all_goods_receive();
$k = 1;
include_once("header.php")
?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Goods Receive</h2>

        <div class="right-wrapper text-right">
            <ol class="breadcrumbs" style="margin-right: 50px;">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Goods Receive</span></li>
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
                            <!--                            <div class="col-sm-6">-->
                            <!--                                <div class="mb-3">-->
                            <!--                                    <a href="addOrderRespons.php">-->
                            <!--                                        <button class="btn btn-primary">Add <i class="fa fa-plus"></i>-->
                            <!--                                        </button>-->
                            <!--                                    </a>-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                        </div>

                    </div>

                    <h2 class="card-title">Goods Receive / GRN List</h2>
                </header>
                <div class="card-body">
                    <?php echo art_message(); ?>

                    <table class="table table-bordered table-striped mb-0" id="datatable-tabletools">
                        <thead>
                        <tr>
                            <th>GRN No</th>
                            <th>ISIV No</th>
                            <th>Plate No</th>
                            <th>Date + Time</th>
                            <th>Item Description</th>
                            <th>Quantity</th>
                            <th>Damage</th>
                            <th>Shortage</th>
                            <th>Over</th>
                            <th>Receive By</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($goods)) {
                            ?>
                            <tr class="<?php echo $row["status"] == 1 ? "success" : ""; ?>">
                                <td><?php echo $row["reference_number"]; ?></td>
                                <td><?php echo find_order_response_by_id($row["respons_id"])["reference_number"]; ?></td>
                                <td><?php echo find_vehicle_by_id(find_order_request_by_id(find_order_response_by_id($row["respons_id"])["order_id"])["vehicle_id"])["plate_no"]; ?></td>
                                <td><?php echo $row["approve_date"]; ?></td>
                                <td><?php echo find_product_by_id(find_order_response_by_id($row["respons_id"])["product_id"])["title"]; ?></td>
                                <td><?php echo find_order_response_by_id($row["respons_id"])["quantity"]; ?></td>
                                <td><?php echo $row["damege_pack"]; ?></td>
                                <td><?php echo $row["shortage_pack"]; ?></td>
                                <td><?php echo $row["over_pack"]; ?></td>
                                <td><?php echo find_user_by_id($row["u_id"])["name"]; ?></td>

                                <td class="actions">
                                    <a href="updategrn.php?id=<?php echo urldecode($row["id"]); ?>"
                                       class="on-editing save-row" onclick="return confirm('Are you sure?');">
                                        <i class="fa fa-thumbs-o-up"></i></a>
                                    <a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>
                                    <a href="editgrn.php?id=<?php echo urldecode($row["id"]); ?>"
                                       class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                    <!--                                    <a href="deletegrn.php?id=-->
                                    <?php //echo urldecode($row["id"]); ?><!--"-->
                                    <!--                                       onclick="return confirm('Are you sure?');" class="on-default remove-row"><i-->
                                    <!--                                            class="fa fa-trash-o"></i></a>-->
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
<!-- Analytics to Track Preview Website -->
<script>          (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o), m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '../../../www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-42715764-8', 'auto');
    ga('send', 'pageview');        </script>
<!-- Examples -->
<script src="js/examples/examples.datatables.default.js"></script>
<script src="js/examples/examples.datatables.row.with.details.js"></script>
<script src="js/examples/examples.datatables.tabletools.js"></script>
<script>
    function req(po) {
        document.cookie = "activation=" + po;
    }
</script>
<script>
</script>
</body>

</html>