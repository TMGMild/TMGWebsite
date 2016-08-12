<?php

require 'common.php';
requireAdminOrMod();
$categoryid = get('id', 1);

$newName = $_POST['name'];
$newDesc = $_POST['desc'];

$query = 
"
UPDATE categories
SET `name` = '$newName', `description` = '$newDesc' 
WHERE id = $categoryid;
";
execute($query);

redirect('editcategories.php?id=' . substr($categoryid, 0, -1))

?>