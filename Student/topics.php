<?php
/**
 * Created by PhpStorm.
 * User: wei
 * Date: 7/26/17
 * Time: 7:45 PM
 */
session_start();
require_once('../include/functions.php');
stoindex();
$page_tittle = 'Topics';
require_once('../include/header.php');
require_once('../include/studentnav.php');
parse_str(file_get_contents('php://input'), $post_value);
if (isset($post_value['search'])){
    $keywords = $post_value['search'];
}
?>

<section class="userwrapper">
    <fieldset class="userfieldset" action = "topics.php">
        <legend>Topic List</legend>
        <form method="POST" class = "search" action="topics.php">
            <input class="searchtext" name="search" type="text" placeholder="separated keywords by a space">
            <button for="password" type='submit' class = "bookbutton">Search</button><br/>
            <?php
            if ((!is_null($keywords))&&(strlen($keywords)<3)){
              echo "The keyword have to be more than 2 characters";
            }

             ?>

        </form>
        <table class="topictable" border="1" cellpadding="1">
            <thead>
            <tr class="tableheader">
                <td>Topic Name</td>
                <td>Topic Describtion</td>
                <td>Advisor Name</td>
                <td>Open Year</td>
                <td>Open Semester</td>
                <td>123</td>
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

            if (   (!is_null($keywords))&&((strlen($keywords)>2))){
                $sql1="SELECT Topic.Topic_Name AS Name
                    FROM `Topic`INNER JOIN Advisor WHERE Advisor.Advisor_ID = Topic.Advisor_ID
                    AND Topic.Topic_Availability =\"Y\" AND MATCH(Topic.Topic_Introduction,Topic.Topic_Name) AGAINST(\"".$keywords."\" IN NATURAL LANGUAGE MODE)";
                $sql2="SELECT Topic.Topic_Name AS Name,Topic.Topic_ID AS ID, Topic.Topic_Introduction AS Introduction,
                    Advisor.Advisor_Name As Advisor,Topic.Open_Year AS Year, Topic.Open_Semester as Semester
                    FROM `Topic`INNER JOIN Advisor WHERE Advisor.Advisor_ID = Topic.Advisor_ID
                    AND Topic.Topic_Availability =\"Y\" AND MATCH(Topic.Topic_Introduction,Topic.Topic_Name) AGAINST(\"".$keywords." \"IN NATURAL LANGUAGE MODE)LIMIT $start_from,5;";
            }else{
                $sql1 = "SELECT Topic.Topic_Name AS Name
                    FROM `Topic` INNER JOIN Advisor WHERE Advisor.Advisor_ID = Topic.Advisor_ID
                    AND Topic.Topic_Availability =\"Y\";";
                $sql2 = "SELECT Topic.Topic_Name AS Name,Topic.Topic_ID AS ID, Topic.Topic_Introduction AS Introduction,
                    Advisor.Advisor_Name As Advisor,Topic.Open_Year AS Year, Topic.Open_Semester as Semester
                    FROM `Topic` INNER JOIN Advisor WHERE Advisor.Advisor_ID = Topic.Advisor_ID
                    AND Topic.Topic_Availability =\"Y\" ORDER BY Topic.Open_Year ASC, Topic.Open_Semester ASC LIMIT $start_from,5;";
            }
            $result1 = $conn->query($sql1);
            $result2 = $conn->query($sql2);


            $total_cnt = $result1->num_rows;


            if ($total_cnt ==0){
                $page_cnt =1;
            }
            else{
                $page_cnt = ceil($total_cnt / 5);
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
            if ($_GET["message"]==1){
                echo "Congratulation！ You have successfully booked appointment for topic: ".$_GET["topic"];
            }elseif($_GET["message"]==2){
                echo "You are not allowed to book two appointments.";
            }
            while ($row = $result2->fetch_assoc()) {
                $herf = "confirm.php?topic=".$row["ID"];
                ?>
                <tr class="tablebody">
                    <td><?php echo $row["Name"];         ?></td>
                    <td><?php echo $row["Introduction"]; ?></td>
                    <td><?php echo $row["Advisor"];      ?></td>
                    <td><?php echo $row["Year"];         ?></td>
                    <td><?php echo $row["Semester"];     ?></td>
                    <td><button class = "bookbutton" onclick="location.href='<?php echo $herf?>';"> Book</button></td>
                </tr>
                <?php
            }
            $conn->close();
            ?>
            </tbody>

        </table>
        <div id='currentpage'>
            Page: <?php echo $page ?> of <?php echo $page_cnt ?>
        </div>
        <div id='nextpage'>
            <a href="topics.php?page=<?php echo $lastpage ?>" <?php
            if ($lastpage == $page) {
                echo "hidden";
            }
            ?>>Last Page</a>

            <a href="topics.php?page=<?php echo $nextpage ?>" <?php
            if ($nextpage == $page) {
                echo "hidden";
            }
            ?>

            >Next Page</a>
        </div>
    </fieldset>
</section>

<?php
require_once('../include/footer.php');
?>
