<?php
/**
 * Created by PhpStorm.
 * User: wei
 * Date: 7/18/17
 * Time: 8:36 PM
 */
session_start();
require_once('../include/functions.php');
towelcome();
$page_tittle = 'Password Recovery';
require_once('../include/header.php');
if ($_GET['level'] == 's') {
    $sendemail_usr = 'validatemail.php?level=s';
} else if ($_GET['level'] == 'a') {
    $sendemail_usr = 'validatemail.php?level=a';
} else {
    header("Location: ../index.html");
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
        <form method="POST" class="loginform" action=validatemail.php>
            <br class="logintext">Reset your password with your email</br></br>
            <label for="email">Email:</label><br/>

            <input class="logintextbox" type="text" name="email"><br/><br/>
            <button class="sendbutton" type='submit'>Send</button>
            <br/>
            <input type="hidden" name='level' value=<?php echo $_GET['level'] ?>>
            <?php
            if (!empty($_GET['errno'])) {
                $errno = $_GET['errno'];
                if ($errno == 1) {
                    echo "<font color = 'red' size = 3>Please check the email and try again.</font>";
                } elseif ($errno == 2) {
                    echo "<font color = 'red' size = 3>Acount doesn't exist!  </font>";
                }
            }
            ?>
        </form>
    </fieldset>
</section>
<?php
require_once('../include/footer.php');
?>
