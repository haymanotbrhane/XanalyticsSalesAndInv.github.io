<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$k = 1;
if (isset($_POST["submit"])) {
    if (isset($_POST["title"]) && isset($_POST["starting"]) && isset($_POST["end"])) {

        $title = $_POST["title"];
        $starting = $_POST["starting"];
        $end = $_POST["end"];
        $user_id = $_SESSION["admin_id"];

        create_productionShift($title, $starting, $end, $user_id);
    } else {
        $_SESSION["art_error"] = "Please Fill Required Fields ";
    }
}
include_once("header.php")
?>
<section role="main" class="content-body card-margin">
    <header class="page-header">
        <h2>Production Shift</h2>

        <div class="right-wrapper text-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Production Shift</span></li>
            </ol>

        </div>
    </header>

    <!-- start: page -->
    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">

                    <h2 class="card-title">Create Production Shift</h2>
                </header>
                <div class="card-body">
                    <?php echo art_message(); ?>
                    <form class="form-horizontal form-bordered" action="#" method="post">

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Title</label>

                            <div class="col-lg-4">
                                <input type="text" name="title" class="form-control" data-plugin-maxlength
                                       maxlength="200" required/>

                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Starting Time</label>

                            <div class="col-lg-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </span>
                                    <input type="text" data-plugin-timepicker class="form-control" name="starting"
                                           data-plugin-options='{ "showMeridian": false }'>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">End Time</label>

                            <div class="col-lg-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </span>
                                    <input type="text" data-plugin-timepicker class="form-control" name="end"
                                           data-plugin-options='{ "showMeridian": false }'>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-lg-6">
                                <a href="productionShift.php">
                                    <button type="button" style="float: right" class="mb-1 mt-1 mr-1 btn btn-info">
                                        Cancel
                                    </button>
                                </a>
                                <input type="submit" name="submit" style="float: right"
                                       class="mb-1 mt-1 mr-1 btn btn-success"
                                       value="Create Production Shift">
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

</script>

</body>

</html>