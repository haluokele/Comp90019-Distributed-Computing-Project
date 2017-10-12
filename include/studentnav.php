
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
             <a href="../Student/home.php" class="studentnav">        Home        </a>
    <a href="../Student/topics.php?page=1" class="studentnav">       Topics       </a>
          <a href="../Student/myaptmt.php" class="studentnav">  My Appointment  </a>
    <a href="../public/logout.php" class="logoutbutton"> Logout </a>
</section>