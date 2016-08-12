<?php

require 'common.php';

$query = "SELECT * FROM standings ORDER BY `w` DESC, `l`, `teamID`";
$rows  = fetchAll($query);

?>

<DOCTYPE html>
<html>
    <head>
        <title>Standings</title>
        <?php include 'head.php'; ?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div claSS="wrapper">
            <div class="content">
                <h1>Standings</h1>
                <hr>
                <table style="font-size:30px;font-weight:100;">
                    <tr style="font-size:20px;">
                        <td>Team</td>
                        <td>Wins</td>
                        <td>Losses</td>
                    </tr>
                    <?php 
                    $i = 1;
                    foreach($rows as $row):
                    ?>
                        <tr>
                            <td><?php echo '<span class="eighteen">' . $i . '</span> <a href="team.php?id=' . $row['teamID'] . '">' . getTeamNameFromTeamID($row['teamID']);?></a></td>
                            <td><?php echo $row['w']; ?></td>
                            <td><?php echo $row['l']; ?></td>
                        </tr>
                    <?php
                    $i++;
                    endforeach;
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>