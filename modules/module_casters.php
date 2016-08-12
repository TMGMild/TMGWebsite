<h2>Casting</h2>
<hr>
<?php

if (date("w") == 1 || date("w") == 2 || date("w") == 3)
{?>
    <form action="casterRequest.php" method="post" class="center" style="font-size:18px;">
        <br>
        Please check which of the following times you are available:
        <br>
        <?php
        for ($i = 1; $i < 7; $i++)
        {
            $query = "SELECT * FROM casterRequestsSlot" . $i . " WHERE casterID=" . userID();
            $row = fetch($query);
            if ($row)
            {
                echo '<input type="checkbox" name="' . $i . '" value="' . $i . '" checked><?php echo timeSlotToTime(' . $i . ');?>' . timeSlotToTime($i) . '<br>';
            }
            else
            {
                echo '<input type="checkbox" name="' . $i . '" value="' . $i . '"><?php echo timeSlotToTime(' . $i . ');?>' . timeSlotToTime($i) . '<br>';
            }
        }?>
        <br>
        <input type="submit" value="Submit">
    </form>
<?php
}
else if (date("w") == 4)
{
    echo 'A casting schedule is being finalized. Please return on Friday for your casting times.';
}
else
{
    ?>
    <p class="red">All of the text following this are for debugging purposes ONLY! These are NOT your actual casting times for this weekend!</p>
    <?php
    //Display actual schedule
    $query = "SELECT * FROM casterSchedule";
    $rows = fetchAll($query);
    $slots = array();
    foreach ($rows as $row)
    {
        if ($row['caster1'] == userID() || $row['caster2'] == userID())
        {
            array_push($slots, $row['slot']);
        }
    }
    if (count($slots) == 0)
    {
        echo "You're on break! It looks like you won't be casting this weekend. Enjoy.";
    }
    else
    {
        echo "You'll be casting at the following times: <br><ul>";
        foreach($slots as $slot)
        {
            echo "<li>" . timeSlotToTime($slot) . "</li>";
        }
        echo "</ul>";
    }
}

?>
