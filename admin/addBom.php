<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$k = 1;
$product = find_product_by_category(2);
$raw = find_product_by_category(1);

if (isset($_POST["submit"])) {
    if (isset($_POST["title"])) {

        $title = $_POST["title"];
        $descr = $_POST["descr"];
        $user_id = $_SESSION["admin_id"];

        create_productionLine($title, $descr, $user_id);
    } else {
        $_SESSION["art_error"] = "Please Fill Required Fields ";
    }
}
include_once("header.php")
?>
<section role="main" class="content-body card-margin">
    <header class="page-header">
        <h2>Bill of Material (BOM)</h2>

        <div class="right-wrapper text-right">
            <ol class="breadcrumbs">
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

                    <h2 class="card-title">Create BOM</h2>
                </header>
                <div class="card-body">

                    <?php echo art_message(); ?>

                    <form class="form-horizontal form-bordered" id="add_bom">

                        <div class="form-group row">

                            <div class="col-lg-3 row">
                                <label class="col-lg-12 control-label text-lg-left"
                                       style="font-size: 16px">Produced Item</label>

                                <div class="col-lg-12">
                                    <select name="pro_item" id="pro_item" data-plugin-selectTwo
                                            class="form-control populate" required>
                                        <option value="">Select Product</option>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($product)) {
                                            ?>
                                            <option
                                                value="<?php echo $row["id"] ?>"><?php echo $row["code"] . ' / ' . $row["title"]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>

                            <div class="col-lg-3 row">
                                <label class="col-lg-12 control-label text-lg-left pt-2"
                                       style="font-size: 16px">Quantity</label>

                                <div class="col-lg-12">
                                    <input type="text" name="pro_qty" id="pro_qty" class="form-control"
                                           data-plugin-maxlength maxlength="200" required/>

                                </div>
                            </div>

                        </div>

                        <div id="dynamic_field" class="mb-5">

                            <div class="form-group row">

                                <div class="col-lg-3 row">
                                    <label class="col-lg-12 control-label text-lg-left pt-2"
                                           style="color: #291bd4;font-size: 16px">Products</label>

                                    <div class="col-lg-12">
                                        <select name="raw_item[]" id="raw_item" data-plugin-selectTwo
                                                class="form-control populate" required>
                                            <option value="">Select Ram Material</option>
                                            <?php
                                            while ($row = mysqli_fetch_assoc($raw)) {
                                                ?>
                                                <option
                                                    value="<?php echo $row["id"] ?>"><?php echo $row["code"] . ' / ' . $row["title"]; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                </div>

                                <div class="col-lg-3 row">
                                    <label class="col-lg-12 control-label text-lg-left pt-2"
                                           style="color: #291bd4;font-size: 16px">Products Quantity</label>

                                    <div class="col-lg-12">
                                        <input type="text" name="raw_qty[]" id="raw_qty" class="form-control"
                                               data-plugin-maxlength maxlength="200" required/>

                                    </div>
                                </div>


                                <div class="col-lg-1">
                                    <label class="col-lg-12 control-label text-lg-left pt-2"
                                           style="color: white">add</label>

                                    <input type="button" name="add" id="add"
                                           style="padding: 0;font-size: 12px;color: #291bd4;" class="form-control"
                                           value="add an item"/>
                                </div>

                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <a href="bom.php">
                                    <button type="button" style="float: right" class="mb-1 mt-1 mr-1 btn btn-info">
                                        Cancel
                                    </button>
                                </a>
                                <input type="button" name="submit" id="submit" style="float: right"
                                       class="mb-1 mt-1 mr-1 btn btn-success" value="Create BOM">
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

<script src="js/examples/examples.advanced.form.js"></script>

<script>
    $(document).ready(function () {
        $("#pro").change(function () {
            var pro = $(this).val();
            $.ajax({
                url: "test/JobCategory.php",
                data: {pro_id: pro},
                type: 'POST',
                success: function (response) {
                    var resp = $.trim(response);
                    $("#parent").html(resp);
                }
            });
        });
    });

    $(document).ready(function () {
        var postURL = "generated/bom.php";
        var i = 1;

        $('#add').click(function () {
            i++;

            $.ajax({
                url: postURL,
                method: "POST",
                data: {increament_id: i},
                type: 'POST',
                success: function (data) {
                    $('#dynamic_field').append($.trim(data));
                }
            });

        });

        $(document).on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });

        $('#submit').click(function () {
            $.ajax({
                url: postURL,
                method: "POST",
                data: $('#add_bom').serialize(),
                type: 'json',
                success: function (data) {
                    i = 1;
                    window.location.href = "addBom.php";
                }
            });
        });

    });
</script>


</body>

</html>