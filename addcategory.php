<?php

require 'common.php';
requireAdminOrMod();
$parentid = $_REQUEST['id'];

$newName = $_REQUEST['name'];
$newDesc = $_REQUEST['desc'];

$query =
"
SELECT `id`
FROM categories
WHERE `id` LIKE '" . $parentid . "_' 
ORDER BY `id` DESC 
LIMIT 1
";

$id = fetchColumn($query);

if (empty($id))
{
    $id = $parentid * 10;
}

if (substr($id, -1) != '9')
{
    $newid = $id + 1;
}
else
{
    
}

$newName = addslashes($newName);
$newDesc = addslashes($newDesc);

$query = 
"
INSERT INTO categories (`id`, `name`, `description`) 
VALUES ($newid, '$newName', '$newDesc');
";
execute($query);

?>