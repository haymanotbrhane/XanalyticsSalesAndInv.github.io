<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$bom = find_all_productionBom();
$k = 1;
include_once("header.php")
?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Bill of Material (BOM)</h2>

        <div class="right-wrapper text-right">
            <ol class="breadcrumbs" style="margin-right: 50px;">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>BOM</span></li>
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
                                    <a href="addBom.php">
                                        <button class="btn btn-primary">Add <i class="fa fa-plus"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <h2 class="card-title">BOM List</h2>
                </header>
                <div class="card-body">
                    <?php echo art_message(); ?>
                    <table class="table table-bordered table-striped mb-0" id="datatable-tabletools">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Item</th>
                            <th>Category</th>
                            <th>Raw Materials</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $k = 1;
                        while ($row = mysqli_fetch_assoc($bom)) {
                            ?>
                            <tr>
                                <td><?php echo $k++; ?></td>
                                <td><?php echo find_product_by_id($row["item_id"])["code"] . ' / ' . find_product_by_id($row["item_id"])["title"]; ?></td>
                                <td><?php echo find_category_by_id(find_product_by_id($row["item_id"])["category"])["title"]; ?></td>
                                <td><a href="#" data-toggle="modal" data-target="#myModal"
                                       onclick="componentCookie('<?php echo $row["id"]; ?>')"
                                       style="color: #007bff;font-size: 15px;padding: 10px;">
                                        <?php echo 'View Components'; ?></a></td>
                                <td><?php echo find_user_by_id($row["created_by"])["name"]; ?></td>
                                <td><?php echo substr($row["creation_date"], 0, 10); ?></td>
                                <td class="actions">
                                    <a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>
                                    <a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>
                                    <a href="#"
                                       class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                    <a href="deleteProductionBom.php?id=<?php echo $row["id"] . ''; ?>"
                                       onclick="return confirm('Are you sure?');" class="on-default remove-row"><i
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

<!-- Modal Create-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
    function componentCookie(id) {
        document.cookie = "bomComponent=" + id;
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

            if (name == "bomComponent") {
                bom = value.toString();
            }
        }

        $.ajax({
            type: "POST",
            url: "generated/bom.php",
            data: "bomId=" + bom,
            success: function (response) {
                var resp = $.trim(response);
                $("#receiveOrder").html(resp);
            }

        });
    }

</script>
</body>

</html>