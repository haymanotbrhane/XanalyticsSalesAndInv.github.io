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

if (isset($_POST["product_category"])) {

    $customer_category = find_product_by_category($_POST["product_category"]);

    echo "<option value=''>Select Product</option>";

    while ($row = mysqli_fetch_assoc($customer_category)) {
        echo "<option value='" . $row["id"] . "'>" . $row["title"] . "</option>";
    }
}
?>