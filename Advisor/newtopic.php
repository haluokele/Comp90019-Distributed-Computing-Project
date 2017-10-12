<?php
/**
 * Created by PhpStorm.
 * User: wei
 * Date: 8/15/17
 * Time: 12:16 PM
 */
session_start();
require_once('../include/functions.php');
atoindex();
require_once('../include/header.php');
require_once('../include/advisornav.php');

$user=$_SESSION['userid'];

$year=date("Y");
$year1=$year+1;
$year2=$year+2;
$year3=$year+3;
?>
<section class="userwrapper">
    <fieldset class="userfieldset">
        <legend>Edit Topics</legend>
        <div>


            <form method="POST" class="topiceditform" action='newtopicprocess.php'>
                <label for="name" class="topiclabel">Topic Name:</label>
                <input class="topicinput" name="name" placeholder="Topic Name" "><br/>
                <label for="year" class="topiclabel">Open Year:</label>
                <select class="topicinput" type="text" name="year">
                    <option value="2017">2017</option>
                    <option value = "2018">2018</option>
                    <option value="2019">2019</option>
                </select><br/>
                <label for="semester" class="topiclabel">Open Semester:</label>
                <select class="topicinput" type="text" name="semester">
                    <option value="1">1</option>
                    <option value="2">2</option></select><br/>
                <label for="des" class="topiclabel">Description:</label></br>
                <textarea rows="5"  cols="60"  name="des" placeholder="Short description of the topic."></textarea><br/>
                <button type='submit' class="bookbutton">Create</button>
                <button  type="button" class="bookbutton" onclick="window.location.href='mytopics.php'">Cancel</button>
            </form>
        </div>

    </fieldset>
</section>

<?php
require_once("../include/footer.php");
?>


