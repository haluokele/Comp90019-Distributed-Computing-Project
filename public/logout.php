<?php
/**
 * Created by PhpStorm.
 * User: wei
 * Date: 7/18/17
 * Time: 9:51 AM
 */
session_start();
if (isset($_SESSION['userid'])) {
    $_SESSION = array();
    session_destroy();
}
$home_url = '../index.html';
header('Location: ' . $home_url);
?>
