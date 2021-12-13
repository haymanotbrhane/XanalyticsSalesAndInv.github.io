<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
if (isset($_POST['submit'])) {
    // Process the form
    // validations
    $required_fields = array("firstname", "middlename", 'phone');
    validate_presences($required_fields);
    if (empty($errors)) {

        // Perform Update
        $fname = sqlsrv_escape($_POST["firstname"]);
        $fnameam = sqlsrv_escape($_POST["firstnameam"]);
        $mname = sqlsrv_escape($_POST["middlename"]);
        $mnameam = sqlsrv_escape($_POST["middlenameam"]);
        $lname = sqlsrv_escape($_POST["lastname"]);
        $lnameam = sqlsrv_escape($_POST["lastnameam"]);
        $gender = sqlsrv_escape($_POST["gender"]);
        $email = sqlsrv_escape($_POST["email"]);
        $phone = sqlsrv_escape(str_replace('-','',substr($_POST["phone"], 5)));
        $lang = sqlsrv_escape($_POST["language"]);
        $birth = sqlsrv_escape($_POST["dateofbirth"]);

        create_user($fname,$fnameam,$mname,$mnameam,$lname,$lnameam,$phone,$gender,$email,$lang,$birth);
    } else {
        $_SESSION["art_error"] = "Please Fill All Fields ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Yihew Job and Tender</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="boot/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="boot/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">

    <!-- Styles -->
    <link href="styles/login_layout.css" rel="stylesheet" type="text/css">
    <link href="styles/elements.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,500,600,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="boot/css/jquery-ui.css"/>

    <!-- Favicon: http://realfavicongenerator.net -->
    <link rel="apple-touch-icon" sizes="76x76" href="../img/logo.png">
    <link rel="icon" type="image/png" href="../img/logo.png" sizes="32x32">
    <link rel="icon" type="image/png" href="../img/logo.png" sizes="16x16">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="../admin/vendor/font-awesome/css/font-awesome.css"/>
    <link rel="stylesheet" href="../admin/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css"/>

    <link rel="stylesheet" href="../admin/vendor/select2/css/select2.css"/>
    <link rel="stylesheet" href="../admin/vendor/select2-bootstrap-theme/select2-bootstrap.min.css"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="container">
                <div class="row">
                    <div class="col-md-8 center-block-e">

                        <div class="login-form">
                            <div class="login-form-inner">
                                <p class="login-form-intro"><img src="../img/logo2.png" width="250"></p>

                                <header class="card-header">
                                    <div class="card-actions">
                                    </div>

                                    <h3 class="card-title" style="text-align: center;margin-bottom: 25px">Create User
                                        Account</h3>
                                </header>
                                <div class="card-body">
                                    <?php echo art_message(); ?>
                                    <form class="form-horizontal form-bordered" action="#" method="post">

                                        <div class="form-group row">
                                            <label class="col-lg-2 control-label text-lg-right pt-2" for="textareaDefault">Fist
                                                Name</label>

                                            <div class="col-lg-4">
                                                <input type="text" required name="firstname" class="form-control" data-plugin-maxlength maxlength="100"/>

                                            </div>

                                            <label class="col-lg-2 control-label text-lg-right pt-2" for="textareaDefault">የራስ
                                                ስም</label>

                                            <div class="col-lg-4">
                                                <input type="text" name="firstnameam" class="form-control" data-plugin-maxlength maxlength="100"/>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-2 control-label text-lg-right pt-2" for="textareaDefault">Middle
                                                Name</label>

                                            <div class="col-lg-4">
                                                <input type="text" required name="middlename" class="form-control" data-plugin-maxlength maxlength="100"/>

                                            </div>

                                            <label class="col-lg-2 control-label text-lg-right pt-2" for="textareaDefault">የአባት
                                                ስም</label>

                                            <div class="col-lg-4">
                                                <input type="text" name="middlenameam" class="form-control" data-plugin-maxlength maxlength="100"/>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-2 control-label text-lg-right pt-2" for="textareaDefault">Last
                                                Name</label>

                                            <div class="col-lg-4">
                                                <input type="text" name="lastname" class="form-control" data-plugin-maxlength maxlength="100"/>

                                            </div>

                                            <label class="col-lg-2 control-label text-lg-right pt-2" for="textareaDefault">የአያት
                                                ስም</label>

                                            <div class="col-lg-4">
                                                <input type="text" name="lastnameam" class="form-control" data-plugin-maxlength maxlength="100"/>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-2 control-label text-lg-right pt-2">Mobile
                                                Phone</label>

                                            <div class="col-lg-4">
                                                <div class="input-group">
                                                    <span class="input-group-addon"> <i class="fa fa-phone"></i> </span>
                                                    <input id="phone" name="phone" data-plugin-masked-input
                                                           data-input-mask="(99)-9999-9999"
                                                           placeholder="(09)-1234-1234"
                                                           class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-2 control-label text-lg-right pt-2"
                                                   for="textareaDefault">E-mail</label>

                                            <div class="col-lg-4">
                                                <input type="email" name="email"  class="form-control"/>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-2 control-label text-lg-right pt-2">Gender</label>

                                            <div class="col-lg-4">
                                                <select name="gender"  data-plugin-selectTwo class="form-control populate">
                                                    <option value="0">Men</option>
                                                    <option value="1">Women</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-2 control-label text-lg-right pt-2">Language</label>

                                            <div class="col-lg-4">
                                                <select  name="language" data-plugin-selectTwo class="form-control populate">
                                                    <option value="1">English</option>
                                                    <option value="2">Amharic</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-2 control-label text-lg-right pt-2">Date Of
                                                Birth</label>

                                            <div class="col-lg-4">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i
                                                            class="fa fa-calendar"></i></span>
                                                    <input name="dateofbirth"  type="text" data-plugin-datepicker class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <input type="submit" name="submit" style="float: right" class="mb-1 mt-1 mr-1 btn btn-success"
                                                       value="Register">
                                            </div>
                                        </div>

                                        <hr>
                                        <p>Already have an account?</p>

                                        <p class="decent-margin align-center"><a href="login.php">Back To Login</a></p>
                                        <br>
                                        <br>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../admin/vendor/jquery/jquery.js"></script>
<script src="../admin/vendor/popper/umd/popper.min.js"></script>
<script src="../admin/vendor/bootstrap/js/bootstrap.js"></script>
<script src="../admin/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../admin/vendor/common/common.js"></script>
<script src="../admin/vendor/jquery-maskedinput/jquery.maskedinput.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="../admin/js/theme.js"></script>

<!-- Theme Custom -->
<script src="../admin/js/custom.js"></script>

<!-- Theme Initialization Files -->
<script src="../admin/js/theme.init.js"></script>

</body>

</html>