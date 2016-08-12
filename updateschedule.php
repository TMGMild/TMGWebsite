<?php

require 'common.php';
requireManager();

$id = $_GET['id'];
$values = "";

foreach($_POST as $slot => $teamID)
{
    $values = $values . "`$slot` = $teamID, ";
}

$values = substr($values, 0, -2);

$query = "UPDATE schedule
        SET $values
        WHERE id = " . $id;

execute($query);

$week = fetchColumn("SELECT `date` FROM schedule WHERE id=$id");
sendUpdate('The schedule for the weekend of ' . $week . ' has changed.');

redirect("manage.php");

?>