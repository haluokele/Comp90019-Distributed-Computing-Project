<?php
/**
 * Created by PhpStorm.
 * User: wei
 * Date: 7/18/17
 * Time: 9:04 PM
 */
require_once('../include/functions.php');
parse_str(file_get_contents('php://input'), $post_value);
$email = $post_value['email'];
$level = $post_value['level'];


if ($level == 's') {
    require_once('../include/sdef.php');
    $back_url = 'forgetpw.php?level=s';
} elseif ($level == 'a') {
    require_once('../include/adef.php');
    $back_url = 'forgetpw.php?level=a';
} else {
    header("Location: ../index.html");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $back_url = $back_url . '&errno=1';
    header("Location: $back_url");
} else {
    $dbc = connectdb();
    $email = mysqli_real_escape_string($dbc, $email);
    $query = "SELECT " . ATT_USERNAME . " From " . TABLE . " WHERE " . ATT_EMAIL . " = '" . $email . "';";
    $result = $dbc->query($query);
    if ($result->num_rows > 0) {
        if ($row = $result->fetch_assoc()) {
            $username = $row[ATT_USERNAME];
        }
        $dbc->close();
        $token = generatetoken();
        sendrecoveryemail($email, $username, $token, $level);
        updatetoken($email, $token, $level);

        $back_url = '../public/login.php?level=' . $level . '&errno=3';
        header("Location: $back_url");

    } else {
        $back_url = $back_url . '&errno=2';
        header("Location: $back_url");
    }

}

?>
