<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$k = 1;
$customer = find_all_customer();
$category = find_all_logistic_categories();

if (isset($_POST["submit"])) {
    if (isset($_POST["title"]) && isset($_POST["plate"]) && isset($_POST["c_id"]) && isset($_POST["cate"])) {

        $title = $_POST["title"];
        $plate_no = $_POST["plate"];
        $c_id = $_POST["c_id"];
        $d_name = $_POST["d_name"];
        $d_number = str_replace('-', '', substr($_POST["d_number"], 5));
        $cate = $_POST["cate"];

        create_vehicle($title, $plate_no, $c_id, $d_name, $d_number, $cate);
    } else {
        $_SESSION["art_error"] = "Please Fill All Fields ";
    }
}
include_once("header.php")
?>
<section role="main" class="content-body card-margin">
    <header class="page-header">
        <h2>Vehicle</h2>

        <div class="right-wrapper text-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Vehicle</span></li>
            </ol>

        </div>
    </header>

    <!-- start: page -->
    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">

                    <h2 class="card-title">Create Vehicle</h2>
                </header>
                <div class="card-body">
                    <?php echo art_message(); ?>
                    <form class="form-horizontal form-bordered" action="#" method="post" enctype='multipart/form-data'>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Title</label>

                            <div class="col-lg-4">
                                <input type="text" name="title" class="form-control" data-plugin-maxlength
                                       maxlength="200" required/>

                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Plate Number</label>

                            <div class="col-lg-4">
                                <input type="text" name="plate" class="form-control" data-plugin-maxlength
                                       maxlength="200" required/>

                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Customer Name</label>

                            <div class="col-lg-4">
                                <select name="c_id" id="c_id" data-plugin-selectTwo class="form-control populate"
                                        required>
                                    <option value="">------- Select --------</option>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($customer)) {
                                        ?>
                                        <option
                                            value="<?php echo $row["id"] ?>"><?php echo $row["name"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Driver Name</label>

                            <div class="col-lg-4">
                                <input type="text" name="d_name" class="form-control" data-plugin-maxlength
                                       maxlength="200" required/>

                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Driver Number</label>

                            <div class="col-lg-4">
                                <div class="input-group">
                                    <span class="input-group-addon"> <i class="fa fa-phone"></i> </span>
                                    <input type="text" name="d_number"
                                           data-plugin-masked-input data-input-mask="(99)-9999-9999"
                                           placeholder="(09)-1234-1234" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Logistic Category</label>

                            <div class="col-lg-4">
                                <select name="cate" id="cate" data-plugin-selectTwo class="form-control populate">
                                    <option value="">------- Select --------</option>
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
                            <div class="col-lg-6">
                                <a href="vehicle.php">
                                    <button type="button" style="float: right" class="mb-1 mt-1 mr-1 btn btn-info">
                                        Cancel
                                    </button>
                                </a>
                                <input type="submit" name="submit" style="float: right"
                                       class="mb-1 mt-1 mr-1 btn btn-success"
                                       value="Create Vehicle">
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