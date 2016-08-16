<?php


if (date("w") == 0)
{
    $initdate = date("l,j M Y", strtotime("last saturday"));
    $displaydate = date("l, F j", strtotime("last saturday"));
}
else if (date("w") == 6)
{
    $initdate = date("l,j M Y", strtotime("today"));
    $displaydate = date("l, F j", strtotime("today"));
}
else
{    
    $initdate = date("l,j M Y", strtotime("last saturday"));
    $displaydate = date("l, F j", strtotime("last saturday"));
}
$date = date('Y-m-d', strtotime(str_replace('-', '/', $initdate)));

$query = "SELECT 1a,1b,2a,2b,3a,3b,4a,4b,5a,5b,6a,6b FROM schedule WHERE `date` = '$date'";
$row = fetch($query);

?>

<h2>Results</h2>
<hr>
<div class="updater green" id="resultsUpdater"></div>
<a href="schedule.php">View full schedule</a>
<br>
<table>
    <?php 
    $i = 0;
    $team1 = 0;
    $team2 = 0;
    if ($row)
    {
        foreach($row as $slot => $entry)
        {
            if ($i % 2 == 0)
            {
                //new row
            ?>
                <tr>
                    <td>
                        <?php
                        $timeslot = substr($slot, 0, 1);
                        $timeslotstr = timeSlotToTime($timeslot);
                        echo $timeslotstr;
                        ?>
                    </td>
                    <td><?php
                        echo getTeamNameFromTeamID($entry);
                        ?>
                    </td>
            <?php $team1 = $entry; }
            else
            {
            ?>
                <td>
                    <?php
                        echo getTeamNameFromTeamID($entry); $team2 = $entry;
                    ?>
                </td>
                <td>
                <a href="updatestandings.php?draw=0&team1=<?php echo $team1;?>&team2=<?php echo $team2;?>">Win</a> | 
                <a href="updatestandings.php?draw=0&team2=<?php echo $team1;?>&team1=<?php echo $team2;?>">Loss</a> | 
                <a href="updatestandings.php?draw=1&team1=<?php echo $team1;?>&team2=<?php echo $team2;?>">Draw</a>
                </td>
            </tr>
            <?php
            }
        
        $i++;
        }
    }
    ?>
</table>

