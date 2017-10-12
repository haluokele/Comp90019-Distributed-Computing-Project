<?php
/**
 * Created by PhpStorm.
 * User: wei
 * Date: 8/15/17
 * Time: 12:20 PM
 */
session_start();
require_once('../include/functions.php');
atoindex();
parse_str(file_get_contents('php://input'), $post_value);
$user = $_SESSION['userid'];
$name= $post_value['name'];
$year = $post_value['year'];
$semester = $post_value['semester'];
$des = $post_value['des'];

echo $user;
echo "+++";
echo $name;
echo "+++";
echo $year;
echo "+++";
echo $semester;
echo "+++";
echo $des;
$conn =connectdb();

$sql = "INSERT INTO Topic( Advisor_ID, Topic_Name, Topic_Introduction, Open_Year, Open_Semester, Topic_Availability) VALUES
( '".$user."','".$name."', '".$des."', ".$year.", ".$semester.", 'Y');";
//echo $sql;
$conn->query($sql);
header("Location: mytopics.php?message=2");

?>
