<?php
/**
 * Created by PhpStorm.
 * User: wei
 * Date: 8/4/17
 * Time: 3:13 PM
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
            <legend>My Topics</legend>
            <div class="newtopic">
                <button class="bookbutton" onclick="location.href='newtopic.php';">New Topic</button>
            </div>

            <?php
            if ($_GET["message"]=="1"){
                echo "You have successfully updated one topic";
            }
            elseif($_GET["message"]=="2"){
                echo "You have successfully created one topic";
            }
            ?>
            <table class="topictable" border="1" cellpadding="1">
                <thead>
                <tr class="tableheader">
                    <td>Topic Name</td>
                    <td>Topic Description</td>
                    <td>Open Year</td>
                    <td>Open Semester</td>
                    <td>Booked</td>
                    <td>Edit</td>
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
                $sql1 = "SELECT Topic.Topic_ID AS ID, Topic.Topic_Name AS NAME, Topic.Topic_Introduction AS INTRO, Topic.Open_Year AS YEAR, Topic.Open_Semester AS SEMESTER, Topic.Topic_Availability AS AV FROM Topic WHERE Topic.Advisor_ID = ".$_SESSION['userid'].";";
                $sql2 = "SELECT Topic.Topic_ID AS ID, Topic.Topic_Name AS NAME, Topic.Topic_Introduction AS INTRO, Topic.Open_Year AS YEAR, Topic.Open_Semester AS SEMESTER, Topic.Topic_Availability AS AV FROM Topic WHERE Topic.Advisor_ID = ".$_SESSION['userid'].
" ORDER BY Topic.Open_Year ASC, Topic.Open_Semester ASC LIMIT $start_from,5;";
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

                while ($row = $result2->fetch_assoc()) {
                    $herf = "topicedit.php?topic=".$row["ID"];
                    ?>

                    <tr class="tablebody">
                        <td><?php echo $row["NAME"];         ?></td>
                        <td><?php echo $row["INTRO"]; ?></td>
                        <td><?php echo $row["YEAR"];      ?></td>
                        <td><?php echo $row["SEMESTER"];         ?></td>
                        <td><?php
                            if ($row["AV"]=="N"){
                                echo "Yes";
                            }else{
                                echo "No";
                            };     ?></td>
                        <td><button class="bookbutton" onclick="location.href='<?php echo $herf?>';"> Edit</button></td>
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
                <a href="mytopics.php?page=<?php echo $lastpage ?>" <?php
                if ($lastpage == $page) {
                    echo "hidden";
                }
                ?>>Last Page</a>
                <a href="mytopics.php?page=<?php echo $nextpage ?>" <?php
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