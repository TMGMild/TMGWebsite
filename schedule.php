<?php
require 'common.php';

$maxID = fetchColumn("SELECT MAX(id) FROM schedule");

if (date("w") == 0)
{
    $date = date("l,j M Y", strtotime("yesterday"));
}
else if (date("w") == 6)
{
    $date = date("l,j M Y", strtotime("today"));
}
else
{
    $date = date("l,j M Y", strtotime("next saturday"));
}

if (isset($_GET['id']))
{
    $id = $_GET['id'];
    $date = fetchColumn("SELECT `date` FROM schedule WHERE `id`=$id");
    $dateLeft = date('l, F j', strtotime('-1 week', strtotime($date)));
    $dateRight = date('l, F j', strtotime('+1 week', strtotime($date)));
}
else
{
    $date = date('Y-m-d', strtotime(str_replace('-', '/', $date)));
    $query = "SELECT id FROM schedule WHERE `date` = '$date'";
    $id = fetchColumn($query);
    $dateLeft = date('l, F j', strtotime('-1 week', strtotime($date)));
    $dateRight = date('l, F j', strtotime('+1 week', strtotime($date)));
}

$idLeft = $id - 1;
$idRight = $id + 1;

$query = "SELECT 1a,1b,2a,2b,3a,3b,4a,4b,5a,5b,6a,6b FROM schedule WHERE `id` = '$id'";
$rowCenter = fetch($query);

$query = "SELECT 1a,1b,2a,2b,3a,3b,4a,4b,5a,5b,6a,6b FROM schedule WHERE `id` = '$idLeft'";
$rowLeft = fetch($query);

$query = "SELECT 1a,1b,2a,2b,3a,3b,4a,4b,5a,5b,6a,6b FROM schedule WHERE `id` = '$idRight'";
$rowRight = fetch($query);

function displaySchedule($date, $row, $fontSize, $headerFontSize)
{
    $newDate = date("l, F j", strtotime($date));
    echo '<h2 style="font-size:' . $headerFontSize . 'px;">Weekend of ' . $newDate . '</h3><br>
    <table style="font-size:' . $fontSize . '">';
        $i = 0;
        if ($row)
        {
            foreach($row as $slot => $entry):
                if ($i % 2 == 0)
                {
                    echo '<tr>
                        <td>';
                            $timeslot = substr($slot, 0, 1);
                            $timeslotstr = timeSlotToTime($timeslot);
                            echo $timeslotstr . '
                        </td>
                        <td>' . getTeamNameFromTeamID($entry) . '</td>';
                }
                else
                { 
                    echo '<td>' . getTeamNameFromTeamID($entry) . '</td></tr>'; 
                }
            $i++;
            endforeach;
        }
        else
        {
            echo 'Schedule currently being developed.';
        }
    echo '</table>';
}
?>

<DOCTYPE html>
<html>
    <head>
        <title>Schedule - TMG</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">
                <h1 class="center">Schedule</h1><br><br><br><br>
                <div class="threeDivLayout">
                    <div class="three Small" style="width:8%;padding:0;margin:0;margin-top:190px;background-color:inherit;">
                        <?php
                        if ($id > 2)
                        {?>
                            <a style="font-size:120px;" href="schedule.php?id=<?php echo $id - 1;?>">&lt;</a> 
                        <?php
                        }
                        ?>
                    </div>
                    <div class="three Big" style="width:84%;padding:0;margin:0;background-color:inherit;"">
                        <div class="threeDivLayout">
                            <div class="three Small">
                                <?php displaySchedule($dateLeft, $rowLeft, 14, 20); ?>
                            </div>
                            <div class="three Big">
                                <?php displaySchedule($date, $rowCenter, 18, 28); ?>
                            </div>
                            <div class="three Small">
                                <?php displaySchedule($dateRight, $rowRight, 14, 20); ?>
                            </div>
                        </div>
                    </div>
                    <div class="three Small" style="width:8%;padding:0;margin:0;margin-top:190px;background-color:inherit;text-align:right;">
                        <?php
                        if ($id + 1 < $maxID)
                        {?>                           
                            <a style="font-size:120px;" href="schedule.php?id=<?php echo $id + 1;?>">&gt;</a> 
                        <?php
                        }
                        ?>
                    </div>
                </div>                 
            </div>
        </div>
    </body>
</html>