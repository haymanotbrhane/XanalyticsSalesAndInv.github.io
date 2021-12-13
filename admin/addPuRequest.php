<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php

$category = find_all_product();

if (isset($_POST["submit"])) {
//    if (isset($_POST["title"]) && isset($_POST["price"])) {

    $code = trim($_POST["code"]);
    $title = trim($_POST["title"]);
    $type = trim($_POST["type"]);
    $category = trim($_POST["c_id"]);
    $measurement = trim($_POST["measurement"]);
    $description = trim($_POST["description"]);
    $min_stock = (trim($_POST["min_stock"]) != '') ? trim($_POST["min_stock"]) : 0;
    $created_by = trim($_SESSION["admin_id"]);

    create_product($code, $title, $type, $category, $measurement, $description, $min_stock, $created_by);
//    } else {
//        $_SESSION["art_error"] = "Please Fill All Fields ";
//    }
}
include_once("header.php")
?>
<section role="main" class="content-body card-margin">
    <header class="page-header">
        <h2>Purchase</h2>

        <div class="right-wrapper text-right">
            <ol class="breadcrumbs">
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

                    <h2 class="card-title">Create Purchase Request</h2>
                </header>
                <div class="card-body">
                    <?php echo art_message(); ?>
                    <form class="form-horizontal form-bordered" action="#" method="post" enctype='multipart/form-data'>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Item Code</label>

                            <div class="col-lg-4">
                                <input type="text" name="code" class="form-control" data-plugin-maxlength
                                       maxlength="100" required/>

                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Item Title</label>

                            <div class="col-lg-4">
                                <input type="text" name="title" class="form-control" data-plugin-maxlength
                                       maxlength="100" required/>

                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Item Category</label>

                            <div class="col-lg-4">
                                <select name="c_id" id="c_id" data-plugin-selectTwo class="form-control populate"
                                        required>
                                    <option value="">Select Category</option>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($category)) {
                                        ?>
                                        <option
                                            value="<?php echo $row["id"] ?>"><?php echo $row["title"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Item Type</label>

                            <div class="col-lg-4">
                                <select name="type" data-plugin-selectTwo class="form-control populate"
                                        required>
                                    <option value="">Select Type</option>
                                    <option value="Consumable">Consumable</option>
                                    <option value="Service">Service</option>
                                    <option value="Stockable Product">Stockable Product</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Unit of Measurement</label>

                            <div class="col-lg-4">
                                <input type="text" name="measurement" class="form-control" data-plugin-maxlength
                                       maxlength="100" required/>

                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Description</label>

                            <div class="col-lg-4">
                                <input type="text" name="description" class="form-control" data-plugin-maxlength
                                       maxlength="100"/>

                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Minimum Stock</label>

                            <div class="col-lg-4">
                                <input type="text" name="min_stock" class="form-control" data-plugin-maxlength
                                       maxlength="100"/>

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
                                       value="Create Product">
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
<script src="js/examples/examples.advanced.form.js"></script>


</body>

</html>