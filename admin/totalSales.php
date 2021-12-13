<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$now = date("Y-m-d");

$date = strtotime("-7 day");

$past = date("Y-m-d", $date);
$branch = "";
$branchs = find_all_branch();

$k = 4;

if (isset($_POST["submit"])) {
    $now = $_POST["edate"];
    $past = $_POST["sdate"];
    $branch = $_POST["branch"];
    $sales = find_total_sales_by_range($branch, $past, $now);
} else {
    $sales = find_total_sales_by_range($branch, $past, $now);
}

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

                    <form action="#" method="post">
                        <div class="row">
                            <div class="col-lg-2" style="padding-right: 0">
                                <h2 class="card-title pt-2">Sales Summery</h2>
                            </div>

                            <div class="col-lg-3 row" style="padding: 0">
                                <label class="col-md-4 control-label text-lg-right pt-2"
                                       style="padding: 0 5px">Branch</label>
                                <select name="branch" id="rangeBranch" class="populate col-md-8"
                                        style="padding: 5px">
                                    <?php
                                    echo "<option value=''>All Branch's</option>";
                                    while ($row = mysqli_fetch_assoc($branchs)) {
                                        ?>
                                        <option <?php echo ($branch == $row["id"]) ? "selected" : ""; ?>
                                                value='<?php echo $row["id"]; ?>'><?php echo $row["title"]; ?></option>
                                    <?php } ?>
                                </select>

                            </div>

                            <div class="col-lg-6 row">

                                <label class="col-lg-3 control-label text-lg-right pt-2">Date range</label>

                                <div class="col-lg-9">
                                    <div class="input-daterange input-group" data-plugin-datepicker>
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                        <input type="text" class="form-control" name="sdate"
                                               value="<?php echo $past; ?>">
                                        <span class="input-group-addon">to</span>
                                        <input type="text" class="form-control" name="edate"
                                               value="<?php echo $now; ?>">
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-1">
                                <input class="btn btn-success" name="submit" type="submit"
                                       style="display: block" value="Search">
                            </div>

                        </div>

                    </form>
                </header>
                <div class="card-body">
                    <?php echo art_message(); ?>

                    <table class="table table-bordered table-striped mb-0" id="datatable-tabletools">
                        <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Tin Number</th>
                            <th>Product Code/Title</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Total Sales</th>
                            <th>Sales Date</th>
                            <th>Vat Type</th>
                            <th>Payment</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total = 0;
                        $cash = 0;
                        $credit = 0;
                        $cheque = 0;

                        while ($row = mysqli_fetch_assoc($sales)) {
                            $total += $row["total"];
                            if ($row["payment_type"] == "Cash")
                                $cash += $row["total"];
                            elseif ($row["payment_type"] == "Credit")
                                $credit += $row["total"];
                            else
                                $cheque += $row["total"];

                            ?>
                            <tr>
                                <td><?php echo $row["name"]; ?></td>
                                <td><?php echo $row["tin"]; ?></td>
                                <td><?php echo $row["code"] . '/' . $row["title"]; ?></td>
                                <td><?php echo $row["price"] . " ETB"; ?></td>
                                <td><?php echo $row["qty"] . " " . $row["uom"]; ?></td>
                                <td><?php echo number_format($row["total"], 2, '.', ','); ?></td>
                                <td><?php echo $row["created_at"]; ?></td>
                                <td><?php echo(($row["vat_type"] == 0) ? "With" : "Without"); ?></td>
                                <td><?php echo $row["payment_type"]; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td><?php echo ""; ?></td>
                            <td><?php echo ""; ?></td>
                            <td><?php echo ""; ?></td>
                            <td><?php echo "<h5 style='font-weight: bolder;text-align: right;margin: 0'>Cash</h5>"; ?></td>
                            <td><?php echo "<h5 style='margin: 0'>" . number_format($cash, 2, '.', ',') . "</h5>"; ?></td>
                            <td><?php echo ""; ?></td>
                            <td><?php echo ""; ?></td>
                            <td><?php echo ""; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo ""; ?></td>
                            <td><?php echo ""; ?></td>
                            <td><?php echo ""; ?></td>
                            <td><?php echo "<h5 style='font-weight: bolder;text-align: right;margin: 0'>Credit</h5>"; ?></td>
                            <td><?php echo "<h5 style='margin: 0'>" . number_format($credit, 2, '.', ',') . "</h5>"; ?></td>
                            <td><?php echo ""; ?></td>
                            <td><?php echo ""; ?></td>
                            <td><?php echo ""; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo ""; ?></td>
                            <td><?php echo ""; ?></td>
                            <td><?php echo ""; ?></td>
                            <td><?php echo "<h5 style='font-weight: bolder;text-align: right;margin: 0'>Cheque</h5>"; ?></td>
                            <td><?php echo "<h5 style='margin: 0'>" . number_format($cheque, 2, '.', ',') . "</h5>"; ?></td>
                            <td><?php echo ""; ?></td>
                            <td><?php echo ""; ?></td>
                            <td><?php echo ""; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo ""; ?></td>
                            <td><?php echo ""; ?></td>
                            <td><?php echo ""; ?></td>
                            <td><?php echo "<h4 style='font-weight: bolder;text-align: right'>Total Sales</h4>"; ?></td>
                            <td><?php echo "<h4 style=''>" . number_format($total, 2, '.', ',') . "</h4>"; ?></td>
                            <td><?php echo ""; ?></td>
                            <td><?php echo ""; ?></td>
                            <td><?php echo ""; ?></td>
                        </tr>
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
            dom: 'Bflrtip',
            "displayLength": 100,
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>
<style>
    #datatable-tabletools_filter, #datatable-tabletools_length {
        float: right;
    }
</style>
<script src="js/examples/examples.datatables.default.js"></script>
<script src="js/examples/examples.datatables.row.with.details.js"></script>
<script src="js/examples/examples.datatables.tabletools.js"></script>

</body>

</html>