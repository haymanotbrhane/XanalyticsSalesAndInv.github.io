<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php

$goods = find_transport_cost($_GET["id"]);
$total = 0;
$damage1 = 0;
$damage2 = 0;
$damage3 = 0;

$shortage1 = 0;
$shortage2 = 0;
$shortage3 = 0;

$price600 = 0;
$price1000 = 0;
$price1500 = 0;
$username = "";
?>
<html>

<head>
    <title>Fiker Water PLC</title>
    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css"/>

    <!-- Invoice Print Style -->
    <link rel="stylesheet" href="css/invoice-print.css"/>
    <style type="text/css">
        .table th, .table td {
            font-size: 13px;
            padding: 0;
            padding-left: 5px;
            vertical-align: top !important;
            border: 1px solid #e9ecef;

        }
    </style>
</head>
<body>
<div class="invoice" style="margin-top: 10px">

    <table class="table table-responsive-md invoice-items">
        <thead>
        <tr class="text-dark">
            <th class="font-weight-semibold" colspan="10"><h4
                    class="h4 mt-0 mb-1 text-dark font-weight-bold text-center">
                    Transport Cost Summary and Payment Request</h4></th>
            <th class="font-weight-semibold text-center" colspan="3">Date <?php echo date("d/mY"); ?></th>
        </tr>
        <tr class="text-dark">
            <th id="cell-id" class="font-weight-semibold">#</th>
            <th id="cell-item" class="font-weight-semibold">Plate No</th>
            <th id="cell-desc" class="font-weight-semibold">Date</th>
            <th id="cell-price" class=" font-weight-semibold">Item</th>
            <th id="cell-qty" class=" font-weight-semibold">Quantity</th>
            <th id="cell-total" class=" font-weight-semibold">Departure</th>
            <th id="cell-total1" class=" font-weight-semibold">Destination</th>
            <th id="cell-total2" class=" font-weight-semibold">Rate</th>
            <th id="cell-total3" class=" font-weight-semibold">Payment</th>
            <th id="cell-total4" class=" font-weight-semibold">ISIV</th>
            <th id="cell-total5" class=" font-weight-semibold">Damage</th>
            <th id="cell-total6" class=" font-weight-semibold">Shortage</th>
            <th id="cell-total7" class=" font-weight-semibold">Over</th>
        </tr>
        </thead>
        <tbody>
        <?php $no = 1;
        while ($row = mysqli_fetch_assoc($goods)) {
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $row["plate_no"]; ?></td>
                <td><?php echo $row["approve_date"]; ?></td>
                <td><?php echo $row["title"]; ?></td>
                <td><?php echo $row["quantity"]; ?></td>
                <td style="text-transform: capitalize"><?php echo $row["departure"]; ?></td>
                <td style="text-transform: capitalize"><?php echo $row["destination"]; ?></td>
                <td style="text-transform: capitalize"><?php echo $row["rate"]; ?></td>
                <td><?php echo number_format($row["amount"], 2, ".", ","); ?></td>
                <td><?php echo $row["reference_number"]; ?></td>
                <td><?php echo $row["damege_pack"]; ?></td>
                <td><?php echo $row["shortage_pack"]; ?></td>
                <td><?php echo $row["over_pack"]; ?></td>
            </tr>
            <?php
            $total += $row["amount"];
            $username = $row["name"];

            if (strpos($row["title"], "600") !== false) {
                $price600 = $row["price"];
                $shortage1 += $row["shortage_pack"];

            }
            if (strpos($row["title"], "1000") !== false) {
                $price1000 = $row["price"];
                $shortage2 += $row["shortage_pack"];
            }
            if (strpos($row["title"], "1500") !== false) {
                $price1500 = $row["price"];
                $shortage3 += $row["shortage_pack"];
            }

            if ($row["damege_pack"] > 3) {
                if (strpos($row["title"], "600") !== false)
                    $damage1 += ($row["damege_pack"] - 3);
                if (strpos($row["title"], "1000") !== false)
                    $damage2 += ($row["damege_pack"] - 3);
                if (strpos($row["title"], "1500") !== false)
                    $damage3 += ($row["damege_pack"] - 3);
            }
        } ?>
        <tr>
            <td colspan="6" style="border: none"></td>
            <td style="font-size: 17px;font-weight: bolder" colspan="2">Total</td>
            <td style="font-size: 17px;font-weight: bolder"
                colspan="2"><?php echo number_format($total, 2, ".", ","); ?></td>
            <td colspan="3" style="border: none"></td>
        </tr>
        <tr>
            <td colspan="6" style="border: none"></td>
            <td colspan="4" style="text-align: center">Please Dedact for Damege and Shortage as follows</td>
            <td colspan="3" style="border: none"></td>
        </tr>
        <tr>
            <td colspan="6" style="border: none"></td>
            <td>Item</td>
            <td>Pack's</td>
            <td>Price</td>
            <td>Total Price</td>
            <td colspan="3" style="border: none"></td>
        </tr>
        <tr>
            <td colspan="3" style="border: none"></td>
            <td colspan="3" style="border: 1px solid #e9ecef;border-bottom:none;text-align: center" rowspan="1">Please
                prepare
                the payment by the name of
            </td>
            <td>600ML</td>
            <td><?php echo $damage1 + $shortage1; ?></td>
            <td><?php echo number_format($price600, 2, ".", ","); ?></td>
            <td><?php echo number_format(($damage1 + $shortage1) * $price600, 2, ".", ","); ?></td>
            <td colspan="3" style="border: none"></td>
        </tr>
        <tr>
            <td colspan="3" style="border: none"></td>
            <td colspan="3" rowspan="2"
                style="border: 1px solid #e9ecef;text-align: center;border-top: none;font-size: 20px;font-weight: bolder">
                <?php echo $username; ?>
            </td>
            <td>1000ML</td>
            <td><?php echo $damage2 + $shortage2; ?></td>
            <td><?php echo number_format($price1000, 2, ".", ","); ?></td>
            <td><?php echo number_format(($damage2 + $shortage2) * $price1000, 2, ".", ","); ?></td>
            <td colspan="3" style="border: none"></td>
        </tr>
        <tr>
            <td colspan="3" style="border: none"></td>
            <td>1500ML</td>
            <td><?php echo $damage3 + $shortage3; ?></td>
            <td><?php echo number_format($price1500, 2, ".", ","); ?></td>
            <td><?php echo number_format(($damage3 + $shortage3) * $price1500, 2, ".", ","); ?></td>
            <td colspan="3" style="border: none"></td>
        </tr>
        <tr>
            <td colspan="7" style="border: none"></td>
            <td><?php echo $damage1 + $damage2 + $damage3 + $shortage1 + $shortage2 + $shortage3; ?></td>
            <td><?php echo number_format(($price600 + $price1000 + $price1500), 2, ".", ","); ?></td>
            <td><?php echo number_format(($damage1 + $shortage1) * $price600 + ($damage2 + $shortage2) * $price1000 + ($damage3 + $shortage3) * $price1500, 2, ".", ","); ?></td>
            <td colspan="3" style="border: none"></td>
        </tr>
        <tr>
            <td colspan="8" style="border: none"></td>
            <td colspan="2"
                style="font-size: 17px;font-weight: bolder"><?php echo number_format($total - (($damage1 + $shortage1) * $price600 + ($damage2 + $shortage2) * $price1000 + ($damage3 + $shortage3) * $price1500), 2, ".", ","); ?></td>
            <td colspan="3" style="border: none"></td>
        </tr>
        </tbody>
    </table>

    <div class="invoice-summary">
        <div class="row justify-content-end">

            <div class="col-sm-11 pr-5">
                <table class="table h6 text-dark">
                    <tbody>
                    <tr class="b-top-0" style="text-align: right;">
                        <td colspan="2" style="border: none">Checked By ________________________</td>
                        <td colspan="2" style="border: none">Checked By ________________________</td>
                        <td colspan="2" style="border: none">Approved By ________________________</td>
                    </tr>
                    <tr style="text-align: right;">
                        <td colspan="2" style="border:none;padding-top: 15px">Date ________________________</td>
                        <td colspan="2" style="border:none;padding-top: 15px">Date ________________________</td>
                        <td colspan="2" style="border:none;padding-top: 15px">Date ________________________</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-1"></div>
        </div>
    </div>
</div>

<script>
    window.print();
	window.close();
</script>
</body>

</html>