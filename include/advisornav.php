
<section class="usernav1">
    <a href='../index.html'><img class="loginnavlogo" src="../images/logo.png"
                                 alt="Home page"></a>

    <div class="userwelcome">

        <?php
        date_default_timezone_set("Australia/Melbourne");
        echo "Welcome " . $_SESSION['username'] . "";
        echo "<br/><br/>";
        echo date("H:i l d M Y");
        ?>
    </div>
</section>

<section id="usernav2">
    <a href="../Advisor/home.php" class="studentnav">        Home        </a>
<!--    <a href="../Advisor/requests.php" class="studentnav">  New Request  </a>-->
    <a href="../Advisor/myaptmts.php" class="studentnav">  My Appointments  </a>
    <a href="../Advisor/mytopics.php?page=1" class="studentnav">       My Topics       </a>
    <a href="../Advisor/mystudents.php?page=1" class="studentnav">       My Students       </a>
<!--    <a href="../Advisor/myaptmts.php" class="studentnav">  My Appointments  </a>-->
    <a href="../public/logout.php" class="logoutbutton"> Logout </a>
</section>