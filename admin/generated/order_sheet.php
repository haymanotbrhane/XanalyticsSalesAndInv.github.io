<?php
require_once("../../includes/db_connection.php");
require_once("../../includes/session.php");
require_once("../../includes/functions.php");

if (isset($_POST["product"])) {

    $output = "";

    for ($k = 0; $k < sizeof($_POST["product"]); $k++) {
        $attribute = json_decode(find_order_product_by_id($_POST["product"][$k])["attribute"]);
        $measurement = json_decode(find_order_product_by_id($_POST["product"][$k])["measurment"]);
        $item_code = find_all_item_code();

        $output .= '<div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2"></label>
                            <div class="col-lg-10" style="font-size: 16px;font-weight: bolder;color: #df6f2d">' . find_order_product_by_id($_POST["product"][$k])["title"] . '</div>' .
            '</div>';

        $output .= '<div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2"></label>
                            <div class="col-lg-9" style="font-size: 12px;font-weight: bold">' . find_order_product_by_id($_POST["product"][$k])["title"] . ' Attributes</div>
                    </div>';

        for ($i = 0; $i < sizeof($attribute); $i++) {
            $output .= '<div class="form-group row" style="margin-bottom: 5px;">';
            $output .= '<label class="col-lg-4 control-label text-lg-right pt-2">' .
                find_attribute_by_id($attribute[$i])["title"] .
                '</label>';
            $output .= '<div class="col-lg-8">
                        <select name="attr_' . $_POST["product"][$k] . '_' . $attribute[$i] . '" data-plugin-selectTwo class="form-control populate" required>';
            $attr_val = find_attribute_value_by_attribute_id($attribute[$i]);
            $output .= '<option value="">Select Attribute</option>';
            while ($attr = mysqli_fetch_assoc($attr_val)) {
                $output .= '<option value="' . $attr["id"] . '">' . $attr["title"] . '</option>';
            }
            $output .= '</select></div> </div>';
        }

        $output .= '<div class="form-group row">
                            <label class="col-lg-2 control-label text-lg-right pt-2"></label>
                            <div class="col-lg-9" style="font-size: 12px;font-weight: bold">' . find_order_product_by_id($_POST["product"][$k])["title"] . ' Measurements</div>
                    </div>';

        for ($i = 0; $i < sizeof($measurement); $i++) {
            $output .= '<div class="form-group row" style="margin-bottom: 5px;">';
            $output .= '<label class="col-lg-4 control-label text-lg-right pt-2">' .
                find_measurement_by_id($measurement[$i])["title"] .
                '</label>';
            $output .= '<div class="col-lg-8">';
            $output .= '<input type="text" class="form-control" data-plugin-maxlength maxlength="100" required name="measur_' . $_POST["product"][$k] . '_' . $measurement[$i] . '"/>';
            $output .= '</div> </div>';
        }

    }
    echo $output;
} elseif (isset($_POST["orderID"]) && isset($_POST["status"])) {
    $id = $_POST["orderID"];
    $status = $_POST["status"];

    $query = "UPDATE order_sheet SET ";
    $query .= "status = '{$status}' ";
    $query .= "WHERE id = {$id}; ";
    $result = mysqli_query($connection, $query);

    if ($result) {
        // Success
        $_SESSION["art_message"] = "Status successfully updated";

    } else {
        // Failure
        $_SESSION["art_error"] = "Status update failed.";
    }
} elseif (isset($_POST["Order_ID"])) {
    $data = $_POST["Order_ID"];
    $order = find_order_sheet_by_id($data);
    ?>
    <div class="modal-body">
        <section class="card">
            <header class="card-header" style="background: rgba(0,0,0,.02)">

                <h2 class="card-title"
                    style="text-align: center"><?php echo $order["customet_name"] . ' / ' . $order["order_number"]; ?>
                </h2>
            </header>
            <div class="card-body">

                <div class="form-group row" style="border-bottom: 1px solid #eff2f7;margin-bottom: 0">

                    <label class="control-label text-lg-right pt-2 pr-3 col-md-5" style="font-weight: bolder">
                        Branch
                    </label>

                    <label class="control-label pt-2 col-md-7">
                        <?php echo find_branch_by_id($order["branch"])["title"]; ?>
                    </label>
                </div>

                <div class="form-group row" style="border-bottom: 1px solid #eff2f7;margin-bottom: 0">

                    <label class="control-label text-lg-right pt-2 pr-3 col-md-5" style="font-weight: bolder">
                        Order Date
                    </label>

                    <label class="control-label pt-2 col-md-7">
                        <?php echo $order["order_date"]; ?>
                    </label>
                </div>

                <div class="form-group row" style="border-bottom: 1px solid #eff2f7;margin-bottom: 0">

                    <label class="control-label text-lg-right pt-2 pr-3 col-md-5" style="font-weight: bolder">
                        Order Number
                    </label>

                    <label class="control-label pt-2 col-md-7">
                        <?php echo $order["order_number"]; ?>
                    </label>
                </div>

                <div class="form-group row" style="border-bottom: 1px solid #eff2f7;margin-bottom: 0">

                    <label class="control-label text-lg-right pt-2 pr-3 col-md-5" style="font-weight: bolder">
                        Customer Name
                    </label>

                    <label class="control-label pt-2 col-md-7">
                        <?php echo $order["customet_name"]; ?>
                    </label>
                </div>

                <div class="form-group row" style="border-bottom: 1px solid #eff2f7;margin-bottom: 0">

                    <label class="control-label text-lg-right pt-2 pr-3 col-md-5" style="font-weight: bolder">
                        Customer Phone
                    </label>

                    <label class="control-label pt-2 col-md-7">
                        <?php echo $order["customer_phone"]; ?>
                    </label>
                </div>

                <div class="form-group row" style="border-bottom: 1px solid #eff2f7;margin-bottom: 0">

                    <label class="control-label text-lg-right pt-2 pr-3 col-md-5" style="font-weight: bolder">
                        Customer Gender
                    </label>

                    <label class="control-label pt-2 col-md-7" style="text-transform: capitalize">
                        <?php echo $order["customer_sex"]; ?>
                    </label>
                </div>

                <div class="form-group row" style="border-bottom: 1px solid #eff2f7;margin-bottom: 0">

                    <label class="control-label text-lg-right pt-2 pr-3 col-md-5" style="font-weight: bolder">
                        Total Payment
                    </label>

                    <label class="control-label pt-2 col-md-7">
                        <?php echo number_format($order["total_payment"], 2, '.', ','); ?>
                    </label>
                </div>

                <div class="form-group row" style="border-bottom: 1px solid #eff2f7;margin-bottom: 0">

                    <label class="control-label text-lg-right pt-2 pr-3 col-md-5" style="font-weight: bolder">
                        Advance Payment
                    </label>

                    <label class="control-label pt-2 col-md-7">
                        <?php echo number_format($order["advance_payment"], 2, '.', ','); ?>
                    </label>
                </div>

                <div class="form-group row" style="border-bottom: 1px solid #eff2f7;margin-bottom: 0">

                    <label class="control-label text-lg-right pt-2 pr-3 col-md-5" style="font-weight: bolder">
                        Remaining Payment
                    </label>

                    <label class="control-label pt-2 col-md-7">
                        <?php echo number_format($order["total_payment"] - $order["advance_payment"], 2, '.', ','); ?>
                    </label>
                </div>

                <div class="form-group row" style="border-bottom: 1px solid #eff2f7;margin-bottom: 0">

                    <label class="control-label text-lg-right pt-2 pr-3 col-md-5" style="font-weight: bolder">
                        Appointment Date
                    </label>

                    <label class="control-label pt-2 col-md-7">
                        <?php echo $order["appointment_date"]; ?>
                    </label>
                </div>

                <div class="form-group row" style="border-bottom: 1px solid #eff2f7;margin-bottom: 0">

                    <label class="control-label text-lg-right pt-2 pr-3 col-md-5" style="font-weight: bolder">
                        Delivery Date
                    </label>

                    <label class="control-label pt-2 col-md-7">
                        <?php echo $order["delivery_date"]; ?>
                    </label>
                </div>

                <div class="form-group row" style="border-bottom: 1px solid #eff2f7;margin-bottom: 0">

                    <label class="control-label text-lg-right pt-2 pr-3 col-md-5" style="font-weight: bolder">
                        Created By
                    </label>

                    <label class="control-label pt-2 col-md-7" style="text-transform: capitalize">
                        <?php echo find_user_by_id($order["created_by"])["name"]; ?>
                    </label>
                </div>

                <div class="form-group row" style="border-bottom: 1px solid #eff2f7;margin-bottom: 0">

                    <label class="control-label text-lg-right pt-2 pr-3 col-md-5" style="font-weight: bolder">
                        Description
                    </label>

                    <label class="control-label pt-2 col-md-7" style="text-transform: capitalize">
                        <?php echo $order["description"]; ?>
                    </label>
                </div>

                <?php
                $output = "";
                $product = (array)json_decode($order["product_id"]);
                for ($k = 0; $k < sizeof($product); $k++) {
                    $attribute = (array)json_decode($order["attribute_value"]);
                    $measurement = (array)json_decode($order["measurment"]);
                    $item_code = (array)json_decode($order["item_code"]);

                    $attributes = json_decode(find_order_product_by_id($product[$k])["attribute"]);
                    $measurements = json_decode(find_order_product_by_id($product[$k])["measurment"]);

                    $output .= '<div class="form-group row" style="margin-bottom: 0">
                            <div class="col-lg-12" style="font-size: 16px;font-weight: bolder;color: #df6f2d">' . find_order_product_by_id($product[$k])["title"] . '</div> </div>';

                    $output .= '<div class="form-group row" style="margin-bottom: 0">
                            <label class="col-lg-1 control-label text-lg-left pt-1"></label>
                            <div class="col-lg-11" style="font-size: 13px;font-weight: bolder;color: #174497;text-decoration: underline">' . find_order_product_by_id($product[$k])["title"] . ' Attributes</div> </div>';

                    $output .= '<div class="form-group row" style="margin-bottom: 0">';
                    $output .= '<label class="col-lg-1 control-label text-lg-left pt-0"></label>';
                    $output .= '<label class="col-lg-11 control-label text-lg-left pt-0">';
                    for ($i = 0; $i < sizeof($attributes); $i++) {
                        $output .= find_attribute_value_by_id($attribute[$product[$k] . '_' . $attributes[$i]])["title"] . ' , ';
                    }
                    $output .= '</label></div>';

                    $output .= '<div class="form-group row" style="margin-bottom: 0">
                            <label class="col-lg-1 control-label text-lg-left pt-0"></label>
                            <div class="col-lg-11" style="font-size: 13px;font-weight: bolder;color: #174497;text-decoration: underline">' . find_order_product_by_id($product[$k])["title"] . ' Measurements</div> </div>';

                    $output .= '<div class="form-group row" style="margin-bottom: 0">';
                    $output .= '<label class="col-lg-1 control-label text-lg-left pt-0"></label>';
                    $output .= '<label class="col-lg-11 control-label text-lg-left pt-0">';
                    for ($i = 0; $i < sizeof($measurements); $i++) {
                        $output .= find_measurement_by_id($measurements[$i])["title"] . ' = ' . $measurement[$product[$k] . '_' . $measurements[$i]] . ' ' .
                            find_measurement_by_id($measurements[$i])["uom"] . ' , ';
                    }
                    $output .= '</label></div>';

                }
                echo $output;
                ?>

            </div>
        </section>
    </div>
    <footer class="card-footer">
        <div class="row">
            <div class="col-md-12 text-right">
                <button class="btn btn-default modal-dismiss" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </footer>

<?php
}
