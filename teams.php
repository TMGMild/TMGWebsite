<?php 
require 'common.php';

$query = "SELECT `teamID`,`teamName`, `teamLogo` FROM rosters";
$teams = fetchAll($query);
?>

<DOCTYPE html>
<html>
    <head>
        <title>Teams - TMG</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">
                <h1>Teams</h1>
                <hr>
                <?php foreach ($teams as $team)
                { 
                    if ($team['teamLogo'] == "")
                    {
                        $team['teamLogo'] = getLetterIconUrl(getActualFirstLetter($team['teamName']));
                    }
                    if ($team['teamName'] != "--")
                    {?>
                    <div class="tile" style="min-height:180px;">
                        <a href="team.php?id=<?php echo $team['teamID'];?>">
                        <img src="<?php echo $team['teamLogo'];?>" style="width:80%;height:100px;max-width:90%;max-height:100px;"/>
                        <br>
                        <?php echo $team['teamName'];?></a>
                        <br>
                        <span><?php echo getRecordStr($team['teamID']);?></span>
                    </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </body>
</html>