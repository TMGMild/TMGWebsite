<?php 

require("common.php");

requireLoggedIn();
if (!isCaptain())
{
    redirect("dashboard.php");
}

$column = get('pos', 'mainTop'); 
$newPlayer = get('player', 'Mild');
$id = fetchColumn("SELECT id FROM users WHERE username='$newPlayer'");

$query = " 
    UPDATE rosters
    SET `$column` = $id 
    WHERE `teamID` = " . teamID(); 
     
execute($query);

$posname = getPositionStrFromName($column);
$updateMsg = teamName() . " has changed their $posname to $newPlayer";
sendUpdate($updateMsg);

echo 'Successfully changed your ' . $posname . ' to ' . $newPlayer . '.';

?> 