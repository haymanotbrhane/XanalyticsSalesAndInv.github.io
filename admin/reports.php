<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
include_once("header.php");
//$balance = find_all_DailyBalance();
//$balances = find_all_DailyBalance();
//$total = find_all_TotalInfo();
$k = 0;
$now = date("Y-m-d");

$date = strtotime("-10 day");
$date1 = strtotime("-1 day");

$past = date("Y-m-d", $date);
$past1 = date("Y-m-d", $date1);
$branchs = find_all_branch();
$branchs1 = find_all_branch();
$branchs01 = find_all_branch();
$branchs2 = find_all_branch();
$branchs3 = find_all_branch();

$totalDailySales = find_daily_total_sales($past, $now);

$totalRangeSalesItem = find_range_top_sales_item($past, $now);
$expiredate = find_daily_total_sales($past, $now);
$topDailySalesItem = find_daily_top_sales_item($past1);
$branchTotalSales = find_branch_total_sales($past1);
$totalSales = find_total_branch_sales("", $past1);

$rangeTotalSales = find_range_branch_sales("", $past, $now);

$branchInv = find_total_inventory_warehouse("");
$branchInv1 = find_total_inventory_warehouse("");
$branchInv01 = find_total_inventory_warehouse("");
$purchase_exp_inv = find_inventory_expiration("");
$tenDaysSales2 = find_daily_total_sales($past, $now);

$items = find_all_product();
$branch = find_all_branch();


//$monday = strtotime("last monday");
//$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
//$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
//$this_week_sd = date("Y-m-d",$monday);
//$this_week_ed = date("Y-m-d",$sunday);
//echo "Current week range from $this_week_sd to $this_week_ed ";

?>

<section role="main" class="content-body">
    <header class="page-header" style="margin-top: 1px;">
        <h2>Dashboard</h2>

        <div class="right-wrapper text-right">
            <ol class="breadcrumbs" style="padding-right: 50px">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Reports</span></li>
            </ol>
        </div>
    </header>


    <!-- start page-->

    <div class="row">

        <div class="col-md-12" style="margin-bottom: 15px">
            <section class="card">
                <header class="card-header">

                    <div class="row">
                        <div class="col-lg-3">
                            <h2 class="card-title">Daily Total Sales</h2>
                        </div>

                        <div class="col-lg-7 row">

                            <label class="col-lg-3 control-label text-lg-right pt-2">Date range</label>

                            <div class="col-lg-9">
                                <div class="input-daterange input-group" data-plugin-datepicker>
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control" name="start" id="startDate"
                                           value="<?php echo $past; ?>" onchange="searchData()">
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="form-control" name="end" id="endDate"
                                           value="<?php echo $now; ?>" onchange="searchData()">
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-2">
                            <button class="btn btn-success" id="searchData" onclick="searchData()"
                                    style="display: block">Search
                            </button>
                        </div>

                    </div>

                </header>
                <div class="card-body" id="dailySales">
                    <?php
                    $sd = $past;
                    $ed = $now;
                    $result = "";
                    while (true) {
                        $row = find_daily_sales_by_date($sd);

                        if ($sd > $ed)
                            break;

                        $result .= "{y:'" . $sd . "',a:" . number_format($row['total'], 2, '.', '') . "},";

                        $sd = date('Y-m-d', strtotime($sd . ' + 1 days'));
                    }
                    ?>
                    <!-- Morris: Bar -->
                    <div class="chart chart-md" id="morrisBar"></div>

                    <script type="text/javascript">

                        var morrisBarData = [<?php echo $result; ?>];

                    </script>
                </div>
            </section>
        </div>

        <div class="col-md-12" style="margin-bottom: 15px">
            <section class="card">
                <header class="card-header">

                    <div class="row">
                        <div class="col-lg-3">
                            <h2 class="card-title">Top 10 Sales Item By Range</h2>
                        </div>

                        <div class="col-lg-7 row">

                            <label class="col-lg-3 control-label text-lg-right pt-2">Date range</label>

                            <div class="col-lg-9">
                                <div class="input-daterange input-group" data-plugin-datepicker>
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control" name="start" id="itemStartDate"
                                           value="<?php echo $past; ?>" onchange="searchTop10SalesItem()">
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="form-control" name="end" id="itemEndDate"
                                           value="<?php echo $now; ?>" onchange="searchTop10SalesItem()">
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-2">
                            <button class="btn btn-success" id="searchTop10SalesItem" onclick="searchTop10SalesItem()"
                                    style="display: block">Search
                            </button>
                        </div>

                    </div>

                </header>
                <div class="card-body" id="rangeSalesItem">
                    <?php

                    $result = "";
                    while ($row = mysqli_fetch_assoc($totalRangeSalesItem)) {
                        $result .= "{y:'" . substr($row["title"], 0, 24) .
                            "',a:" . number_format($row['total'], 2, '.', '') .
                            "},";
                    }
                    ?>
                    <!-- Morris: Bar -->
                    <div class="chart chart-md" id="morrisBar4"></div>

                    <script type="text/javascript">

                        var morrisBarData4 = [<?php echo $result; ?>];

                    </script>
                </div>
            </section>
        </div>

        <div class="col-md-6" style="margin-bottom: 15px">
            <section class="card">
                <header class="card-header">

                    <div class="row">
                        <div class="col-lg-4">
                            <h2 class="card-title">Top 10 Sales Item</h2>
                        </div>

                        <div class="col-lg-6 row">

                            <label class="col-lg-3 control-label text-lg-right pt-2">Date</label>

                            <div class="col-lg-9">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" id="selectedDate" value="<?php echo $now; ?>"
                                           data-plugin-datepicker class="form-control" onchange="searchTopSales()">
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-2">
                            <button class="btn btn-success" id="searchItem" onclick="searchTopSales()"
                                    style="display: block">Search
                            </button>
                        </div>

                    </div>

                </header>
                <div class="card-body" id="topSalesItem">

                    <!-- Morris: Bar -->

                    <div class="chart chart-md" id="morrisBar2"></div>

                    <?php

                    $result = "";
                    while ($row = mysqli_fetch_assoc($topDailySalesItem)) {
                        $result .= "{y:'" . $row["title"] .
                            "',a:" . number_format($row['total'], 2, '.', '') .
                            "},";
                    }
                    ?>
                    <script type="text/javascript">

                        var morrisBarData2 = [<?php echo $result; ?>];

                    </script>

                </div>
            </section>
        </div>

        <div class="col-md-6" style="margin-bottom: 15px">
            <section class="card">
                <header class="card-header">

                    <div class="row">
                        <div class="col-lg-4">
                            <h2 class="card-title">Branch Total Sales</h2>
                        </div>

                        <div class="col-lg-6 row">

                            <label class="col-lg-3 control-label text-lg-right pt-2">Date</label>

                            <div class="col-lg-9">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" id="branchDate" value="<?php echo $now; ?>"
                                           data-plugin-datepicker class="form-control" onchange="searchBranchSales()">
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-2">
                            <button class="btn btn-success" id="searchItem" onclick="searchBranchSales()"
                                    style="display: block">Search
                            </button>
                        </div>

                    </div>

                </header>
                <div class="card-body" id="branchSales">

                    <!-- Morris: Bar -->

                    <div class="chart chart-md" id="morrisBar1"></div>

                    <?php
                    $result = "";
                    while ($row = mysqli_fetch_assoc($branchTotalSales)) {
                        $result .= "{y:'" . find_branch_by_id($row["branch"])["title"] .
                            "',a:" . number_format($row['total'], 2, '.', '') .
                            "},";
                    }
                    ?>
                    <script type="text/javascript">

                        var morrisBarData1 = [<?php echo $result; ?>];

                    </script>

                </div>
            </section>
        </div>

        <div class="col-md-12" style="margin-bottom: 15px">
            <section class="card">
                <header class="card-header">

                    <div class="row">
                        <div class="col-lg-2">
                            <h2 class="card-title pt-2">Current Stocks</h2>
                        </div>

                        <div class="col-lg-3 row">
                            <label class="col-md-4 control-label text-lg-right pt-2">Branch</label>
                            <select name="branch" id="branch" onchange="searchStock()"
                                    class="populate col-md-8">
                                <?php
                                echo "<option value=''>All Branch's</option>";
                                while ($row = mysqli_fetch_assoc($branchs)) {
                                    ?>
                                    <option
                                            value='<?php echo $row["id"]; ?>'><?php echo $row["title"]; ?></option>
                                <?php } ?>
                            </select>

                        </div>

                        <div class="col-lg-3 row">

                            <label class="col-lg-5 control-label text-lg-right pt-2">
                                Quantity <span style="font-size: 16px;color: black;font-weight: bolder">></span>
                            </label>

                            <div class="col-lg-7">
                                <input type="text" class="form-control" name="end" id="grtInv"
                                       value="0" onchange="searchStock()">
                            </div>

                        </div>

                        <div class="col-lg-3 row">

                            <label class="col-lg-5 control-label text-lg-right pt-2">
                                Quantity <span style="font-size: 16px;color: black;font-weight: bolder"><</span>
                            </label>

                            <div class="col-lg-7">
                                <input type="text" class="form-control" name="end" id="lesInv"
                                       value="100" onchange="searchStock()">
                            </div>

                        </div>

                        <div class="col-lg-1">
                            <button class="btn btn-success" id="searchData" onclick="searchStock()"
                                    style="display: block">Search
                            </button>
                        </div>

                    </div>

                </header>
                <div class="card-body" id="branchInv">
                    <?php
                    $result = "";
                    while ($row = mysqli_fetch_assoc($branchInv)) {
                        if ($row["quantity"] > 0 && $row["quantity"] <= 100)
                            $result .= "{y:'" . find_product_by_id($row["item_id"])["title"] .
                                "',a:" . number_format($row['quantity'], 2, '.', '') . "},";
                    }
                    ?>
                    <!-- Morris: Bar -->
                    <div class="chart chart-md" id="morrisBar3"></div>

                    <script type="text/javascript">

                        var morrisBarData3 = [<?php echo $result; ?>];

                    </script>
                </div>
            </section>
        </div>

        <div class="col-md-12" style="margin-bottom: 15px">
            <section class="card">
                <header class="card-header">

                    <div class="row">
                        <div class="col-lg-2" style="padding-right: 0">
                            <h2 class="card-title pt-2">Sales By Date Range</h2>
                        </div>

                        <div class="col-lg-3 row" style="padding: 0">
                            <label class="col-md-4 control-label text-lg-right pt-2"
                                   style="padding: 0 5px">Branch</label>
                            <select name="branch3" id="rangeBranch" class="populate col-md-8"
                                    style="padding: 5px" onchange="searchRangeTotalSales()">
                                <?php
                                echo "<option value=''>All Branch's</option>";
                                while ($row = mysqli_fetch_assoc($branchs3)) {
                                    ?>
                                    <option
                                            value='<?php echo $row["id"]; ?>'><?php echo $row["title"]; ?></option>
                                <?php } ?>
                            </select>

                        </div>

                        <div class="col-lg-6 row">

                            <label class="col-lg-3 control-label text-lg-right pt-2">Date range</label>

                            <div class="col-lg-9">
                                <div class="input-daterange input-group" data-plugin-datepicker>
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control" name="start" id="salesStartDate"
                                           value="<?php echo $past; ?>" onchange="searchRangeTotalSales()">
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="form-control" name="end" id="salesEndDate"
                                           value="<?php echo $now; ?>" onchange="searchRangeTotalSales()">
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-1">
                            <button class="btn btn-success" id="searchRangeTotalSales" onclick="searchRangeTotalSales()"
                                    style="display: block">Search
                            </button>
                        </div>

                    </div>

                </header>

                <div class="card-body" id="rangeTotalSales">
                    <table class="table table-bordered table-striped mb-0" id="datatable-tabletools4">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Item Code/Title</th>
                            <th class="text-right">Quantity</th>
                            <th class="text-right">Total Price</th>
                            <!--                            <th class="text-right">Sales Rank</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total = 0;
                        $k = 1;
                        while ($row = mysqli_fetch_assoc($rangeTotalSales)) {
                            $total += $row["total"];
                            ?>
                            <tr>
                                <td><?php echo $k++; ?></td>
                                <td><?php echo $row["code"] . "/" . $row["title"]; ?></td>
                                <td class="text-right"><?php echo number_format($row["qty"], 2, '.', ','); ?></td>
                                <td class="text-right"><?php echo number_format($row["total"], 2, '.', ','); ?></td>
                                <!--                                <td>-->
                                <!--                                    --><?php //echo ($row["quantity"] > find_product_by_id($row["item_id"])["min_stock"]) ? "" : "<span style='border-radius: 5px; background: red;padding: 5px 10px;color: white;'>Less Stock</span>"; ?>
                                <!--                                </td>-->
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

            </section>
        </div>

        <div class="col-md-6" style="margin-bottom: 15px">
            <section class="card">
                <header class="card-header">

                    <div class="row">
                        <div class="col-lg-2" style="padding-right: 0">
                            <h2 class="card-title pt-2">Sales</h2>
                        </div>

                        <div class="col-lg-4 row" style="padding: 0">
                            <label class="col-md-4 control-label text-lg-right pt-2"
                                   style="padding: 0 5px">Branch</label>
                            <select name="branch1" id="branch2" class="populate col-md-8"
                                    style="padding: 5px" onchange="searchTotalSales()">
                                <?php
                                echo "<option value=''>All Branch's</option>";
                                while ($row = mysqli_fetch_assoc($branchs1)) {
                                    ?>
                                    <option
                                            value='<?php echo $row["id"]; ?>'><?php echo $row["title"]; ?></option>
                                <?php } ?>
                            </select>

                        </div>

                        <div class="col-lg-5 row">
                            <label class="col-lg-4 control-label text-lg-right pt-2">Date</label>

                            <div class="col-lg-8" style="padding: 0 3px">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" id="salesDate" value="<?php echo $now; ?>"
                                           data-plugin-datepicker class="form-control" onchange="searchTotalSales()">
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-2">
                            <button class="btn btn-success" id="searchTotalSales" onclick="searchTotalSales()"
                                    style="display: block">Search
                            </button>
                        </div>

                    </div>

                </header>

                <div class="card-body" id="totalSalesTable">
                    <table class="table table-bordered table-striped mb-0" id="datatable-tabletools6">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Item Code/Title</th>
                            <th class="text-right">Quantity</th>
                            <th class="text-right">Total Price</th>
                            <!--                            <th class="text-right">Sales Rank</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total = 0;
                        $k = 1;
                        while ($row = mysqli_fetch_assoc($totalSales)) {
                            $total += $row["total"];
                            ?>
                            <tr>
                                <td><?php echo $k++; ?></td>
                                <td><?php echo $row["code"] . "/" . $row["title"]; ?></td>
                                <td class="text-right"><?php echo number_format($row["qty"], 2, '.', ','); ?></td>
                                <td class="text-right"><?php echo number_format($row["total"], 2, '.', ','); ?></td>
                                <!--                                <td>-->
                                <!--                                    --><?php //echo ($row["quantity"] > find_product_by_id($row["item_id"])["min_stock"]) ? "" : "<span style='border-radius: 5px; background: red;padding: 5px 10px;color: white;'>Less Stock</span>"; ?>
                                <!--                                </td>-->
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

            </section>
        </div>

        <div class="col-md-6" style="margin-bottom: 15px">
            <section class="card">
                <header class="card-header">

                    <div class="row">
                        <div class="col-lg-4">
                            <h2 class="card-title pt-2">Stocks</h2>
                        </div>

                        <div class="col-lg-6 row">
                            <label class="col-md-4 control-label text-lg-right pt-2">Branch</label>
                            <select name="branch1" id="branch1" class="populate col-md-8" onchange="searchTotalStock()">
                                <?php
                                echo "<option value=''>All Branch's</option>";
                                while ($row = mysqli_fetch_assoc($branchs2)) {
                                    ?>
                                    <option
                                            value='<?php echo $row["id"]; ?>'><?php echo $row["title"]; ?></option>
                                <?php } ?>
                            </select>

                        </div>

                        <div class="col-lg-2">
                            <button class="btn btn-success" id="searchTotalData" onclick="searchTotalStock()"
                                    style="display: block">Search
                            </button>
                        </div>

                    </div>

                </header>

                <div class="card-body" id="totalStock">
                    <table class="table table-bordered table-striped mb-0" id="datatable-tabletools5">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Item Code/Title</th>
                            <th class="text-right">Quantity</th>
                            <th class="text-right">Minimum Stock</th>
                            <th class="text-right">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total = 0;
                        $k = 1;
                        while ($row = mysqli_fetch_assoc($branchInv1)) {
                            $total += $row["quantity"];
                            $type = "";
                            if (!isset($row["warehouse_id"]))
                                $b_type = "";
                            else
                                $b_type = find_branch_by_id($row["warehouse_id"])["branch_type"];

                            if ($b_type == "Showroom")
                                $type = find_product_by_id($row["item_id"])["min_showroom"];
                            elseif ($b_type == "Shop")
                                $type = find_product_by_id($row["item_id"])["min_shop"];
                            else
                                $type = find_product_by_id($row["item_id"])["min_stock"];
                            ?>
                            <tr>
                                <td><?php echo $k++; ?></td>
                                <td><?php echo find_product_by_id($row["item_id"])["code"] . "/" . find_product_by_id($row["item_id"])["title"]; ?></td>
                                <td class="text-right"><?php echo number_format($row["quantity"], 2, '.', ','); ?></td>
                                <td class="text-right"><?php echo number_format($type, 2, '.', ','); ?></td>
                                <td>
                                    <?php echo ($row["quantity"] > $type) ? "" : "<span style='border-radius: 5px; background: red;padding: 5px 10px;color: white;'>Less Stock</span>"; ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

            </section>
        </div>
        <!-- Expire Date -->
        <div class="col-md-12" style="margin-bottom: 15px">
            <section class="card">
                <header class="card-header">

                    <div class="row">
                        <div class="col-lg-5">
                            <h2 class="card-title pt-2">Items Expire date Summary</h2>
                        </div>
              
                   
                         <div class="col-lg-6 row">

                        <label class="col-lg-3 control-label text-lg-right pt-2">Date range</label>

                        <div class="col-lg-9">
                            <div class="input-daterange input-group" data-plugin-datepicker>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text"  id="expire_date" value="<?php echo $now; ?>"
                                           data-plugin-datepicker class="form-control" onchange="searchExpireDate()">
                                </div>
                        </div>

                        </div>

                        <div class="col-lg-1">
                            <button class="btn btn-success" id="searchBranchExpireDate" onclick="searchExpireDate()"
                                    style="display: block">Search
                            </button>
                        </div>

                    </div>

                </header>

                <div class="card-body" id="ExpireDate">
                    <table class="table table-bordered table-striped mb-0" id="datatable-tabletools05">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Item Code/Title</th>
                            
                            <th class="text-right">Received Date</th>
                            <th class="text-left">Warehouse</th>
                            <th class="text-right">Quantity</th>
                            <th class="text-right">Expire Date</th>
                            <th class="text-right">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total = 0;
                        $k = 1;
                        while ($row = mysqli_fetch_assoc($purchase_exp_inv)) {
                            $total += $row["quantity"];
                            $CD = date("Y-m-d"); 
                            $ED = $row["expiered_date"]; 
                            $warehouse= $row["warehouse_id"];
                            $LD = abs(strtotime($ED) - strtotime($CD ));
                            $years = floor($LD  / (365*60*60*24));
                            $months = floor(($LD  - $years * 365*60*60*24) / (30*60*60*24));
                            $days = floor(($LD  - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                            // $LD=$CD-$ED / 86400;
                            ?>
                            <tr>
                                <td><?php echo $k++; ?></td>
                                <td><?php echo find_product_by_id($row["item_id"])["code"] . "/" . find_product_by_id($row["item_id"])["title"]; ?></td>
                                <!-- <td class="text-right"><php echo number_format($type, 2, '.', ','); ?></td> -->
                                <td data-title="warehouse" class="text-left"><?php echo  find_branch_by_id($warehouse)["title"]; ?></td>
                                <td><?php echo $row["creation_date"]; ?></td>
                                <td class="text-right"><?php echo number_format($row["quantity"], 2, '.', ','); ?></td>
                               
                                <td><?php echo $row["expiered_date"]; ?></td>
                                <td>
                                <!-- expiered_date -->
                               
                                    <?php echo ($ED > $CD ) ? "" : "<span style='border-radius: 5px; background: red;padding: 5px 10px;color: white;'>Expired</span>";
                                     echo ( $months == 0 ) ?  "" :"<span style='border-radius: 5px; background: yellow;padding: 5px 10px;color: black;'> $months Months, </span>";
                                     echo ( $ED <= $CD ) ?  "" :"<span style='border-radius: 5px; background: yellow;padding: 5px 10px;color: black;'>$days Days Left</span>";
                                ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

            </section>
        </div>


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
<script src="vendor/jquery-appear/jquery-appear.js"></script>
<script src="vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.js"></script>
<script src="vendor/flot/jquery.flot.js"></script>
<script src="vendor/flot.tooltip/flot.tooltip.js"></script>
<script src="vendor/flot/jquery.flot.pie.js"></script>
<script src="vendor/flot/jquery.flot.categories.js"></script>
<script src="vendor/flot/jquery.flot.resize.js"></script>
<script src="vendor/jquery-sparkline/jquery-sparkline.js"></script>
<script src="vendor/raphael/raphael.js"></script>
<script src="vendor/morris/morris.js"></script>
<script src="vendor/gauge/gauge.js"></script>
<script src="vendor/snap.svg/snap.svg.js"></script>
<script src="vendor/liquid-meter/liquid.meter.js"></script>
<script src="vendor/chartist/chartist.js"></script>

<!-- Specific Page Vendor -->
<script src="vendor/select2/js/select2.js"></script>
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/media/js/dataTables.bootstrap4.min.js"></script>
<script src="vendor/datatables/extras/TableTools/Buttons-1.4.2/js/dataTables.buttons.min.js"></script>
<script src="vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.html5.min.js"></script>
<script src="vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.print.min.js"></script>
<script src="vendor/datatables/extras/TableTools/JSZip-2.5.0/jszip.min.js"></script>
<script src="vendor/datatables/extras/TableTools/pdfmake-0.1.32/pdfmake.min.js"></script>
<script src="vendor/datatables/extras/TableTools/pdfmake-0.1.32/vfs_fonts.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="js/theme.js"></script>

<!-- Theme Custom -->
<script src="js/custom.js"></script>

<!-- Theme Initialization Files -->
<script src="js/theme.init.js"></script>
<!-- Analytics to Track Preview Website -->
<script>
    $(document).ready(function () {
        $('#datatable-tabletools4').DataTable({
            dom: 'Bflrtip',
            "displayLength": 10,
            buttons: [
                'excel', 'pdf', 'print'
            ]
        });
    });

    $(document).ready(function () {
        $('#datatable-tabletools5').DataTable({
            dom: 'Bflrtip',
            "displayLength": 10,
            buttons: [
                'excel', 'pdf', 'print'
            ]
        });
    });
    $(document).ready(function () {
        $('#datatable-tabletools6').DataTable({
            dom: 'Bflrtip',
            "displayLength": 10,
            buttons: [
                'excel', 'pdf', 'print'
            ]
        });
    });
</script>
<!-- Examples -->
<style>
    #datatable-tabletools4_filter, #datatable-tabletools4_length,#datatable-tabletools5_filter, #datatable-tabletools5_length, #datatable-tabletools6_filter, #datatable-tabletools6_length {
        float: right;
    }

    #ChartistCSSAnimation .ct-series.ct-series-a .ct-line {
        fill: none;
        stroke-width: 4px;
        stroke-dasharray: 5px;
        -webkit-animation: dashoffset 1s linear infinite;
        -moz-animation: dashoffset 1s linear infinite;
        animation: dashoffset 1s linear infinite;
    }

    #ChartistCSSAnimation .ct-series.ct-series-b .ct-point {
        -webkit-animation: bouncing-stroke 0.5s ease infinite;
        -moz-animation: bouncing-stroke 0.5s ease infinite;
        animation: bouncing-stroke 0.5s ease infinite;
    }

    #ChartistCSSAnimation .ct-series.ct-series-b .ct-line {
        fill: none;
        stroke-width: 3px;
    }

    #ChartistCSSAnimation .ct-series.ct-series-c .ct-point {
        -webkit-animation: exploding-stroke 1s ease-out infinite;
        -moz-animation: exploding-stroke 1s ease-out infinite;
        animation: exploding-stroke 1s ease-out infinite;
    }

    #ChartistCSSAnimation .ct-series.ct-series-c .ct-line {
        fill: none;
        stroke-width: 2px;
        stroke-dasharray: 40px 3px;
    }

    @-webkit-keyframes dashoffset {
        0% {
            stroke-dashoffset: 0px;
        }

        100% {
            stroke-dashoffset: -20px;
        }

    ;
    }

    @-moz-keyframes dashoffset {
        0% {
            stroke-dashoffset: 0px;
        }

        100% {
            stroke-dashoffset: -20px;
        }

    ;
    }

    @keyframes dashoffset {
        0% {
            stroke-dashoffset: 0px;
        }

        100% {
            stroke-dashoffset: -20px;
        }

    ;
    }

    @-webkit-keyframes bouncing-stroke {
        0% {
            stroke-width: 5px;
        }

        50% {
            stroke-width: 10px;
        }

        100% {
            stroke-width: 5px;
        }

    ;
    }

    @-moz-keyframes bouncing-stroke {
        0% {
            stroke-width: 5px;
        }

        50% {
            stroke-width: 10px;
        }

        100% {
            stroke-width: 5px;
        }

    ;
    }

    @keyframes bouncing-stroke {
        0% {
            stroke-width: 5px;
        }

        50% {
            stroke-width: 10px;
        }

        100% {
            stroke-width: 5px;
        }

    ;
    }

    @-webkit-keyframes exploding-stroke {
        0% {
            stroke-width: 2px;
            opacity: 1;
        }

        100% {
            stroke-width: 20px;
            opacity: 0;
        }

    ;
    }

    @-moz-keyframes exploding-stroke {
        0% {
            stroke-width: 2px;
            opacity: 1;
        }

        100% {
            stroke-width: 20px;
            opacity: 0;
        }

    ;
    }

    @keyframes exploding-stroke {
        0% {
            stroke-width: 2px;
            opacity: 1;
        }

        100% {
            stroke-width: 20px;
            opacity: 0;
        }

    ;
    }
</style>
<script src="js/examples/examples.datatables.default.js"></script>
<script src="js/examples/examples.datatables.row.with.details.js"></script>
<script src="js/examples/examples.datatables.tabletools.js"></script>

<script src="js/examples/examples.charts.js"></script>
<script type="text/javascript">

    function searchData() {

        var start = $('#startDate').val();
        var end = $('#endDate').val();
        $.ajax({
            type: "POST",
            url: "generated/report.php",
            data: "startDate=" + start + "&endDate=" + end,
            success: function (response) {
                $("#dailySales").html(response);
            }

        });
    }

    function searchTop10SalesItem() {

        var start = $('#itemStartDate').val();
        var end = $('#itemEndDate').val();
        $.ajax({
            type: "POST",
            url: "generated/report.php",
            data: "itemStartDate=" + start + "&itemEndDate=" + end,
            success: function (response) {
                $("#rangeSalesItem").html(response);
            }

        });
    }


    function searchRangeTotalSales() {

        var branch = $('#rangeBranch').val();
        var start = $('#salesStartDate').val();
        var end = $('#salesEndDate').val();
        $.ajax({
            type: "POST",
            url: "generated/report.php",
            data: "salesStartDate=" + start + "&salesEndDate=" + end + "&branch3=" + branch,
            success: function (response) {
                $("#rangeTotalSales").html(response);
            }

        });
    }

    function searchTopSales() {

        var start = $('#selectedDate').val();
        $.ajax({
            type: "POST",
            url: "generated/report.php",
            data: "selectedDate=" + start,
            success: function (response) {
                $("#topSalesItem").html(response);
            }

        });
    }

    function searchBranchSales() {

        var start = $('#branchDate').val();
        $.ajax({
            type: "POST",
            url: "generated/report.php",
            data: "branchDate=" + start,
            success: function (response) {
                $("#branchSales").html(response);
            }

        });
    }

    function searchStock() {

        var branch = $('#branch').val();
        var grtInv = $('#grtInv').val();
        var lesInv = $('#lesInv').val();

        $.ajax({
            type: "POST",
            url: "generated/report.php",
            data: "branch=" + branch + "&grtInv=" + grtInv + "&lesInv=" + lesInv,
            success: function (response) {
                $("#branchInv").html(response);
            }

        });
    }

    function searchTotalStock() {

        var branch = $('#branch1').val();

        $.ajax({
            type: "POST",
            url: "generated/report.php",
            data: "branch1=" + branch,
            success: function (response) {
                $("#totalStock").html(response);
            }

        });
    }

    function searchTotalSales() {

        var branch = $('#branch2').val();
        var date = $('#salesDate').val();

        $.ajax({
            type: "POST",
            url: "generated/report.php",
            data: "branch2=" + branch + "&salesDate=" + date,
            success: function (response) {
                $("#totalSalesTable").html(response);
            }

        });
    }

    function searchBranchExpireDate() {
        var date = $('#expire_date').val();

var branch = $('#branch01').val();

$.ajax({
    type: "POST",
    url: "generated/report.php",
    data: "branch01=" + branch + "&expire_date=" + date,
    success: function (response) {
        $("#ExpireDate").html(response);
    }

});
}
function searchExpireDate() {
        var date = $('#expire_date').val();

$.ajax({
    type: "POST",
    url: "generated/report.php",
    data:"&expire_date=" + date,
    success: function (response) {
        $("#ExpireDate").html(response);
    }

});
}



</script>


</body>

</html>