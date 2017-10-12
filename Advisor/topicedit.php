<?php
/**
 * Created by PhpStorm.
 * User: wei
 * Date: 8/9/17
 * Time: 11:21 AM
 */

session_start();
require_once('../include/functions.php');
atoindex();
require_once('../include/header.php');
require_once('../include/advisornav.php');
$topic_id = $_GET["topic"];
$conn =connectdb();
$sql = "SELECT Topic.Topic_Name,Topic.Topic_Introduction,Topic.Open_Year,Topic.Open_Semester FROM Topic WHERE 
Topic.Topic_ID = ".$topic_id." AND Topic.Advisor_ID = ".$_SESSION["userid"].";";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$topic_name = $row["Topic_Name"];
$topic_description = $row["Topic_Introduction"];
$open_year = $row["Open_Year"];
$open_semester = $row["Open_Semester"];
$conn->close();

$year=date("Y");
$year1=$year+1;
$year2=$year+2;
$year3=$year+3;
?>
<section class="userwrapper">
    <fieldset class="userfieldset">
        <legend>Edit Topics</legend>
        <div>


        <form method="POST" class="topiceditform" action='updatetopic.php'>
            <input type="hidden" name="id" id="id" value="<?php echo $topic_id;?>">
            <label for="name" class="topiclabel">Topic Name:</label>
            <input class="topicinput" name="name" value="<?php echo $topic_name?>"><br/>
            <label for="year" class="topiclabel">Open Year:</label>
            <select class="topicinput" type="text" name="year">
                <option value="2017">2017</option>
            <option value = "2018">2018</option>
            <option value="2019">2019</option>
            </select><br/>
            <label for="semester" class="topiclabel">Open Semester:</label>
            <select class="topicinput" type="text" name="semester">

            <option value="1"   <?php
            if ( $open_semester=="1"){
                echo "selected";
            }
                ?> >1</option>
            <option value="2" <?php
            if ( $open_semester=="2"){
                echo "selected";
            }
            ?>>2</option></select><br/>
            <label for="des" class="topiclabel">Description:</label></br>
            <textarea rows="5"  cols="60"  name="des" ><?php echo $topic_description?></textarea><br/>
            <button type='submit' class="bookbutton">Change</button>
            <button  type="button" class="bookbutton" onclick="window.location.href='mytopics.php'">Cancel</button>
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
        </div>

    </fieldset>
</section>

<?php
require_once("../include/footer.php");
?>


