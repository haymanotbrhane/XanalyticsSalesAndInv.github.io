<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$k = 7;
$branchs = find_all_branch();

if (isset($_POST["submit"])) {

    if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["pass"])) {
        $pass = trim($_POST["pass"]);
        $compass = trim($_POST["compass"]);
        if ($pass === $compass) {
            $email = trim($_POST["email"]);
            $check = find_user_by_username($email);
            if (empty($check)) {
                $name = trim($_POST["name"]);
                $branch = trim($_POST["branch"]);
                $photo = "";
                $role = trim($_POST["role"]);
                $phone = str_replace("-", "", substr(trim($_POST["phone"]), 5));
                $pass = password_encrypt(trim($_POST["pass"]));

                create_user($name, $email, $phone, $photo, $pass, $role, $branch);
            } else {
                $_SESSION["art_error"] = 'Use Other E-mail.';
            }
        } else {
            $_SESSION["art_error"] = 'Password is not match.';
        }
    } else {
        $_SESSION["art_error"] = "Please Fill All Fields ";
    }
}
include_once("header.php")
?>
<section role="main" class="content-body card-margin">
    <header class="page-header">
        <h2>User</h2>

        <div class="right-wrapper text-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li style="margin-right: 25px"><span>CreateUser</span></li>
            </ol>

        </div>
    </header>

    <!-- start: page -->
    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">

                    <h2 class="card-title">Create User</h2>
                </header>
                <div class="card-body">
                    <?php echo art_message(); ?>
                    <form class="form-horizontal form-bordered" method="post" action="#" enctype='multipart/form-data'>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2" for="textareaDefault">User
                                Name</label>

                            <div class="col-lg-4">
                                <input name="name" type="text" class="form-control" data-plugin-maxlength
                                       maxlength="50"/>

                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2"
                                   for="textareaDefault">E-mail</label>

                            <div class="col-lg-4">
                                <input class="form-control" type="email" name="email" data-plugin-maxlength
                                       maxlength="50"/>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Mobile Phone</label>

                            <div class="col-lg-4">
                                <div class="input-group">
                                    <span class="input-group-addon"> <i class="fa fa-phone"></i> </span>
                                    <input name="phone" id="phone" data-plugin-masked-input
                                           data-input-mask="(99)-9999-9999"
                                           placeholder="(09)-1234-1234"
                                           class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Role</label>

                            <div class="col-lg-4">
                                <select name="role" data-plugin-selectTwo class="form-control populate">
                                    <option value="admin">Admin</option>
                                    <option value="finance">Finance</option>
                                    <option value="cashier">Cashier</option>
                                    <option value="stock_keeper">Stock Keeper</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2">Office Branch</label>

                            <div class="col-lg-4">
                                <select name="branch" id="branch" data-plugin-selectTwo
                                        class="form-control populate" style="width: 100%">
                                    <?php
                                    echo "<option value=''>Select Branch</option>";
                                    while ($row = mysqli_fetch_assoc($branchs)) {
                                        ?>
                                        <option
                                            value='<?php echo $row["id"]; ?>'><?php echo $row["title"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2"
                                   for="textareaDefault">Password</label>

                            <div class="col-lg-4">
                                <input type="password" name="pass" class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2"
                                   for="textareaDefault">Confirm Password</label>

                            <div class="col-lg-4">
                                <input type="password" name="compass" class="form-control"/>

                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <a href="users.php">
                                    <button type="button" style="float: right" class="mb-1 mt-1 mr-1 btn btn-info">
                                        Cancel
                                    </button>
                                </a>
                                <input type="submit" name="submit" style="float: right"
                                       class="mb-1 mt-1 mr-1 btn btn-success"
                                       value="Create User Account">
                            </div>
                        </div>

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