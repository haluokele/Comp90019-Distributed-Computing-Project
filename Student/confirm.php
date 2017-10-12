<?php
/**
 * Created by PhpStorm.
 * User: wei
 * Date: 8/2/17
 * Time: 7:39 PM
 */
session_start();
require_once('../include/functions.php');
stoindex();
$topic_id=$_GET["topic"];
$conn=connectdb();
$sql = "SELECT Topic_ID FROM `Student` WHERE Student_ID = ".$_SESSION["userid"].";";
$result1 = $conn->query($sql);
$row=$result1->fetch_assoc();

if (!isset($row["Topic_ID"])){
    //update student's topic and topic's avaliability
    $sql1 ="UPDATE Student SET Topic_ID = ".$topic_id." WHERE Student_ID =".$_SESSION["userid"].";";
    $sql2 ="UPDATE Topic SET Topic_Availability = \"N\" WHERE Topic_ID = ".$topic_id.";";
    $conn ->query($sql1);
    $conn ->query($sql2);

//get advisor id
    $sql3 = "Select Topic.Advisor_ID from Topic WHERE Topic.Topic_ID= ".$topic_id.";";
    $result3 = $conn->query($sql3);
    $row3=$result3->fetch_assoc();
    $advisor_id = $row3["Advisor_ID"];


//create new appointment
    $sql4 = "INSERT INTO Appointment( Advisor_ID, Student_ID) VALUES
('".$advisor_id."','".$_SESSION["userid"]."');";
    echo $sql4;
    $conn->query($sql4);

//get appointment id
    $sql5 = "SELECT Appointment.Appointment_ID from Appointment where Appointment.Student_ID = ".$_SESSION["userid"].";";
    $result5 = $conn->query($sql5);
    $row5=$result5->fetch_assoc();
    $aptid = $row5["Appointment_ID"];

    echo $aptid;


    //update student's aptmt
    $sql6 = "UPDATE Student SET Student.Aptmt = ".$aptid." WHERE Student.Student_ID = ".$_SESSION['userid'].";";
    $conn->query($sql6);


// get more information to send email
    $sql7 = "SELECT Student.Student_Email AS semail,Student.Student_Username AS susername, Student.Student_Name AS sname,
Topic.Topic_Name AS tname, Advisor.Advisor_Name AS aname, Advisor.Advisor_Email AS aemail,Advisor.Advisor_Username AS ausername
FROM Student INNER JOIN Advisor INNER JOIN Topic WHERE Advisor.Advisor_ID = Topic.Advisor_ID AND Topic.Topic_ID = ".$topic_id." AND Student.Student_ID = ".$_SESSION["userid"].";";

    $result7 = $conn->query($sql7);
    $row7=$result7->fetch_assoc();
    $semail = $row7["semail"];
    $susername = $row7["susername"];
    $sname = $row7["sname"];
    $tname = $row7["tname"];
    $aname = $row7["aname"];
    $aemail = $row7["aemail"];
    $ausername = $row7["ausername"];
    bookemail2s($semail,$susername,$aname,$tname);
    bookemail2a($aemail,$ausername,$sname,$tname);


    $url = "topics.php?message=1&topic=".$tname;
    $conn->close();
}else{
    $url = "topics.php?message=2";
}
header("Location: ".$url);
?>