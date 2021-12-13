<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$k = 1;
$response = find_order_response_by_id($_GET["id"]);
$request = find_order_request_by_id($response["order_id"])["reference_number"];
$product = find_all_product();

if ($response["status"] == 1) {
    $_SESSION["art_error"] = "This response is already loaded.";
    redirect_to("orderResponse.php");
}

if (isset($_POST["submit"])) {
    if (isset($_POST["p_id"]) && isset($_POST["qyt"])) {

        $p_id = trim($_POST["p_id"]);
        $qyt = trim($_POST["qyt"]);
        $dep = trim($_POST["departure"]);
        $des = trim($_POST["destination"]);
        $u_id = $_SESSION["admin_id"];

        $id = $response["id"];
        $query = "UPDATE isiv SET ";
        $query .= "product_id = {$p_id}";
        $query .= ",quantity = {$qyt} ";
        $query .= ",departure = '{$dep}' ";
        $query .= ",destination = '{$des}' ";
        $query .= ",user_id = {$u_id} ";
        $query .= "WHERE id = {$id}; ";
        $result = mysqli_query($connection, $query);

        if ($result) {
            // Success
            $_SESSION["art_message"] = "Successfully Updated";

            redirect_to("orderResponse.php");

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
        <h2>Order Response</h2>

        <div class="right-wrapper text-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Order Response</span></li>
            </ol>

        </div>
    </header>

    <!-- start: page -->
    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">

                    <h2 class="card-title">Update Order Response</h2>
                </header>
                <div class="card-body">
                    <?php echo art_message(); ?>
                    <form class="form-horizontal form-bordered" action="#" method="post" enctype='multipart/form-data'>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Order Reference No</label>

                            <div class="col-lg-4">
                                <input type="text" name="o_ref" class="form-control" data-plugin-maxlength
                                       maxlength="200" value="<?php echo $request; ?>" disabled />

                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Reference Number</label>

                            <div class="col-lg-4">
                                <input type="text" name="ref" class="form-control" data-plugin-maxlength
                                       maxlength="200" value="<?php echo $response["reference_number"]; ?>" disabled />

                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Item Description</label>

                            <div class="col-lg-4">
                                <select name="p_id" id="p_id" data-plugin-selectTwo class="form-control populate">
                                    <option value="">------- Select --------</option>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($product)) {
                                        ?>
                                        <option <?php echo ($row["id"] === $response["product_id"]) ? 'selected' : ""; ?>
                                            value="<?php echo $row["id"] ?>"><?php echo $row["title"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Quantity</label>

                            <div class="col-lg-4">
                                <input type="text" name="qyt" class="form-control" data-plugin-maxlength
                                       maxlength="200" required value="<?php echo $response["quantity"]; ?>"/>

                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Departure</label>

                            <div class="col-lg-4">
                                <select name="departure" data-plugin-selectTwo class="form-control populate">
                                    <option value="agena" <?php echo $response["departure"]==="agena"?"selected":""; ?> >Agena</option>
                                    <option value="addis ababa" <?php echo $response["departure"]==="addis ababa"?"selected":""; ?> >Addis Ababa</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Destination</label>

                            <div class="col-lg-4">
                                <select name="destination" data-plugin-selectTwo class="form-control populate">
                                    <option value="addis ababa" <?php echo $response["destination"]==="addis ababa"?"selected":""; ?> >Addis Ababa</option>
                                    <option value="agena" <?php echo $response["destination"]==="agena"?"selected":""; ?> >Agena</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <a href="orderResponse.php">
                                    <button type="button" style="float: right" class="mb-1 mt-1 mr-1 btn btn-info">
                                        Cancel
                                    </button>
                                </a>
                                <input type="submit" name="submit" style="float: right"
                                       class="mb-1 mt-1 mr-1 btn btn-success"
                                       value="Update Order Response">
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

<script>

    $(document).ready(function () {
        $("#city").change(function () {
            var city = $(this).val();
            $.ajax({
                url: "test/SubCity.php",
                data: {c_id: city},
                type: 'POST',
                success: function (response) {
                    var resp = $.trim(response);
                    $("#subcity").html(resp);
                }
            });
        });
    });

</script>

</body>

</html>