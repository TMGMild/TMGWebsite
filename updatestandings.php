<?php

require 'common.php';

if (!isManager())
{
    redirect("dashboard.php");
}

if ($_GET['draw'] == 1)
{
    $team1 = $_GET['team1'];
    $team2 = $_GET['team2'];
    
    //Team1:
    $query = "SELECT d FROM standings WHERE `teamID` = $team1";
    $draws = fetchColumn($query);
    $draws++;
    $query = "UPDATE standings
            SET `d` = $draws
            WHERE `teamID` = $team1";
    execute($query);

    //Team2:
    $query = "SELECT d FROM standings WHERE `teamID` = $team2";
    $draws = fetchColumn($query);
    $draws++;
    $query = "UPDATE standings
            SET `d` = $draws
            WHERE `teamID` = $team2";
    execute($query);

    //Send update:
    $team1Name = getTeamNameFromTeamID($team1);
    $team2Name = getTeamNameFromTeamID($team2);
    $date = date("Y-m-d H:i:s");
    $msg = "$team1Name has tied 1-1 with $team2Name.";
    $query = "
            INSERT INTO updates
            VALUES ('$msg', $date)
            ";
    execute($query);
}
else
{
    //Some team won. Let's figure out which, first.
    $winner = $_GET['team1'];
    $loser = $_GET['team2'];

    //Winner:
    $query = "SELECT w FROM standings WHERE `teamID` = $winner";
    $wins = fetchColumn($query);
    $wins++;
    $query = "UPDATE standings
            SET `w` = $wins
            WHERE `teamID` = $winner";
    execute($query);

    //Loser:
    $query = "SELECT l FROM standings WHERE `teamID` = $loser";
    $losses = fetchColumn($query);
    $losses++;
    $query = "UPDATE standings
            SET `l` = $losses
            WHERE `teamID` = $loser";
    execute($query);

    //Send update:
    $winnerName = getTeamNameFromTeamID($winner);
    $loserName = getTeamNameFromTeamID($loser);
    $date = date("Y-m-d H:i:s");
    $msg = "$winnerName has defeated $loserName.";
    $query = "
            INSERT INTO updates
            VALUES ('$msg', '$date')
            ";
    execute($query);
}

redirect("manage.php");

?>