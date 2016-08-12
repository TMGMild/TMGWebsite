<?php

require 'common.php';
$applications = fetchAll("SELECT * FROM staffApplications");

?>
<DOCTYPE html>
<html>
    <head>
        <title>Staff Applications</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">
                <h2>Staff Applications</h2>
                <hr>
                <table>
                    <tr>
                        <td>IGN</td>
                        <td>Position</td>
                        <td>Date</td>
                        <td>Options</td>
                    </tr>
                    <?php
                    foreach ($applications as $app)
                    { ?>
                        <tr style="font-size:19px;">
                            <a href="application.php?id=<?php echo $app['id'];?>">
                                <td><?php echo $app['ign'];?></td>
                                <td><?php echo $app['position'];?></td>
                                <td><?php echo $app['date'];?></td>
                                <td><a href="application.php?id=<?php echo $app['id'];?>">View</a></td>
                            </a>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>