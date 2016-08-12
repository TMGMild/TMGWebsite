<?php

$query = "SELECT * FROM standings ORDER BY `w` DESC, `l`, `teamID`";
$rows  = fetchAll($query);

?>

<h2>Standings</h2>
<hr>
<table>
    <tr>
        <td>Team</td>
        <td>Wins</td>
        <td>Losses</td>
    </tr>
    <?php foreach($rows as $row)
    { if($row['teamID'] == teamID()) { ?>
        <tr class="highlight">
            <td><?php echo getTeamNameFromTeamID($row['teamID']);?></td>
            <td><?php echo $row['w']; ?></td>
            <td><?php echo $row['l']; ?></td>
        </tr>
    <?php } else { ?>
        <tr>
            <td><?php echo getTeamNameFromTeamID($row['teamID']);?></td>
            <td><?php echo $row['w']; ?></td>
            <td><?php echo $row['l']; ?></td>
        </tr>
    <?php } } ?>
</table>