<?php

require 'common.php';

if (!empty($_POST))
{
    $ign = $_POST['ign'];
    $position = $_POST['position'];
    $experience = $_POST['experience'];
    $why = $_POST['why'];
    $date = date("Y-m-d");

    $query = "
    INSERT INTO staffApplications (`ign`, `position`, `experience`, `why`, `date`) 
    VALUES ('$ign', '$position', '$experience', '$why', '$date');
    ";
    execute($query);

    $complete = 1;
}
else
{
    $complete = 0;
}

?>

<DOCTYPE html>
<html>
    <head>
        <title>Apply - TMG</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">
                <?php
                if ($complete == 0) {
                ?>
                    <h2>Work With Us</h2>
                    <hr>
                    <form action="apply.php" class="center" method="post">
                        <?php
                        if (loggedIn())
                        {?>
                            <input type="hidden" name="ign" value="<?php echo username();?>">
                            <span style="font-size:20px;">Summoner name: <?php echo username();?></span>
                        <?php
                        } else { ?>
                            <input type="text" name="ign" class="big" placeholder="Summoner name">
                        <?php 
                        } ?>
                        <br><br>
                        <input type="text" class="big" name="position" placeholder="Desired position">
                        <p class="small">This can be any position that is not currently filled. The forum lists positions we are currently in need of.</p>
                        <br><br>
                        <textarea style="width:500px;" rows="6" name="experience">Prior experience</textarea>
                        <p class="small">List all experience that relates in any way to your desired position.</p>
                        <br><br>
                        <textarea style="width:500px;" rows="6" name="why">Why I'd be a good fit</textarea>
                        <p class="small">Tell us why we should choose you over other candidates. What makes you different?</p>
                        <br><br>
                        <input type="submit" class="big" value="Submit">
                    </form>
                <?php
                } else {
                ?>
                    <h2 style="font-size:60px;">Thanks.</h2>
                    <br>
                    <div style="width:100%;text-align:center;">
                        <p style="margin:auto;font-size:22px;width:600px;">Thanks for applying. We'll get back to you as soon as possible. We look forward to working with you. <a href="index.php">Return home</a>.</p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </body>
</html>