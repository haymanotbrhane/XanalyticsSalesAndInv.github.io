<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$item = find_ProductionPlan_by_id($_GET["id"]);
$bom = find_ProductionBom_by_item($item["item_id"]);
$k = 1;
if (isset($_POST["submit"])) {
    if (isset($_POST["pr_qty"])) {

        $id = $item["id"];
        $user_id = $_SESSION["admin_id"];
        $f_qty = $_POST["pr_qty"];
        $d_qty = array();
        $r_qty = array();

        for ($k = 0; $k < sizeof(json_decode($bom["raw_item_id"])); $k++) {
            if (!empty(json_decode($bom["raw_item_id"])[$k]) && !empty(json_decode($bom["raw_quantity"])[$k])) {

                $d_qty["" . find_product_by_id(json_decode($bom["raw_item_id"])[$k])["id"] . ""] = $_POST["damage_" . find_product_by_id(json_decode($bom["raw_item_id"])[$k])["id"] . ""];
            }
        }

        for ($k = 0; $k < sizeof(json_decode($bom["raw_item_id"])); $k++) {
            if (!empty(json_decode($bom["raw_item_id"])[$k]) && !empty(json_decode($bom["raw_quantity"])[$k])) {

                $r_qty["" . find_product_by_id(json_decode($bom["raw_item_id"])[$k])["id"] . ""] = $_POST["return_" . find_product_by_id(json_decode($bom["raw_item_id"])[$k])["id"] . ""];
            }
        }
        $d_qty = json_encode($d_qty);
        $r_qty = json_encode($r_qty);

        $query = "update `production_plan` set `finished_qty` = {$f_qty}, `damage_qty` = '{$d_qty}', `return_qty` = '{$r_qty}', production_status = 1 where id = {$id};";
        $result_set = mysqli_query($connection, $query);

        if ($result_set) {
            // Success
            $_SESSION["art_message"] = "Production Completed.";
            redirect_to("productionPlan.php");

        } else {
            // Failure
            $_SESSION["art_error"] = "Please try again.";
        }

    } else {
        $_SESSION["art_error"] = "Please Fill Required Fields ";
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
        <div class="col">
            <section class="card">
                <header class="card-header">

                    <h2 class="card-title">Complete Production Plan
                        ( <?php echo $item["production_date"] . ' / ' .
                            find_ProductionShift_by_id($item["shift_id"])["title"] . ' / ' .
                            find_ProductionLine_by_id($item["line_id"])["title"] ?>
                        )
                    </h2>
                </header>
                <div class="card-body">
                    <?php echo art_message(); ?>

                    <div class="card-body" style="padding: 10px;">
                        <form class="form-horizontal form-bordered" action="#" method="post">
                            <div class="form-group row" style="margin-bottom: 5px;">
                                <label class="col-lg-2 control-label text-lg-right pt-2">Produced Quantity</label>

                                <div class="col-lg-4">
                                    <input type="text" name="pr_qty" id="pr_qty" class="form-control"
                                           data-plugin-maxlength maxlength="100" required/>
                                </div>
                            </div>

                            <div class="form-group row" style="padding-bottom: 0 !important;margin-bottom: 0">
                                <label class="col-lg-6 control-label text-lg-right pt-1"
                                       style="text-align: center !important;font-weight: bolder;text-decoration: underline;">Damage
                                    Quantity</label>

                            </div>
                            <?php

                            for ($k = 0; $k < sizeof(json_decode($bom["raw_item_id"])); $k++) {
                                if (!empty(json_decode($bom["raw_item_id"])[$k]) && !empty(json_decode($bom["raw_quantity"])[$k])) {
                                    echo '<div class="form-group row" style="margin-bottom: 5px;">';
                                    echo '<label class="col-lg-2 control-label text-lg-right pt-2">' . find_product_by_id(json_decode($bom["raw_item_id"])[$k])["title"] . '</label>';
                                    echo '<div class="col-lg-4">';
                                    echo '<input type="text"  class="form-control" data-plugin-maxlength maxlength="100" required name="damage_' . find_product_by_id(json_decode($bom["raw_item_id"])[$k])["id"] . '"/>';
                                    echo '</div> ';
                                    echo '</div> ';
                                }
                            }?>

                            <div class="form-group row" style="padding-bottom: 0 !important;margin-bottom: 0">
                                <label class="col-lg-6 control-label text-lg-right pt-2"
                                       style="text-align: center !important;font-weight: bolder;text-decoration: underline;">
                                    Return Quantity
                                </label>
                            </div>
                            <?php
                            for ($k = 0; $k < sizeof(json_decode($bom["raw_item_id"])); $k++) {
                                if (!empty(json_decode($bom["raw_item_id"])[$k]) && !empty(json_decode($bom["raw_quantity"])[$k])) {
                                    echo '<div class="form-group row" style="margin-bottom: 5px;">';
                                    echo '<label class="col-lg-2 control-label text-lg-right pt-2">' . find_product_by_id(json_decode($bom["raw_item_id"])[$k])["title"] . '</label>';
                                    echo '<div class="col-lg-4">';
                                    echo '<input type="text"  class="form-control" data-plugin-maxlength maxlength="100" required name="return_' . find_product_by_id(json_decode($bom["raw_item_id"])[$k])["id"] . '"/>';
                                    echo '</div> ';
                                    echo '</div> ';
                                }
                            }
                            ?>

                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <a href="productionPlan.php">
                                        <button type="button" style="float: right" class="mb-1 mt-1 mr-1 btn btn-info">
                                            Cancel
                                        </button>
                                    </a>
                                    <input type="submit" name="submit" style="float: right"
                                           class="mb-1 mt-1 mr-1 btn btn-success"
                                           value="Complete Production Plan">
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <br>

                        </form>
                    </div>

                </div>
            </section>
        </div>
    </div>

    <!--end: page-->
</section>
</div >

</section >

<!--Vendor -->
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

<!--Specific Page Vendor-->
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

<!--Theme Base, Components and Settings-->
<script src="js/theme.js"></script>

<!--Theme Custom-->
<script src="js/custom.js"></script>

<!--Theme Initialization Files-->
<script src="js/theme.init.js"></script>
<script src="js/examples/examples.advanced.form.js"></script>

<script>
    $(document).ready(function () {
        $("#pro").change(function () {
            var
                pro = $(this).val();
            $.ajax({
                url: "test/JobCategory.php",
                data: {
                    pro_id: pro
                },
                type: 'POST',
                success: function (response) {
                    var
                        resp = $.trim(response);
                    $("#parent").html(resp);
                }
            });
        });
    });

</script>

</body >

</html >

<script>

    $.ajax({
        type: "POST",
        url: "generated/production.php",
        data: "productionPlan=" + bom,
        success: function (response) {
            var
                resp = $.trim(response);
            $("#completproduction").html(resp);
        }

    });

</script>

</body >

</html >