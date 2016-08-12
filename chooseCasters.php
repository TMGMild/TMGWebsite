<?php

require 'common.php';

if (!empty($_POST))
{    
    for ($i = 1; $i < 7; $i++)
    {
        //Do A
        if (isset($_POST[$i . 'a']))
        {
            $casterIDA = $_POST[$i . 'a'];
            $query = "UPDATE casterSchedule
                    SET `caster1` = " . $casterIDA .
                    " WHERE `slot` = " . $i;
            execute($query);
        }
        else
        {
            $query = "UPDATE casterSchedule
                    SET `caster1` = 0 WHERE `slot` = " . $i;
            execute($query);
        }
        //Do B
        if (isset($_POST[$i . 'b']))
        {
            $casterIDA = $_POST[$i . 'b'];
            $query = "UPDATE casterSchedule
                    SET `caster2` = " . $casterIDA .
                    " WHERE `slot` = '" . $i . "'";
            execute($query);
        }
        else
        {
            $query = "UPDATE casterSchedule
                    SET `caster2` = 0 WHERE `slot` = " . $i;
            execute($query);
        }
    }
}

redirect("manage.php");


?>