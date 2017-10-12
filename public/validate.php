<?php
/**
 * Created by PhpStorm.
 * User: wei
 * Date: 7/18/17
 * Time: 11:35 AM
 */
require_once('../include/functions.php');
parse_str(file_get_contents('php://input'), $post_value);
$username = $post_value['username'];
$password = $post_value['password'];
$password=md5($password);
$level = $post_value['level'];

if (($username == '') || ($password == '')) {
    if ($level == 's') {
        header("Location: login.php?errno=1&level=s"); /* Redirect browser */
    } else {
        header("Location: login.php?errno=1&level=a"); /* Redirect browser */
    }
} else {
    $dbc = connectdb();
    $username = mysqli_real_escape_string($dbc, $username);
    $password = mysqli_real_escape_string($dbc, $password);
    if ($level == 's') {
        $query = "SELECT Student_ID, Student_Username, Student_Password FROM Student WHERE Student_Username ='$username'
                AND Student_Password = '$password'";
        $data = mysqli_query($dbc, $query) or die (mysqli_error($dbc));
        echo mysqli_num_rows($data);
        if (mysqli_num_rows($data) == 1) {
            $row = mysqli_fetch_array($data);
            setsession($row["Student_ID"], $username, $level);
            header("Location: ../Student/home.php");
        } else {
            header("Location: login.php?errno=2&level=s");
        }
    } else {
        $query = "SELECT Advisor_ID, Advisor_Username, Advisor_Password FROM Advisor WHERE Advisor_Username ='$username'
                AND Advisor_Password = '$password'";
        $data = mysqli_query($dbc, $query);
        if (mysqli_num_rows($data) == 1) {
            $row = mysqli_fetch_array($data);
            setsession($row["Advisor_ID"], $username, $level);
            header("Location: ../Advisor/home.php");


        } else {
            header("Location: login.php?errno=2&level=a");
        }
    }
}
?>
