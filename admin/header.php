<?php
confirm_logged_in();
?>
<!doctype html>
<html class="fixed">

<head>

    <!-- Basic -->
    <meta charset="UTF-8">

    <title>Jub Trading PLC.</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../account/images/logoXA.jpg" type="image/x-icon"/>

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light"
          rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" href="vendor/animate/animate.css">

    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.css"/>
    <link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.css"/>
    <link rel="stylesheet" href="vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css"/>

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="vendor/pnotify/pnotify.custom.css"/>

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="vendor/jquery-ui/jquery-ui.css"/>
    <link rel="stylesheet" href="vendor/jquery-ui/jquery-ui.theme.css"/>
    <link rel="stylesheet" href="vendor/bootstrap-multiselect/bootstrap-multiselect.css"/>
    <link rel="stylesheet" href="vendor/morris/morris.css"/>

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="vendor/chartist/chartist.min.css"/>

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="vendor/select2/css/select2.css"/>
    <link rel="stylesheet" href="vendor/select2-bootstrap-theme/select2-bootstrap.min.css"/>
    <link rel="stylesheet" href="vendor/datatables/media/css/dataTables.bootstrap4.css"/>

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="vendor/bootstrap-tagsinput/bootstrap-tagsinput.css"/>
    <link rel="stylesheet" href="vendor/bootstrap-timepicker/css/bootstrap-timepicker.css"/>
    <link rel="stylesheet" href="vendor/dropzone/basic.css"/>
    <link rel="stylesheet" href="vendor/dropzone/dropzone.css"/>
    <link rel="stylesheet" href="vendor/bootstrap-markdown/css/bootstrap-markdown.min.css"/>
    <link rel="stylesheet" href="vendor/summernote/summernote-bs4.css"/>
    <link rel="stylesheet" href="vendor/codemirror/lib/codemirror.html"/>
    <link rel="stylesheet" href="vendor/codemirror/theme/monokai.html"/>

    <!-- Theme CSS -->
    <link rel="stylesheet" href="css/theme.css"/>

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="css/custom.css">

    <!-- Head Libs -->
    <script src="vendor/modernizr/modernizr.js"></script>
    <script src="master/style-switcher/style.switcher.localstorage.js"></script>

    <style type="text/css">
        .modal-open .select2-container--open {
            z-index: 999999 !important;
        }

        .modal-open .select2-dropdown {
            z-index: 10060 !important;
        }

        .modal-open .select2-close-mask {
            z-index: 10055 !important;
        }
    </style>
</head>
<body>
<section class="body">

<!-- start: header -->
<header class="header row" style="background: black;border: none;border-bottom: 2px white solid;">

    <div class="logo-container col-lg-3">
        <a href="#" class="logo" style="margin-top: 0;height: 100%">
            <img src="../account/images/logoXA.jpg" style="height: 100%" alt="Admin"/>
        </a>

        <div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html"
             data-fire-event="sidebar-left-opened"><i class="fa fa-bars" aria-label="Toggle sidebar"></i></div>
    </div>

    <div class="col-lg-5">

    </div>
    <!-- start: search & user box -->
    <div class="header-right col-lg-4">

        <div id="userbox" class="userbox float-right border"
             style="margin-right: 15%;padding: 8px;border: 1px solid gray !important;">
            <a href="#" data-toggle="dropdown">
                <figure class="profile-picture">
                    <img src="img/%21logged-user.jpg" alt="Essey Water" class="rounded-circle"
                         data-lock-picture="img/%21logged-user.jpg"/>
                </figure>
                <div class="profile-info">
                    <span class="name"
                          style="color: #fff;font-weight: bolder"><?php echo $_SESSION["username"]; ?></span>
                    <span class="role" style="color: #fff"><?php echo $_SESSION["role"]; ?></span>
                </div>

                <i class="fa custom-caret" style="color: #fff"></i>
            </a>

            <div class="dropdown-menu">
                <ul class="list-unstyled mb-2">
                    <li class="divider"></li>
                    <?php if ($_SESSION["role"] == "admin") { ?>
                        <li>
                            <a role="menuitem" tabindex="-1"
                               href="editUser.php?id=<?php echo $_SESSION['admin_id']; ?>"><i
                                    class="fa fa-user"></i>
                                My Profile</a>
                        </li>
                    <?php } ?>
                    <li>
                        <a role="menuitem" tabindex="-1" href="logout.php"><i class="fa fa-power-off"></i>
                            Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end: search & user box -->
</header>
<!-- end: header -->

<div class="inner-wrapper">
    <!-- start: sidebar -->
    <aside id="sidebar-left" class="sidebar-left">

        <div class="sidebar-header">
            <div class="sidebar-title" style="color: #0ff;font-weight: bold">
                Navigation
            </div>
            <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html"
                 data-fire-event="sidebar-left-toggle">
                <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
            </div>
        </div>

        <div class="nano">
            <div class="nano-content">
                <nav id="menu" class="nav-main" role="navigation">

                    <ul class="nav nav-main">
                        <?php if ($_SESSION["role"] == "admin") { ?>
                            <li>
                                <a class="nav-link" href="index.php">
                                    <i class="fa fa-home" aria-hidden="true"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
							
					
							
                        <?php
                        }
                        if ($_SESSION["role"] == "admin" || $_SESSION["role"] == "cashier" || $_SESSION["role"] == "finance") {
                            ?>
                            <!--companies-->
                            <li class="nav-parent <?php echo ($k == 4) ? " nav-expanded" : ""; ?>">
                                <a class="nav-link" href="#">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <span>Sales</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li>
                                        <a class="nav-link fa fa-link" href="pos.php">
                                            <span style="padding-left: 10px">Sales</span>
                                        </a>
                                    </li>
                                    <?php if ($_SESSION["role"] == "admin") { ?>
                                        <li>
                                            <a class="nav-link fa fa-link" href="sales.php">
                                                <span style="padding-left: 10px">Activity</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a class="nav-link fa fa-link" href="totalSales.php">
                                                <span style="padding-left: 10px">Summery</span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php
                        }
                        if ($_SESSION["role"] == "admin" || $_SESSION["role"] == "stock_keeper" || $_SESSION["role"] == "finance") {
                            ?>
                            <!--companies-->
                            <li class="nav-parent <?php echo ($k == 3) ? " nav-expanded" : ""; ?>">
                                <a class="nav-link" href="#">
                                    <i class="fa fa-stack-overflow" aria-hidden="true"></i>
                                    <span>Inventory</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li>
                                        <a class="nav-link fa fa-link" href="inv_activity.php">
                                            <span style="padding-left: 10px">Activity</span>
                                        </a>
                                    </li>
                                    <li class="nav-parent <?php echo ($j == 1) ? " nav-expanded" : ""; ?>">

                                        <a class="nav-link fa fa-link" href="#">
                                            <span style="padding-left: 10px">Inventory</span>
                                        </a>

                                        <ul class="nav nav-children">
                                            <li>
                                                <a class="nav-link fa fa-link" href="fgInventory.php">
                                                    <span style="padding-left: 10px">Finished Good</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="nav-link fa fa-link" href="rmInventory.php">
                                                    <span style="padding-left: 10px">Raw Material</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="nav-link fa fa-link" href="inventory.php">
                                                    <span style="padding-left: 10px">Damage Item</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </li>

                                </ul>

                            </li>
                        <?php
                        }
                        if ($_SESSION["role"] == "admin") {
                            ?>
                            <!--companies-->
                            <li class="nav-parent <?php echo ($k == 2) ? " nav-expanded" : ""; ?>">
                                <a class="nav-link" href="#">
                                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                    <span>Report</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li>
                                        <a class="nav-link fa fa-link" href="reports.php">
                                            <span style="padding-left: 10px">Report</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>


                            <!--Users-->
                            <li class="nav-parent <?php echo ($k == 6) ? " nav-expanded" : ""; ?>">
                                <a class="nav-link" href="#">
                                    <i class="fa fa-gear" aria-hidden="true"></i>
                                    <span>Configuration</span>
                                </a>
                                <ul class="nav nav-children">

                                    <li>
                                        <a class="nav-link fa fa-link" href="price.php">
                                            <span style="padding-left: 10px">Price List</span>
                                        </a>
                                    </li>
									
                                    <li>
                                        <a class="nav-link fa fa-link" href="pricecategories.php">
                                            <span style="padding-left: 10px">Price Category</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a class="nav-link fa fa-link" href="product.php">
                                            <span style="padding-left: 10px">Items</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a class="nav-link fa fa-link" href="categories.php">
                                            <span style="padding-left: 10px">Item Categories</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a class="nav-link fa fa-link" href="branch.php">
                                            <span style="padding-left: 10px">Branch/Warehouse</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <li class="nav-parent <?php echo ($k == 7) ? " nav-expanded" : ""; ?>">
                                <a class="nav-link" href="#">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                                    <span>User</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li>
                                        <a class="nav-link fa fa-link" href="users.php">
                                            <span style="padding-left: 10px">Users</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        <?php } ?>

                        <li>
                            <a class="nav-link" href="logout.php">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                    <br>
                    <br>
                    <br>
                    <br>
                </nav>

            </div>

            <script>
                // Maintain Scroll Position
                if (typeof localStorage !== 'undefined') {
                    if (localStorage.getItem('sidebar-left-position') !== null) {
                        var initialPosition = localStorage.getItem('sidebar-left-position'),
                            sidebarLeft = document.querySelector('#sidebar-left .nano-content');

                        sidebarLeft.scrollTop = initialPosition;
                    }
                }
            </script>


        </div>

    </aside>
    <!-- end: sidebar -->