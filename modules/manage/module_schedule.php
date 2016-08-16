<?php

$query = "SELECT * FROM schedule ORDER BY `date`";
$rows = fetchAll($query);

$query = "SELECT teamID,teamName FROM rosters";
$teams = fetchAll($query);

?>

<h2>Schedule</h2>
<hr>
<div class="updater green" id="scheduleUpdater"></div>
<table class="maxwidth">
    <tr>
        <td>Saturday</td>
            <?php
            for ($i = 1; $i < 7; $i++)
            {
                echo '<td>' . timeSlotToTime($i) . '</td>';
            }
            ?>
    </tr>
    <?php foreach ($rows as $row):
        if (new DateTime() < new DateTime($row['date'])) {
            //can edit
            ?>
            <form action="updateschedule.php?id=<?php echo $row['id'];?>" method="post">
                <?php echo '<tr>';
                    foreach ($row as $slot => $column):
                        if ($slot == "date")
                        {
                            echo '<td>' . $column . '</td>';
                        }
                        else if (contains($slot, "a"))
                        {
                            //starting a column
                            ?>
                            <td>
                                <select name="<?php echo $slot;?>">
                                    <?php 
                                    foreach($teams as $team): 
                                        $teamID = $team['teamID'];
                                        $teamName = $team['teamName'];
                                        if ($teamID == $column)
                                        {
                                            echo '<option value="' . $teamID . '" selected="true">' . $teamName . '</option>';
                                        }
                                        else
                                        {
                                            echo '<option value="' . $teamID . '">' . $teamName . '</option>';
                                        }                    
                                    endforeach; ?>
                                </select>
                            <?php
                        }
                        else if (contains($slot, "b"))
                        {
                            //ending a column
                            ?>
                                <select name="<?php echo $slot;?>">
                                    <?php 
                                    foreach($teams as $team):
                                        $teamID = $team['teamID'];
                                        $teamName = $team['teamName'];
                                        if ($teamID == $column)
                                        {
                                            echo '<option value="' . $teamID . '" selected="true">' . $teamName . '</option>';
                                        }
                                        else
                                        {
                                            echo '<option value="' . $teamID . '">' . $teamName . '</option>';
                                        }
                                    endforeach; ?>
                                </select>                        
                            </td>
                            <?php
                        }
                    endforeach;
                    echo '<td><input type="submit" value="Update" /></td>';
                echo '</tr>'; ?>
            </form>
        <?php 
        }
        else { 
        ?>
            <?php echo '<tr>';
                    foreach ($row as $slot => $column):
                        if ($slot == "date")
                        {
                            echo '<td>' . $column . '</td>';
                        }
                        else if (contains($slot, "a"))
                        {
                            //starting a column
                            echo '<td>' . getTeamNameFromTeamID($column) . ' vs ';
                        }
                        else if (contains($slot, "b"))
                        {
                            //ending a column
                            echo getTeamNameFromTeamID($column) . '</td>';
                        }
                    endforeach;
                echo '</tr>'; ?>
        <?php 
        } 
    endforeach; 
    ?>

</table>