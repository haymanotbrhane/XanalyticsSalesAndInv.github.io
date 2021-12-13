<?php
/**
 * Created by PhpStorm.
 * User: mel
 * Date: 4/22/2016
 * Time: 7:03 AM
 */
?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
// v1: simple logout
// session_start();
$_SESSION["admin_id"] = null;
$_SESSION["username"] = null;
$_SESSION["role"] = null;
redirect_to("../account/login.php");
?>
<?php
// v2: destroy session
// assumes nothing else in session to keep
// session_start();
// $_SESSION = array();
// if (isset($_COOKIE[session_name()])) {
//   setcookie(session_name(), '', time()-42000, '/');
// }
// session_destroy();
// redirect_to("login.php");
?>
