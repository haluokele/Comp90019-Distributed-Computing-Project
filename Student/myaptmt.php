<?php
/**
 * Created by PhpStorm.
 * User: wei
 * Date: 7/26/17
 * Time: 7:46 PM
 */
session_start();
require_once('../include/functions.php');
stoindex();
$page_tittle = 'My Appointment';
require_once('../include/header.php');
require_once('../include/studentnav.php')
?>

<section class="userwrapper">
    <fieldset class="userfieldset">
        <legend>My Appointment</legend>
        <?php
        $conn = connectdb();
        $sql1 = "SELECT Student_Username,Aptmt,Student.Topic_ID,Aptmt FROM Student INNER JOIN Topic INNER JOIN Advisor WHERE Student_ID = " . $_SESSION["userid"] . " AND Student.Topic_ID =Topic.Topic_ID AND Topic.Advisor_ID = Advisor.Advisor_ID;" ;
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch_assoc();
        if (isset($row1['Aptmt'])) {
            $aptid=$row1['Aptmt'];
            $sql2 = "SELECT Topic.Topic_Name, Advisor.Advisor_Name,
                    Advisor.Room_Num, Appointment.Aptmt_Date, Appointment.Aptmt_Time, Appointment.Aptmt_Date,Appointment.Aptmt_Time
                    FROM Appointment INNER JOIN Advisor INNER JOIN Student INNER JOIN Topic WHERE
                    Student.Topic_ID =Topic.Topic_ID AND
                    Appointment.Student_ID = Student.Student_ID AND
                    Appointment.Advisor_ID = Advisor.Advisor_ID AND
                    Student.Student_ID = " . $_SESSION['userid'] . ";";

//            echo $sql2;

            $result2=$conn->query($sql2);
            $row2 = $result2->fetch_assoc();

            if (isset($row2['Aptmt_Date'])){
                $myaptmt = 'Hello ' . $_SESSION['username'] . ', you have following appointment with advisor ' .
                    $row2['Advisor_Name'] . ',<br /><br />Topic: ' . $row2['Topic_Name'] . ',<br />Date:  ' . $row2['Aptmt_Date'] . ',<br />Time: ' . $row2['Aptmt_Time'] .
                    ',<br />Venue: ' . $row2['Room_Num'];
            }else{
                $myaptmt = 'Hello ' . $_SESSION['username'] . ', <br /><br />You booked appointment with advisor ' . $row2['Advisor_Name'] . ' for the project: ' . $row2['Topic_Name'] . '.<br /><br />Please notice, the appointment is not confirmed yet. ';
            }
            } else {
                $myaptmt = 'Hello ' . $_SESSION['username'] . ', you didn\'t book any appointment yet.';

//                $sql3 = "SELECT Student.Student_Username,Advisor.Advisor_Name,Topic.Topic_Name FROM Student INNER JOIN Advisor INNER JOIN Topic WHERE Student.Topic_ID = Topic.Topic_ID AND Topic.Advisor_ID = Advisor.Advisor_ID AND Student.Student_ID = " . $_SESSION['userid'] . ";";
//                $result2 = $conn->query($sql3);
//                $row2 = $result2->fetch_assoc();
//                $myaptmt = 'Hello ' . $_SESSION['username'] . ',You booked appointment with advisor ' . $row2['Advisor_Name'] . ' for topic: ' . $row2['Topic_Name'] . ',<br />Please notice this appointment is not confirmed. ';
            }
            echo $myaptmt;


//        } else {
//            echo 'Hello ' . $_SESSION['username'] . ',You didn\'t book any appointment.';
//        }
        $conn->close();
        ?>
    </fieldset>
</section>

<?php
require_once('../include/footer.php');
?>
