<?php

$query = "SELECT teamID,teamName,captain FROM rosters";
$rows = fetchAll($query);

?>
<h2>Teams</h2>
<hr>
<div id="teamsUpdater" class="updaterGreen"></div>
<table id="teams">

<?php 
$i = 0;
foreach($rows as $row)
{ ?>

    <tr id="<?php echo $row['teamID'];?>">
        <td><?php echo $row['teamName'];?></td>
        <td>
            <input type="text" oninput="updateCaptain(<?php echo $row['teamID'];?>, this.value)" value="<?php echo getUsernameFromId($row['captain']);?>"/> &nbsp;
        </td>
        <td><a class="red" href="javascript:removeTeam(<?php echo $row['teamID'];?>)">Remove</a></td>
    </tr>

<?php $i++; } ?>

<tr>
    <td>New Team</td>
    <td>
        <input type="text" name="newTeamName" id="newTeamName"/> &nbsp;
        <input type="submit" value="Add Team" onclick="addTeam()"/>
    </td>
    <td></td>
</tr>

</table>