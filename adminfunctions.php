<?php

//This file is a list of admin PHP functions that can easily be called from ajax.js with the "callFunction()" javascript function.

require 'common.php';
requireAdminOrMod();
$function = get('f', '');
$result = "";

function changeRole()
{
    $userid = $_REQUEST['userid'];
    $newRole = $_REQUEST['newrole'];
    if ($newRole != "admin" && $newRole != "mod" && $newRole != "user")
    {
        $newRole = "admin";
    }
    $query = "UPDATE users SET role = '$newRole' WHERE `id` = $userid";
    execute($query);
}

function toggleColumn()
{
    $columnName = $_REQUEST['columnname'];
    $userid = $_REQUEST['userid'];
    $newVal = $_REQUEST['newvalue'];
    if ($newVal == 'true')
    {
        $newVal = 1;
    }
    else if ($newVal == 'false')
    {
        $newVal = 0;
    }
    $query = "UPDATE users SET `$columnName` = $newVal WHERE id = $userid";
    execute($query);
}

function suspendUser2()
{
    $userid = $_REQUEST['userid'];
    $days = $_REQUEST['days'];

    if (!checkPermissions($userid)) { return; }
    $suspensiondate = date("Y:m:d H:i:s", strtotime('+' . $days . ' days'));
    $newsuscount = getSusCount($userid) + 1;
    $query =
    "
    UPDATE users
    SET suspensiondate = '$suspensiondate', suscount = $newsuscount 
    WHERE id=$userid;
    ";
    execute($query);
}

function liftSuspension()
{
    $userid = $_REQUEST['userid'];
    $date = date("Y-m-d H:i:s", strtotime("yesterday")); //yesterday just to be sure
    $query = "UPDATE users SET suspensiondate = '$date' WHERE id=$userid";
    execute($query);
}

function changeCategoryName()
{
    $id = $_REQUEST['id'];
    $newname = $_REQUEST['newname'];
    $query = "UPDATE categories SET name = '$newname' WHERE id = $id";
    execute($query);
}

function changeCategoryDesc()
{
    $id = $_REQUEST['id'];
    $newdesc = addslashes($_REQUEST['newdesc']);
    $query = "UPDATE categories SET description = '$newdesc' WHERE id=$id";
    execute($query);
}

function changeStaff()
{
    $oldid = $_REQUEST['old'];
    $newUsername = $_REQUEST['new'];
    $newid = getUserIdFromUsername($newUsername);
    $query = "UPDATE staff SET id=$newid WHERE id=$oldid";
    execute($query);
}

function changeStaffPosition()
{
    $id = $_REQUEST['id'];
    $new = $_REQUEST['new'];
    $query = "UPDATE staff SET positions='$new' WHERE id=$id";
    execute($query);
}

function newStaff()
{
    $name = $_REQUEST['name'];
    $id = getUserIdFromUsername($name);
    $pos = $_REQUEST['pos'];
    $query = "INSERT INTO staff VALUES($id, '$pos')";
    execute($query);
}

$result = $function();
echo $result;
?>