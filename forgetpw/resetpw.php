<?php
/**
 * Created by PhpStorm.
 * User: wei
 * Date: 7/18/17
 * Time: 10:41 PM
 */
require_once('../include/functions.php');
$email = $_GET['email'];
$token = $_GET['token'];
$level = $_GET['level'];
$page_tittle = 'Password Recovery';
require_once('../include/header.php');

if ($level == 's') {
    require_once('../include/sdef.php');
    $login_url = '../public/login.php?level=s&errno=3';
    $reset_url = 'resetpwprocess.php?level=s';
} else if ($level == 'a') {
    require_once('../include/adef.php');
    $login_usr = '../public/login.php?level=a$error=3';
    $reset_url = 'resetpwprocess.php?level=a';
} else {
//    header("Location: ../index.html");
}
?>
<section id="loginnav">
    <a href="../index.html"><img class="loginnavlogo" src="../images/logo.png"
                                 alt="University of Melbourne"></a>
    <div id="loginnavtext">
        <?php
        echo $page_tittle
        ?>
    </div>
</section>

<section class="loginwrapper">
    <fieldset class="loginfieldset">

        <legend>Password Recovery</legend>
        <form method="POST" class="loginform" action='resetpwprocess.php'>
            <br class="logintext">Please input your new password below:</br></br>

            <input class="logintextbox" type="text" name="password"><br/><br/>
            <input type="hidden" name='level' value=<?php echo $level ?>>
            <input type="hidden" name='email' value=<?php echo $email ?>>
            <input type="hidden" name='token' value=<?php echo $token ?>>
            <button class="sendbutton" type='submit'>Reset</button>
            <br/>
        </form>
    </fieldset>
</section>
<?php
require_once('../include/footer.php');
?>
