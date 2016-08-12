<?php

require 'common.php';
$newcid = $_REQUEST['cid'];
$postid = $_REQUEST['pid'];

$query = "UPDATE posts SET `cid` = $newcid WHERE `pid` = $postid";

execute($query);

redirect("viewforum.php?id=$newcid");

?>