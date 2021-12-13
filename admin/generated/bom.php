<?php require_once("../../includes/db_connection.php"); ?>
<?php require_once("../../includes/session.php"); ?>
<?php require_once("../../includes/functions.php"); ?>
<?php require_once("../../includes/validation_functions.php"); ?>
<?php
$product = find_product_by_category(1);

if (isset($_POST["increament_id"])) {
    $i = $_POST["increament_id"];
    ?>
    <div class="form-group row dynamic-added">

        <div class="col-lg-3 row">
            <div class="col-lg-12">
                <select name="raw_item[]" id="raw_item" data-plugin-selectTwo class="form-control populate" required>
                    <option value="">Select Raw Material</option>
                    <?php
                    while ($row = mysqli_fetch_assoc($product)) {
                        ?>
                        <option
                            value="<?php echo $row["id"] ?>"><?php echo $row["code"] . ' / ' . $row["title"]; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-lg-3 row">
            <div class="col-lg-12">
                <input type="text" name="raw_qty[]" id="raw_qty" class="form-control" data-plugin-maxlength
                       maxlength="200" required/>
            </div>

        </div>

    </div>
<?php

}
elseif (isset($_POST["raw_item"]) && isset($_POST["raw_qty"]) && isset($_POST["pro_item"]) && isset($_POST["pro_qty"])) {
    $pro_item = $_POST["pro_item"];
    $pro_qty = $_POST["pro_qty"];
    $raw_item = json_encode($_POST["raw_item"]);
    $raw_qty = json_encode($_POST["raw_qty"]);

    create_productionBom($_POST["pro_item"], $_POST["pro_qty"], $raw_item, $raw_qty, $_SESSION["admin_id"]);

} elseif (isset($_POST["bomId"])) {

    $bom = find_ProductionBom_by_id($_POST["bomId"]);

    $output = '<header class="card-header">';
    $output .= '<h2 class="card-title">' . find_product_by_id($bom["item_id"])["code"] . ' /  ' . find_product_by_id($bom["item_id"])["title"] . ' Production components.</h2>';
    $output .= '</header>';
    $output .= '<div class="card-body" style="padding: 1.0rem 0 1.0rem 1.0rem;">';
    $output .= '<div class="row" style="background: linen;font-size: 17px;">';
    $output .= '<label class="col-lg-2 control-label  pt-2">No</label>';
    $output .= '<label class="col-lg-5 control-label  pt-2">Item</label>';
    $output .= '<label class="col-lg-4 control-label  pt-2">Quantity</label>';
    $output .= '</div> ';
    for ($k = 0; $k < sizeof(json_decode($bom["raw_item_id"])); $k++) {
        if (!empty(json_decode($bom["raw_item_id"])[$k]) && !empty(json_decode($bom["raw_quantity"])[$k])) {
            $output .= '<div class="row" style="border-bottom: 1px solid #eff2f7;">';
            $output .= '<label class="col-lg-2 control-label  pt-2">' . ($k + 1) . '</label>';
            $output .= '<label class="col-lg-5 control-label  pt-2">' . find_product_by_id(json_decode($bom["raw_item_id"])[$k])["code"] . ' / ' . find_product_by_id(json_decode($bom["raw_item_id"])[$k])["title"] . '</label>';
            $output .= '<label class="col-lg-4 control-label  pt-2">' . json_decode($bom["raw_quantity"])[$k] . ' ' . find_product_by_id(json_decode($bom["raw_item_id"])[$k])["measurment"] . '</label>';
            $output .= '</div> ';
        }
    }
    $output .= '</div>';

    echo $output;
}
?>