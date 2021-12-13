<?php
/**
 * Created by PhpStorm.
 * User: Melkamu
 * Date: 5/8/2019
 * Time: 9:14 PM
 */
require_once("../../includes/db_connection.php");
require_once("../../includes/session.php");
require_once("../../includes/functions.php");

if (isset($_POST["startDate"]) && isset($_POST["endDate"])) {
//    $totalDailySales = find_daily_total_sales($_POST["startDate"], $_POST["endDate"]);

    $sd = $_POST["startDate"];
    $ed = $_POST["endDate"];
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

        (function ($) {

            'use strict';

            /*
            Morris: Bar
            */
            if ($('#morrisBar').get(0)) {
                Morris.Bar({
                    resize: true,
                    element: 'morrisBar',
                    data: morrisBarData,
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['Sales ETB '],
                    hideHover: true,
                    barColors: ['#3366CC']
                });
            }

        }).apply(this, [jQuery]);

    </script>
    <?php
}
elseif (isset($_POST["itemStartDate"]) && isset($_POST["itemEndDate"])) {
//    $totalDailySales = find_daily_total_sales($_POST["startDate"], $_POST["endDate"]);

    $sd = $_POST["itemStartDate"];
    $ed = $_POST["itemEndDate"];

    $topRangeSalesItem = find_range_top_sales_item($sd,$ed);

    $result = "";
    while ($row = mysqli_fetch_assoc($topRangeSalesItem)) {
        $result .= "{y:'" . substr($row["title"], 0, 24) .
            "...',a:" . number_format($row['total'], 2, '.', '') .
            "},";
    }
    ?>
    <div class="chart chart-md" id="morrisBar4"></div>
    <script type="text/javascript">
        var morrisBarData4 = [<?php echo $result; ?>];

        (function ($) {

            'use strict';

            if ($('#morrisBar4').get(0)) {
                Morris.Bar({
                    resize: true,
                    element: 'morrisBar4',
                    data: morrisBarData4,
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['Sales ETB '],
                    hideHover: true,
                    barColors: ['#00CC21'],
                    labelTop: true
                });
            }

        }).apply(this, [jQuery]);

    </script>
    <?php
}
elseif (isset($_POST["selectedDate"])) {
    $topDailySalesItem = find_daily_top_sales_item($_POST["selectedDate"]);

    $result = "";
    while ($row = mysqli_fetch_assoc($topDailySalesItem)) {
        $result .= "{y:'" . substr($row["title"], 0, 24) .
            "...',a:" . number_format($row['total'], 2, '.', '') .
            "},";
    }
    ?>
    <div class="chart chart-md" id="morrisBar2"></div>
    <script type="text/javascript">
        var morrisBarData2 = [<?php echo $result; ?>];

        (function ($) {

            'use strict';

            if ($('#morrisBar2').get(0)) {
                Morris.Bar({
                    resize: true,
                    element: 'morrisBar2',
                    data: morrisBarData2,
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['Sales ETB '],
                    hideHover: true,
                    barColors: ['#00CC21'],
                    labelTop: true
                });
            }

        }).apply(this, [jQuery]);

    </script>
    <?php
}
elseif (isset($_POST["branchDate"])) {
    $branchTotalSales = find_branch_total_sales($_POST["branchDate"]);

    $result = "";
    while ($row = mysqli_fetch_assoc($branchTotalSales)) {
        $result .= "{y:'" . find_branch_by_id($row["branch"])["title"] .
            "',a:" . number_format($row['total'], 2, '.', '') .
            "},";
    }
    ?>
    <div class="chart chart-md" id="morrisBar1"></div>
    <script type="text/javascript">
        var morrisBarData1 = [<?php echo $result; ?>];

        (function ($) {

            'use strict';

            if ($('#morrisBar1').get(0)) {
                Morris.Bar({
                    resize: true,
                    element: 'morrisBar1',
                    data: morrisBarData1,
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['Sales ETB '],
                    hideHover: true,
                    barColors: ['#CACC20']
                });
            }

        }).apply(this, [jQuery]);

    </script>
    <?php
}
elseif (isset($_POST["branch"]) && isset($_POST["grtInv"]) && isset($_POST["lesInv"])) {
    $branch = $_POST["branch"];
    $grt = $_POST["grtInv"];
    $les = $_POST["lesInv"];

    $branchInv = find_total_inventory_warehouse($branch);

    $result = "";
    while ($row = mysqli_fetch_assoc($branchInv)) {
        if ($row["quantity"] > $grt && $row["quantity"] <= $les)
            $result .= "{y:'" . find_product_by_id($row["item_id"])["title"] .
                "',a:" . number_format($row['quantity'], 2, '.', '') . "},";
    }
    ?>

    <div class="chart chart-md" id="morrisBar3"></div>
    <script type="text/javascript">
        var morrisBarData3 = [<?php echo $result; ?>];

        (function ($) {

            'use strict';

            if ($('#morrisBar3').get(0)) {
                Morris.Bar({
                    resize: true,
                    element: 'morrisBar3',
                    data: morrisBarData3,
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['Stock Qty '],
                    hideHover: true,
                    barColors: ['#2baab1']
                });
            }

        }).apply(this, [jQuery]);

    </script>
    <?php
}
elseif (isset($_POST["branch1"])) {
    $branch = $_POST["branch1"];

    $branchInv1 = find_total_inventory_warehouse($branch);
    ?>
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
        <?php }
        ?>
        </tbody>
    </table>
    <script>

        (function ($) {

            'use strict';

            var datatableInit5 = function () {
                var $table = $('#datatable-tabletools5');

                $('<div />').addClass('').prependTo('#datatable-tabletools_wrapper');

                $('#datatable-tabletools_wrapper').find('.btn-secondary').removeClass('btn-secondary').addClass('btn-default');
            };
            $(function () {
                datatableInit5();
            });

        }).apply(this, [jQuery]);

        $(document).ready(function () {
            $('#datatable-tabletools5').DataTable({
                dom: 'Bflrtip',
                "displayLength": 10,
                buttons: [
                    'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
    <?php
}
elseif (isset($_POST["branch2"]) && isset($_POST["salesDate"])) {
    $branch = $_POST["branch2"];
    $date = $_POST["salesDate"];

    $totalSales = find_total_branch_sales($branch, $date);
    ?>
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

    <script>

        (function ($) {

            'use strict';

            var datatableInit6 = function () {
                var $table = $('#datatable-tabletools6');

                $('<div />').addClass('').prependTo('#datatable-tabletools_wrapper');

                $('#datatable-tabletools_wrapper').find('.btn-secondary').removeClass('btn-secondary').addClass('btn-default');
            };
            $(function () {
                datatableInit6();
            });

        }).apply(this, [jQuery]);
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
    <?php
}
elseif ( isset($_POST["expire_date"])) {
    // $branch = $_POST["branch01"];
    $date = $_POST["expire_date"];
    // $branchInv01 = find_total_inventory_warehouse($branch);
    $purchase_exp_inv = find_item_exp_date_by_date($date);
    ?>
    <table class="table table-bordered table-striped mb-0" id="datatable-tabletools05">
        <thead>
        <tr>
          
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
                                     echo ( $months == 0 ) ?  "" :"<span style='border-radius: 5px; background: yellow;padding: 5px 10px;color: black;'> $months Months and </span>";
                                     echo ( $ED < $CD ) ?  "" :"<span style='border-radius: 5px; background: yellow;padding: 5px 10px;color: black;'>$days Days Left</span>";
                                ?></td>
                            </tr>
                        <?php } ?>
    </table>
    <script>

        (function ($) {

            'use strict';

            var datatableInit05 = function () {
                var $table = $('#datatable-tabletools05');

                $('<div />').addClass('').prependTo('#datatable-tabletools_wrapper');

                $('#datatable-tabletools_wrapper').find('.btn-secondary').removeClass('btn-secondary').addClass('btn-default');
            };
            $(function () {
                datatableInit05();
            });

        }).apply(this, [jQuery]);

        $(document).ready(function () {
            $('#datatable-tabletools05').DataTable({
                dom: 'Bflrtip',
                "displayLength": 10,
                buttons: [
                    'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
    <?php
}
elseif (isset($_POST["branch2"]) && isset($_POST["salesDate"])) {
    $branch = $_POST["branch2"];
    $date = $_POST["salesDate"];

    $totalSales = find_total_branch_sales($branch, $date);
    ?>
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

    <script>

        (function ($) {

            'use strict';

            var datatableInit6 = function () {
                var $table = $('#datatable-tabletools6');

                $('<div />').addClass('').prependTo('#datatable-tabletools_wrapper');

                $('#datatable-tabletools_wrapper').find('.btn-secondary').removeClass('btn-secondary').addClass('btn-default');
            };
            $(function () {
                datatableInit6();
            });

        }).apply(this, [jQuery]);
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
    <?php
}
elseif (isset($_POST["branch3"]) && isset($_POST["salesStartDate"]) && isset($_POST["salesEndDate"])) {
    $branch = $_POST["branch3"];
    $sdate = $_POST["salesStartDate"];
    $edate = $_POST["salesEndDate"];

    $rangeTotalSales = find_range_branch_sales($branch, $sdate,$edate);
    ?>
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

    <script>

        (function ($) {

            'use strict';

            var datatableInit4 = function () {
                var $table = $('#datatable-tabletools4');

                $('<div />').addClass('').prependTo('#datatable-tabletools_wrapper');

                $('#datatable-tabletools_wrapper').find('.btn-secondary').removeClass('btn-secondary').addClass('btn-default');
            };
            $(function () {
                datatableInit4();
            });

        }).apply(this, [jQuery]);
        $(document).ready(function () {
            $('#datatable-tabletools4').DataTable({
                dom: 'Bflrtip',
                "displayLength": 10,
                buttons: [
                    'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
    <?php
}

?>
