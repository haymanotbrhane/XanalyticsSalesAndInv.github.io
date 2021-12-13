<?php
include_once("header.php")
?>


<section role="main" class="content-body card-margin">
<header class="page-header">
    <h2>Form Wizard</h2>

    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li>
                <a href="index-2.html">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><span>Forms</span></li>
            <li><span>Wizard</span></li>
        </ol>

        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
    </div>
</header>

<!-- start: page -->
<div class="row">
<div class="col-lg-6">
    <section class="card form-wizard" id="w1">
        <header class="card-header">
            <div class="card-actions">
                <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
            </div>

            <h2 class="card-title">Form Wizard</h2>
        </header>
        <div class="card-body card-body-nopadding">
            <div class="wizard-tabs">
                <ul class="nav wizard-steps">
                    <li class="nav-item active">
                        <a href="#w1-account" data-toggle="tab" class="nav-link text-center">
                            <span class="badge">1</span>
                            Account
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#w1-profile" data-toggle="tab" class="nav-link text-center">
                            <span class="badge">2</span>
                            Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#w1-confirm" data-toggle="tab" class="nav-link text-center">
                            <span class="badge">3</span>
                            Confirm
                        </a>
                    </li>
                </ul>
            </div>
            <form class="form-horizontal" novalidate="novalidate">
                <div class="tab-content">
                    <div id="w1-account" class="tab-pane p-3 active">
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1"
                                   for="w1-username">Username</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="username" id="w1-username" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1"
                                   for="w1-password">Password</label>

                            <div class="col-sm-8">
                                <input type="password" class="form-control" name="password" id="w1-password"
                                       minlength="6" required>
                            </div>
                        </div>
                    </div>
                    <div id="w1-profile" class="tab-pane p-3">
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1" for="w1-first-name">First
                                Name</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="first-name" id="w1-first-name"
                                       required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1" for="w1-last-name">Last
                                Name</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="last-name" id="w1-last-name" required>
                            </div>
                        </div>
                    </div>
                    <div id="w1-confirm" class="tab-pane p-3">
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1" for="w1-email">Email</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="email" id="w1-email" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <div class="checkbox-custom">
                                    <input type="checkbox" name="terms" id="w1-terms" required>
                                    <label for="w1-terms">I agree to the terms of service</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <ul class="pager">
                <li class="previous disabled">
                    <a><i class="fa fa-angle-left"></i> Previous</a>
                </li>
                <li class="finish hidden float-right">
                    <a>Finish</a>
                </li>
                <li class="next">
                    <a>Next <i class="fa fa-angle-right"></i></a>
                </li>
            </ul>
        </div>
    </section>
</div>
<div class="col-lg-6">
    <section class="card form-wizard" id="w2">
        <div class="tabs">
            <ul class="nav nav-tabs nav-justify">
                <li class="nav-item active">
                    <a href="#w2-account" data-toggle="tab" class="nav-link text-center">
                        <span class="badge badge-primary">1</span>
                        Account
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#w2-profile" data-toggle="tab" class="nav-link text-center">
                        <span class="badge badge-primary">2</span>
                        Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#w2-confirm" data-toggle="tab" class="nav-link text-center">
                        <span class="badge badge-primary">3</span>
                        Confirm
                    </a>
                </li>
            </ul>
            <form class="form-horizontal" novalidate="novalidate">
                <div class="tab-content">
                    <div id="w2-account" class="tab-pane p-3 active">
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1"
                                   for="w2-username">Username</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="w2-username" name="username" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1"
                                   for="w2-password">Password</label>

                            <div class="col-sm-8">
                                <input type="password" class="form-control" name="password" id="w2-password"
                                       required minlength="6">
                            </div>
                        </div>
                    </div>
                    <div id="w2-profile" class="tab-pane p-3">
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1" for="w2-first-name">First
                                Name</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="first-name" id="w2-first-name"
                                       required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1" for="w2-last-name">Last
                                Name</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="last-name" id="w2-last-name" required>
                            </div>
                        </div>
                    </div>
                    <div id="w2-confirm" class="tab-pane p-3">
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1" for="w2-email">Email</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="email" id="w2-email" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <div class="checkbox-custom">
                                    <input type="checkbox" name="terms" id="w2-terms" required>
                                    <label for="w2-terms">I agree to the terms of service</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <ul class="pager">
                <li class="previous disabled">
                    <a><i class="fa fa-angle-left"></i> Previous</a>
                </li>
                <li class="finish hidden float-right">
                    <a>Finish</a>
                </li>
                <li class="next">
                    <a>Next <i class="fa fa-angle-right"></i></a>
                </li>
            </ul>
        </div>
    </section>
</div>
</div>
<div class="row">
    <div class="col">
        <section class="card form-wizard" id="w4">
            <header class="card-header">
                <div class="card-actions">
                    <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                    <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                </div>

                <h2 class="card-title">Form Wizard</h2>
            </header>
            <div class="card-body">
                <div class="wizard-progress wizard-progress-lg">
                    <div class="steps-progress">
                        <div class="progress-indicator"></div>
                    </div>
                    <ul class="nav wizard-steps">
                        <li class="nav-item active">
                            <a class="nav-link" href="#w4-account" data-toggle="tab"><span>1</span>Account Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#w4-profile" data-toggle="tab"><span>2</span>Profile Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#w4-billing" data-toggle="tab"><span>3</span>Billing Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#w4-confirm" data-toggle="tab"><span>4</span>Confirmation</a>
                        </li>
                    </ul>
                </div>

                <form class="form-horizontal p-3" novalidate="novalidate">
                    <div class="tab-content">
                        <div id="w4-account" class="tab-pane active">
                            <div class="form-group row">
                                <label class="col-sm-3 control-label text-sm-right pt-1"
                                       for="w4-username">Username</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="username" id="w4-username" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label text-sm-right pt-1"
                                       for="w4-password">Password</label>

                                <div class="col-sm-9">
                                    <input type="password" class="form-control" name="password" id="w4-password"
                                           required minlength="6">
                                </div>
                            </div>
                        </div>
                        <div id="w4-profile" class="tab-pane">
                            <div class="form-group row">
                                <label class="col-sm-3 control-label text-sm-right pt-1" for="w4-first-name">First
                                    Name</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="first-name" id="w4-first-name"
                                           required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label text-sm-right pt-1" for="w4-last-name">Last
                                    Name</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="last-name" id="w4-last-name" required>
                                </div>
                            </div>
                        </div>
                        <div id="w4-billing" class="tab-pane">
                            <div class="form-group row">
                                <label class="col-sm-3 control-label text-sm-right pt-1" for="w4-cc">Card Number</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="cc-number" id="w4-cc" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label text-sm-right pt-1"
                                       for="inputSuccess">Expiration</label>

                                <div class="col-sm-5">
                                    <select class="form-control" name="exp-month" required>
                                        <option>January</option>
                                        <option>February</option>
                                        <option>March</option>
                                        <option>April</option>
                                        <option>May</option>
                                        <option>June</option>
                                        <option>July</option>
                                        <option>August</option>
                                        <option>September</option>
                                        <option>October</option>
                                        <option>November</option>
                                        <option>December</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control" name="exp-year" required>
                                        <option>2014</option>
                                        <option>2015</option>
                                        <option>2017</option>
                                        <option>2017</option>
                                        <option>2018</option>
                                        <option>2019</option>
                                        <option>2020</option>
                                        <option>2021</option>
                                        <option>2022</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="w4-confirm" class="tab-pane">
                            <div class="form-group row">
                                <label class="col-sm-3 control-label text-sm-right pt-1" for="w4-email">Email</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="email" id="w4-email" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <div class="checkbox-custom">
                                        <input type="checkbox" name="terms" id="w4-terms" required>
                                        <label for="w4-terms">I agree to the terms of service</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <ul class="pager">
                    <li class="previous disabled">
                        <a><i class="fa fa-angle-left"></i> Previous</a>
                    </li>
                    <li class="finish hidden float-right">
                        <a>Finish</a>
                    </li>
                    <li class="next">
                        <a>Next <i class="fa fa-angle-right"></i></a>
                    </li>
                </ul>
            </div>
        </section>
    </div>
</div>
<div class="row">
<div class="col-lg-6">
    <section class="card form-wizard" id="w3">
        <header class="card-header">
            <div class="card-actions">
                <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
            </div>

            <h2 class="card-title">Form Wizard</h2>
        </header>
        <div class="card-body">
            <div class="wizard-progress">
                <div class="steps-progress">
                    <div class="progress-indicator"></div>
                </div>
                <ul class="nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#w3-account" data-toggle="tab"><span>1</span>Account Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#w3-profile" data-toggle="tab"><span>2</span>Profile Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#w3-billing" data-toggle="tab"><span>3</span>Billing Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#w3-confirm" data-toggle="tab"><span>4</span>Confirmation</a>
                    </li>
                </ul>
            </div>
            <form class="form-horizontal p-3" novalidate="novalidate">
                <div class="tab-content">
                    <div id="w3-account" class="tab-pane active">
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1" for="w3-username">Username</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="username" id="w3-username" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1" for="w3-password">Password</label>

                            <div class="col-sm-8">
                                <input type="password" class="form-control" name="password" id="w3-password"
                                       minlength="6" required>
                            </div>
                        </div>
                    </div>
                    <div id="w3-profile" class="tab-pane">
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1" for="w3-first-name">First
                                Name</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="first-name" id="w3-first-name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1" for="w3-last-name">Last
                                Name</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="last-name" id="w3-last-name">
                            </div>
                        </div>
                    </div>
                    <div id="w3-billing" class="tab-pane">
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1" for="w3-cc">Card Number</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="cc-number" id="w3-cc" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1"
                                   for="inputSuccess">Expiration</label>

                            <div class="col-sm-4">
                                <select class="form-control" name="exp-month" required>
                                    <option>January</option>
                                    <option>February</option>
                                    <option>March</option>
                                    <option>April</option>
                                    <option>May</option>
                                    <option>June</option>
                                    <option>July</option>
                                    <option>August</option>
                                    <option>September</option>
                                    <option>October</option>
                                    <option>November</option>
                                    <option>December</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-control" name="exp-year" required>
                                    <option>2014</option>
                                    <option>2015</option>
                                    <option>2017</option>
                                    <option>2017</option>
                                    <option>2018</option>
                                    <option>2019</option>
                                    <option>2020</option>
                                    <option>2021</option>
                                    <option>2022</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="w3-confirm" class="tab-pane">
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1" for="w3-email">Email</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="email" id="w3-email" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <div class="checkbox-custom">
                                    <input type="checkbox" name="terms" id="w3-terms" required>
                                    <label for="w3-terms">I agree to the terms of service</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <ul class="pager">
                <li class="previous disabled">
                    <a><i class="fa fa-angle-left"></i> Previous</a>
                </li>
                <li class="finish hidden float-right">
                    <a>Finish</a>
                </li>
                <li class="next">
                    <a>Next <i class="fa fa-angle-right"></i></a>
                </li>
            </ul>
        </div>
    </section>
</div>
<div class="col-lg-6">
    <section class="card form-wizard" id="w5">
        <header class="card-header">
            <div class="card-actions">
                <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
            </div>

            <h2 class="card-title">Form Wizard</h2>
        </header>
        <div class="card-body">
            <div class="wizard-tabs" style="visibility: hidden; position: absolute;">
                <ul class="nav wizard-steps">
                    <li class="nav-item active">
                        <a class="nav-link" href="#w5-account" data-toggle="tab"><span class="badge">1</span>Account
                            Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#w5-profile" data-toggle="tab"><span class="badge">2</span>Profile
                            Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#w5-billing" data-toggle="tab"><span class="badge">3</span>Billing
                            Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#w5-confirm" data-toggle="tab"><span class="badge">4</span>Confirmation</a>
                    </li>
                </ul>
            </div>
            <div class="progress progress-striped progress-xl m-md light">
                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                     style="width: 60%;">
                    <span class="sr-only">60%</span>
                </div>
            </div>
            <form class="form-horizontal p-3" novalidate="novalidate">
                <div class="tab-content">
                    <div id="w5-account" class="tab-pane active">
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1" for="w5-username">Username</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="username" id="w5-username" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1" for="w5-password">Password</label>

                            <div class="col-sm-8">
                                <input type="password" class="form-control" name="password" id="w5-password"
                                       minlength="2" required>
                            </div>
                        </div>
                    </div>
                    <div id="w5-profile" class="tab-pane">
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1" for="w5-first-name">First
                                Name</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="first-name" id="w5-first-name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1" for="w5-last-name">Last
                                Name</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="last-name" id="w5-last-name" required>
                            </div>
                        </div>
                    </div>
                    <div id="w5-billing" class="tab-pane">
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1" for="w5-cc">Card Number</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="cc-number" id="w5-cc" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1"
                                   for="inputSuccess">Expiration</label>

                            <div class="col-sm-4">
                                <select class="form-control" name="exp-month" required>
                                    <option>January</option>
                                    <option>February</option>
                                    <option>March</option>
                                    <option>April</option>
                                    <option>May</option>
                                    <option>June</option>
                                    <option>July</option>
                                    <option>August</option>
                                    <option>September</option>
                                    <option>October</option>
                                    <option>November</option>
                                    <option>December</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-control" name="exp-year" required>
                                    <option>2014</option>
                                    <option>2015</option>
                                    <option>2017</option>
                                    <option>2017</option>
                                    <option>2018</option>
                                    <option>2019</option>
                                    <option>2020</option>
                                    <option>2021</option>
                                    <option>2022</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="w5-confirm" class="tab-pane">
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-sm-right pt-1" for="w5-email">Email</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="email" id="w5-email" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <div class="checkbox-custom">
                                    <input type="checkbox" name="terms" id="w5-terms" required>
                                    <label for="w5-terms">I agree to the terms of service</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <ul class="pager">
                <li class="previous disabled">
                    <a><i class="fa fa-angle-left"></i> Previous</a>
                </li>
                <li class="finish hidden float-right">
                    <a>Finish</a>
                </li>
                <li class="next">
                    <a>Next <i class="fa fa-angle-right"></i></a>
                </li>
            </ul>
        </div>
    </section>
</div>
</div>
<!-- end: page -->
</section>
</div>

<aside id="sidebar-right" class="sidebar-right">
    <div class="nano">
        <div class="nano-content">
            <a href="#" class="mobile-close d-md-none">
                Collapse <i class="fa fa-chevron-right"></i>
            </a>

            <div class="sidebar-right-wrapper">

                <div class="sidebar-widget widget-calendar">
                    <h6>Upcoming Tasks</h6>

                    <div data-plugin-datepicker data-plugin-skin="dark"></div>

                    <ul>
                        <li>
                            <time datetime="2017-04-19T00:00+00:00">04/19/2017</time>
                            <span>Company Meeting</span>
                        </li>
                    </ul>
                </div>

                <div class="sidebar-widget widget-friends">
                    <h6>Friends</h6>
                    <ul>
                        <li class="status-online">
                            <figure class="profile-picture">
                                <img src="img/%21sample-user.jpg" alt="Joseph Doe" class="rounded-circle">
                            </figure>
                            <div class="profile-info">
                                <span class="name">Joseph Doe Junior</span>
                                <span class="title">Hey, how are you?</span>
                            </div>
                        </li>
                        <li class="status-online">
                            <figure class="profile-picture">
                                <img src="img/%21sample-user.jpg" alt="Joseph Doe" class="rounded-circle">
                            </figure>
                            <div class="profile-info">
                                <span class="name">Joseph Doe Junior</span>
                                <span class="title">Hey, how are you?</span>
                            </div>
                        </li>
                        <li class="status-offline">
                            <figure class="profile-picture">
                                <img src="img/%21sample-user.jpg" alt="Joseph Doe" class="rounded-circle">
                            </figure>
                            <div class="profile-info">
                                <span class="name">Joseph Doe Junior</span>
                                <span class="title">Hey, how are you?</span>
                            </div>
                        </li>
                        <li class="status-offline">
                            <figure class="profile-picture">
                                <img src="img/%21sample-user.jpg" alt="Joseph Doe" class="rounded-circle">
                            </figure>
                            <div class="profile-info">
                                <span class="name">Joseph Doe Junior</span>
                                <span class="title">Hey, how are you?</span>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</aside>
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
<script src="js/examples/examples.wizard.js"></script>
</body>

<!-- Mirrored from preview.oklerthemes.com/porto-admin/2.0.0/forms-wizard.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 17 Feb 2018 14:39:57 GMT -->
</html>