<?php
/**
 * Created by PhpStorm.
 * User: wei
 * Date: 8/4/17
 * Time: 3:14 PM
 */
session_start();
require_once('../include/functions.php');
atoindex();
$page_tittle = 'Home';
require_once('../include/header.php');
require_once('../include/advisornav.php');
$today = date("Y-m-d");
?>
    <div id="popupwindow1" name = "popupwindow1" class="popupwindow">
        <div class="popuphead">
            <div class="popupheadword" >
                    Appointment Reschedule
            </div>
        </div>
        <div class="popupbody">
            <div class="popupbodyform">
                <form method="POST"  name="form" action="process.php?type=1">
                    <label for="Date">Date:</label>
                    <input class="popupinput"  name="date"  type=date min="<?php echo $today?>" value ="<?php echo $today?>"></br></br>
                    <label for="Time">Time:</label>
                    <input class="popupinput" name="time"  type=time></br></br>
                    <input type="hidden" id="aptid1" value="" name ="aptid">
                    <button  type="submit" onclick="assign1();" class="popupbutton">Reschedule</button>
                    <button type="button" onclick="document.getElementById('popupwindow1').style.display='none'" class="popupbutton">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <div id="popupwindow2" name = "popupwindow2" class="popupwindow">
        <div class="popuphead">
            <div class="popupheadword" >
                Appointment Schedule
            </div>
        </div>
        <div class="popupbody">
            <div class="popupbodyform">
                <form method="POST"  name="form" action="process.php?type=2">
                    <label for="Date">Date:</label>
                    <input class="popupinput"  name="date"  type=date min="<?php echo $today?>" value ="<?php echo $today?>"></br></br>
                    <label for="Time">Time:</label>
                    <input class="popupinput" name="time"  type=time></br></br>
                    <input type="hidden" id="aptid2" value="" name ="aptid">
                    <button  type="submit" onclick="assign2();" class="popupbutton">Schedule</button>
                    <button type="button" onclick="document.getElementById('popupwindow2').style.display='none'" class="popupbutton">Cancel</button>
                </form>
            </div>
        </div>
    </div>
    <div class="userwrapper">
        <fieldset class="userfieldset">
            <legend>My Appointments</legend>
                <?php
                    if ($_GET["message"]==1){
                        echo "You have successfully rescheduled one appointment!";
                    }elseif ($_GET["message"] ==2){
                        echo "You have successfully scheduled one appointment!";
                    }
                ?>
                <table class="topictable" border="1" cellpadding="1">
                <thead>
                <tr class="tableheader">
                    <td>Date</td>
                    <td>Time</td>
                    <td>Topic</td>
                    <td>Student Name</td>
                    <td>Student Email</td>
                    <td>Operation</td>
                </tr>
                </thead>
                <tbody>
                <?php
                if (isset($_GET["page"])) {
                    $page = $_GET["page"];
                } else {
                    $page = 1;
                };
                $start_from = ($page - 1) * 5;
                $conn = connectdb();
                $sql1 = "SELECT Appointment.Aptmt_Date, Appointment.Aptmt_Time FROM Appointment INNER JOIN Topic INNER JOIN Advisor INNER JOIN Student WHERE Appointment.Student_ID = Student.Student_ID AND Student.Advisor_ID = Advisor.Advisor_ID AND Student.Topic_ID = Topic.Topic_ID AND Appointment.Advisor_ID = ".$_SESSION['userid'].";";
                $sql2 = "SELECT Appointment.Appointment_ID,Appointment.Aptmt_Date, Appointment.Aptmt_Time, Topic.Topic_Name,Student.Student_Name, Student.Student_Email 
                        FROM Appointment INNER JOIN Topic INNER JOIN Student INNER JOIN Advisor
                        WHERE Appointment.Student_ID = Student.Student_ID AND Topic.Advisor_ID = Advisor.Advisor_ID AND Student.Topic_ID = Topic.Topic_ID AND Appointment.Advisor_ID = ".$_SESSION['userid']." ORDER BY Appointment.Aptmt_Date ASC,Appointment.Aptmt_Time ASC LIMIT $start_from,5;";
                $result1 = $conn->query($sql1);
                $result2 = $conn->query($sql2);
                $total_cnt = $result1->num_rows;
                if ($total_cnt ==0){
                    $page_cnt =1;
                }
                else{
                    $page_cnt = ceil($total_cnt / 8);
                }
                if ($page == 1) {
                    if ($page_cnt == 1) {
                        $nextpage = $page;
                        $lastpage = $page;
                    } else {
                        $nextpage = $page + 1;
                        $lastpage = $page;
                    }
                } elseif ($page == $page_cnt) {
                    $nextpage = $page;
                    $lastpage = $page - 1;
                } else {
                    $nextpage = $page + 1;
                    $lastpage = $page - 1;
                }
                while ($row = $result2->fetch_assoc()) {
                    $herf = "confirm.php?topic=".$row["ID"];
                    if ( isset($row['Aptmt_Date'])) {
                        ?>
                        <tr class="tablebody">
                            <td><?php echo $row["Aptmt_Date"]; ?></td>
                            <td><?php echo $row["Aptmt_Time"]; ?></td>
                            <td><?php echo $row["Topic_Name"]; ?></td>
                            <td><?php echo $row["Student_Name"]; ?></td>
                            <td><?php echo $row["Student_Email"]; ?></td>
                            <td>
                                <button class="bookbutton" onclick="set(<?php echo $row["Appointment_ID"]; ?>);show1();"> Reschedule
                                </button>
                            </td>
                        </tr>
                        <?php
                    }else{
                        ?>
                    <tr class="tablebody">
                    <td></td>
                    <td></td>
                    <td><?php echo $row["Topic_Name"];      ?></td>
                    <td><?php echo $row["Student_Name"];         ?></td>
                    <td><?php echo $row["Student_Email"];         ?></td>
                    <td><button class="bookbutton" onclick="set(<?php echo $row["Appointment_ID"];?>);show2();">Schedule</button></td>
                    </tr>
                    <?php
                }
                }
                $conn->close();
                ?>
                </tbody>
            </table>
            <div id='currentpage'>
                Page: <?php echo $page ?> of <?php echo $page_cnt ?>
            </div>
            <div id='nextpage'>
                <a href="mytopics.php?page=<?php echo $lastpage ?>" <?php
                if ($lastpage == $page) {
                    echo "hidden";
                }
                ?>>Last Page</a>
                <a href="mytopics.php?page=<?php echo $nextpage ?>" <?php
                if ($nextpage == $page) {
                    echo "hidden";
                }
                ?>>Next Page</a>
            </div>
        </fieldset>
    </div>
<?php
require_once('../include/footer.php');
?>