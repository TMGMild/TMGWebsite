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
    $initdate = date("l,j M Y", strtotime("next saturday"));
    $displaydate = date("l, F j", strtotime("next saturday"));
}
$date = date('Y-m-d', strtotime(str_replace('-', '/', $initdate)));

$query = "SELECT 1a,1b,2a,2b,3a,3b,4a,4b,5a,5b,6a,6b FROM schedule WHERE `date` = '$date'";
$row = fetch($query);

?>

<h2>Schedule</h2>
<hr>
<a href="schedule.php">(View full schedule)</a>
<table>

<?php 
$i = 0;
if ($row)
{
    foreach($row as $slot => $entry):
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
                <td>
                    <?php
                    if ($entry == teamID())
                    {
                        echo '<span style="font-size:18px;color:red;">' . getTeamNameFromTeamID($entry) . '</span>';
                    }
                    else
                    {
                        echo getTeamNameFromTeamID($entry);
                    }
                    ?>
                </td>
        <?php }
        else
        {
            //continue (and end) row
            ?>
            <td>
                <?php
                    if ($entry == teamID())
                    {
                        echo '<span style="font-size:18px;color:red;">' . getTeamNameFromTeamID($entry) . '</span>';
                    }
                    else
                    {
                        echo getTeamNameFromTeamID($entry);
                    }
                ?>
            </td>
        </tr>
        <?php }

    $i++;
    endforeach;
}
?>

</table>

