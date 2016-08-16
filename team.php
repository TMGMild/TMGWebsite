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
                <div class="layout two">
                    <h2>Roster</h2><hr>
                    <table>
                    <?php 
                    foreach(getRosterFromTeamID($teamID) as $position => $player) 
                    {
                        echo 
                        '<tr>
                            <td style="text-align:right;width:30%;font-size:20px;font-weight:100;">' . getPositionLabelFromName($position) . '</td>
                            <td style="font-size:26px;font-weight:100;"><a href="profile.php?id=' . $player . '">' . getUsernameFromId($player) . '</a></td>
                        </tr>';
                    } 
                    ?>
                    </table>
                </div>
                <div class="layout two">
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