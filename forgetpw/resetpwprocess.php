<?php
/**
 * Created by PhpStorm.
 * User: wei
 * Date: 7/18/17
 * Time: 11:06 PM
 */
require_once('../include/functions.php');
parse_str(file_get_contents('php://input'), $post_value);
$new_password = $post_value['password'];
$email = $post_value['email'];
$token = $post_value['token'];
$level = $post_value['level'];

if (validatelink($email, $token, $level)) {
    resetpw($email, $new_password, $level);
    $newtoken = generatetoken();
    updatetoken($email, $newtoken, $level);
    if ($level == 'a') {
        header("Location: ../public/login.php?level=a&error=3");
    } elseif ($level == 's') {
        header("Location: ../public/login.php?level=s&error=3");
    } else {
        header("Location: ../index.html");
    }

} else {
    header("Location: ../index.html");
}
?>