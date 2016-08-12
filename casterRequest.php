<?php
require 'common.php';
for ($i = 1; $i < 7; $i++)
{
    if (isset($_POST[$i]))
    {
        //First, we check to make sure that the caster has not already registered for this slot. If they have, we shouldn't add them. If they haven't, we should.
        $query = "SELECT * FROM casterRequestsSlot" . $i . " WHERE casterID=" . userID();
        $row = fetch($query);
        if ($row)
        {
            //They're already registered, so do nothing.
        }
        else
        {
            //They're not already registered, so let's register them.
            $query = "INSERT INTO casterRequestsSlot" . $i . " VALUES(" . userID() . ")";
            execute($query);
        }
    }
    else
    {
        //The user has not checked the checkbox, thus they're either not registering or are removing their registration.
        //To determine which, we have to find out (as before) if they're already in the table.
        $query = "SELECT * FROM casterRequestsSlot" . $i . " WHERE casterID=" . userID();
        $row = fetch($query);
        if ($row)
        {
            //They're already registered, so remove them.
            $query = "DELETE FROM casterRequestsSlot" . $i . " WHERE casterID=" . userID();
            execute($query);
        }
        else
        {
            //They're not already registered, so do nothing.
        }
    }
}
if (isManager())
{
    redirect("manage.php");
}
else
{
    redirect("dashboard.php");
}
?>