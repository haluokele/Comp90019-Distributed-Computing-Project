<?php
/**
 * Created by PhpStorm.
 * User: wei
 * Date: 7/17/17
 * Time: 6:04 PM
 */

session_start();
require_once('../include/functions.php');
atoindex();
$page_tittle = 'Home';
require_once('../include/header.php');
require_once('../include/advisornav.php')
?>

<section class="userwrapper">

    <fieldset class="userfieldset">
        <legend>Important information</legend>
        <?php

        $myfile = fopen('../public/info.txt', "r") or die("Unable to open file!");
        // Output one line until end-of-file
        while (!feof($myfile)) {
            echo fgets($myfile) . "<br>";
        }
        fclose($myfile);
        ?>
    </fieldset>


</section>

<?php
require_once('../include/footer.php');
?>
