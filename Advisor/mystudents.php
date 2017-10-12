<?php
/**
 * Created by PhpStorm.
 * User: wei
 * Date: 8/4/17
 * Time: 3:16 PM
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
            <legend>My Students</legend>
            <table class="topictable" border="1" cellpadding="1">
                <thead>
                <tr class="tableheader">
                    <td>Student ID</td>
                    <td>Student Name</td>
                    <td>Student Email</td>
                    <td>Student Topic</td>
                </tr>
                </thead>
                <tbody>
                <?php
                if (isset($_GET["page"])) {
                    $page = $_GET["page"];
                } else {
                    $page = 1;
                };
                $start_from = ($page - 1) * 8;
                $conn = connectdb();

                $sql1 = "SELECT Student.Student_ID, Student.Student_Name,Student.Student_Email,Topic.Topic_Name FROM Student INNER JOIN Topic WHERE Student.Topic_ID = Topic.Topic_ID AND Topic.Advisor_ID = ".$_SESSION['userid'].";";
                $sql2 = "SELECT Student.Student_ID, Student.Student_Name,Student.Student_Email,Topic.Topic_Name FROM Student INNER JOIN Topic WHERE Student.Topic_ID = Topic.Topic_ID AND Topic.Advisor_ID = ".$_SESSION['userid']." LIMIT $start_from,5;";




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
                    ?>
                    <tr class="tablebody">
                        <td><?php echo $row["Student_ID"];         ?></td>
                        <td><?php echo $row["Student_Name"]; ?></td>
                        <td><?php echo $row["Student_Email"]; ?></td>
                        <td><?php echo $row["Topic_Name"]; ?></td>
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