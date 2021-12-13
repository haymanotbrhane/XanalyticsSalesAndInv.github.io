<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php

$plan = find_ProductionPlan_by_id($_GET["id"]);
$warehouse = find_all_warehouse();
$warehouse1 = find_all_warehouse();
$warehouse2 = find_all_warehouse();

if (isset($_POST["submit"])) {
    if (isset($_POST["fqty"]) && isset($_POST["house1"]) && isset($_POST["house2"]) && isset($_POST["house3"])) {

        $item = $plan["item_id"];
        $fqty = $_POST["fqty"];
        $house1 = $_POST["house1"];
        $house2 = $_POST["house2"];
        $house3 = $_POST["house3"];
        $user = $_SESSION["admin_id"];

        $complete = create_inventory($item, 2, $fqty, "production_produced", $house1, $user,"");

        if ($complete) {
            $d_qty = array();
            $d_qty = $plan["damage_qty"];
            $d_qty = str_replace("{", "", $d_qty);
            $d_qty = str_replace('}', "", $d_qty);
            $d_qty = str_replace('"', "", $d_qty);
            $d_qty = explode(',', $d_qty);

            $d = false;
            $bom = find_ProductionBom_by_item($item);

            foreach ($d_qty as $value) {
                $key = explode(':', $value);
                $damage = $_POST['damage_' . find_product_by_id($key[0])["id"]];
                create_inventory(find_product_by_id($key[0])["id"], 3, $damage, "production_damage", $house3, $user,"");
            }

            $r_qty = array();
            $r_qty = $plan["return_qty"];
            $r_qty = str_replace("{", "", $r_qty);
            $r_qty = str_replace('}', "", $r_qty);
            $r_qty = str_replace('"', "", $r_qty);
            $r_qty = explode(',', $r_qty);

            foreach ($r_qty as $value) {
                $key = explode(':', $value);
                $return = $_POST['return_' . find_product_by_id($key[0])["id"]];
                create_inventory(find_product_by_id($key[0])["id"], 1, $return, "production_return", $house2, $user,"");
            }
            $check = update_completed_production($plan["id"]);

            if ($check) {
                $_SESSION["art_message"] = "Item transfer from production to inventory.";
                redirect_to("inventoryRequest.php");
            } else {
                $_SESSION["art_error"] = "Please try again.";
            }
        } else {
            $_SESSION["art_error"] = "Please try again.";
        }

    } else {
        $_SESSION["art_error"] = "Please Fill All Fields ";
    }
}
include_once("header.php")
?>
<section role="main" class="content-body card-margin">
<header class="page-header">
    <h2>Production Plan</h2>

    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li>
                <a href="#">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><span>Production Plan</span></li>
        </ol>

    </div>
</header>

<!-- start: page -->
<div class="row">
    <div class="col-lg-12">
        <section class="card form-wizard row" id="w1" style="background: #ffffff">
            <header class="card-header">

                <h2 class="card-title">Complete Production Plan</h2>
            </header>
            <div class="card-body card-body-nopadding col-lg-6">
                <div class="wizard-tabs">
                    <ul class="nav wizard-steps">
                        <li class="nav-item active">
                            <a href="#w1-account" data-toggle="tab" class="nav-link text-center">
                                <span class="badge">1</span>
                                Finished Goods
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#w1-profile" data-toggle="tab" class="nav-link text-center">
                                <span class="badge">2</span>
                                Return Materials
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#w1-confirm" data-toggle="tab" class="nav-link text-center">
                                <span class="badge">3</span>
                                Damaged Materials
                            </a>
                        </li>
                    </ul>
                </div>
                <?php echo art_message(); ?>
                <form class="form-horizontal form-bordered" action="addReceiveProduct.php?id=<?php echo $_GET["id"]; ?>"
                      method="post" enctype='multipart/form-data'
                      novalidate="novalidate">
                    <div class="tab-content">
                        <div id="w1-account" class="tab-pane p-3 active">
                            <div class="form-group row">
                                <label class="col-lg-4 control-label text-lg-right pt-2"
                                       for="textareaDefault">Produced Qty</label>

                                <div class="col-lg-8">
                                    <input class="form-control" type="text" name="title" data-plugin-maxlength
                                           maxlength="200" required disabled
                                           value="<?php echo $plan["finished_qty"] . ' ' . find_product_by_id($plan["item_id"])["measurment"]; ?>"/>

                                </div>

                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 control-label text-lg-right pt-2"
                                       for="textareaDefault">Receive Qty</label>

                                <div class="col-lg-8">
                                    <input class="form-control" type="text" name="fqty" data-plugin-maxlength
                                           maxlength="200" required value="<?php echo $plan["finished_qty"]; ?>"/>

                                </div>

                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 control-label text-lg-right pt-2">Warehouse Location</label>

                                <div class="col-lg-8">
                                    <select name="house1" id="house1" data-plugin-selectTwo
                                            class="form-control populate" style="width: 100%" required>
                                        <?php
                                        echo "<option value=''>------- Select --------</option>";
                                        while ($row = mysqli_fetch_assoc($warehouse)) {
                                            ?>
                                            <option
                                                value='<?php echo $row["id"]; ?>'><?php echo $row["title"]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>


                        </div>

                        <div id="w1-profile" class="tab-pane p-3">
                            <?php
                            $bom = find_ProductionBom_by_item($plan["item_id"]);
                            $output = "";

                            for ($k = 0; $k < sizeof(json_decode($bom["raw_item_id"])); $k++) {
                                if (!empty(json_decode($bom["raw_item_id"])[$k]) && !empty(json_decode($bom["raw_quantity"])[$k])) {
                                    $output .= '<div class="form-group row" style="margin-bottom: 5px;">';
                                    $output .= '<label class="col-lg-4 control-label text-lg-right pt-2">' .
                                        find_product_by_id(json_decode($bom["raw_item_id"])[$k])["title"] .
                                        '</label>';
                                    $output .= '<div class="col-lg-8">';
                                    $output .= '<input type="text" class="form-control" data-plugin-maxlength maxlength="100" required name="return_' . find_product_by_id(json_decode($bom["raw_item_id"])[$k])["id"] . '"/>';
                                    $output .= '</div> </div>';
                                }
                            }
                            echo $output;
                            ?>

                            <div class="form-group row">
                                <label class="col-lg-4 control-label text-lg-right pt-2">Warehouse Location</label>

                                <div class="col-lg-8">
                                    <select name="house2" id="house2" data-plugin-selectTwo
                                            class="form-control populate" style="width: 100%" required>
                                        <?php
                                        echo "<option value=''>------- Select --------</option>";
                                        while ($row = mysqli_fetch_assoc($warehouse1)) {
                                            ?>
                                            <option
                                                value='<?php echo $row["id"]; ?>'><?php echo $row["title"]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                        </div>


                        <div id="w1-confirm" class="tab-pane p-3">
                            <?php
                            $bom = find_ProductionBom_by_item($plan["item_id"]);
                            $output = "";

                            for ($k = 0; $k < sizeof(json_decode($bom["raw_item_id"])); $k++) {
                                if (!empty(json_decode($bom["raw_item_id"])[$k]) && !empty(json_decode($bom["raw_quantity"])[$k])) {
                                    $output .= '<div class="form-group row" style="margin-bottom: 5px;">';
                                    $output .= '<label class="col-lg-4 control-label text-lg-right pt-2">' .
                                        find_product_by_id(json_decode($bom["raw_item_id"])[$k])["title"] .
                                        '</label>';
                                    $output .= '<div class="col-lg-8">';
                                    $output .= '<input type="text" class="form-control" data-plugin-maxlength maxlength="100" required
                                                    name="damage_' . find_product_by_id(json_decode($bom["raw_item_id"])[$k])["id"] . '"/>';
                                    $output .= '</div> </div>';
                                }
                            }
                            echo $output;
                            ?>

                            <div class="form-group row">
                                <label class="col-lg-4 control-label text-lg-right pt-2">Warehouse Location</label>

                                <div class="col-lg-8">
                                    <select name="house3" id="house3" data-plugin-selectTwo
                                            class="form-control populate" style="width: 100%" required>
                                        <?php
                                        echo "<option value=''>------- Select --------</option>";
                                        while ($row = mysqli_fetch_assoc($warehouse2)) {
                                            ?>
                                            <option
                                                value='<?php echo $row["id"]; ?>'><?php echo $row["title"]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input class="float-right btn btn-success" type="submit"
                                           value="Complete Production Plan" name="submit">
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
                    <!--                    <li class="finish hidden float-right">-->
                    <!--                        <a>Finish</a>-->
                    <!--                    </li>-->
                    <li class="next">
                        <a>Next <i class="fa fa-angle-right"></i></a>
                    </li>
                </ul>
            </div>

            <div class="form-group row">
                <div class="col-sm-8 text-left ml-3 mb-5">
                    <a href="inventoryRequest.php" class=" btn btn-success">Back</a>
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
    var $cat = $("#cate");
    var $sub_cat = $("#sub_cate");
    var $attribute = $("#w1-confirm");

    $(document).ready(function () {
        $cat.change(function () {

            var cla = $(this).val();

            $.ajax({
                url: "test/subCategory.php",
                data: {category: cla},
                type: "POST",
                success: function (response) {
                    var resp = $.trim(response);
                    $sub_cat.html(resp);
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