<?php

require 'common.php';
$id = get('id', 1);

$query = "SELECT * FROM staffApplications WHERE id=$id";
$app = fetchRow($query);

?>
<DOCTYPE html>
<html>
    <head>
        <title>View Application</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">
                
                <a href="applications.php">Back to applications</a><br>
                
                <p class="small">Player summoner name</p>
                <p class="big"><?php echo $app['ign'];?></p>
                <br>
                <p class="small">Desired position</p>
                <p class="big"><?php echo $app['position'];?></p>
                <br>
                <p class="small">Past experience</p>
                <p class="big"><?php echo $app['experience'];?></p>
                <br>
                <p class="small">Why you should choose this player</p>
                <p class="big"><?php echo $app['why'];?></p>
                
            </div>
        </div>
    </body>
</html>