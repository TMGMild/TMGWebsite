<?php

require 'common.php';
$teamID = get('id', 1);
$teamName = getTeamNameFromTeamID($teamID);

$limit = 10;
$query = "SELECT * FROM updates WHERE `text` LIKE '%$teamName%' ORDER BY `time` DESC LIMIT $limit";
$rows = fetchAll($query);
?>

<DOCTYPE html>
<html>
    <head>
        <title><?php echo $teamName;?></title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">
                <h1><?php echo $teamName; ?></h1>
                <hr>
                <div class="left">
                    <h2>Roster</h2><hr>
                    <div class="left" style="text-align:right;line-height:275%;width:30%;">
                    <?php foreach(getRosterFromTeamID($teamID) as $position => $player):?>
                        <?php 
                        echo '<span class="label">' . str_replace("main", "Main ", str_replace("sub", "Sub ", $position)) . '</span>';
                        ?>
                        <br>
                    <?php endforeach; ?>
                    </div>
                    <div class="right" style="width:60%;float:left;">
                    <?php foreach(getRosterFromTeamID($teamID) as $position => $player):?>
                        <?php 
                        echo '<span class="value">' . $player . '</span>'; 
                        ?>
                        <br>
                    <?php endforeach; ?>
                    </div>
                </div>
                <div class="right">
                    <h2>Recent Updates</h2><hr>
                    <table>
                        <?php foreach ($rows as $row)
                        {?>
                            <tr>
                                <td><?php echo $row['text']; ?></td>
                                <td><?php echo timeToString($row['time']); ?></td>
                            </tr>
                        <?php 
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>