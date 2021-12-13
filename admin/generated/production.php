<?php
/**
 * Created by PhpStorm.
 * User: Melkamu
 * Date: 6/28/2019
 * Time: 10:49 AM
 */
require_once("../../includes/db_connection.php");
require_once("../../includes/session.php");
require_once("../../includes/functions.php");

if (isset($_POST["production_plan"]) && isset($_POST["finished_quantity"]) && isset($_POST["damaged_quantity"]) && isset($_POST["returned_quantity"])) {
    $id = $_POST["production_plan"];
    $f_qty = $_POST["finished_quantity"];
    $d_qty = $_POST["damaged_quantity"];
    $r_qty = $_POST["returned_quantity"];

    $query = "update `production_plan` set `finished_qty` = {$f_qty}, `damage_qty` = {$d_qty}, `return_qty` = {$r_qty}, production_status = 1 where id = {$id};";
    $result_set = mysqli_query($connection, $query);

    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "Production Completed.";

    } else {
        // Failure
        $_SESSION["art_error"] = "Please try again.";
    }

}
elseif (isset($_POST["productionPlan"])) {

    $item = find_ProductionPlan_by_id($_POST["productionPlan"]);
    $bom = find_ProductionBom_by_item($item["item_id"]);

    $output = '
    <header class="card-header">
        <h2 class="card-title">Production Quantity</h2>
    </header>
    <div class="card-body" style="padding: 10px;">
        <form class="form-horizontal form-bordered" action="#" method="post">
            <div class="form-group row" style="margin-bottom: 5px;">
                <label class="col-lg-4 control-label text-lg-right pt-2">Produced Quantity</label>
                <div class="col-lg-8">
                    <input type="text" name="pr_qty" id="pr_qty" class="form-control"
                           data-plugin-maxlength maxlength="100" required/>
                </div>
            </div>

            <div class="form-group row" style="padding-bottom: 0 !important;margin-bottom: 0">
                <label class="col-lg-12 control-label text-lg-right pt-1"
                style="text-align: center !important;font-weight: bolder;text-decoration: underline;">Damage Quantity</label>
                
            </div>';

    for ($k = 0; $k < sizeof(json_decode($bom["raw_item_id"])); $k++) {
        if (!empty(json_decode($bom["raw_item_id"])[$k]) && !empty(json_decode($bom["raw_quantity"])[$k])) {
            $output .= '<div class="form-group row" style="margin-bottom: 5px;">';
            $output .= '<label class="col-lg-4 control-label text-lg-right pt-2">' . find_product_by_id(json_decode($bom["raw_item_id"])[$k])["title"] . '</label>';
            $output .= '<div class="col-lg-8">';
            $output .= '<input type="text"  class="form-control" data-plugin-maxlength maxlength="100" required id="damage_' . find_product_by_id(json_decode($bom["raw_item_id"])[$k])["id"] . '"/>';
            $output .= '</div> ';
            $output .= '</div> ';
        }
    }
    $output .= '
    <div class="form-group row"  style="padding-bottom: 0 !important;margin-bottom: 0">
        <label class="col-lg-12 control-label text-lg-right pt-2" style="text-align: center !important;font-weight: bolder;text-decoration: underline;">
        Return Quantity
        </label>
    </div> ';

    for ($k = 0; $k < sizeof(json_decode($bom["raw_item_id"])); $k++) {
        if (!empty(json_decode($bom["raw_item_id"])[$k]) && !empty(json_decode($bom["raw_quantity"])[$k])) {
            $output .= '<div class="form-group row" style="margin-bottom: 5px;">';
            $output .= '<label class="col-lg-4 control-label text-lg-right pt-2">' . find_product_by_id(json_decode($bom["raw_item_id"])[$k])["title"] . '</label>';
            $output .= '<div class="col-lg-8">';
            $output .= '<input type="text"  class="form-control" data-plugin-maxlength maxlength="100" required id="return_' . find_product_by_id(json_decode($bom["raw_item_id"])[$k])["id"] . '"/>';
            $output .= '</div> ';
            $output .= '</div> ';
        }
    }
    $output .= '
    </form>
    </div>';
    echo $output;
}
?>