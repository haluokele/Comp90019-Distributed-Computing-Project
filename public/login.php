<?php
/**
 * Created by PhpStorm.
 * User: wei
 * Date: 7/18/17
 * Time: 11:04 AM
 */
session_start();
require_once('../include/functions.php');
towelcome();
require_once('../include/info.php');

if ($_GET['level'] == 's') {
    $page_tittle = 'Student Login';
    $recovery_url = '../forgetpw/forgetpw.php?level=s';
} elseif ($_GET['level'] == 'a') {
    $page_tittle = 'Advisor Login';
    $recovery_url = '../forgetpw/forgetpw.php?level=a';
} else {
    header("Location: ../index.html");

}
require_once('../include/header.php');
?>
<section id="loginnav">
    <a href='../index.html'><img class="loginnavlogo" src="../images/logo.png"
                                 alt="Home page"></a>
    <div id="loginnavtext">
        <?php
        echo $page_tittle
        ?>
    </div>
</section>

<section class="loginwrapper">
    <fieldset class="loginfieldset">
        <legend>Advising Appointment</legend>
        <form method="POST" class="loginform" action='validate.php'>
            <br class="logintext">Login with your advising username and password</br></br>
            <label for="username">Username:</label><br/>
            <input class="logintextbox" type="text" name="username"><br/><br/>
            <label for="password">Password:</label><br/>
            <input class="logintextbox" type="password" name="password"/><br/><br/>
            <input type="hidden" name='level' value=<?php echo $_GET['level'] ?>>
            <button class="loginbutton" type='submit'>Login</button>
            <a href= <?php echo $recovery_url; ?> class="forget"> Forget Password?</a><br/>
            <?php
            if (!empty($_GET['errno'])) {
                $errno = $_GET['errno'];
                if ($errno == 1) {
                    echo "<font color = 'red' size = 3>Username and password couldn't be null. </font>";
                } elseif ($errno == 2) {
                    echo "<font color = 'red' size = 3>Username and Password is not matched. </font>";
                } elseif ($errno == 3) {
                    echo "<font color = 'red' size = 3>We have sent a reset password link to your email.</font>";
                }
            }
            ?>
        </form>
    </fieldset>
</section>
<?php
require_once('../include/footer.php');
?>



