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
if (isset($_POST["item_id"]) && isset($_POST["damage_quantity"]) && isset($_POST["warehouse_location"]) && isset($_POST["expiered_date"])) {
    $item = $_POST["item_id"];
    $qty = $_POST["damage_quantity"] * -1;
    $warehouse = $_POST["warehouse_location"];
    $edate = $_POST["expiered_date"];
    $user = $_SESSION["admin_id"];
    $type = "damage";

    $inv_qty = find_Inventory_by_Item_ExpireDate($item, $warehouse, $edate );

    $category = find_category_by_id(find_product_by_id($item)['category'])['category'];

    if ($inv_qty >= $qty * -1) {
        $val = create_inventory($item, $type, $qty, $category, $warehouse, $edate, $user, "");
        if ($val)
            $_SESSION["art_message"] = "Damage Added to Inventory.";
        else
            $_SESSION["art_error"] = "Please try again. ";
    } else
        $_SESSION["art_error"] = "Please check your inventory.";


} elseif (isset($_POST["rec_item"]) && isset($_POST["rec_quantity"]) && isset($_POST["rec_branch"]) && isset($_POST["p_date"])) {
    $item = $_POST["rec_item"];
    $qty = $_POST["rec_quantity"];
    $warehouse = $_POST["rec_branch"];
    $edate = $_POST["p_date"];
    $user = $_SESSION["admin_id"];
    $type = "purchase";

    $category = find_category_by_id(find_product_by_id($item)['category'])['category'];

    $val = create_inventory($item, $type, $qty, $category, $warehouse, $user, $edate, "");

    if ($val)
        $_SESSION["art_message"] = "Product Added to Inventory.";
    else
        $_SESSION["art_error"] = "Please try again. ";
}
?>