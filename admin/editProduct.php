<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$k = 6;
$product = find_product_by_id($_GET["id"]);
$category = find_all_category();

if (isset($_POST["submit"])) {
    if (isset($_POST["title"]) && isset($_POST["code"])) {

        $id = $product["id"];
        $code = trim($_POST["code"]);
        $title = trim($_POST["title"]);
        $type = trim($_POST["type"]);
        $category = trim($_POST["c_id"]);
        $measurement = trim($_POST["measurement"]);
        $description = trim($_POST["description"]);
        $min_stock = (trim($_POST["min_stock"]) != '') ? trim($_POST["min_stock"]) : 0;
        $sh_min_stock = (trim($_POST["sh_min_stock"]) != '') ? trim($_POST["sh_min_stock"]) : 0;
        $sr_min_stock = (trim($_POST["sr_min_stock"]) != '') ? trim($_POST["sr_min_stock"]) : 0;
        $created_by = trim($_SESSION["admin_id"]);

        $query = "UPDATE product SET ";
        $query .= "code = '{$code}'";
        $query .= ",title = '{$title}'";
        $query .= ",type = '{$type}'";
        $query .= ",category = {$category}";
        $query .= ",measurment = '{$measurement}' ";
        $query .= ",description = '{$description}' ";
        $query .= ",min_stock = {$min_stock} ";
        $query .= ",min_shop = {$sh_min_stock} ";
        $query .= ",min_showroom = {$sr_min_stock} ";
        $query .= ",last_update_by = {$created_by} ";
        $query .= "WHERE id = {$id}; ";
        $result = mysqli_query($connection, $query);

        if ($result) {
            // Success
            $_SESSION["art_message"] = "Successfully Updated";

            redirect_to("product.php");
        } else {
            // Failure
            $_SESSION["art_error"] = "Update failed.";
        }
    } else {
        $_SESSION["art_error"] = "Please Fill All Fields ";
    }
}
include_once("header.php")
?>
<section role="main" class="content-body card-margin">
    <header class="page-header">
        <h2>Product</h2>

        <div class="right-wrapper text-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Product</span></li>
            </ol>

        </div>
    </header>

    <!-- start: page -->
    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">

                    <h2 class="card-title">Update Product</h2>
                </header>
                <div class="card-body">
                    <?php echo art_message(); ?>
                    <form class="form-horizontal form-bordered" action="#" method="post" enctype='multipart/form-data'>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Product Code</label>

                            <div class="col-lg-4">
                                <input type="text" name="code" class="form-control" data-plugin-maxlength
                                       maxlength="100" required value="<?php echo $product["code"]; ?>"/>

                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Product Title</label>

                            <div class="col-lg-4">
                                <input type="text" name="title" class="form-control" data-plugin-maxlength
                                       maxlength="100" required value="<?php echo $product["title"]; ?>"/>

                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Product Category</label>

                            <div class="col-lg-4">
                                <select name="c_id" id="c_id" data-plugin-selectTwo class="form-control populate"
                                        required>
                                    <option value="">Select Category</option>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($category)) {
                                        ?>
                                        <option <?php echo ($row["id"] === $product["category"]) ? "selected" : ""; ?>
                                            value="<?php echo $row["id"] ?>"><?php echo $row["title"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Unit of Measurement</label>

                            <div class="col-lg-4">
                                <input type="text" name="measurement" class="form-control" data-plugin-maxlength
                                       maxlength="100" required value="<?php echo $product["measurment"]; ?>"/>

                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Description</label>

                            <div class="col-lg-4">
                                <input type="text" name="description" class="form-control" data-plugin-maxlength
                                       maxlength="100" value="<?php echo $product["description"]; ?>"/>

                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Warehouse Min Stock</label>

                            <div class="col-lg-4">
                                <input type="text" name="min_stock" class="form-control" data-plugin-maxlength
                                       maxlength="100" value="<?php echo $product["min_stock"]; ?>"/>

                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Shop Min Stock</label>

                            <div class="col-lg-4">
                                <input type="text" name="sh_min_stock" class="form-control" data-plugin-maxlength
                                       maxlength="100" value="<?php echo $product["min_shop"]; ?>"/>

                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Showroom Min Stock</label>

                            <div class="col-lg-4">
                                <input type="text" name="sr_min_stock" class="form-control" data-plugin-maxlength
                                       maxlength="100" value="<?php echo $product["min_showroom"]; ?>"/>

                            </div>

                        </div>


                        <div class="form-group row">
                            <div class="col-lg-6">
                                <a href="product.php">
                                    <button type="button" style="float: right" class="mb-1 mt-1 mr-1 btn btn-info">
                                        Cancel
                                    </button>
                                </a>
                                <input type="submit" name="submit" style="float: right"
                                       class="mb-1 mt-1 mr-1 btn btn-success"
                                       value="Update Product">
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>

                    </form>
                </div>
            </section>
        </div>
    </div>

    <!-- end: page -->
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
<script src="vendor/jquery-ui/jquery-ui.js"></script>
<script src="vendor/jqueryui-touch-punch/jqueryui-touch-punch.js"></script>
<script src="vendor/select2/js/select2.js"></script>
<script src="vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="vendor/jquery-maskedinput/jquery.maskedinput.js"></script>
<script src="vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<script src="vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.js"></script>
<script src="vendor/fuelux/js/spinner.js"></script>
<script src="vendor/dropzone/dropzone.js"></script>
<script src="vendor/bootstrap-markdown/js/markdown.js"></script>
<script src="vendor/bootstrap-markdown/js/to-markdown.js"></script>
<script src="vendor/bootstrap-markdown/js/bootstrap-markdown.js"></script>
<script src="vendor/codemirror/lib/codemirror-2.html"></script>
<script src="vendor/codemirror/addon/selection/active-line.html"></script>
<script src="vendor/codemirror/addon/edit/matchbrackets.html"></script>
<script src="vendor/codemirror/mode/javascript/javascript.html"></script>
<script src="vendor/codemirror/mode/xml/xml.html"></script>
<script src="vendor/codemirror/mode/htmlmixed/htmlmixed.html"></script>
<script src="vendor/codemirror/mode/css/css.html"></script>
<script src="vendor/summernote/summernote-bs4.js"></script>
<script src="vendor/bootstrap-maxlength/bootstrap-maxlength.js"></script>
<script src="vendor/ios7-switch/ios7-switch.js"></script>

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
<script src="js/examples/examples.advanced.form.js"></script>

</body>

</html>