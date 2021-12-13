<?php
require_once("../../includes/db_connection.php");
require_once("../../includes/session.php");
require_once("../../includes/functions.php");

if (isset($_POST["itemChecking"]) && isset($_POST["category"]) && isset($_POST["branch"]) && isset($_POST["expiered_date"])) {
    $item = find_product_by_barcode($_POST["itemChecking"]);
	$category = $_POST["category"];
  
    if ($item) {
        $user = $_SESSION["admin_id"];
        $expiered_date = $_POST["expiered_date"];
        $warehouse = $_POST["branch"];
        $wareName = find_branch_by_id($warehouse)["title"];
        $invexp_itm = find_expire_Inventory_itm_ed($item["id"], $warehouse);
        $invexp_itm_q = find_expire_Inventory_itm_ed_q($item["id"], $warehouse);
        $invexp = find_expire_Inventory_Edate($item["id"], $warehouse, $expiered_date);
        $invEqty=find_expire_Inventory_Quantity($item["id"], $warehouse, $expiered_date);
        $inv_qty = find_Inventory_by_Item($item["id"], $warehouse);
        $price = find_price_by_item_id_and_group($item["id"],$category);
        ?>
        <td data-title="Code" class="text-left"><?php echo $item["code"]; ?></td>
        <td data-title="title" class="text-left"><?php echo $item["title"]; ?></td>
        <td data-title="Price" class="text-left"><?php echo $price["price"]; ?> ETB</td>
        <td data-title="warehouse" class="text-left"><?php echo $wareName; ?></td>
       <td data-title="expiered_date" class="text-left">
            <?php echo (($expiered_date == "") ? $invexp_itm : $invexp); ?>
        </td>
        <td data-title="qty" class="text-left">
            <?php echo (($expiered_date == "") ? $invexp_itm_q : $invEqty) . " " . $item["measurment"]; ?>
        </td>
        <td data-title="qty" class="text-left">
            <?php echo (($inv_qty == "") ? "0" : $inv_qty) . " " . $item["measurment"]; ?>
        </td>
    <?php
    }
} elseif (isset($_POST["itemAdded"]) && isset($_POST["qty"]) && isset($_POST["category"]) && isset($_POST["branch"])) {
    $items = find_product_by_barcode($_POST["itemAdded"]);
    $qty = $_POST["qty"];
    $category = $_POST["category"];
    $tin = $_POST["tin"];
    $comp = $_POST["company"];
    $warehouse = $_POST["branch"];
    $vat = $_POST["vat"];
    $payment = $_POST["payment"];
    $expiered_date = $_POST["expiered_date"];
    
    $inv_qty = find_Inventory_by_Item($items["id"], $warehouse);
    $cart_id = "0";

    $cart_id = find_max_cart_id();

    if (!isset($_SESSION["cart"])) {
        if ($cart_id == "")
            $_SESSION["cart"] = $_SESSION["admin_id"] . 0;
        else
            $_SESSION["cart"] = $cart_id + 1;
    }

    $check = find_item_in_cart($items["id"], $_SESSION["cart"]);
    $invEqty=find_expire_Inventory_Quantity($items["id"], $warehouse, $expiered_date);
    
   
    if ($check !== null)
        $qty = $check["qty"] + $qty;

    if ($invEqty >= $qty) {
        $price = find_price_by_item_id_and_group($items["id"],$category);

        if ($check == null) {
            $val = create_cart($_SESSION["cart"], $items["id"], $items["code"], $items["title"], $warehouse, $category, $price["price"], $qty, $items["measurment"], $tin, $comp, $vat, $payment);
        } else {
            $val = update_cart($items["id"], $_SESSION["cart"], $qty);
        }
//        $_SESSION["art_error"] = null;

    } else {
//        $_SESSION["art_error"] = "Please check your stock.";
    }

    $subtotal = 0;
    $vat = 0;
    $total = 0;
    $carts = find_cart_by_cart_id($_SESSION["cart"]);
    while ($row = mysqli_fetch_assoc($carts)) {
        if($row["qty"] > 0) {
            $subtotal += $row["price"] * $row["qty"];

            if($row["vat_type"] == 0){
                $vat += ($row["price"] * $row["qty"])*0.15;
            }
            ?>
            <tr>
                <td class="font-weight-semibold text-dark"><?php echo $row["title"] ." (". (($row["vat_type"] == 0)?"With":"Without") . ") "; ?></td>
                <td class="text-right"><?php echo number_format($row["price"], 2, '.', ','); ?></td>
                <td class="text-right"><?php echo $row["qty"] . " " . $row["uom"]; ?></td>
                <td class="text-right"><?php echo number_format($row["price"] * $row["qty"], 2, '.', ','); ?>
                </td>
            </tr>

        <?php
        }
    }
    
    $total = $subtotal + $vat;
    ?>
    <tr class="b-top-0" style="border-top: double">
        <td colspan="1"></td>
        <td colspan="1" class="text-right">Subtotal</td>
        <td colspan="2" class="text-right"><?php echo number_format($subtotal, 2, '.', ','); ?></td>
    </tr>
    <tr>
        <td colspan="1"></td>
        <td colspan="1" class="text-right">Vat</td>
        <td colspan="2" class="text-right"><?php echo number_format($vat, 2, '.', ','); ?></td>
    </tr>
    <tr class="h5">
        <td colspan="1"></td>
        <td colspan="1" class="text-right">Total</td>
        <td colspan="2" class="text-right"><?php echo number_format($total, 2, '.', ','); ?></td>
    </tr>

<?php

}
elseif (isset($_POST["createOrder"])) {
    $carts = "";
    if (isset($_SESSION["cart"])) {
        $carts = find_cart_by_cart_id($_SESSION["cart"]);
    }
    $order_id = find_max_order_id();

    if (!isset($_SESSION["order"])) {
        if ($order_id == "" || $order_id == null)
            $_SESSION["order"] = $_SESSION["admin_id"] . 0;
        else
            $_SESSION["order"] = $order_id + 1;
    }

    while ($row = mysqli_fetch_assoc($carts)) {
        $category = find_category_by_id(find_product_by_id($row["item"])['category'])['category'];
        $warehouse = $row["branch"];
        $user = $_SESSION["admin_id"];
        $expiered_date = $_POST["expiered_date"];
        $branch = $_POST["branch"]; 
        $qty = $_POST["qty"]; 
        $item = $_POST["item"];  
        $inv_qty = find_Inventory_by_Item($row["item"], trim($warehouse));
        $invEqty=find_expire_Inventory_Quantity($row["item"], $warehouse, $expiered_date);
    
        if ($invEqty >= $row["qty"]) {
           
          $inv1 = create_inventory($row["item"], "sales", -($row["qty"]), $category, $warehouse, $user, $expiered_date, "");
        //   $inv2 = update_inventory_expiration($row["item"], ($row["qty"]), $category, $expiered_date, $user, $warehouse, "");
          
            if ($inv1) {

                $check = create_order($_SESSION["order"], $row["item"], $row["code"], $row["title"], $warehouse, $row["price_group"], $row["price"], $row["qty"], $row["uom"], $row["tin"], $row["name"], $row["vat_type"], $row["payment_type"]);

                if ($check) {
//                    $_SESSION["art_message"] = "Sales Completed.";
                    delete_cart($row["cart_id"]);
                }

            } else
                $_SESSION["art_error"] = "Sales Failed.";
        } else {
            $_SESSION["art_error"] = "Please check your inventory.";
        }

    }

    if (isset($_SESSION["cart"])) {
        $carts = find_cart_by_cart_id($_SESSION["cart"]);
    }

    if ($carts == null || $carts == "") {
        $_SESSION["cart"] = null;
        $_SESSION["order"] = null;
    }

}
elseif (isset($_POST["cancelOrder"])) {
    $carts = "";
    if (isset($_SESSION["cart"])) {
        $carts = find_cart_by_cart_id($_SESSION["cart"]);
    }

    while ($row = mysqli_fetch_assoc($carts)) {

        delete_cart($row["cart_id"]);

    }

    if (isset($_SESSION["cart"])) {
        $carts = find_cart_by_cart_id($_SESSION["cart"]);
    }

    if ($carts == null || $carts == "") {
        $_SESSION["cart"] = null;
        $_SESSION["order"] = null;
    }

}
elseif (isset($_POST["cartView"])) {
    if (isset($_SESSION["cart"])) {
        $subtotal = 0;
        $vat = 0;
        $total = 0;
        $carts = find_cart_by_cart_id($_SESSION["cart"]);
        while ($row = mysqli_fetch_assoc($carts)) {
            if($row["qty"] > 0) {
                $subtotal += $row["price"] * $row["qty"];
                if($row["vat_type"] == 0)
                    $vat += ($row["price"] * $row["qty"])*0.15;
                ?>
                <tr>
                    <td class="text-dark"><?php echo $row["title"] ." (". (($row["vat_type"] == 0)?"With":"Without") . ") "; ?></td>
                    <td class="text-right"><?php echo number_format($row["price"], 2, '.', ','); ?></td>
                    <td class="text-right"><?php echo $row["qty"] . " " . $row["uom"]; ?></td>
                    <td class="text-right"><?php echo number_format($row["price"] * $row["qty"], 2, '.', ','); ?>
                    </td>
                </tr>

            <?php
            }
        }
       
        $total = $subtotal + $vat;
        ?>
        <tr class="b-top-0" style="border-top: double">
            <td colspan="1"></td>
            <td colspan="1" class="text-right">Subtotal</td>
            <td colspan="2" class="text-right"><?php echo number_format($subtotal, 2, '.', ','); ?></td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td colspan="1" class="text-right">Vat</td>
            <td colspan="2" class="text-right"><?php echo number_format($vat, 2, '.', ','); ?></td>
        </tr>
        <tr class="h5">
            <td colspan="1"></td>
            <td colspan="1" class="text-right">Total</td>
            <td colspan="2" class="text-right"><?php echo number_format($total, 2, '.', ','); ?></td>
        </tr>

    <?php
    }
}
?>    