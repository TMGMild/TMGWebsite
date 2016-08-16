<?php
require 'common.php';
$maxID = fetchColumn("SELECT MAX(id) FROM schedule");

if (isset($_GET['id']))
{
    $id = $_GET['id'];
}
else
{
    if (date("w") == 0)
    {
        $tempdate = date("l,j M Y", strtotime("yesterday"));
    }
    else if (date("w") == 6)
    {
        $tempdate = date("l,j M Y", strtotime("today"));
    }
    else
    {
        $tempdate = date("l,j M Y", strtotime("next saturday"));
    }
    $tempdate = date('Y-m-d', strtotime(str_replace('-', '/', $tempdate)));
    $id = fetchColumn("SELECT id FROM schedule WHERE `date` = '$tempdate'");
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
                <input type="hidden" id="scheduleID" value="<?php echo $id;?>">
                <input type="hidden" id="maxID" value="<?php echo $maxID;?>">
                <h1 class="center">Schedule</h1><br>
                <div class="layout three" style="min-height:500px;background-color:inherit;text-align:center;padding-top:190px;">
                    <a id="backArrow" style="font-size:120px;color:white;" href="javascript:loadPrevSchedule()">&lt;</a>
                </div>
                <div class="layout three" style="min-height:500px;text-align:center;" id="schedule"></div>
                <div class="layout three" style="min-height:500px;background-color:inherit;text-align:center;padding-top:190px;">
                    <a id="forwardArrow" style="font-size:120px;color:white;" href="javascript:loadNextSchedule()">&gt;</a>
                </div>            
            </div>
        </div>
        <script>
        loadSchedule(<?php echo $id;?>)
        </script>
    </body>
</html>