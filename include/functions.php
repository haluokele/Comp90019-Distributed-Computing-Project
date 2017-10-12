<?php
/**
 * Created by PhpStorm.
 * User: wei
 * Date: 7/18/17
 * Time: 8:24 PM
 */
require_once('info.php');

function setsession($userid, $username, $level)
{
    session_start();
    $_SESSION['userid'] = $userid;
    $_SESSION['username'] = $username;
    $_SESSION['level'] = $level;
}

function atoindex()
{
    if ((!isset($_SESSION['userid'])) or ($_SESSION['level'] == 's')) {
        $home_url = '../index.html';
        header('Location: ' . $home_url);
        exit();
    }
}

function stoindex()
{
    if ((!isset($_SESSION['userid'])) or ($_SESSION['level'] == 'a')) {
        $home_url = '../index.html';
        header('Location: ' . $home_url);
        exit();
    }
}


function towelcome()
{
    if (isset($_SESSION['userid'])) {

        if (isset($_SESSION['level'])) {
            if ($_SESSION['level'] == 'a') {
                $home_url = '../Advisor/home.php';
            } else {
                $home_url = '../Student/home.php';
            }
        }
        header('Location: ' . $home_url);
    }

}

function connectdb()
{
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    return $dbc;
}

function generatetoken()
{
    $token = "abcdefghijklmnopqrstuvwxyz1234567890";
    $token = str_shuffle($token);
    $token = substr($token, 0, 15);
    return $token;
}

function sendrecoveryemail($email, $username, $token, $level)
{
  echo "asd";
    $headers = 'From: no-reply@appointment.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion() .
        'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $to = $email;
    $subject = 'Password Recovery';
    $url = RECOVER_ADDRESS . "?token=" . $token . "&level=" . $level . "&email=" . $email;
    $message = "Hi, " . $username . ",<br/><br/>We received a request to reset your Advising Appointment password.
        <br/><br/><a href=$url>Click here to change your password.</a>
        <br/><br/>If you didn't request a new password, please just ignore this email.
        <br/><br/><br/><br/>Sincerely,<br/><br/>Advising Appointment<br/>";

    mail($to, $subject, $message, $headers);

}

function resetpw($email, $new_password, $level)
{
    $dbc = connectdb();
    $email = mysqli_real_escape_string($dbc, $email);
    $new_password = mysqli_real_escape_string($dbc, $new_password);
    $token = generatetoken();
    $new_password =md5($new_password);
    if ($level == 'a') {
        $query1 = "UPDATE Advisor SET Advisor_Password = '$new_password' WHERE Advisor_Email ='$email'";
    } else {
        $query1 = "UPDATE Student SET Student_Password = '$new_password' WHERE Student_Email ='$email'";
    }
    $dbc->query($query1);
    $dbc->close();
}

function validatelink($email, $token, $level)
{
    $dbc = connectdb();
    $email = mysqli_real_escape_string($dbc, $email);
    $token = mysqli_real_escape_string($dbc, $token);
    if ($level == 'a') {
        $query = "SELECT Advisor_ID FROM Advisor WHERE Advisor_Email ='$email'
                AND Advisor_Token = '$token'";
    } else {
        $query = "SELECT Student_ID FROM Student WHERE Student_Email ='$email'
                AND Student_Token = '$token'";
    }

    $data = mysqli_query($dbc, $query);
    $dbc->close();
    if (mysqli_num_rows($data) > 0) {
        return true;
    } else {
        return false;
    }

}

function updatetoken($email, $token, $level)
{
    $dbc = connectdb();
    $email = mysqli_real_escape_string($dbc, $email);
    $token = mysqli_real_escape_string($dbc, $token);
    if ($level == 'a') {
        $query = "UPDATE Advisor SET Advisor_Token = '$token' WHERE Advisor_Email = '$email';";
    } else {
        $query = "UPDATE Student SET Student_Token = '$token' WHERE Student_Email = '$email';";
    }
    $dbc->query($query);
    $dbc->close();

}

function bookemail2s($semail,$susername,$aname,$tname){
    $headers = 'From: no-reply@appointment.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion() .
        'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $to = $semail;
    $subject = 'Appointment Booked';
    $message = "Hi, " . $susername . ",<br/><br/>You have booked an appointment with advisor ".$aname." for the project ".$tname.
        ",<br/><br/>Your advisor would schedule the appointment for you shortly.
        <br/><br/><br/><br/>Sincerely,<br/><br/>Advising Appointment<br/>";
    mail($to, $subject, $message, $headers);
}

function bookemail2a($aemail,$ausername,$sname,$tname){
    $headers = 'From: no-reply@appointment.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion() .
        'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $to = $aemail;
    $subject = 'Appointment Booked';
    $message = "Hi, " . $ausername . ",<br/><br/>Student ". $sname." booked an appointment with you for the project ".$tname.
        ",<br/><br/>Please arrange it.
        <br/><br/><br/><br/>Sincerely,<br/><br/>Advising Appointment<br/>";
    mail($to, $subject, $message, $headers);
}
function scheduleemail($email,$username,$advisor,$date,$time,$venue){
    $headers = 'From: no-reply@appointment.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion() .
        'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $to = $email;
    $subject = 'Appointment Scheduled';
    $message = "Hi, " . $username . ",<br/><br/>Your appointment with advisor ". $advisor." has been scheduled.<br/>The information of your appointment:
                <br/>     Date: ".$date."<br/>     Time: ".$time. "<br/>     Venue: ".$venue.
        "<br/><br/><br/><br/>Sincerely,<br/><br/>Advising Appointment<br/>";
    mail($to, $subject, $message, $headers);


}
function rescheduleemail($email,$username,$advisor,$date,$time,$venue){
    $headers = 'From: no-reply@appointment.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion() .
        'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $to = $email;
    $subject = 'Appointment Rescheduled';
    $message = "Hi, " . $username . ",<br/><br/>Your appointment with advisor ". $advisor." has been rescheduled.<br/>The updated information of your appointment:
                <br/>     Date: ".$date."<br/>     Time: ".$time. "<br/>     Venue: ".$venue.
        "<br/><br/><br/><br/>Sincerely,<br/><br/>Advising Appointment<br/>";
    mail($to, $subject, $message, $headers);

}
