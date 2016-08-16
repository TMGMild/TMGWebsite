<?php
if (isOnTeam())
{
    $teamID = teamID();
    if (isCaptain())
    {
        $query = "SELECT teamLogo FROM rosters WHERE teamID = $teamID";
        $teamLogo = fetchColumn($query);
        ?>

    <h2>Manage My Team</h2>
    <hr>
    <div class="updater green" id="teamUpdater"></div>
    <table>
        <tr>
            <td>Team Logo URL</td>
            <td><input type="text" value="<?php echo $teamLogo;?>" oninput="changeTeamLogo(<?php echo $teamID;?>, this.value)" placeholder="http://www.imgur.com/myLogo"/>&nbsp;&nbsp;<i>(100 x 100px)</i></td>
        </tr>
        <?php 
        foreach(getRosterFromTeamID($teamID) as $position => $player) 
        {
            if ($player == 0) { $player = ""; } 
            else { $player = getUsernameFromId($player); } 
            ?>
            <tr>
                <td><?php echo str_replace("main", "Main ", str_replace("sub", "Sub ", $position)); ?></td>
                <td>
                    <input type="textbox" oninput="updateRoster(<?php echo '\'' . $position . '\',this.value)';?>" id="<?php echo $position;?>" value="<?php echo $player; ?>"/>
                </td>
            </tr>
        <?php 
        } 
        ?>
    </table>
    <?php 
    } 
    else 
    {
    ?>
    <h2>My Team</h2>
    <hr>
    <table>
        <?php 
        foreach(getRosterFromTeamID($teamID) as $position => $player) 
        { 
            if ($player == 0) { $player = ""; } 
            else { $player = getUsernameFromId($player); } 
            ?>
            <tr>
                <td><?php echo str_replace("main", "Main ", str_replace("sub", "Sub ", $position)); ?></td>
                <td><?php echo $player; ?>"
                </td>
            </tr>
        <?php 
        } 
        ?>
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