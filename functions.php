<?php

//This file is a list of PHP functions that can easily be called from ajax.js with the "callFunction()" javascript function.

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

$result = $function();
echo $result;