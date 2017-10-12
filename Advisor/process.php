<?php
/**
 * Created by PhpStorm.
 * User: wei
 * Date: 8/8/17
 * Time: 5:57 PM
 */
//echo "123";
//header("Location: myaptmts.php");
session_start();

require_once('../include/functions.php');
require_once('../include/header.php');
require_once('../include/advisornav.php');
atoindex();
parse_str(file_get_contents('php://input'), $post_value);
$date = $post_value['date'];
$time = $post_value['time'];
$aptid = $post_value['aptid'];
$conn =connectdb();
$sql1 = "SELECT Student.Student_Email, Student.Student_Username,Advisor.Advisor_Name,Advisor.Room_Num FROM Student INNER JOIN Advisor INNER JOIN Appointment WHERE Student.Student_ID = Appointment.Student_ID AND Advisor.Advisor_ID=Appointment.Advisor_ID AND Appointment.Appointment_ID =".$aptid.";";
$sql2 = "UPDATE Appointment SET Appointment.Aptmt_Date = \"".$date."\", Appointment.Aptmt_Time= \"".$time."\" WHERE Appointment.Appointment_ID =".$aptid.";";
$sql3 = "UPDATE Student SET Student.Aptmt = ".$aptid." WHERE Student.Student_ID == Appointment.Appointment_ID AND Appointment.Appointment_ID= ". $aptid.";";
$result = $conn->query($sql1);
$row = $result->fetch_assoc();
$student_email= $row["Student_Email"];
$student_username=$row["Student_Username"];
$advisor = $row["Advisor_Name"];
$address = $row["Room_Num"];
$conn ->query($sql2);
$conn->query($sql3);
echo $sql3;
$conn->close();
if ($_GET["type"]==1){
    rescheduleemail($student_email,$student_username,$advisor,$date,$time,$address);
    header("Location: myaptmts.php?message=1");
}elseif($_GET["type"]==2){
    scheduleemail($student_email,$student_username,$advisor,$date,$time,$address);
    header("Location: myaptmts.php?message=2");
}
else{
    atoindex();
}
?>



