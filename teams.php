<?php 
require 'common.php';

$query = "SELECT `teamID`,`teamName` FROM rosters";
$rows = fetchAll($query);
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
                <table style="font-size:26px;font-weight:100;">
                    <?php foreach ($rows as $row)
                    { 
                        if ($row['teamName'] != "--")
                        {?>
                        <tr>
                            <td><a href="team.php?id=<?php echo $row['teamID'];?>"><?php echo $row['teamName'];?></a></td>
                        </tr>
                    <?php
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>