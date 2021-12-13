<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$k = 1;
$product = find_all_order_product();
$branch = find_all_branch();

if (isset($_POST["submit"])) {
    if (isset($_POST["branch"]) && isset($_POST["o_date"]) && isset($_POST["order_number"]) && isset($_POST["name"]) && isset($_POST["d_date"]) && isset($_POST["total_payment"]) && isset($_POST["product"])) {

        $branch = $_POST["branch"];
        $order_number = $_POST["order_number"];
        $o_date = $_POST["o_date"];
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $sex = $_POST["sex"];
        $a_date = $_POST["a_date"];
        $d_date = $_POST["d_date"];
        $descr = $_POST["descr"];
        $total = $_POST["total_payment"];
        $advance = $_POST["advance_payment"];
        $product_data = json_encode($_POST["product"]);
        $attribute_data = [];
        $measurement_data = [];
        $item_code_data = [];

        for ($k = 0; $k < sizeof($_POST["product"]); $k++) {
            $attribute = json_decode(find_order_product_by_id($_POST["product"][$k])["attribute"]);
            $measurement = json_decode(find_order_product_by_id($_POST["product"][$k])["measurment"]);

            for ($i = 0; $i < sizeof($attribute); $i++) {
                $attribute_data[$_POST["product"][$k] . '_' . $attribute[$i]] = $_POST["attr_" . $_POST["product"][$k] . '_' . $attribute[$i] . ""];
            }
            for ($i = 0; $i < sizeof($measurement); $i++) {
                $measurement_data[$_POST["product"][$k] . '_' . $measurement[$i]] = $_POST["measur_" . $_POST["product"][$k] . '_' . $measurement[$i] . ""];
            }
            $item_code_data[$_POST["product"][$k]] = $_POST["item_code_" . $_POST["product"][$k] . ""];

        }

        create_order_sheet($branch, $o_date, $order_number, $name, $phone, $sex, $product_data, $descr, json_encode($attribute_data), json_encode($measurement_data), $total, $advance, $a_date, $d_date, json_encode($item_code_data));

    } else {
        $_SESSION["art_error"] = "Please Fill All Fields ";
    }
}
include_once("header.php")
?>
<section role="main" class="content-body card-margin">
<header class="page-header">
    <h2>Order Sheet</h2>

    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
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
<div class="col-lg-12">
<section class="card form-wizard row" id="w1" style="background: #ffffff">
<header class="card-header">

    <h2 class="card-title">Order Sheet</h2>
</header>
<div class="card-body card-body-nopadding col-lg-6">
<div class="wizard-tabs">
    <ul class="nav wizard-steps">
        <li class="nav-item active">
            <a href="#info" data-toggle="tab" class="nav-link text-center">
                <span class="badge">1</span>
                Order Information
            </a>
        </li>
        <li class="nav-item">
            <a href="#detail" data-toggle="tab" class="nav-link text-center">
                <span class="badge">2</span>
                Order Detail
            </a>
        </li>
        <li class="nav-item">
            <a href="#financial" data-toggle="tab" class="nav-link text-center">
                <span class="badge">3</span>
                Order Financial Info
            </a>
        </li>
    </ul>
</div>
<?php echo art_message(); ?>
<form class="form-horizontal form-bordered" action="#" method="post" enctype='multipart/form-data'
      novalidate="novalidate">
    <div class="tab-content">
        <div id="info" class="tab-pane p-3 active">
            <div class="form-group row">
                <label class="col-lg-4 control-label text-lg-right pt-2">Branch</label>

                <div class="col-lg-8">
                    <select name="branch" data-plugin-selectTwo
                            class="form-control populate" style="width: 100%" required>
                        <?php
                        echo "<option value=''>Select Branch</option>";
                        while ($row = mysqli_fetch_assoc($branch)) {
                            ?>
                            <option
                                value='<?php echo $row["id"]; ?>'><?php echo $row["title"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-4 control-label text-lg-right pt-2"
                       for="textareaDefault">Order Number</label>

                <div class="col-lg-8">
                    <input class="form-control" type="text" name="order_number" data-plugin-maxlength
                           maxlength="100"
                           required/>

                </div>

            </div>

            <div class="form-group row">
                <label class="col-lg-4 control-label text-lg-right pt-2">Order Date</label>

                <div class="col-lg-8">
                    <div class="input-group">
                        <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                        <input type="text" name="o_date" id="o_date" data-plugin-datepicker required
                               class="form-control" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-4 control-label text-lg-right pt-2"
                       for="textareaDefault">Customer Name</label>

                <div class="col-lg-8">
                    <input class="form-control" type="text" name="name" data-plugin-maxlength
                           maxlength="100" required/>

                </div>

            </div>

            <div class="form-group row">
                <label class="col-lg-4 control-label text-lg-right pt-2"
                       for="textareaDefault">Customer Phone</label>

                <div class="col-lg-8">
                    <input class="form-control" type="text" name="phone" data-plugin-maxlength
                           maxlength="100" required/>

                </div>

            </div>

            <div class="form-group row">
                <label class="col-lg-4 control-label text-lg-right pt-2">Customer Gender</label>

                <div class="col-lg-8">
                    <select name="sex" data-plugin-selectTwo class="form-control populate" style="width: 100%">
                        <option value=''>Select Gender</option>
                        <option value='man'>Man</option>
                        <option value='woman'>Woman</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-4 control-label text-lg-right pt-2">Items</label>

                <div class="col-lg-8">
                    <select name="product[]" id="product" data-plugin-selectTwo class="form-control populate"
                            multiple >
                        <?php
                        while ($row = mysqli_fetch_assoc($product)) {
                            ?>
                            <option value="<?php echo $row["id"] ?>"><?php echo $row["title"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-4 control-label text-lg-right pt-2">Appointment Date</label>

                <div class="col-lg-8">
                    <div class="input-group">
                        <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                        <input type="text" name="a_date" id="a_date" data-plugin-datepicker required
                               class="form-control" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-4 control-label text-lg-right pt-2">Deliver Date</label>

                <div class="col-lg-8">
                    <div class="input-group">
                        <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                        <input type="text" name="d_date" id="d_date" data-plugin-datepicker required
                               class="form-control" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-4 control-label text-lg-right pt-2"
                       for="textareaDefault">Description</label>

                <div class="col-lg-8">
                    <textarea class="form-control" name="descr" data-plugin-maxlength
                              maxlength="200"></textarea>

                </div>

            </div>

        </div>

        <div id="detail" class="tab-pane p-3">
            <div id="special_order">

            </div>
        </div>

        <div id="financial" class="tab-pane p-3">
            <div class="form-group row">
                <label class="col-lg-4 control-label text-lg-right pt-2"
                       for="textareaDefault">Total Payment</label>

                <div class="col-lg-8">
                    <input class="form-control" type="text" name="total_payment" data-plugin-maxlength
                           maxlength="100" required/>

                </div>

            </div>

            <div class="form-group row">
                <label class="col-lg-4 control-label text-lg-right pt-2"
                       for="textareaDefault">Advance Payment</label>

                <div class="col-lg-8">
                    <input class="form-control" type="text" name="advance_payment" data-plugin-maxlength
                           maxlength="100" required/>

                </div>

            </div>

            <div class="form-group row">
                <div class="col-sm-12">
                    <input class="float-right btn btn-success" type="submit"
                           value="Create Order" name="submit">
                </div>
            </div>

        </div>

    </div>
</form>
</div>
<div class="card-footer row">
    <ul class="pager col-lg-6 pl-2">
        <li class="previous disabled">
            <a><i class="fa fa-angle-left"></i> Previous</a>
        </li>

        <li class="next">
            <a>Next <i class="fa fa-angle-right"></i></a>
        </li>
    </ul>
</div>

<div class="form-group row">
    <div class="col-sm-8 text-left ml-3 mb-5">
        <a href="orderSheet.php" class=" btn btn-success">Back</a>
    </div>
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
<script src="vendor/jquery-validation/jquery.validate.js"></script>
<script src="vendor/bootstrap-wizard/jquery.bootstrap.wizard.js"></script>
<script src="vendor/pnotify/pnotify.custom.js"></script>

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
<script src="js/examples/examples.wizard.js"></script>
<script>
    var $product = $("#product");
    var $special = $("#special_order");
    var $attribute = $("#w1-confirm");

    $(document).ready(function () {
        $product.change(function () {

            var pro = $(this).val();

            $.ajax({
                url: "generated/order_sheet.php",
                data: {product: pro},
                type: "POST",
                success: function (response) {
                    $special.html(response);
                }
            });
        });
    });

    $(document).ready(function () {
        $sub_cat.change(function () {

            var cla = $(this).val();

            $.ajax({
                url: "test/productAttributes.php",
                data: {sub_category: cla},
                type: "POST",
                success: function (response) {
                    var resp = $.trim(response);
                    $attribute.html(resp);
                }
            });
        });
    });
</script>

</body>

</html>