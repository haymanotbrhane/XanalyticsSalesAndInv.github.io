<?php


function redirect_to($new_location)
{
    header("Location: " . $new_location);
    exit;
}

function mysql_prep($string)
{
    global $connection;
    $escaped_string = mysqli_real_escape_string($connection, $string);

    return $escaped_string;
}

function confirm_query($result_set)
{
    if (!$result_set) {
//        $_SESSION["art_error"] = ("Database query failed.");
    }
}

function form_errors($errors = array())
{
    $output = "";
    if (!empty($errors)) {
        $output .= "<div class = \"error\" style='margin-bottom: -20px;margin-left: 20%;'>";
        $output .= "Please fix the following errors:";
        $output .= "<ul style='color: red'>";
        foreach ($errors as $key => $error) {
            $output .= "<li>";
            $output .= htmlentities($error);
            $output .= "</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
    }

    return $output;
}


//find all
function find_all_users()
{
    global $connection;

    $query = "SELECT * ";
    $query .= "FROM users ";
    $user_set = mysqli_query($connection, $query);
    confirm_query($user_set);

    return $user_set;
}

function find_all_category()
{
    global $connection;

    $query = "SELECT * FROM `category`;";

    $cate_set = mysqli_query($connection, $query);
    confirm_query($cate_set);

    return $cate_set;
}

function find_all_categories()
{
    global $connection;

    $query = "SELECT * FROM `category`;";

    $cate_set = mysqli_query($connection, $query);
    confirm_query($cate_set);

    return $cate_set;
}

function find_all_price()
{
    global $connection;

    $query = "SELECT * FROM `price` order by starting_date desc, id desc;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_product()
{
    global $connection;

    $query = "SELECT * FROM `product`;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_purchase_request()
{
    global $connection;

    $query = "SELECT * FROM `pu_request` where quantity > approved_quantity order by id desc;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_purchase_order()
{
    global $connection;

    $query = "SELECT * FROM `pu_order` where quantity > received_qty order by scheduled_date;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_approved_purchase_request()
{
    global $connection;

    $query = "SELECT * FROM `pu_request` where quantity = approved_quantity order by id desc;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_received_purchase_order()
{
    global $connection;

    $query = "SELECT * FROM `pu_order` where quantity = received_qty order by scheduled_date desc;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_warehouse()
{
    global $connection;

    $query = "SELECT * FROM `warehouse` ;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_productionLine()
{
    global $connection;

    $query = "SELECT * FROM `production_line` ;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_productionShift()
{
    global $connection;

    $query = "SELECT * FROM `production_shift` ;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_productionBom()
{
    global $connection;

    $query = "SELECT * FROM `production_bom` ;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_productionPlan()
{
    global $connection;

    $query = "SELECT * FROM `production_plan` order by production_date ;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_requested_productionPlan()
{
    global $connection;

    $query = "SELECT * FROM `production_plan` where request_status = 1 order by production_date;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_pending_productionPlan()
{
    global $connection;

    $query = "SELECT * FROM `production_plan` where production_status = 0 order by production_date;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_complete_productionPlan()
{
    global $connection;

    $query = "SELECT * FROM `production_plan` where production_status = 1 or production_status = 2 order by production_date;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_untransfer_productionPlan()
{
    global $connection;

    $query = "SELECT * FROM `production_plan` where production_status = 1 order by production_date;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_grouped_productionBom()
{
    global $connection;

    $query = "SELECT item_id,produce_quantity,created_by,count(raw_item_id) as raw FROM `production_bom` ";
    $query .= "group by item_id,produce_quantity,created_by; ";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_inventory_request($type)
{
    global $connection;
    $type = mysqli_real_escape_string($connection, $type);

    $query = "SELECT * FROM `inv_ret_tra` where `type` =  '{$type}' order by id DESC;";

    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    return $result_set;
}

function find_raw_inventory()
{
    global $connection;

    $query = "SELECT `item_id`, sum(`quantity`) as quantity, `warehouse_id` ";
    $query .= "FROM `inventory` where category = 2 group by `item_id`, `warehouse_id`;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_finish_inventory()
{
    global $connection;

    $query = "SELECT `item_id`, sum(`quantity`) as quantity, `warehouse_id`, `expiered_date` ";
    $query .= "FROM `inventory` where  category = 1 group by `item_id`, `warehouse_id`, `expiered_date` ;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_damage_inventory()
{
    global $connection;

    $query = "SELECT `item_id`, sum(`quantity`) as quantity, `warehouse_id`, `expiered_date` ";
    $query .= "FROM `inventory` where type = 'damage' group by `item_id`, `warehouse_id`,type, `expiered_date` ;";


    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_damage_inventory_detail()
{
    global $connection;

    $query = "SELECT * FROM `inventory` where `type` = 'damage' order by id DESC;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_purchase_inventory_ED()
{
    global $connection;

    $query = "SELECT DISTINCT expiered_date FROM `inventory` order by expiered_date asc ;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_purchase_inventory_detail()
{
    global $connection;

    $query = "SELECT * FROM `inventory` where `type` = 'purchase' order by id DESC;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}
function find_purchase_inventory_detail_item($item)
{
    global $connection;

    $query = "SELECT * FROM `inventory` where `item_id` = '{$item}';";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}
function find_purchase_inventory_exp($item)
{
    global $connection;

    $query = "SELECT * FROM `inventory` where `item_id` = '{$item}';";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_inventory_expiration()
{
    global $connection;
    $query = "SELECT `item_id`, `warehouse_id`, sum(`quantity`) as quantity, expiered_date, `creation_date`";
    $query .= "FROM `inventory`  group by item_id, warehouse_id, expiered_date";

 
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}
function find_inventory_expiration_item($item)
{
    // $item
    global $connection;
   $query = "SELECT * FROM `inventory` where item_id = {$item}   order by id DESC;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}
function find_inventory_expiration_date()
{
    global $connection;
    $query = "SELECT * FROM `inventory` order by id DESC;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}
function find_all_order_request()
{
    global $connection;

    $query = "SELECT * FROM `order_requst` order by status,order_date;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_price_category()
{
    global $connection;

    $query = "SELECT * FROM `price_category`;";

    $cate_set = mysqli_query($connection, $query);
    confirm_query($cate_set);

    return $cate_set;
}
function find_all_inventory()
{
    global $connection;

    $query = "SELECT * FROM `inventory`;";

    $cate_set = mysqli_query($connection, $query);
    confirm_query($cate_set);

    return $cate_set;
}


function check_item_inventory($id, $type, $warehouse)
{
    global $connection;

    $id = mysqli_real_escape_string($connection, $id);
    $type = mysqli_real_escape_string($connection, $type);
    $warehouse = mysqli_real_escape_string($connection, $warehouse);

    $query = "SELECT sum(`quantity`) as quantity  ";
    $query .= "FROM `inventory` where item_type = {$type} and item_id = {$id} and warehouse_id = {$warehouse} ";
    $query .= "group by `item_id`;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($re = mysqli_fetch_assoc($result_set)) {
        return $re;
    } else {
        return null;
    }
}

function find_all_order_response()
{
    global $connection;

    $query = "SELECT * FROM `isiv` order by status;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_goods_receive()
{
    global $connection;

    $query = "SELECT * FROM `grn` order by status;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_item_code()
{
    global $connection;

    $query = "SELECT * FROM `item_code`;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_order_product()
{
    global $connection;

    $query = "SELECT * FROM `order_product`;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_attribute()
{
    global $connection;

    $query = "SELECT * FROM `product_attribute`;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_attribute_value()
{
    global $connection;

    $query = "SELECT * FROM `attribute_value`;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_measurement()
{
    global $connection;

    $query = "SELECT * FROM `measurment`;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_branch()
{
    global $connection;

    $query = "SELECT * FROM `branch`;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_order_sheet()
{
    global $connection;

    $query = "SELECT * FROM `order_sheet` order by status ASC , id DESC;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_cart()
{
    global $connection;

    $query = "SELECT * FROM `cart` order by created_at desc , cart_id DESC;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_all_orders()
{
    global $connection;

    $query = "SELECT `id`, `order_id`, `item`, `code`, `title`, `branch`,  `price_group`, `price`, `uom`,
              `qty`, `tin`, `name`, `vat_type`, `payment_type`, `created_by`, `created_at`,
              ( CASE 
                        WHEN `vat_type` = '0' THEN (`price` * `qty`*1.15 )
                        ELSE (`price` * `qty`)
                    END) AS total
               FROM `orders` order by created_at desc , order_id DESC;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_total_sales_by_range($branch, $sdate, $edate)
{
    global $connection;

    $branch = mysqli_real_escape_string($connection, $branch);
    $sdate = mysqli_real_escape_string($connection, $sdate);
    $edate = mysqli_real_escape_string($connection, $edate);

    if ($branch == "")
        $branch = " SELECT id FROM `branch` ";

    $query = "SELECT `item`, `code`, `title`, price, `uom`,
              sum(`qty`) as qty, `tin`, `name`, `vat_type`, `payment_type`,
              DATE(`created_at`) as created_at, 
              sum( CASE 
                        WHEN `vat_type` = '0' THEN (`price` * `qty`*1.15 )
                        ELSE (`price` * `qty`)
                    END) AS total
              FROM `orders` where branch in ($branch) and DATE(`created_at`) BETWEEN '{$sdate}' and '{$edate}'
              group by `item`, `code`, `title`, `uom`, `tin`, `name`, `vat_type`, `payment_type`, DATE(`created_at`)
              order by created_at desc ;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    return $result_set;
}

function find_total_inventory_warehouse($branch)
{
    global $connection;

    if (trim($branch) == "") {
        $branch = "group by item_id";
        $col = "SELECT item_id, sum(`quantity`) as quantity ";
    } else {
        $branch = " where warehouse_id = '{$branch}' group by item_id, warehouse_id ";
        $col = "SELECT item_id, warehouse_id, sum(`quantity`) as quantity ";
    }

    $query = $col;
    $query .= "FROM `inventory` $branch order by quantity;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}
function find_total_inventory_expire_warehouse($branch)
{
    global $connection;

    if (trim($branch) == "") {
        // $branch = "group by item_id";
        $col = "SELECT * ";
    } else {
        $branch = " where warehouse_id = '{$branch}'";
        $col = "SELECT * ";
    }

    $query = $col;
    $query .= "FROM `inventory` $branch order by quantity;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_total_inventory_warehouse_item($branch, $item)
{
    global $connection;

    $query = "SELECT item_id, warehouse_id, sum(`quantity`) as quantity ";
    $query .= "FROM `inventory` where item_id = '{$item}' and warehouse_id = '{$branch}' group by item_id, warehouse_id;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

//by id
function find_item_code_by_id($id)
{
    global $connection;

    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "SELECT * ";
    $query .= "FROM item_code ";
    $query .= "WHERE id = {$safe_id} ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}
function find_item_by_code($code)
{
    global $connection;

    $code = mysqli_real_escape_string($connection, $code);

    $query = "SELECT item_id ";
    $query .= "FROM item_code ";
    $query .= "WHERE code = {$code} ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result["item_id"];
    } else {
        return null;
    }
}
function find_order_product_by_id($id)
{
    global $connection;

    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "SELECT * ";
    $query .= "FROM order_product ";
    $query .= "WHERE id = {$safe_id} ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_attribute_by_id($id)
{
    global $connection;

    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "SELECT * ";
    $query .= "FROM product_attribute ";
    $query .= "WHERE id = {$safe_id} ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_attribute_value_by_id($id)
{
    global $connection;

    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "SELECT * ";
    $query .= "FROM attribute_value ";
    $query .= "WHERE id = {$safe_id} ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_measurement_by_id($id)
{
    global $connection;

    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "SELECT * ";
    $query .= "FROM measurment ";
    $query .= "WHERE id = {$safe_id} ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_branch_by_id($id)
{
    global $connection;

    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "SELECT * ";
    $query .= "FROM branch ";
    $query .= "WHERE id = {$safe_id} ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_order_sheet_by_id($id)
{
    global $connection;

    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "SELECT * ";
    $query .= "FROM order_sheet ";
    $query .= "WHERE id = {$safe_id} ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_cart_by_id($id)
{
    global $connection;

    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "SELECT * ";
    $query .= "FROM cart ";
    $query .= "WHERE id = {$safe_id} ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_order_by_id($id)
{
    global $connection;

    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "SELECT * ";
    $query .= "FROM orders ";
    $query .= "WHERE id = {$safe_id} ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_price_category_by_id($id)
{
    global $connection;

    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "SELECT * ";
    $query .= "FROM price_category ";
    $query .= "WHERE id = {$safe_id} ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

// by other
function find_attribute_value_by_attribute_id($id)
{
    global $connection;

    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "SELECT * ";
    $query .= "FROM attribute_value ";
    $query .= "WHERE attribute_id = {$safe_id} ;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_price_by_item_id($id)
{
    global $connection;

    $safe_id = mysqli_real_escape_string($connection, $id);

    $date = date("Y-m-d") . " 00:00:00";

    $query = "SELECT * ";
    $query .= "FROM price ";
    $query .= "WHERE item = {$safe_id} and starting_date <= '{$date}' order by starting_date desc, id desc ";
    $query .= "LIMIT 1;";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_price_by_item_id_and_group($id, $group)
{
    global $connection;

    $safe_id = mysqli_real_escape_string($connection, $id);
    $safe_group = mysqli_real_escape_string($connection, $group);
    $date = date("Y-m-d") . " 00:00:00";

    $query = "SELECT * ";
    $query .= "FROM price ";
    $query .= "WHERE item = {$safe_id} and price_group = {$safe_group} and starting_date <= '{$date}' order by starting_date desc, id desc ";
    $query .= "LIMIT 1;";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_cart_by_tin($tin)
{
    global $connection;

    $safe_tin = mysqli_real_escape_string($connection, $tin);

    $query = "SELECT * ";
    $query .= "FROM cart ";
    $query .= "WHERE tin = '{$safe_tin}';";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_cart_by_cart_id($id)
{
    global $connection;

    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "SELECT * ";
    $query .= "FROM cart ";
    $query .= "WHERE cart_id = '{$safe_id}';";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_max_cart_id()
{
    global $connection;

    $query = "SELECT cart_id ";
    $query .= "FROM cart ";
    $query .= "where cart_id like '{$_SESSION["admin_id"]}%' ";
    $query .= "order by cart_id desc ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result["cart_id"];
    } else {
        return null;
    }
}

function find_max_order_id()
{
    global $connection;

    $query = "SELECT order_id ";
    $query .= "FROM orders ";
    $query .= "where order_id like '{$_SESSION["admin_id"]}%' ";
    $query .= "order by order_id desc ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result["order_id"];
    } else {
        return null;
    }
}

function find_item_in_cart($id, $cart_id)
{
    global $connection;

    $query = "SELECT * ";
    $query .= "FROM cart ";
    $query .= "WHERE item = '{$id}' and cart_id = '{$cart_id}';";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_grouped_customer_name($companyName)
{
    global $connection;

    $query = "SELECT `name` FROM `orders` where `name` like '%{$companyName}%' ";
    $query .= "group by `name`;";

    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    return $result_set;
}

//order sheet creation
function create_item_code($title, $image)
{
    global $connection;
    $safe_title = mysqli_real_escape_string($connection, $title);
    $safe_image = mysqli_real_escape_string($connection, $image);
    $safe_user = $_SESSION["admin_id"];

    $query = "INSERT INTO `item_code`(`code`, `image`, `created_by`) ";
    $query .= "VALUES ('{$safe_title}','{$safe_image}',{$safe_user});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "Item code created.";

        redirect_to("itemCode.php");
    } else {
        // Failure
        $_SESSION["art_error"] = "Item code creation failed.";
    }
}

function create_order_product($title, $attribute, $measurement)
{
    global $connection;
    $safe_title = mysqli_real_escape_string($connection, $title);
    $safe_attribute = mysqli_real_escape_string($connection, $attribute);
    $safe_measurement = mysqli_real_escape_string($connection, $measurement);
    $safe_user = $_SESSION["admin_id"];


    $query = "INSERT INTO `order_product`(`title`, `attribute`, `measurment`, `created_by`) ";
    $query .= "VALUES ('{$safe_title}' ,'{$safe_attribute}','{$safe_measurement}',{$safe_user});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);
    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "Product created.";

        redirect_to("orderProduct.php");
    } else {
        // Failure
        $_SESSION["art_error"] = "Product creation failed.";
    }
}

function create_attribute($title)
{
    global $connection;
    $safe_title = mysqli_real_escape_string($connection, $title);
    $safe_user = $_SESSION["admin_id"];

    $query = "INSERT INTO `product_attribute`(`title`, `created_by`) ";
    $query .= "VALUES ('{$safe_title}',{$safe_user});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);
    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "Attribute created.";

        redirect_to("attribute.php");
    } else {
        // Failure
        $_SESSION["art_error"] = "Attribute creation failed.";
    }
}

function create_attribute_value($title, $attr_id)
{
    global $connection;
    $safe_title = mysqli_real_escape_string($connection, $title);
    $safe_attr_id = mysqli_real_escape_string($connection, $attr_id);
    $safe_user = $_SESSION["admin_id"];

    $query = "INSERT INTO `attribute_value`(`title`, `attribute_id`, `created_by`) ";
    $query .= "VALUES ('{$safe_title}', {$safe_attr_id},{$safe_user});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);
    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "Attribute Value created.";

        redirect_to("attributeValue.php");
    } else {
        // Failure
        $_SESSION["art_error"] = "Attribute Value creation failed.";
    }
}

function create_measurement($title, $uom)
{
    global $connection;
    $safe_title = mysqli_real_escape_string($connection, $title);
    $safe_uom = mysqli_real_escape_string($connection, $uom);
    $safe_user = $_SESSION["admin_id"];

    $query = "INSERT INTO `measurment`(`title`, `uom`, `created_by`) ";
    $query .= "VALUES ('{$safe_title}','{$safe_uom}',{$safe_user});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "Measurement created.";

        redirect_to("measurement.php");
    } else {
        // Failure
        $_SESSION["art_error"] = "Measurement creation failed.";
    }
}

function create_branch($title, $location, $phone, $b_type)
{
    global $connection;
    $safe_title = mysqli_real_escape_string($connection, $title);
    $safe_location = mysqli_real_escape_string($connection, $location);
    $safe_phone = mysqli_real_escape_string($connection, $phone);
    $safe_b_type = mysqli_real_escape_string($connection, $b_type);
    $safe_user = $_SESSION["admin_id"];

    $query = "INSERT INTO `branch`(`title`,`branch_type`, `location`, `phone`, `created_by`) ";
    $query .= "VALUES ('{$safe_title}','{$safe_b_type}','{$safe_location}','{$safe_phone}',{$safe_user});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "Branch created.";
        redirect_to("branch.php");
    } else {
        // Failure
        $_SESSION["art_error"] = "Branch creation failed. ";
    }
}

function create_order_sheet($branch, $order_date, $order_no, $customer_name, $customer_phone, $customer_sex, $product_id, $description,
                            $attr_value, $measurement, $total_payment, $advance_payment, $appointment_date, $delivery_date, $item_code)
{
    global $connection;
    $safe_branch = mysqli_real_escape_string($connection, $branch);
    $safe_order_date = mysqli_real_escape_string($connection, $order_date);
    $safe_order_no = mysqli_real_escape_string($connection, $order_no);
    $safe_customer_name = mysqli_real_escape_string($connection, $customer_name);
    $safe_customer_phone = mysqli_real_escape_string($connection, $customer_phone);
    $safe_customer_sex = mysqli_real_escape_string($connection, $customer_sex);
    $safe_product_id = mysqli_real_escape_string($connection, $product_id);
    $safe_description = mysqli_real_escape_string($connection, $description);
    $safe_attr_value = mysqli_real_escape_string($connection, $attr_value);
    $safe_measurement = mysqli_real_escape_string($connection, $measurement);
    $safe_total_payment = mysqli_real_escape_string($connection, $total_payment);
    $safe_advance_payment = mysqli_real_escape_string($connection, $advance_payment);
    $safe_appointment_date = mysqli_real_escape_string($connection, $appointment_date);
    $safe_delivery_date = mysqli_real_escape_string($connection, $delivery_date);
    $safe_item_code = mysqli_real_escape_string($connection, $item_code);
    $safe_user = $_SESSION["admin_id"];

    $query = "INSERT INTO `order_sheet`(`branch`, `order_date`, `order_number`, `customet_name`, `customer_phone`, `customer_sex`, `product_id`, `description`";
    $query .= ", `attribute_value`, `measurment`, `total_payment`, `advance_payment`, `appointment_date`, `delivery_date`, `item_code`, `created_by`) ";
    $query .= "VALUES ({$safe_branch},'{$safe_order_date}','{$safe_order_no}','{$safe_customer_name}','{$safe_customer_phone}','{$safe_customer_sex}','{$safe_product_id}','{$safe_description}'";
    $query .= ",'{$safe_attr_value}' ,'{$safe_measurement}',{$safe_total_payment},{$safe_advance_payment} ,'{$safe_appointment_date}','{$safe_delivery_date}','{$safe_item_code}',{$safe_user});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "Order created.";

        redirect_to("orderSheet.php");
    } else {
        // Failure
        $_SESSION["art_error"] = "Order creation failed.";
    }
}

function create_cart($cart_id, $item, $code, $title, $branch, $price_group, $price, $qty, $uom, $tin, $name, $vat_type, $payment_type)
{
    global $connection;
    $cart_id = mysqli_real_escape_string($connection, $cart_id);
    $item = mysqli_real_escape_string($connection, $item);
    $code = mysqli_real_escape_string($connection, $code);
    $title = mysqli_real_escape_string($connection, $title);
    $branch = mysqli_real_escape_string($connection, $branch);
    $price_group = mysqli_real_escape_string($connection, $price_group);
    $price = mysqli_real_escape_string($connection, $price);
    $qty = mysqli_real_escape_string($connection, $qty);
    $uom = mysqli_real_escape_string($connection, $uom);
    $tin = mysqli_real_escape_string($connection, $tin);
    $name = mysqli_real_escape_string($connection, $name);
    $vat_type = mysqli_real_escape_string($connection, $vat_type);
    $payment_type = mysqli_real_escape_string($connection, $payment_type);
    // $expiered_date = mysqli_real_escape_string($connection, $expiered_date);
    $safe_user = $_SESSION["admin_id"];

    $query = "INSERT INTO `cart`( `cart_id`, `item`, `code`, `title`,  `branch`, `price_group`,  `price`, `qty`, `uom`, `tin`, `name`,`vat_type`, `payment_type`, `created_by`) ";
    $query .= "VALUES ({$cart_id},{$item},'{$code}','{$title}',{$branch},{$price_group},{$price},{$qty},'{$uom}','{$tin}','{$name}',{$vat_type},'{$payment_type}', {$safe_user});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        // $_SESSION["art_message"] = "Cart created.";
        return true;
    } else {
        // Failure
        // $_SESSION["art_error"] = "Order creation failed." .$query;
        return false;
    }
}

function update_cart($id, $cart_id, $qty)
{
    global $connection;

    $query = "update `cart` set qty = {$qty} ";
    $query .= "where item = {$id} and cart_id = {$cart_id};";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        return true;

    } else {
        // Failure
        return false;
    }
}
function find_Inventory_by_Item($item, $warehouse)
{
    global $connection;

    $query = "SELECT `item_id`, sum(`quantity`) as quantity, `warehouse_id` ";
    $query .= "FROM `inventory` where `item_id` = '{$item}' and ";
    $query .= "`warehouse_id` = '{$warehouse}' group by `item_id`, `warehouse_id`;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    if (!$result_set)
        die(mysqli_error($connection));

    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result["quantity"];
    } else {
        return null;
    }
}

function find_Inventory_by_Item_ExpireDate($item, $warehouse, $edate)
{
    global $connection;

    $query = "SELECT `item_id`, sum(`quantity`) as quantity, `warehouse_id` , `expiered_date` ";
    $query .= "FROM `inventory` where `item_id` = '{$item}' and  `expiered_date` = '{$edate}' and ";
    $query .= "`warehouse_id` = '{$warehouse}' group by `item_id`, `warehouse_id`, `expiered_date`;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    if (!$result_set)
        die(mysqli_error($connection));

    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result["quantity"];
    } else {
        return null;
    }
}

function find_expire_Inventory_itm_ed($item, $warehouse)
{
    global $connection;

    $query = "SELECT `item_id`, expiered_date, 'quantity', `warehouse_id` ";
    $query .= "FROM `inventory` where `item_id` = '{$item}' and ";
    $query .= "`warehouse_id` = '{$warehouse}' order by expiered_date asc;";
    
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    if (!$result_set)
        die(mysqli_error($connection));

    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result["expiered_date"];
    } else {
        return null;
    }
}
function find_expire_Inventory_itme_by_werehouse($item, $warehouse)
{
    global $connection;

    $query = "SELECT `item_id`, expiered_date, 'quantity', `warehouse_id` ";
    $query .= "FROM `inventory` where `item_id` = '{$item}' and ";
    $query .= "`warehouse_id` = '{$warehouse}';";
    
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

   
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    return $result_set;
}
function find_expire_Inventory_itm_ed_q($item, $warehouse)
{
    global $connection;

    $query = "SELECT `item_id`, expiered_date , sum(`quantity`) as quantity , `warehouse_id` ";
    $query .= "FROM `inventory` where `item_id` = '{$item}' and ";
    $query .= "`warehouse_id` = '{$warehouse}' group by `item_id`, `warehouse_id` , `expiered_date` order by `expiered_date` asc ;";
    
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    if (!$result_set)
        die(mysqli_error($connection));

    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result["quantity"];
    } else {
        return null;
    }
}
function find_expire_Inventory_Edate($item, $warehouse, $expiered_date)
{
    global $connection;

    $query = "SELECT `item_id`, expiered_date, 'quantity', `warehouse_id` ";
    $query .= "FROM `inventory` where `item_id` = '{$item}' and `expiered_date` = '{$expiered_date}' and ";
    $query .= "`warehouse_id` = '{$warehouse}'";
    $query .= "LIMIT 1;";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    if (!$result_set)
        die(mysqli_error($connection));

    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result["expiered_date"];
    } else {
        return null;
    }
}
function find_expire_Inventory_Quantity($item, $warehouse, $expiered_date)
{
    global $connection;

    $query = "SELECT `item_id`, `expiered_date`, sum(`quantity`) as quantity, `warehouse_id` ";
    $query .= "FROM `inventory` ";
    $query .= " where `item_id` = '{$item}' and ";
    $query .= "`expiered_date` = '{$expiered_date}' and ";
    $query .=" `warehouse_id` = '{$warehouse}' group by `item_id`, `warehouse_id`,`expiered_date`;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    if (!$result_set)
        die(mysqli_error($connection));

    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result["quantity"];
    } else {
        return null;
    }
}
function delete_cart($id)
{
    global $connection;

    $query = "DELETE FROM `cart` WHERE cart_id = {$id};";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        return true;

    } else {
        // Failure
        return false;
    }
}

function create_order($order_id, $item, $code, $title, $branch, $price_group, $price, $qty, $uom, $tin, $name, $vat_type, $payment_type)
{
    global $connection;
    $order_id = mysqli_real_escape_string($connection, $order_id);
    $item = mysqli_real_escape_string($connection, $item);
    $code = mysqli_real_escape_string($connection, $code);
    $title = mysqli_real_escape_string($connection, $title);
    $branch = mysqli_real_escape_string($connection, $branch);
    $price_group = mysqli_real_escape_string($connection, $price_group);
    $price = mysqli_real_escape_string($connection, $price);
    $qty = mysqli_real_escape_string($connection, $qty);
    $uom = mysqli_real_escape_string($connection, $uom);
    $tin = mysqli_real_escape_string($connection, $tin);
    $name = mysqli_real_escape_string($connection, $name);
    $vat_type = mysqli_real_escape_string($connection, $vat_type);
    $payment_type = mysqli_real_escape_string($connection, $payment_type);
    $safe_user = $_SESSION["admin_id"];

    $query = "INSERT INTO `orders`(`order_id`, `item`, `code`, `title`, `branch`, `price_group`, `price`, `qty`, `uom`, `tin`, `name`, `vat_type`, `payment_type`, `created_by`) ";
    $query .= "VALUES ({$order_id},{$item},'{$code}','{$title}','{$branch}',{$price_group},{$price},{$qty},'{$uom}','{$tin}','{$name}', {$vat_type},'{$payment_type}', {$safe_user});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        //$_SESSION["art_message"] = "Cart created.";
        return true;
    } else {
        // Failure
        //$_SESSION["art_error"] = "Order creation failed." .$query;
        return false;
    }
}

function create_price_category($title, $user_id)
{
    global $connection;
    $safe_title = mysqli_real_escape_string($connection, $title);
    $safe_user_id = mysqli_real_escape_string($connection, $user_id);

    $query = "INSERT INTO `price_category`( `title`, `created_by`) ";
    $query .= "VALUES ('{$safe_title}', {$safe_user_id});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);
    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "Price List Category Created.";

        redirect_to("pricecategories.php");
    } else {
        // Failure
        $_SESSION["art_error"] = "Price List Category Creation Failed." . $query;
    }
}

//find by id
function find_user_by_id($user_id)
{
    global $connection;

    $safe_user_id = mysqli_real_escape_string($connection, $user_id);

    $query = "SELECT * ";
    $query .= "FROM users ";
    $query .= "WHERE id = {$safe_user_id} ";
    $query .= "LIMIT 1";
    $user_set = mysqli_query($connection, $query);
    confirm_query($user_set);
    if ($user = mysqli_fetch_assoc($user_set)) {
        return $user;
    } else {
        return null;
    }
}

function find_category_by_id($cate_id)
{
    global $connection;

    $safe_cate_id = mysqli_real_escape_string($connection, $cate_id);

    $query = "SELECT * ";
    $query .= "FROM category ";
    $query .= "WHERE id = {$safe_cate_id} ";
    $query .= "LIMIT 1";
    $cate_set = mysqli_query($connection, $query);
    confirm_query($cate_set);
    if ($cate = mysqli_fetch_assoc($cate_set)) {
        return $cate;
    } else {
        return null;
    }
}

function find_logistic_category_by_id($cate_id)
{
    global $connection;

    $safe_cate_id = mysqli_real_escape_string($connection, $cate_id);

    $query = "SELECT * ";
    $query .= "FROM logistic_category ";
    $query .= "WHERE id = {$safe_cate_id} ";
    $query .= "LIMIT 1";
    $cate_set = mysqli_query($connection, $query);
    confirm_query($cate_set);
    if ($cate = mysqli_fetch_assoc($cate_set)) {
        return $cate;
    } else {
        return null;
    }
}

function find_price_by_id($price_id)
{
    global $connection;

    $safe_price_id = mysqli_real_escape_string($connection, $price_id);

    $query = "SELECT * ";
    $query .= "FROM price ";
    $query .= "WHERE id = {$safe_price_id} ";
    $query .= "LIMIT 1";
    $price_set = mysqli_query($connection, $query);
    confirm_query($price_set);
    if ($price = mysqli_fetch_assoc($price_set)) {
        return $price;
    } else {
        return null;
    }
}

function find_vehicle_by_id($vehicle_id)
{
    global $connection;

    $safe_vehicle_id = mysqli_real_escape_string($connection, $vehicle_id);

    $query = "SELECT * ";
    $query .= "FROM vehicle ";
    $query .= "WHERE id = {$safe_vehicle_id} ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_product_by_id($product_id)
{
    global $connection;

    $safe_product_id = mysqli_real_escape_string($connection, $product_id);

    $query = "SELECT * ";
    $query .= "FROM product ";
    $query .= "WHERE id = {$safe_product_id} ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_product_by_barcode($barcode)
{
    global $connection;

    $barcode = mysqli_real_escape_string($connection, $barcode);

    $query = "SELECT * ";
    $query .= "FROM product ";
    $query .= "WHERE code = '{$barcode}' ";
    $query .= "LIMIT 1;";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}
function find_purchase_request_by_id($pr_id)
{
    global $connection;

    $safe_pr_id = mysqli_real_escape_string($connection, $pr_id);

    $query = "SELECT * ";
    $query .= "FROM pu_request ";
    $query .= "WHERE id = {$safe_pr_id} ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_purchase_order_by_id($po_id)
{
    global $connection;

    $safe_po_id = mysqli_real_escape_string($connection, $po_id);

    $query = "SELECT * ";
    $query .= "FROM pu_order ";
    $query .= "WHERE id = {$safe_po_id} ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_warehouse_by_id($id)
{
    global $connection;

    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "SELECT * ";
    $query .= "FROM warehouse ";
    $query .= "WHERE id = {$safe_id} ";
    $query .= "LIMIT 1;";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_ProductionLine_by_id($id)
{
    global $connection;

    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "SELECT * ";
    $query .= "FROM production_line ";
    $query .= "WHERE id = {$safe_id} ";
    $query .= "LIMIT 1;";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_ProductionShift_by_id($id)
{
    global $connection;

    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "SELECT * ";
    $query .= "FROM production_shift ";
    $query .= "WHERE id = {$safe_id} ";
    $query .= "LIMIT 1;";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_ProductionBom_by_id($id)
{
    global $connection;

    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "SELECT * ";
    $query .= "FROM production_bom ";
    $query .= "WHERE id = {$safe_id} ";
    $query .= "LIMIT 1;";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_ProductionBom_by_item($item)
{
    global $connection;

    $item = mysqli_real_escape_string($connection, $item);

    $query = "SELECT * ";
    $query .= "FROM production_bom ";
    $query .= "WHERE item_id = {$item} ";
    $query .= "LIMIT 1;";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_ProductionPlan_by_id($id)
{
    global $connection;

    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "SELECT * ";
    $query .= "FROM production_plan ";
    $query .= "WHERE id = {$safe_id} ";
    $query .= "LIMIT 1;";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_inventory_by_id($id)
{
    global $connection;

    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "SELECT * ";
    $query .= "FROM inventory ";
    $query .= "WHERE id = {$safe_id} ";
    $query .= "LIMIT 1;";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_transfer_request_by_id($id)
{
    global $connection;

    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "SELECT * ";
    $query .= "FROM inv_ret_tra ";
    $query .= "WHERE id = {$safe_id} ";
    $query .= "LIMIT 1;";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_order_request_by_id($request_id)
{
    global $connection;

    $safe_request_id = mysqli_real_escape_string($connection, $request_id);

    $query = "SELECT * ";
    $query .= "FROM order_requst ";
    $query .= "WHERE id = {$safe_request_id} ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_order_response_by_id($response_id)
{
    global $connection;

    $safe_response_id = mysqli_real_escape_string($connection, $response_id);

    $query = "SELECT * ";
    $query .= "FROM isiv ";
    $query .= "WHERE id = {$safe_response_id} ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_goods_receive_by_id($grn_id)
{
    global $connection;

    $safe_grn_id = mysqli_real_escape_string($connection, $grn_id);

    $query = "SELECT * ";
    $query .= "FROM grn ";
    $query .= "WHERE id = {$safe_grn_id} ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_product_by_category($category)
{
    global $connection;

    $safe_category_id = mysqli_real_escape_string($connection, $category);

    $query = "SELECT * ";
    $query .= "FROM product ";
    $query .= "WHERE category = {$safe_category_id} ;";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_purchase_inventory_by_item($item, $warehouse)
{
    global $connection;

    $query = "SELECT `item_id`, sum(`quantity`) as quantity, `warehouse_id` ";
    $query .= "FROM `inventory` where `item_id` = '{$item}' and ";
    $query .= "`warehouse_id` = '{$warehouse}' group by `item_id`, `warehouse_id`;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    if (!$result_set)
        die(mysqli_error($connection));

    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result["quantity"];
    } else {
        return null;
    }
}
function find_purchase_inventory_quantity_by_item_and_warehouse($item, $warehouse, $expiered_d)
{
    global $connection;

    $query = "SELECT `item_id`, 'expiered_date', 'quantity', `warehouse_id` ";
    $query .= "FROM `inventory` where `item_id` = '{$item}' and `expiered_date` = '{$expiered_d}' and ";
    $query .= "`warehouse_id` = '{$warehouse}'";
    $query .= "LIMIT 1;";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    if (!$result_set)
        die(mysqli_error($connection));

    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result["quantity"];
    } else {
        return null;
    }
}
function find_purchase_inventory_by_item_and_warehouse_and_edate($item, $warehouse, $expiered_d)
{
    global $connection;

    $query = "SELECT `item_id`, 'expiered_date', 'quantity', `warehouse_id` ";
    $query .= "FROM `inventory` where `item_id` = '{$item}' and `expiered_date` = '{$expiered_d}' and ";
    $query .= "`warehouse_id` = '{$warehouse}' group by `item_id`, `warehouse_id`";
    $query .= "LIMIT 1;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    if (!$result_set)
        die(mysqli_error($connection));

    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}
function find_purchase_inventory_by_item_and_warehouse($item, $warehouse)
{
    global $connection;

    $query = "SELECT `item_id`, 'expiered_date', 'quantity', `warehouse_id` ";
    $query .= "FROM `inventory` where `item_id` = '{$item}' and ";
    $query .= "`warehouse_id` = '{$warehouse}' group by `item_id`, `warehouse_id`";
    $query .= "LIMIT 1;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    if (!$result_set)
        die(mysqli_error($connection));

    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_daily_total_sales($past, $now)
{
    global $connection;

    $query = "SELECT DATE(`created_at`) as created_at, sum(`price` * `qty`) AS TOT , ";
    $query .= "sum( CASE 
                        WHEN `vat_type` = '0' THEN (`price` * `qty`*1.15 )
                        ELSE (`price` * `qty`)
                    END) AS total ";
    $query .= "FROM orders where DATE(`created_at`) <='{$now}' and DATE(`created_at`) >='{$past}' ";
    $query .= " GROUP BY DATE(`created_at`);";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_daily_sales_by_date($date)
{
    global $connection;

    $query = "SELECT DATE(`created_at`) as created_at, sum(`price` * `qty`) AS TOT , ";
    $query .= "sum( CASE 
                        WHEN `vat_type` = '0' THEN (`price` * `qty`*1.15 )
                        ELSE (`price` * `qty`)
                    END) AS total ";
    $query .= "FROM orders where DATE(`created_at`) ='{$date}' ";
    $query .= " GROUP BY DATE(`created_at`);";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    if (!$result_set)
        die(mysqli_error($connection));

    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_daily_top_sales_item($date)
{
    global $connection;

    $query = "SELECT code, title, DATE(`created_at`) as created_at, sum(`price` * `qty`) AS TOT , ";
    $query .= "sum( CASE 
                        WHEN `vat_type` = '0' THEN (`price` * `qty`*1.15 )
                        ELSE (`price` * `qty`)
                    END) AS total ";
    $query .= "FROM orders where DATE(`created_at`) ='{$date}' ";
    $query .= " GROUP BY DATE(`created_at`),code,title order by total desc limit 10;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}


function find_range_top_sales_item($past, $now)
{
    global $connection;

    $query = "SELECT code, title, DATE(`created_at`) as created_at, sum(`price` * `qty`) AS TOT , ";
    $query .= "sum( CASE 
                        WHEN `vat_type` = '0' THEN (`price` * `qty`*1.15 )
                        ELSE (`price` * `qty`)
                    END) AS total ";
    $query .= "FROM orders where DATE(`created_at`) BETWEEN '{$past}' and '{$now}' ";
    $query .= " GROUP BY DATE(`created_at`),code,title order by total desc limit 10;";

    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    return $result_set;
}

function find_branch_total_sales($date)
{
    global $connection;

    $query = "SELECT branch, DATE(`created_at`) as created_at, sum(`price` * `qty`) AS TOT , ";
    $query .= "sum( CASE 
                        WHEN `vat_type` = '0' THEN (`price` * `qty`*1.15 )
                        ELSE (`price` * `qty`)
                    END) AS total ";
    $query .= "FROM orders where DATE(`created_at`) ='{$date}' ";
    $query .= " GROUP BY DATE(`created_at`),branch order by total desc limit 10;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_item_exp_date_by_date($date)
{
    global $connection;
    $query = "SELECT `item_id`, `warehouse_id`, sum(`quantity`) as quantity, expiered_date, `creation_date`";
    $query .= "FROM `inventory` where DATE(`expiered_date`) ='{$date}'  group by item_id, warehouse_id, expiered_date";

 
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}
function find_total_branch_sales($branch, $date)
{
    global $connection;
    $sales = "where DATE(`created_at`) ='{$date}' ";

    if (trim($branch) == "")
        $branch = "";
    else
        $branch = " and branch = '{$branch}' ";

    $sales .= $branch;

    $query = "SELECT item, code, title, sum(`qty`) AS qty, ";
    $query .= "sum( CASE 
                        WHEN `vat_type` = '0' THEN (`price` * `qty`*1.15 )
                        ELSE (`price` * `qty`)
                    END) AS total ";
    $query .= "FROM `orders` $sales group by item, code, title order by total desc;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_range_branch_sales($branch, $sdate, $edate)
{
    global $connection;
    $sales = "where DATE(`created_at`) BETWEEN '{$sdate}' and '{$edate}'  ";

    if (trim($branch) == "")
        $branch = "";
    else
        $branch = " and branch = '{$branch}' ";

    $sales .= $branch;

    $query = "SELECT item, code, title, sum(`qty`) AS qty, ";
    $query .= "sum( CASE 
                        WHEN `vat_type` = '0' THEN (`price` * `qty`*1.15 )
                        ELSE (`price` * `qty`)
                    END) AS total ";
    $query .= "FROM `orders` $sales group by item, code, title order by total desc;";

    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

//


function find_category_category($category)
{
    global $connection;

    $safe_category = mysqli_real_escape_string($connection, trim($category));

    $query = "SELECT * ";
    $query .= "FROM `category` ";
    $query .= "WHERE category = '{$safe_category}';";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_customer_by_category($category)
{
    global $connection;

    $safe_category = mysqli_real_escape_string($connection, trim($category));

    $query = "SELECT * ";
    $query .= "FROM `customer` ";
    $query .= "WHERE category = {$safe_category} ;";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

//
function find_user_by_username($username)
{
    global $connection;

    $safe_username = mysqli_real_escape_string($connection, $username);

    $query = "SELECT * ";
    $query .= "FROM users ";
    $query .= "WHERE email = '{$safe_username}' ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_purchase_request_by_qty()
{
    global $connection;

//    $safe_ref = mysqli_real_escape_string($connection, $ref);

    $query = "SELECT * ";
    $query .= "FROM pu_request ";
    $query .= "WHERE approved_quantity > 0 and ordered_quantity < approved_quantity;";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_order_request_by_ref($ref)
{
    global $connection;

    $safe_ref = mysqli_real_escape_string($connection, $ref);

    $query = "SELECT * ";
    $query .= "FROM order_requst ";
    $query .= "WHERE reference_number = '{$safe_ref}' ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_order_response_by_ref($ref)
{
    global $connection;

    $safe_ref = mysqli_real_escape_string($connection, $ref);

    $query = "SELECT * ";
    $query .= "FROM isiv ";
    $query .= "WHERE reference_number = '{$safe_ref}' ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_goods_receive_by_ref($ref)
{
    global $connection;

    $safe_ref = mysqli_real_escape_string($connection, $ref);

    $query = "SELECT * ";
    $query .= "FROM grn ";
    $query .= "WHERE reference_number = '{$safe_ref}' ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result = mysqli_fetch_assoc($result_set)) {
        return $result;
    } else {
        return null;
    }
}

function find_vehicle_by_customer_id($c_id)
{
    global $connection;

    $safe_c_id = mysqli_real_escape_string($connection, $c_id);

    $query = "SELECT * ";
    $query .= "FROM vehicle ";
    $query .= "WHERE customer_id = {$safe_c_id} ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_order_request_by_vehicle_id($v_id)
{
    global $connection;

    $safe_v_id = mysqli_real_escape_string($connection, $v_id);

    $query = "SELECT * ";
    $query .= "FROM order_requst ";
    $query .= "WHERE vehicle_id = {$safe_v_id} ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_isiv_by_request_id($r_id)
{
    global $connection;

    $safe_r_id = mysqli_real_escape_string($connection, $r_id);

    $query = "SELECT * ";
    $query .= "FROM isiv ";
    $query .= "WHERE order_id = {$safe_r_id} ";
    $query .= "LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

function find_transport_cost($customer_id)
{
    global $connection;

    $safe_c_id = mysqli_real_escape_string($connection, $customer_id);

    $query = "SELECT pro . price, c . name,v . plate_no,gr . approve_date,pro . title,isi . quantity,isi . departure,";
    $query .= "isi . destination,r . rate,lc . amount,isi . reference_number,gr . damege_pack,";
    $query .= "gr . shortage_pack,gr . over_pack,gr . status ";
    $query .= "FROM customer c left join vehicle v on c . id = v . customer_id ";
    $query .= "left join logistic_category lc ON v . category_id = lc . id ";
    $query .= "left join order_requst r ON v . id = r . vehicle_id ";
    $query .= "left join isiv isi ON r . id = isi . order_id ";
    $query .= "left join product pro ON isi . product_id = pro . id ";
    $query .= "left join grn gr ON isi . id = gr . respons_id ";
    $query .= "WHERE c . id = {$safe_c_id} and gr . status = 1 ";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);

    return $result_set;
}

//create
function create_user($name, $email, $phone, $photo, $pass, $role, $branch)
{
    global $connection;
    $safe_name = mysqli_real_escape_string($connection, $name);
    $safe_email = mysqli_real_escape_string($connection, $email);
    $safe_phone = mysqli_real_escape_string($connection, $phone);
    $safe_photo = mysqli_real_escape_string($connection, $photo);
    $safe_pass = mysqli_real_escape_string($connection, $pass);
    $safe_role = mysqli_real_escape_string($connection, $role);
    $safe_branch = mysqli_real_escape_string($connection, $branch);


    $query = "INSERT INTO `users`(`name`, `email`, `phone`, `avatar`, `password`, `Role`, `branch`) ";
    $query .= "VALUES('{$safe_name}', '{$safe_email}', '{$safe_phone}', '{$safe_photo}', '{$safe_pass}', '{$safe_role}', '{$safe_branch}')";
    $user_set = mysqli_query($connection, $query);

    confirm_query($user_set);
    if ($user_set) {
        // Success
        $_SESSION["art_message"] = "User created . ";

        redirect_to("users.php");
    } else {
        // Failure
        $_SESSION["art_error"] = "User creation failed . ";
    }
}

function create_category($title, $category, $description, $user_id)
{
    global $connection;
    $safe_title = mysqli_real_escape_string($connection, $title);
    $safe_category = mysqli_real_escape_string($connection, $category);
    $safe_description = mysqli_real_escape_string($connection, $description);
    $safe_create_by = mysqli_real_escape_string($connection, $user_id);
    $safe_update_by = mysqli_real_escape_string($connection, $user_id);

    $query = "INSERT INTO `category`(`title`, `category`, `description`, `created_by`, `last_update_by`) ";
    $query .= "VALUES('{$safe_title}', '{$safe_category}', '{$safe_description}',{$safe_create_by},{$safe_update_by});";
    $cate_set = mysqli_query($connection, $query);

    confirm_query($cate_set);
    if ($cate_set) {
        // Success
        $_SESSION["art_message"] = "Category created . ";

        redirect_to("categories.php");
    } else {
        // Failure
        $_SESSION["art_error"] = "Category creation failed . ";
    }
}

function create_price($cat, $item, $price, $uom, $date, $user_id)
{
    global $connection;
    $safe_cat = mysqli_real_escape_string($connection, $cat);
    $safe_item = mysqli_real_escape_string($connection, $item);
    $safe_price = mysqli_real_escape_string($connection, $price);
    $safe_uom = mysqli_real_escape_string($connection, $uom);
    $safe_date = mysqli_real_escape_string($connection, $date);
    $safe_user_id = mysqli_real_escape_string($connection, $user_id);

    $query = "INSERT INTO `price`(`item`,`price_group`, `price`, `uom`, `starting_date`, `created_by`) ";
    $query .= "VALUES ({$safe_item},{$safe_cat}, {$safe_price},'{$safe_uom}','{$safe_date}',{$safe_user_id});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);
    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "Price List Created.";

        redirect_to("price.php");
    } else {
        // Failure
        $_SESSION["art_error"] = "Price List Creation Failed." . $query;
    }
}

function create_vehicle($title, $plate_no, $customer_id, $driver_name, $driver_number, $category_id)
{
    global $connection;
    $safe_title = mysqli_real_escape_string($connection, $title);
    $safe_plate = mysqli_real_escape_string($connection, $plate_no);
    $safe_cu_id = mysqli_real_escape_string($connection, $customer_id);
    $safe_dr_name = mysqli_real_escape_string($connection, $driver_name);
    $safe_dr_number = mysqli_real_escape_string($connection, $driver_number);
    $safe_cat_id = mysqli_real_escape_string($connection, $category_id);
    $date = date("Y / m / d");

    $query = "INSERT INTO `vehicle`(`title`, `plate_no`, `customer_id`, `driver_name`, `driver_number`, `category_id`, `join_date`) ";
    $query .= "VALUES('{$safe_title}', '{$safe_plate}', '{$safe_cu_id}', '{$safe_dr_name}', '{$safe_dr_number}', '{$safe_cat_id}', '{$date}');";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "Vehicle created . ";

        redirect_to("vehicle.php");
    } else {
        // Failure
        $_SESSION["art_error"] = "Vehicle creation failed . ";
    }
}

function create_product($code, $title, $type, $category, $measurement, $description, $min_stock, $sh_min_stock, $sr_min_stock, $created_by)
{
    global $connection;
    $safe_code = mysqli_real_escape_string($connection, $code);
    $safe_title = mysqli_real_escape_string($connection, $title);
    $safe_type = mysqli_real_escape_string($connection, $type);
    $safe_category = mysqli_real_escape_string($connection, $category);
    $safe_measurement = mysqli_real_escape_string($connection, $measurement);
    $safe_description = mysqli_real_escape_string($connection, $description);
    $safe_min_stock = mysqli_real_escape_string($connection, $min_stock);
    $safe_sh_min_stock = mysqli_real_escape_string($connection, $sh_min_stock);
    $safe_sr_min_stock = mysqli_real_escape_string($connection, $sr_min_stock);
    $safe_created_by = mysqli_real_escape_string($connection, $created_by);
//    $safe_last_update_by = mysqli_real_escape_string($connection, $last_update_by);
//    $safe_last_update_date = mysqli_real_escape_string($connection, $last_update_date);

    $query = "INSERT INTO `product`(`code`, `title`, `type`, `category`, `measurment`, `description`, `min_stock`, `min_shop`, `min_showroom`, `created_by`, `last_update_by`) ";
    $query .= "VALUES('{$safe_code}', '{$safe_title}', '{$safe_type}',{$safe_category},'{$safe_measurement}','{$safe_description}',{$safe_min_stock},{$safe_sh_min_stock},{$safe_sr_min_stock} ,{$safe_created_by},{$safe_created_by});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "Product created . ";

        redirect_to("product.php");
    } else {
        // Failure
        $_SESSION["art_error"] = "Product creation failed . ";
    }
}

function create_purchase_request($item_id, $qyt, $u_id)
{
    global $connection;
    $safe_item = mysqli_real_escape_string($connection, $item_id);
    $safe_qyt = mysqli_real_escape_string($connection, $qyt);
    $safe_u_id = mysqli_real_escape_string($connection, $u_id);

    $query = "INSERT INTO `pu_request`(`item_id`, `quantity`, `created_by`, `last_update_by`) ";
    $query .= "VALUES({$safe_item},{$safe_qyt},{$safe_u_id},{$safe_u_id});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "Purchase Request created . ";

    } else {
        // Failure
        $_SESSION["art_error"] = "Purchase Request creation failed . ";
    }
}

function create_purchase_order($pr_id, $v_id, $qyt, $s_date, $u_price, $warehouse_id, $u_id)
{
    global $connection;
    $safe_pr = mysqli_real_escape_string($connection, $pr_id);
    $safe_v_id = mysqli_real_escape_string($connection, $v_id);
    $safe_qyt = mysqli_real_escape_string($connection, $qyt);
    $safe_s_date = mysqli_real_escape_string($connection, $s_date);
    $safe_warehouse = mysqli_real_escape_string($connection, $warehouse_id);
    $safe_price = mysqli_real_escape_string($connection, $u_price);
    $safe_u_id = mysqli_real_escape_string($connection, $u_id);

    $query = "INSERT INTO `pu_order`(`pu_request_id`, `vendor_id`, `quantity`, `scheduled_date`, `unit_price`, `warehouse_id`, `created_by`, `last_update_by`) ";
    $query .= "VALUES({$safe_pr},{$safe_v_id},{$safe_qyt},'{$safe_s_date}',{$safe_price},{$safe_warehouse},{$safe_u_id},{$safe_u_id});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        return true;

    } else {
        // Failure
        return false;
    }
}

function create_warehouse($title, $address, $u_id)
{
    global $connection;
    $safe_title = mysqli_real_escape_string($connection, $title);
    $safe_address = mysqli_real_escape_string($connection, $address);
    $safe_u_id = mysqli_real_escape_string($connection, $u_id);

    $query = "INSERT INTO `warehouse`(`title`, `address`, `created_by`, `last_update_by`) ";
    $query .= "VALUES('{$safe_title}', '{$safe_address}',{$safe_u_id},{$safe_u_id});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "Warehouse created . ";
        redirect_to('warehouse.php');

    } else {
        // Failure
        $_SESSION["art_error"] = "Warehouse creation failed . ";
    }
}

function create_productionLine($title, $descr, $u_id)
{
    global $connection;
    $safe_title = mysqli_real_escape_string($connection, $title);
    $safe_descr = mysqli_real_escape_string($connection, $descr);
    $safe_u_id = mysqli_real_escape_string($connection, $u_id);

    $query = "INSERT INTO `production_line`(`title`, `descr`, `created_by`) ";
    $query .= "VALUES('{$safe_title}', '{$safe_descr}',{$safe_u_id});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "Production line created . ";
        redirect_to('addProductionLine.php');

    } else {
        // Failure
        $_SESSION["art_error"] = "Production line creation failed . ";
    }
}

function create_productionShift($title, $starting, $ending, $u_id)
{
    global $connection;
    $safe_title = mysqli_real_escape_string($connection, $title);
    $safe_starting = mysqli_real_escape_string($connection, $starting);
    $safe_ending = mysqli_real_escape_string($connection, $ending);
    $safe_u_id = mysqli_real_escape_string($connection, $u_id);

    $query = "INSERT INTO `production_shift`(`title`, `starting_time`, `ending_time`, `created_by`) ";
    $query .= "VALUES('{$safe_title}', '{$safe_starting}', '{$safe_ending}',{$safe_u_id});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "Production shift created . ";
        redirect_to('addProductionShift.php');

    } else {
        // Failure
        $_SESSION["art_error"] = "Production shift creation failed . ";
    }
}

function create_productionBom($item, $p_qty, $raw_item, $raw_qty, $u_id)
{
    global $connection;
    $safe_item = mysqli_real_escape_string($connection, $item);
    $safe_qty = mysqli_real_escape_string($connection, $p_qty);
    $safe_raw_item = mysqli_real_escape_string($connection, $raw_item);
    $safe_raw_qty = mysqli_real_escape_string($connection, $raw_qty);
    $safe_u_id = mysqli_real_escape_string($connection, $u_id);

    $query = "INSERT INTO `production_bom`(`item_id`, `produce_quantity`, `raw_item_id`, `raw_quantity`, `created_by`) ";
    $query .= "VALUES({$safe_item},{$safe_qty},'{$safe_raw_item}','{$safe_raw_qty}',{$safe_u_id});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "BOM created . ";
//        redirect_to('bom.php');

    } else {
        // Failure
        $_SESSION["art_error"] = "BOM creation failed . ";
    }
}

function create_productionPlan($date, $line, $shift, $item, $qty, $created_by)
{
    global $connection;
    $safe_date = mysqli_real_escape_string($connection, $date);
    $safe_line = mysqli_real_escape_string($connection, $line);
    $safe_shift = mysqli_real_escape_string($connection, $shift);
    $safe_item = mysqli_real_escape_string($connection, $item);
    $safe_qty = mysqli_real_escape_string($connection, $qty);
    $safe_created_by = mysqli_real_escape_string($connection, $created_by);

    $query = "INSERT INTO `production_plan`(`production_date`, `line_id`, `shift_id`, `item_id`, `quantity`, `created_by`) ";
    $query .= "VALUES('{$safe_date}',{$safe_line},{$safe_shift},{$safe_item},{$safe_qty},{$safe_created_by});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "Production plan created . ";

        redirect_to("productionPlan.php");
    } else {
        // Failure
        $_SESSION["art_error"] = "Production plan creation failed . ";
    }
}
function create_inventory($item_id, $type, $qyt, $category, $warehouse, $u_id, $edate)
{
    global $connection;
    $safe_item = mysqli_real_escape_string($connection, $item_id);
    $safe_type = mysqli_real_escape_string($connection, $type);
    $safe_qyt = mysqli_real_escape_string($connection, $qyt);
    $safe_category = mysqli_real_escape_string($connection, $category);
    $safe_warehouse = mysqli_real_escape_string($connection, $warehouse);
    $safe_edate = mysqli_real_escape_string($connection, $edate);
    $safe_u_id = mysqli_real_escape_string($connection, $u_id);

    $query = "INSERT INTO `inventory`(`item_id`,`type`, `quantity`, `category`, `warehouse_id`, `expiered_date`, `created_by`,`last_update_by`) ";
    $query .= "VALUES({$safe_item},'{$safe_type}',{$safe_qyt},{$safe_category},{$safe_warehouse},'{$safe_edate}',{$safe_u_id},{$safe_u_id});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        return true;

    } else {
        // Failure
        return false;
    }
}

function create_inventory_expiration($item_id,$qyt,$edate, $u_id, $warehouse)
{
    global $connection;
    $safe_item = mysqli_real_escape_string($connection, $item_id);
    $safe_qyt = mysqli_real_escape_string($connection, $qyt);
    $safe_edate = mysqli_real_escape_string($connection, $edate);
    $safe_u_id = mysqli_real_escape_string($connection, $u_id);
    $safe_warehouse = mysqli_real_escape_string($connection, $warehouse);
    $query = "INSERT INTO `inventory`(`item_id`, `quantity`, `expiered_date`,`warehouse_id`, `created_by`,`last_update_by`) ";
    $query .= "VALUES({$safe_item},{$safe_qyt},'{$safe_edate}',{$safe_warehouse},{$safe_u_id},{$safe_u_id});";
    $result_set = mysqli_query($connection, $query);
    confirm_query($result_set);
    if ($result_set) {
        // Success
        return true;

    } else {

    $query1 = "SELECT * ";
    $query1 .= "FROM inventory ";
    $query1 .= "WHERE item_id = {$safe_item} and warehouse_id = {$safe_warehouse} and expiered_date <= '{$safe_edate}'";
    $query1 .= "LIMIT 1;";
    $result_set1 = mysqli_query($connection, $query1);
    confirm_query($result_set1);
    // $result = mysqli_fetch_assoc($result_set1);
    if ($result_set1)
    {
        $query2 = "update `inventory` set `quantity` = quantity + {$safe_qyt} ";
        $query2 .= "WHERE item_id = {$safe_item} and warehouse_id = {$safe_warehouse} and expiered_date <= '{$safe_edate}'";  
        $result_set2 = mysqli_query($connection, $query2);
        confirm_query($result_set2);
        if ($result_set2) {
            // Success
            return true;

        } else {
            // Failure
            return false;
        }
    }  
}
    }
function create_inventory_out($item_id, $type, $qyt, $category, $warehouse, $u_id, $remark)
{
    global $connection;
    $safe_item = mysqli_real_escape_string($connection, $item_id);
    $safe_type = mysqli_real_escape_string($connection, $type);
    $safe_qyt = mysqli_real_escape_string($connection, $qyt);
    $safe_category = mysqli_real_escape_string($connection, $category);
    $safe_warehouse = mysqli_real_escape_string($connection, $warehouse);
    $safe_u_id = mysqli_real_escape_string($connection, $u_id);
    $safe_remark = mysqli_real_escape_string($connection, $remark);

    $query = "INSERT INTO `inventory`(`item_id`,`type`, `quantity`, `category`, `warehouse_id`, `created_by`,`last_update_by`,`remark`) ";
    $query .= "VALUES({$safe_item},'{$safe_type}',{$safe_qyt},{$safe_category},{$safe_warehouse},{$safe_u_id},{$safe_u_id},'{$safe_remark}');";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        return true;

    } else {
        // Failure
        return false;
    }
}

function create_transfer($item_id, $type, $qyt, $category, $warehouse, $warehouse1, $user, $u_id)
{
    global $connection;
    $safe_item = mysqli_real_escape_string($connection, $item_id);
    $safe_category = mysqli_real_escape_string($connection, $category);
    $safe_qyt = mysqli_real_escape_string($connection, $qyt);
    $safe_type = mysqli_real_escape_string($connection, $type);
    $safe_warehouse = mysqli_real_escape_string($connection, $warehouse);
    $safe_warehouse1 = mysqli_real_escape_string($connection, $warehouse1);
    $safe_user = mysqli_real_escape_string($connection, $user);
    $safe_u_id = mysqli_real_escape_string($connection, $u_id);

    $query = "INSERT INTO `inv_ret_tra`(`type`,`category`, `item`, `quantity`, `from_location`, `to_location`, `transferd_by`, `req_by`, `update_by`) ";
    $query .= " VALUES('{$safe_type}', '{$safe_category}',{$safe_item},{$safe_qyt},{$safe_warehouse},{$safe_warehouse1},{$safe_user},{$safe_u_id},{$safe_u_id});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set)
        return true;
    else
        return false;
}


function create_transfer_out($item_id, $type, $qyt, $category, $warehouse, $user, $u_id, $remark)
{
    global $connection;
    $safe_item = mysqli_real_escape_string($connection, $item_id);
    $safe_category = mysqli_real_escape_string($connection, $category);
    $safe_qyt = mysqli_real_escape_string($connection, $qyt);
    $safe_type = mysqli_real_escape_string($connection, $type);
    $safe_warehouse = mysqli_real_escape_string($connection, $warehouse);
    $safe_user = mysqli_real_escape_string($connection, $user);
    $safe_u_id = mysqli_real_escape_string($connection, $u_id);
    $safe_remark = mysqli_real_escape_string($connection, $remark);

    $query = "INSERT INTO `inv_ret_tra`(`type`,`category`, `item`, `quantity`, `from_location`,  `transferd_by`, `req_by`, `update_by`, `remark`) ";
    $query .= " VALUES('{$safe_type}', '{$safe_category}',{$safe_item},{$safe_qyt},{$safe_warehouse},{$safe_user},{$safe_u_id},{$safe_u_id},'{$safe_remark}');";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set)

        return true;
    else
        return false;
}

function create_order_request($v_id, $p_id, $qyt, $r_number, $u_id, $rate)
{
    global $connection;
    $safe_ref = mysqli_real_escape_string($connection, $r_number);
    $safe_v_id = mysqli_real_escape_string($connection, $v_id);
    $safe_p_id = mysqli_real_escape_string($connection, $p_id);
    $safe_qyt = mysqli_real_escape_string($connection, $qyt);
    $safe_rate = mysqli_real_escape_string($connection, $rate);
    $safe_u_id = mysqli_real_escape_string($connection, $u_id);
    $safe_o_date = date("Y / m / d h:i:sa");

    $query = "INSERT INTO `order_requst`(`reference_number`, `vehicle_id`, `product_id`, `quantity`, `rate`, `order_date`, `user_id`) ";
    $query .= "VALUES('{$safe_ref}',{$safe_v_id},{$safe_p_id},{$safe_qyt},'{$safe_rate}','{$safe_o_date}',{$safe_u_id});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "Order Request created . ";

        redirect_to("orderRequest.php");
    } else {
        // Failure
        $_SESSION["art_error"] = "Order Request creation failed . ";
    }
}

function create_order_response($o_id, $p_id, $qyt, $r_number, $departure, $destination, $u_id)
{
    global $connection;
    $safe_ref = mysqli_real_escape_string($connection, $r_number);
    $safe_o_id = mysqli_real_escape_string($connection, $o_id);
    $safe_p_id = mysqli_real_escape_string($connection, $p_id);
    $safe_qyt = mysqli_real_escape_string($connection, $qyt);
    $safe_departure = mysqli_real_escape_string($connection, $departure);
    $safe_destination = mysqli_real_escape_string($connection, $destination);
    $safe_u_id = mysqli_real_escape_string($connection, $u_id);
    $safe_r_date = date("Y / m / d h:i:sa");

    $query = "INSERT INTO `isiv`(`reference_number`, `order_id`, `product_id`, `quantity`, `date`,`departure`, `destination`, `user_id`) ";
    $query .= "VALUES('{$safe_ref}',{$safe_o_id},{$safe_p_id},{$safe_qyt},'{$safe_r_date}','{$safe_departure}','{$safe_destination}',{$safe_u_id});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        update_order_request($safe_o_id);

        $_SESSION["art_message"] = "Order Response created . ";

        redirect_to("orderRequest.php");
    } else {
        // Failure
        $_SESSION["art_error"] = "Order Response creation failed . ";
    }
}

function create_goods_receive($r_id, $ref, $damege, $shortage, $over, $remark, $u_id)
{
    global $connection;
    $safe_ref = mysqli_real_escape_string($connection, $ref);
    $safe_r_id = mysqli_real_escape_string($connection, $r_id);
    $safe_damage = mysqli_real_escape_string($connection, $damege);
    $safe_shortage = mysqli_real_escape_string($connection, $shortage);
    $safe_over = mysqli_real_escape_string($connection, $over);
    $safe_remark = mysqli_real_escape_string($connection, $remark);
    $safe_u_id = mysqli_real_escape_string($connection, $u_id);
    $safe_r_date = date("Y / m / d h:i:sa");

    $query = "INSERT INTO `grn`(`respons_id`, `reference_number`, `approve_date`, `damege_pack`, `shortage_pack`, `over_pack`, `remark`, `u_id`) ";
    $query .= "VALUES({$safe_r_id},'{$safe_ref}','{$safe_r_date}',{$safe_damage},{$safe_shortage},{$safe_over},'{$safe_remark}',{$safe_u_id});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        update_order_respons($safe_r_id);

        $_SESSION["art_message"] = "Goods Received . ";

        redirect_to("orderResponse.php");
    } else {
        // Failure
        $_SESSION["art_error"] = "Goods Not Received . ";
    }
}


//
function pu_request_approved_quantity($p_id, $qyt, $u_id)
{
    global $connection;
    $safe_p_id = mysqli_real_escape_string($connection, $p_id);
    $safe_qyt = mysqli_real_escape_string($connection, $qyt);
    $safe_u_id = mysqli_real_escape_string($connection, $u_id);

    $query = "INSERT INTO `pu_approved_quantity`(`pu_request_id`, `approved_quantity`,`approved_by`, `update_by`) ";
    $query .= "VALUES({$safe_p_id},{$safe_qyt},{$safe_u_id},{$safe_u_id});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        return true;
    } else {
        // Failure
        return false;
    }
}

function pu_order_received_quantity($p_id, $qyt, $plate, $driver, $phone, $u_id)
{
    global $connection;
    $safe_p_id = mysqli_real_escape_string($connection, $p_id);
    $safe_qyt = mysqli_real_escape_string($connection, $qyt);
    $safe_plate = mysqli_real_escape_string($connection, $plate);
    $safe_driver = mysqli_real_escape_string($connection, $driver);
    $safe_phone = mysqli_real_escape_string($connection, $phone);
    $safe_u_id = mysqli_real_escape_string($connection, $u_id);

    $query = "INSERT INTO `pu_recevied_quantity`(`pu_order_id`, `quantity`, `plate_no`, `driver_name`, `driver_phone`, `recevied_by`, `last_update_by`) ";
    $query .= "VALUES({$safe_p_id},{$safe_qyt},'{$safe_plate}','{$safe_driver}','{$safe_phone}',{$safe_u_id},{$safe_u_id});";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        return true;
    } else {
        // Failure
        return false;
    }
}

function approve_purchase_request($pr_id, $qyt, $u_id)
{
    global $connection;
    $safe_pr = mysqli_real_escape_string($connection, $pr_id);
    $safe_qyt = str_replace(',', '', mysqli_real_escape_string($connection, $qyt));
    $safe_u_id = mysqli_real_escape_string($connection, $u_id);
    $safe_r_date = date("Y - m - d h:i:sa");

    $query = "update `pu_request` set `approved_by` = {$safe_u_id},approved_quantity = {$safe_qyt} , approved_date = '{$safe_r_date}'";
    $query .= "where id = {$safe_pr};";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "Purchase Request approved . ";

    } else {
        // Failure
        $_SESSION["art_error"] = "Purchase Request approval failed . ";
    }
}

function update_approved_purchase_request($pr_id, $qyt)
{
    global $connection;
    $safe_pr = mysqli_real_escape_string($connection, $pr_id);
    $safe_qyt = str_replace(',', '', mysqli_real_escape_string($connection, $qyt));

    $query = "update `pu_request` set ordered_quantity = {$safe_qyt} ";
    $query .= "where id = {$safe_pr};";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        return true;

    } else {
        // Failure
        return false;
    }
}

function update_purchase_receive($pr_id, $qyt, $u_id)
{
    global $connection;

    $safe_pr = mysqli_real_escape_string($connection, $pr_id);
    $safe_qyt = str_replace(',', '', mysqli_real_escape_string($connection, $qyt));
    $safe_u_id = mysqli_real_escape_string($connection, $u_id);
    $pu_order = find_purchase_order_by_id($safe_pr);

    $qty = $safe_qyt - $pu_order['received_qty'];

    $query = "update `pu_order` set `receive_by` = {$safe_u_id},received_qty = {$safe_qyt} ";
    $query .= "where id = {$safe_pr};";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success

        $pu_request = find_purchase_request_by_id($pu_order["pu_request_id"])["item_id"];

        $type = find_product_by_id($pu_request)['category'];
        create_inventory($pu_request, $type, $qty, "purchase", $pu_order['warehouse_id'], $safe_u_id, "");

        $_SESSION["art_message"] = "Purchase order received . ";

    } else {
        // Failure
        $_SESSION["art_error"] = "Purchase order received failed . ";
    }
}

function update_purchase_invoice($pr_id, $qyt, $u_id)
{
    global $connection;
    $safe_pr = mysqli_real_escape_string($connection, $pr_id);
    $safe_qyt = str_replace(',', '', mysqli_real_escape_string($connection, $qyt));
    $safe_u_id = mysqli_real_escape_string($connection, $u_id);

    $query = "update `pu_order` set `invoice_by` = {$safe_u_id},invoced_qty = {$safe_qyt} ";
    $query .= "where id = {$safe_pr};";
    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "Purchase order invoiced . ";

    } else {
        // Failure
        $_SESSION["art_error"] = "Purchase order invoice failed . ";
    }
}

function update_order_request($id)
{
    global $connection;
    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "UPDATE order_requst SET ";
    $query .= "status = 1 ";
    $query .= "WHERE id = {
    $safe_id}; ";
    $result = mysqli_query($connection, $query);

    if ($result) {
        // Success
        return true;

    } else {
        // Failure
        return false;
    }

}

function update_completed_production($id)
{
    global $connection;
    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "UPDATE production_plan SET ";
    $query .= "production_status = 2 ";
    $query .= "WHERE id = {$safe_id}; ";
    $result = mysqli_query($connection, $query);

    if ($result) {
        // Success
        return true;

    } else {
        // Failure
        return false;
    }

}

function approve_transfer_request($tr_id, $qyt, $u_id)
{
    global $connection;
    $safe_tr = mysqli_real_escape_string($connection, $tr_id);
    $safe_qyt = str_replace(',', '', mysqli_real_escape_string($connection, $qyt));
    $safe_u_id = mysqli_real_escape_string($connection, $u_id);
    $safe_r_date = date("Y - m - d h:i:sa");

    $query = "update `inv_ret_tra` set `approved_by` = {$safe_u_id},approved_quantity = {$safe_qyt} , approved_date = '{$safe_r_date}', transfer_status = 1 ";
    $query .= "where id = {$safe_tr};";

    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        $_SESSION["art_message"] = "Transfer Request approved . ";

    } else {
        // Failure
        $_SESSION["art_error"] = "Transfer Request approval failed . ";
    }
}

function update_receive_transfer($tr_id, $qyt, $d_qyt, $u_id)
{
    global $connection;
    $safe_tr = mysqli_real_escape_string($connection, $tr_id);
    $safe_qyt = str_replace(',', '', mysqli_real_escape_string($connection, $qyt));
    $safe_d_qyt = str_replace(',', '', mysqli_real_escape_string($connection, $d_qyt));
    $safe_u_id = mysqli_real_escape_string($connection, $u_id);
    $safe_r_date = date("Y - m - d h:i:sa");

    $query = "update `inv_ret_tra` set `rec_by` = {$safe_u_id},rec_qty = {$safe_qyt} ,damage_qty = {$safe_d_qyt} , rec_at = '{$safe_r_date}', transfer_status = 2 ";
    $query .= "where id = {$safe_tr};";

    $result_set = mysqli_query($connection, $query);

    confirm_query($result_set);

    if ($result_set) {
        // Success
        return true;

    } else {
        // Failure
        return false;
    }
}

function update_order_respons($id)
{
    global $connection;
    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "UPDATE isiv SET ";
    $query .= "status = 1 ";
    $query .= "WHERE id = {$safe_id}; ";
    $result = mysqli_query($connection, $query);

    if ($result) {
        // Success
        return true;

    } else {
        // Failure
        return false;
    }

}

function update_goods_receive($id)
{
    global $connection;
    $safe_id = mysqli_real_escape_string($connection, $id);

    $query = "UPDATE grn SET ";
    $query .= "status = 1 ";
    $query .= "WHERE id = {$safe_id}; ";
    $result = mysqli_query($connection, $query);

    if ($result) {
        // Success
        return true;

    } else {
        // Failure
        return false;
    }

}

//registration and login
function password_encrypt($password)
{
    $hash_format = "2y$10$";
    $salt_length = 22;
    $salt = generate_salt($salt_length);
    $format_and_salt = $hash_format . $salt;
    $hash = crypt($password, $format_and_salt);

    return $hash;

}

function generate_salt($length)
{
    $unique_random_string = md5(uniqid(mt_rand(), true));

    // Valid characters for a salt are [a-zA-Z0-9./]
    $base64_string = base64_encode($unique_random_string);

    // But not '+' which is valid in base64 encoding
    $modified_base64_string = str_replace('+', '.', $base64_string);

    // Truncate string to the correct length
    $salt = substr($modified_base64_string, 0, $length);

    return $salt;
}

function password_check($password, $existing_hash)
{
    // existing hash contains format and salt at start
    $hash = crypt($password, $existing_hash);

    if ($hash === $existing_hash) {
        return true;
    } else {
        return false;
    }
}

function attempt_login($username, $password)
{
    $user = find_user_by_username($username);

    if ($user) {
        //admin found, now check password
        if (password_check($password, $user["password"])) {
            //password matches
            return $user;
        } else {
            //password not matches
            return false;
        }
    } else {
        //admin not found
        return false;
    }
}

function logged_in()
{
    return isset($_SESSION['admin_id']);
}

function confirm_logged_in()
{
    if (!logged_in()) {
        redirect_to("../account / login.php");
    }
}

function upload_file($name)
{
    $image_url = null;
    $imgFile = $_FILES[$name]['name'];
    $tmp_dir = $_FILES[$name]['tmp_name'];
    $imgSize = $_FILES[$name]['size'];

    if (empty($imgFile)) {

        $_SESSION["art_error"] = "Please Select File . ";
    } else {
        $upload_dir = 'user_images/'; // upload directory
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension

        // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'pdf'); // valid extensions

        // rename uploading image
        $image_url = rand(1000, 1000000) . $imgFile;

        // allow valid image file formats
        if (in_array($imgExt, $valid_extensions)) {
            // Check file size '5MB'
            if ($imgSize < 100000000) {
                move_uploaded_file($tmp_dir, "admin / " . $upload_dir . $image_url);
                $image_url = $upload_dir . $image_url;
            } else {
                $_SESSION["art_error"] = "Sorry, your file is too large . ";
            }
        } else {
            $_SESSION["art_error"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed . ";
        }
    }
    return $image_url;
}

function upload_image($name)
{
    $image_url = null;
    $imgFile = $_FILES[$name]['name'];
    $tmp_dir = $_FILES[$name]['tmp_name'];
    $imgSize = $_FILES[$name]['size'];


    if (empty($imgFile)) {

//        $_SESSION["art_error"] = "Please Select Image File . ";
    } else {
        $upload_dir = 'user_images/'; // upload directory
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension

        // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'pdf'); // valid extensions

        // rename uploading image
        $image_url = rand(1000, 1000000) . $imgFile;

        // allow valid image file formats
        if (in_array($imgExt, $valid_extensions)) {
            // Check file size '5MB'
            if ($imgSize < 100000000) {
                move_uploaded_file($tmp_dir, $upload_dir . $image_url);
                $image_url = $upload_dir . $image_url;
            } else {
                $_SESSION["art_error"] = "Sorry, your file is too large . ";
            }
        } else {
            $_SESSION["art_error"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed . ";
        }
    }
    return $image_url;
}

function apply($mailto, $from_mail, $from_name, $messages, $subject, $name)
{

    $filename = $_FILES[$name]["name"];
    $content = chunk_split(base64_encode(file_get_contents($_FILES[$name]["tmp_name"])));

    $eol = PHP_EOL;

    $uid = md5(uniqid(time()));
//    $name = basename($file);
    $header = "From: " . $from_name . " < " . $from_mail . ">" . $eol;
//    $header .= "Reply - To: " . $replyto . " ".$eol;

    $header .= "MIME - Version: 1.0\r\n";
    $header .= "Content - Type: multipart / mixed; boundary = \"" . $uid . "\"";
    //$header .= "This is a multi-part message in MIME format.\r\n";

    $message = "--" . $uid . " " . $eol;

// You add html "Content-type: text/html; charset=utf-8\n" or for Text "Content-type:text/plain; charset=iso-8859-1\r\n" by I.khan
    $message .= "Content-type:text/html; charset=utf-8" . $eol;
    $message .= "Content-Transfer-Encoding: 8bit" . $eol . $eol;

// User Message you can add HTML if You Selected HTML content
    $message .= "<div style='color: red'>" . $message . "</div>" . $eol;

    $message .= "--" . $uid . $eol;
    $message .= "Content-Type: application/pdf; name=\"" . $filename . "\"" . $eol;// use different content types here
    $message .= "Content-Transfer-Encoding: base64" . $eol;
    $message .= "Content-Disposition: attachment; filename=\"" . $filename . "\"" . $eol;// For Attachment
    $message .= $content . $eol;
    $message .= "--" . $uid . "--";
    if (mail($mailto, "ኮስት አካውንታንት/ Cost Accountant " . $subject, $message, $header)) {
        $_SESSION["art_message"] = "Successfully apply.";// or use booleans here
    } else {
        $_SESSION["art_error"] = "Please Try again.";
    }

//    return true;
}

function image_gallery_from_folder($folder_path)
{
    $num_files = glob($folder_path . "*.{JPG,jpg,gif,png,bmp}", GLOB_BRACE);

    $folder = opendir($folder_path);

    $output = "";
    if ($num_files > 0) {
        while (false !== ($file = readdir($folder))) {
            $file_path = $folder_path . $file;
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if ($extension == 'jpg' || $extension == 'png' || $extension == 'gif' || $extension == 'bmp') {

                $output = "<a href= \" ";
                $output .= $file_path;
                $output .= "\"> <img src = \"";
                $output .= $file_path;
                $output .= "\"";
                $output .= "height = \"250\" width = \"250\" /></a >";

            }
        }
    } else {
        $output = null;
    }
    closedir($folder);

    return $output;
}

function send_mail($message_body)
{
    //$mailhost, $musername, $mpassword, $mport,
    $mailhost = "localhost";
    $musername = 'mel@local';
    $mpassword = '12345678';
    $mport = 25;
    $site_root = 'http://localhost/mailer.php';
    $mpassword = trim($mpassword);
    $musername = trim($musername);
    try {
        require_once("PHPMailer_5.2.4/class.phpmailer.php");

        $mail = new PHPMailer();
        $mail->IsSMTP();
        //$mail->SMTPDebug = 1; // for debug purpose
        $mail->SMTPAuth = true;
        //$mail->SMTPSecure = 'tls';
        $mail->Host = $mailhost;
        $mail->Port = $mport; // or 587
        $mail->IsHTML(true);
        $mail->Username = $musername;
        $mail->Password = $mpassword;
        $mail->SetFrom($musername);
        $mail->Subject = "Contact Form Shemu website";
        $mail->Body = $message_body;
        $mail->AddAddress('postmaster@localhost');

    } catch (Exception $e) {
        return false;
        //echo "We tried sending you a confirmation email. But we were unable to do so.";
    }
    if (!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
        return false;
    } else {
        return true;
        //echo "We have sent a reservation email to you.  <a href='index.php'>Return Back</a>";
        //header('Location: index.php');
        //exit();
    }
    return true;
}

function email_to_admin($user_name, $user_email, $message)
{
    global $connection;

    $safe_user_name = mysqli_real_escape_string($connection, $user_name);
    $safe_user_email = mysqli_real_escape_string($connection, $user_email);
    $safe_message = mysqli_real_escape_string($connection, $message);

    $qurey = "INSERT INTO `contact`(`username`, `emial`, `message`)";
    $qurey .= " VALUES ('{$safe_user_name}','{$safe_user_email}','{$safe_message}')";

    $contact_set = mysqli_query($connection, $qurey);
    confirm_query($contact_set);
    if ($contact_set) {
        $_SESSION["art_message"] = "Successfully Send Message.";
    } else {
        $_SESSION["art_error"] = "Please try again.";
    }

}

function validatePhone($string)
{
    $numbersOnly = ereg_replace("[^0-9]", "", $string);
    $numberOfDigits = strlen($numbersOnly);
    if ($numberOfDigits == 10 || $numberOfDigits = 12) {
        echo $numbersOnly;
    } else {
        echo 'Invalid Phone Number';
    }
}


?>