<?php

//This file is a list of PHP functions that can easily be called from with AJAX.

require 'common.php';
$function = get('f', '');
$result = "";

function getHighestTeamId()
{
    $query = "SELECT MAX(`teamID`) FROM rosters";
    return fetchColumn($query);
}

function retrieveCategories()
{
    $categoryID = $_REQUEST['id'];
    $categoryname = getCategoryNameFromId($categoryID);
    $targetlength = 1 + strlen($categoryID);

    $query = "SELECT * FROM categories WHERE LENGTH(id) = " . $targetlength . " AND id LIKE '" . $categoryID . "%'"; //Get categories
    $categories = fetchAll($query);
    $output = "";
    foreach ($categories as $category)
    { 
        $id = $category['id'];
        $output .= "
        <tr>
            <td style='width:10%;'>
                <a id='name$id' href='javascript:retrieveCategories($id)'>" . $category['name'] . "</a>
            </td>
            <td style='width:5%;'>
                <a style='font-size:14px;color:red;' href='javascript:removeCategory($id)'>Remove</a>
            </td>
            <td style='width:85%;'>
                <input type='text' style='background-color:#222222;' oninput='changeCategory(\"name\", $id, this)' value='" . $category['name'] . "'>
                <br>
                <input type='text' style='width:100%;background-color:#222222;' oninput='changeCategory(\"desc\", $id, this)' value='" . $category['description'] . "'>
            </td>
        </tr>
        ";
    }
    if (count($categories) == 0)
    {
        $output .= "
        <tr>
        This category does not contain any subcategories.
        </tr>
        ";
    }
    if (count($categories) != 10)
    {
        $output .= "
        <tr id='new'><td><input type='submit' value='Add Category' onclick='newCategory()' /></td><td></td><td></td><td></td><td></td></tr>
        ";
    }
    return $output;
}

function getCategoryNameFromId2()
{
    $id = $_REQUEST['id'];
    return "Return to " . getCategoryNameFromId($id);
}

function userExistsByUsername()
{
    $username = $_REQUEST['username'];
    $query = "SELECT 1 FROM users WHERE username='$username'";
    if (fetchRow($query))
    {
        return "true";
    }
    else
    {
        return "false";
    }
}

function displaySchedule()
{
    $id = get('id', 1);
    $return = "";
    $date = fetchColumn("SELECT `date` FROM schedule WHERE id=$id");
    $row = fetch("SELECT 1a,1b,2a,2b,3a,3b,4a,4b,5a,5b,6a,6b FROM schedule WHERE `id` = '$id'");
    $displayDate = date("l, F j", strtotime($date));
    $return = '<h2>Weekend of ' . $displayDate . '</h3><br>
    <table>';
        $i = 0;
        if ($row)
        {
            foreach($row as $slot => $entry):
                if ($i % 2 == 0)
                {
                    $return .= '<tr>
                        <td>';
                            $timeslot = substr($slot, 0, 1);
                            $timeslotstr = timeSlotToTime($timeslot);
                            $return .= $timeslotstr . '
                        </td>
                        <td>' . getTeamNameFromTeamID($entry) . '</td>';
                }
                else
                { 
                    $return .= '<td>' . getTeamNameFromTeamID($entry) . '</td></tr>'; 
                }
            $i++;
            endforeach;
        }
        else
        {
            $return .= '<i>Schedule under development</i>';
        }
    $return .= '</table>';
    return $return;
}

function loadStaff()
{
    $return = "";
    $staff = fetchAll("SELECT * FROM staff");
    foreach ($staff as $staffmember)
    {
        $return .= 
        "<tr>
            <td style='width:5%;'>
                <input type='text' value='" . getUserNameFromId($staffmember['id']) . "' oninput='changeStaffMember(" . $staffmember['id'] . ", this)' />
            </td>
            <td style='width:30%;'>
                <input type='text' value='" . $staffmember['positions'] . "' oninput='changeStaffPosition(" . $staffmember['id'] . ", this)' />
            </td>
            <td>
                <a href='javascript:removeStaff(" . $staffmember['id'] . ")' class='red'>Remove</a>
            </td>
        </tr>";
    }
    $return .= 
        "
        <tr>
            <td>
                <input type='text' id='newStaffName' />
            </td>
            <td>
                <input type='text' id='newStaffPosition' />
            </td>
            <td>
                <a href='javascript:newStaff()' class='button'>Add</a>
            </td>
        </tr>
        ";
    return $return;
}

function changeTeamLogo()
{
    $teamID = $_REQUEST['teamID'];
    $logo = $_REQUEST['logo'];
    if (isCaptainOf($teamID))
    {
        $query = "UPDATE rosters SET teamLogo = '$logo' WHERE teamID = $teamID";
        execute($query);
    }
}

echo $function();