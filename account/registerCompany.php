<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$sub = find_all_subcity();
$city = find_all_city();
if (isset($_POST["submit"])) {
    if (isset($_POST["cname"]) && isset($_POST["city"])) {

        $logo = "";
        $imgFile = basename($_FILES["logo"]["name"]);

        if ($_FILES["logo"]["name"] != '') {
            // Select file type
            $imageFileType = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION));

            // Valid file extensions
            $extensions_arr = array("jpg", "jpeg", "png", "gif");

            $image_base64 = base64_encode(file_get_contents($_FILES['logo']['tmp_name']));
            $image = 'data:image/' . $imageFileType . ';base64,' . $image_base64;

            $logo = $image;
        }

        $cname = $_POST["cname"];
        $city = $_POST["city"];
        $subcity = $_POST["subcity"];
        $wereda = $_POST["woreda"];
        $kebele = $_POST["kebele"];
        $hnumber = $_POST["hnumber"];
        $olocation = $_POST["olocation"];
        $mnumber = str_replace('-', '', substr($_POST["mobilephone"], 5));
        $onumber = $_POST["onumber"];
        $email = $_POST["email"];

        create_company_by_user($cname, $city, $subcity, $wereda, $kebele, $hnumber, $olocation, $mnumber, $onumber, $email, $logo);
        redirect_to("login.php");
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

                                    <h3 class="card-title" style="text-align: center;margin-bottom: 25px">Create Company
                                        Account</h3>
                                </header>
                                <div class="card-body">
                                    <?php echo art_message(); ?>
                                    <form class="form-horizontal form-bordered" action="#" method="post"
                                          enctype='multipart/form-data'>

                                        <div class="form-group row">
                                            <label class="col-lg-4 control-label text-lg-right pt-2">Company
                                                Name</label>

                                            <div class="col-lg-6">
                                                <input type="text" name="cname" class="form-control"
                                                       data-plugin-maxlength
                                                       maxlength="200" required/>

                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 control-label text-lg-right pt-2">City</label>

                                            <div class="col-lg-6">
                                                <select name="city" id="city" data-plugin-selectTwo
                                                        class="form-control populate" required>
                                                    <option value="">------- Select --------</option>
                                                    <?php
                                                    while ($row = sqlsrv_fetch_array($city, SQLSRV_FETCH_ASSOC)) {
                                                        ?>
                                                        <option
                                                            value="<?php echo $row["CityID"] ?>"><?php echo $row["City"]; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 control-label text-lg-right pt-2">Sub City</label>

                                            <div class="col-lg-6">
                                                <select name="subcity" id="subcity" data-plugin-selectTwo
                                                        class="form-control populate">
                                                    <option value="">------- Select --------</option>
                                                    <?php
                                                    while ($row = sqlsrv_fetch_array($sub, SQLSRV_FETCH_ASSOC)) {
                                                        ?>
                                                        <option
                                                            value="<?php echo $row["SubCityID"] ?>"><?php echo $row["SubCity"]; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 control-label text-lg-right pt-2">Woreda</label>

                                            <div class="col-lg-6">
                                                <input type="text" name="woreda" class="form-control"
                                                       data-plugin-maxlength
                                                       maxlength="200"/>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 control-label text-lg-right pt-2">Kebele</label>

                                            <div class="col-lg-6">
                                                <input type="text" name="kebele" class="form-control"
                                                       data-plugin-maxlength
                                                       maxlength="200"/>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 control-label text-lg-right pt-2">House
                                                Number</label>

                                            <div class="col-lg-6">
                                                <input type="text" name="hnumber" class="form-control"
                                                       data-plugin-maxlength
                                                       maxlength="200"/>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 control-label text-lg-right pt-2">Office
                                                Location</label>

                                            <div class="col-lg-6">
                                                <input type="text" name="olocation" class="form-control"/>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 control-label text-lg-right pt-2">Mobile
                                                Phone</label>

                                            <div class="col-lg-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon"> <i class="fa fa-phone"></i> </span>
                                                    <input type="text" name="mobilephone"
                                                           data-plugin-masked-input data-input-mask="(99)-9999-9999"
                                                           placeholder="(09)-1234-1234" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 control-label text-lg-right pt-2">Other Telephone
                                                Numbers</label>

                                            <div class="col-lg-6">
                                                <input type="text" name="onumber" class="form-control"/>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 control-label text-lg-right pt-2">E-Mail</label>

                                            <div class="col-lg-6">
                                                <input type="text" name="email" class="form-control"
                                                       data-plugin-maxlength
                                                       maxlength="200"/>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 control-label text-lg-right pt-2">Logo</label>

                                            <div class="col-lg-6">
                                                <input type="file" name="logo" class="form-control"/>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-8">
                                                <input type="submit" name="submit" style="float: right"
                                                       class="mb-1 mt-1 mr-1 btn btn-success"
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
<script>

    $(document).ready(function () {
        $("#city").change(function () {
            var city = $(this).val();
            $.ajax({
                url: "../admin/test/SubCity.php",
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