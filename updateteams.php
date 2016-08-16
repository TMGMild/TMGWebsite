<?php

require 'common.php';

if (!isManager())
{
    redirect("dashboard.php");
}

$mode = get('mode', 0);
$teamID = get('teamid', 0);

if ($mode == 0)
{
    //add a team
    $newTeamName = get('name', '');
    $query = "INSERT INTO rosters (teamName)
            VALUES ('$newTeamName');
            ";
    execute($query);
    $teamID = fetchColumn("SELECT MAX(teamID) FROM rosters");
    $query = "INSERT INTO standings VALUES($teamID, 0,0,0)";
    execute($query);
    sendUpdate('Welcome ' . $newTeamName . ' to the League!');
}
else if ($mode == 1)
{
    //remove a team
    $teamName = getTeamNameFromTeamID($teamID);
    $query = "DELETE FROM rosters
            WHERE `teamID` = $teamID";
    execute($query);
    $query = "DELETE FROM standings WHERE `teamID` = $teamID";
    execute($query);
    sendUpdate( $teamName . ' has dropped from the League.');
}
else
{
    //change team captain
    $newCaptain = getUserIdFromUsername(get('captain', ''));
    $query = "UPDATE rosters
            SET `captain` = '$newCaptain' 
            WHERE `teamID` = $teamID";
    execute($query); //set new captain
    sendUpdate(get('captain') . ' is the new captain of ' . getTeamNameFromTeamID($teamID) . '.');
}
?>