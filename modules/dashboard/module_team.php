<?php     
$isCaptain = isCaptain();
if (isOnTeam())
{
    $teamID = teamID();
    if (isCaptain())
    {
    ?>

    <h2>Manage My Team</h2>
    <hr>
    <div id="teamUpdater" class="updaterGreen"></div>
    <table>
        <?php foreach(getRosterFromTeamID($teamID) as $position => $player) { if ($player == 0) { $player = ""; } else { $player = getUsernameFromId($player); } ?>
            <tr>
                <td><?php echo str_replace("main", "Main ", str_replace("sub", "Sub ", $position)); ?></td>
                <td>
                    <input type="textbox" oninput="updateRoster(<?php echo '\'' . $position . '\',this.value)';?>" id="<?php echo $position;?>" value="<?php echo $player; ?>"/>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php } else {?>
    <h2>My Team</h2>
    <hr>
    <table>
        <?php foreach(getRosterFromTeamID($teamID) as $position => $player) { if ($player == 0) { $player = ""; } else { $player = getUsernameFromId($player); } ?>
            <tr>
                <td><?php echo str_replace("main", "Main ", str_replace("sub", "Sub ", $position)); ?></td>
                <td><?php echo $player; ?>"
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php 
    } 
} 
else 
{
    ?>
    <h2>Teams</h2>
    <hr>
    <p>You're not currently on a team.</p>
    <?php 
} 
?>