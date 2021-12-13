<?php
require_once("../../includes/db_connection.php");
require_once("../../includes/session.php");
require_once("../../includes/functions.php");
if (isset($_GET['term'])) {
     
   $query = "SELECT * FROM users WHERE name LIKE '{$_GET['term']}%' LIMIT 25";
    $result = mysqli_query($conn, $query);
 
    if (mysqli_num_rows($result) > 0) {
     while ($user = mysqli_fetch_array($result)) {
      $res[] = $user['name'];
     }
    } else {
      $res = array();
    }
    //return json res
    echo json_encode($res);
}
?>