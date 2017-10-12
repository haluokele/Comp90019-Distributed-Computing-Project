<?php
/**
 * Created by PhpStorm.
 * User: wei
 * Date: 8/9/17
 * Time: 6:32 PM
 */
session_start();
require_once('../include/functions.php');
require_once('../include/header.php');
require_once('../include/advisornav.php');
atoindex();
parse_str(file_get_contents('php://input'), $post_value);
$id = $post_value['id'];
$name = $post_value['name'];
$year = $post_value['year'];
$semester = $post_value['semester'];
$des = $post_value['des'];
$conn =connectdb();
$sql = "UPDATE Topic SET Topic.Topic_Name = \"".$name."\",Topic.Open_Year = ".$year.",Topic.Open_Semester = ".$semester.", Topic.Topic_Introduction= \"". $des."\" WHERE Topic.Topic_ID = ".$id.";";
$conn->query($sql);
$conn->close();
header("Location: mytopics.php?message=1");
