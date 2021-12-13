<?php
/**
 * Created by PhpStorm.
 * User: Melkamu
 * Date: 5/8/2019
 * Time: 8:46 PM
 */
require_once("../../includes/db_connection.php");
require_once("../../includes/session.php");
require_once("../../includes/functions.php");

if (isset($_POST["item"]) && isset($_POST["quantity"])) {
    $item = $_POST["item"];
    $qty = $_POST["quantity"];
    $user = $_SESSION["admin_id"];

    create_purchase_request($item, $qty, $user);
}
elseif (isset($_POST["por_id"]) && isset($_POST["receive_quantity"])) {
    $pr_id = $_POST["por_id"];
    $pr_driver = $_POST["driver_name"];
    $pr_phone = $_POST["driver_phone"];
    $pr_plate = $_POST["plate_no"];
    $qty = str_replace(',', '', $_POST["receive_quantity"]);
    $user = $_SESSION["admin_id"];

    $order = find_purchase_order_by_id($pr_id);

    $diff = $order["quantity"] - $order["received_qty"];

    if ($diff >= $qty) {
        $pu_qty = pu_order_received_quantity($pr_id, $qty, $pr_plate, $pr_driver, $pr_phone, $user);
        if ($pu_qty) {
            $qty = $qty + $order["received_qty"];
            update_purchase_receive($pr_id, $qty, $user);
        } else
            $_SESSION["art_error"] = "Please try again !!";

    } else
        $_SESSION["art_error"] = "Receive quantity is less than ordered quantity!!";

}
elseif (isset($_POST["poi_id"]) && isset($_POST["invoice_quantity"])) {
    $pr_id = $_POST["poi_id"];
    $qty = str_replace(',', '', $_POST["invoice_quantity"]);
    $user = $_SESSION["admin_id"];

    $invoice = find_purchase_order_by_id($pr_id);

    $diff = $invoice["received_qty"] - $invoice["invoced_qty"];

    if ($diff >= $qty) {
        $qty = $qty + $invoice["invoced_qty"];
        update_purchase_invoice($pr_id, $qty, $user);
    } else
        $_SESSION["art_error"] = $diff . " Invoice quantity less than received quantity. " . $qty;

}
elseif (isset($_POST["pr_id"]) && isset($_POST["ap_quantity"])) {
    $pr_id = $_POST["pr_id"];
    $pr_driver = $_POST["driver_name"];
    $pr_phone = $_POST["driver_phone"];
    $pr_plate = $_POST["plate_no"];
    $qty = str_replace(',', '', $_POST["ap_quantity"]);
    $user = $_SESSION["admin_id"];

    $request = find_purchase_request_by_id($pr_id);

    $diff = $request["quantity"] - $request["approved_quantity"];

    if ($diff >= $qty) {
        $pu_re = pu_request_approved_quantity($pr_id, $qty, $user);
        if ($pu_re) {
//            $pu_qty = pu_order_received_quantity($pr_id, $qty, $pr_plate, $pr_driver, $pr_phone, $user);
//            if ($pu_qty) {
            $qty = $qty + $request["approved_quantity"];
            approve_purchase_request($pr_id, $qty, $user);
//            } else
//                $_SESSION["art_error"] = "Please try again !!";
        }
    } else
        $_SESSION["art_error"] = "Please check the quantity !!";

}
elseif (isset($_POST["purchaseRequestId"])) {

    echo art_message();
    $request = find_purchase_request_by_id($_POST["purchaseRequestId"]);
    ?>
    <form class="form-horizontal form-bordered" action="#" method="post">

        <div class="form-group row">
            <label class="col-lg-4 control-label text-lg-right pt-2">Requested Item</label>

            <div class="col-lg-8">
                <select name="item" id="item" data-plugin-selectTwo
                        class="form-control populate" style="width: 100%" disabled>
                    <option
                        value=''><?php echo find_product_by_id($request["item_id"])["code"] . " / " . find_product_by_id($request["item_id"])['title']; ?></option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-4 control-label text-lg-right pt-2">Requested Quantity</label>

            <div class="col-lg-8">
                <input type="text" name="re_quantity" id="re_quantity" class="form-control"
                       data-plugin-maxlength value="<?php echo number_format($request["quantity"], 2, '.', ','); ?>"
                       maxlength="100" disabled/>
            </div>

        </div>

        <div class="form-group row">
            <label class="col-lg-4 control-label text-lg-right pt-2">Last Approved</label>

            <div class="col-lg-8">
                <input type="text" name="re_quantity" id="re_quantity" class="form-control"
                       data-plugin-maxlength
                       value="<?php echo number_format($request["approved_quantity"], 2, '.', ','); ?>"
                       maxlength="100" disabled/>
            </div>

        </div>

        <div class="form-group row">
            <label class="col-lg-4 control-label text-lg-right pt-2">Approve Quantity</label>

            <div class="col-lg-8">
                <input type="text" name="ap_quantity" id="ap_quantity" class="form-control"
                       data-plugin-maxlength
                       value="<?php echo number_format(($request["quantity"] - $request["approved_quantity"]), 2, '.', ','); ?>"
                       maxlength="100" required/>
            </div>

        </div>

    </form>

<?php
}
elseif (isset($_POST["purchaseOrderId"])) {

    $order = find_purchase_order_by_id($_POST["purchaseOrderId"]);
    ?>
    <form class="form-horizontal form-bordered" action="#" method="post">

        <div class="form-group row">
            <label class="col-lg-4 control-label text-lg-right pt-2">Ordered Item</label>

            <div class="col-lg-8">
                <select name="item" id="item" data-plugin-selectTwo
                        class="form-control populate" style="width: 100%" disabled>
                    <option
                        value=''><?php echo find_product_by_id(find_purchase_request_by_id($order["pu_request_id"])['item_id'])["code"]
                            . " / " . find_product_by_id(find_purchase_request_by_id($order["pu_request_id"])['item_id'])["title"]; ?></option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-4 control-label text-lg-right pt-2">Ordered Quantity</label>

            <div class="col-lg-8">
                <input type="text" name="or_quantity" id="or_quantity" class="form-control"
                       data-plugin-maxlength value="<?php echo number_format($order["quantity"], 2, '.', ','); ?>"
                       maxlength="100" disabled/>
            </div>

        </div>

        <div class="form-group row">
            <label class="col-lg-4 control-label text-lg-right pt-2">Last Received</label>

            <div class="col-lg-8">
                <input type="text" name="re_quantity" id="re_quantity" class="form-control"
                       data-plugin-maxlength
                       value="<?php echo number_format($order["received_qty"], 2, '.', ','); ?>"
                       maxlength="100" disabled/>
            </div>

        </div>

        <div class="form-group row">
            <label class="col-lg-4 control-label text-lg-right pt-2">Received Quantity</label>

            <div class="col-lg-8">
                <input type="text" name="receive_quantity" id="receive_quantity" class="form-control"
                       data-plugin-maxlength
                       value="<?php echo number_format(($order["quantity"] - $order["received_qty"]), 2, '.', ','); ?>"
                       maxlength="100" required/>
            </div>

        </div>

        <div class="form-group row">
            <label class="col-lg-4 control-label text-lg-right pt-2">Plate No</label>

            <div class="col-lg-8">
                <input type="text" name="plate_no" id="plate_no" class="form-control"
                       data-plugin-maxlength maxlength="100" required/>
            </div>

        </div>

        <div class="form-group row">
            <label class="col-lg-4 control-label text-lg-right pt-2">Driver Name</label>

            <div class="col-lg-8">
                <input type="text" name="driver_name" id="driver_name" class="form-control"
                       data-plugin-maxlength maxlength="100" required/>
            </div>

        </div>


        <div class="form-group row">
            <label class="col-lg-4 control-label text-lg-right pt-2">Driver Phone</label>

            <div class="col-lg-8">
                <div class="input-group">
                    <span class="input-group-addon"> <i class="fa fa-phone"></i> </span>
                    <input name="phone" id="phone" data-plugin-masked-input
                           data-input-mask="(99)-9999-9999"
                           placeholder="(09)-1234-1234"
                           class="form-control">
                </div>
            </div>
        </div>

    </form>

<?php
}
elseif (isset($_POST["purchaseInvoiceId"])) {

    $order = find_purchase_order_by_id($_POST["purchaseInvoiceId"]);
    ?>
    <form class="form-horizontal form-bordered" action="#" method="post">

        <div class="form-group row">
            <label class="col-lg-4 control-label text-lg-right pt-2">Ordered Item</label>

            <div class="col-lg-8">
                <select name="item" id="item" data-plugin-selectTwo
                        class="form-control populate" style="width: 100%" disabled>
                    <option
                        value=''><?php echo find_product_by_id(find_purchase_request_by_id($order["pu_request_id"])['item_id'])["title"] . " / " . find_product_by_id(find_purchase_request_by_id($order["pu_request_id"])['item_id'])["title"]; ?></option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-4 control-label text-lg-right pt-2">Ordered Quantity</label>

            <div class="col-lg-8">
                <input type="text" name="or_quantity" id="or_quantity" class="form-control"
                       data-plugin-maxlength value="<?php echo number_format($order["quantity"], 2, '.', ','); ?>"
                       maxlength="100" disabled/>
            </div>

        </div>

        <div class="form-group row">
            <label class="col-lg-4 control-label text-lg-right pt-2">Received Quantity</label>

            <div class="col-lg-8">
                <input type="text" name="or_quantity" id="or_quantity" class="form-control"
                       data-plugin-maxlength value="<?php echo number_format($order["received_qty"], 2, '.', ','); ?>"
                       maxlength="100" disabled/>
            </div>

        </div>

        <div class="form-group row">
            <label class="col-lg-4 control-label text-lg-right pt-2">Last Invoiced</label>

            <div class="col-lg-8">
                <input type="text" name="inv_quantity" id="inv_quantity" class="form-control"
                       data-plugin-maxlength
                       value="<?php echo number_format($order["invoced_qty"], 2, '.', ','); ?>"
                       maxlength="100" disabled/>
            </div>

        </div>

        <div class="form-group row">
            <label class="col-lg-4 control-label text-lg-right pt-2">Invoiced Quantity</label>

            <div class="col-lg-8">
                <input type="text" name="invoiced_quantity" id="invoiced_quantity" class="form-control"
                       data-plugin-maxlength
                       value="<?php echo number_format(($order["received_qty"] - $order["invoced_qty"]), 2, '.', ','); ?>"
                       maxlength="100" required/>
            </div>

        </div>

    </form>

<?php
}
elseif (isset($_POST["pu_request"])) {

    $pu_request = find_purchase_request_by_id($_POST["pu_request"]);

    $output = '<div class="form-group row">';
    $output .= '<label class="col-lg-4 control-label text-lg-right pt-2">Item</label>';
    $output .= '<div class="col-lg-8" ><input type="text" name="code" id="code" class="form-control" disabled data-plugin-maxlength value="';
    $output .= find_product_by_id($pu_request["item_id"])["code"] . " / " . find_product_by_id($pu_request["item_id"])["title"];
    $output .= '" maxlength="100" required/> </div>';
    $output .= '</div> ';
    $output .= '<div class="row" style="border-bottom: 1px solid #eff2f7;padding-bottom: 15px;margin-bottom: 15px;">';
    $output .= '<label class="col-lg-4 control-label text-lg-right pt-2">Quantity</label>';
    $output .= '<div class="col-lg-8" ><input type="text" name="quantity" id="quantity" class="form-control" data-plugin-maxlength value="';
    $output .= number_format(($pu_request["approved_quantity"] - $pu_request["ordered_quantity"]), 2, '.', ',');
    $output .= '" maxlength="100" required/> </div>';
    $output .= '</div> ';
    echo $output;
}
elseif (isset($_POST["customer_category"])) {

    $customer_category = find_customer_by_category($_POST["customer_category"]);

    echo "<option value=''>------- Select --------</option>";

    while ($row = mysqli_fetch_assoc($customer_category)) {
        echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
    }
} elseif (isset($_POST["purchase_request"]) && isset($_POST["order_quantity"]) && isset($_POST["vendor"]) && isset($_POST["s_date"]) && isset($_POST["warehouse"]) && isset($_POST["unit_price"])) {

    $pu_request = find_purchase_request_by_id($_POST["purchase_request"]);

    $pr_id = $_POST["purchase_request"];
    $vendor = $_POST["vendor"];
    $s_date = substr($_POST["s_date"], 6, 4) . "-" . substr(str_replace('/', '-', $_POST["s_date"]), 0, 6);
    $unit_price = $_POST["unit_price"];
    $warehouse = $_POST["warehouse"];
    $u_id = $_SESSION["admin_id"];
    $qty = str_replace(',', '', $_POST["order_quantity"]);

    $diff = $pu_request["approved_quantity"] - $pu_request["ordered_quantity"];

    if ($qty <= $diff) {
        $result = create_purchase_order($pr_id, $vendor, $qty, $s_date, $unit_price, $warehouse, $u_id);
        if ($result) {
            update_approved_purchase_request($_POST["purchase_request"], ($pu_request["ordered_quantity"] + $qty));

            $_SESSION["art_message"] = "Purchase Order created.";
        }

    } else {
        $_SESSION["art_error"] = "Please check the quantity !!";
    }

}

?>