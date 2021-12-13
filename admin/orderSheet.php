<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php

$order = find_all_order_sheet();
$k = 1;

include_once("header.php")
?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Order Sheet</h2>

        <div class="right-wrapper text-right">
            <ol class="breadcrumbs" style="margin-right: 50px;">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Order Sheet</span></li>
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
                                    <a href="addOrderSheet.php">
                                        <button class="btn btn-primary">Add <i class="fa fa-plus"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <h2 class="card-title">Order Sheet</h2>
                </header>
                <div class="card-body">
                    <?php echo art_message(); ?>

                    <table class="table table-responsive-lg table-bordered table-striped table-sm mb-0"
                           id="datatable-tabletools">
                        <thead>
                        <tr>
                            <!--                            <th>No</th>-->
                            <th>Branch</th>
                            <th>Order Date</th>
                            <th>Order Number</th>
                            <th>Customer Name</th>
                            <th>Customer Phone</th>
                            <th>Order Items</th>
                            <th>Total Price</th>
                            <th>Advance</th>
                            <!--                            <th>Appointment Date</th>-->
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $k = 1;
                        while ($row = mysqli_fetch_assoc($order)) {
                            ?>
                            <tr>
                                <!--                                <td>--><?php //echo $k++; ?><!--</td>-->
                                <td><?php echo find_branch_by_id($row["branch"])["title"]; ?></td>
                                <td><?php echo $row["order_date"]; ?></td>
                                <td><?php echo $row["order_number"]; ?></td>
                                <td><?php echo $row["customet_name"]; ?></td>
                                <td><?php echo $row["customer_phone"]; ?></td>
                                <td style="color: #000000;font-size: 14px"><?php
                                    $products = json_decode($row["product_id"]);
                                    $product_list = "";
                                    for ($i = 0; $i < sizeof($products); $i++)
                                        $product_list .= find_order_product_by_id($products[$i])["title"] . "</br>";

                                    echo $product_list;
                                    ?>
                                </td>
                                <td><?php echo number_format($row["total_payment"], 2, '.', ','); ?></td>
                                <td><?php echo number_format($row["advance_payment"], 2, '.', ','); ?></td>
                                <!--                                <td>-->
                                <?php //echo $row["appointment_date"]; ?><!--</td>-->
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#myModal"
                                       onclick="order_id(<?php echo urldecode($row["id"]); ?>);"
                                       style="color: #000000"><?php echo ($row["status"] == 2) ? "<span style='background: green;color: white;padding: 5px'>Completed</span>" : "<span style='background: #ffff00;padding: 5px'>Pending</span>"; ?></a>
                                </td>
                                <td class="actions" style="font-size: 20px">
                                    <a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>
                                    <a href="#" onclick="display_detail(<?php echo urldecode($row["id"]); ?>);"
                                       data-toggle="modal" data-target="#myModal1"
                                       class="on-editing cancel-row p-1"><i class="fa fa-info"></i></a>
                                    <a href="#" class="on-default edit-row p-1"><i class="fa fa-pencil"></i></a>
                                    <a href="deleteOrderSheet.php?id=<?php echo urldecode($row["id"]); ?>"
                                       onclick="return confirm('Are you sure?');" class="on-default remove-row p-1"><i
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

    <!-- Modal status-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <section class="card">
                        <header class="card-header">

                            <h2 class="card-title">Update Order Status</h2>
                        </header>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-lg-4 control-label text-lg-right pt-2">Order Status</label>

                                <div class="col-lg-8">
                                    <select name="status" id="status" data-plugin-selectTwo
                                            class="form-control populate" style="width: 100%">
                                        <option value='2'>Complete</option>
                                        <option value='1'>Pending</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </section>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit_status" id="status_btn" onclick="saveStatus()"
                            class="btn btn-success">Update Status
                    </button>
                    <button class="btn btn-info" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <!-- order detail-->
    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="order_body">

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
<!-- Analytics to Track Preview Website -->
<!--<script>          (function (i, s, o, g, r, a, m) {-->
<!--        i['GoogleAnalyticsObject'] = r;-->
<!--        i[r] = i[r] || function () {-->
<!--            (i[r].q = i[r].q || []).push(arguments)-->
<!--        }, i[r].l = 1 * new Date();-->
<!--        a = s.createElement(o), m = s.getElementsByTagName(o)[0];-->
<!--        a.async = 1;-->
<!--        a.src = g;-->
<!--        m.parentNode.insertBefore(a, m)-->
<!--    })(window, document, 'script', '../../../www.google-analytics.com/analytics.js', 'ga');-->
<!--    ga('create', 'UA-42715764-8', 'auto');-->
<!--    ga('send', 'pageview');        </script>-->
<!-- Examples -->
<script src="js/examples/examples.datatables.default.js"></script>
<script src="js/examples/examples.datatables.row.with.details.js"></script>
<script src="js/examples/examples.datatables.tabletools.js"></script>

<script>
    //production request
    function order_id(id) {
        document.cookie = "orderId=" + id;
    }

    function saveStatus() {

        var o_id = "";

        var allcookies = document.cookie;

        // Get all the cookies pairs in an array
        cookiearray = allcookies.split(';');

        // Now take key value pair out of this array
        for (var i = 0; i < cookiearray.length; i++) {
            name = cookiearray[i].split('=')[0].toString().trim();
            value = cookiearray[i].split('=')[1];

            if (name == "orderId") {
                o_id = value.toString();
            }
        }

        var status = $('#status').val();

        $.ajax({
            type: "POST",
            url: "generated/order_sheet.php",
            data: "orderID=" + o_id + "&status=" + status,
            success: function (response) {
                window.location = "orderSheet.php";
            }

        });
    }

    function display_detail(id) {
        $.ajax({
            type: "POST",
            url: "generated/order_sheet.php",
            data: "Order_ID=" + id,
            success: function (response) {
                $("#order_body").html(response);
            }

        });
    }

</script>

</body>

</html>