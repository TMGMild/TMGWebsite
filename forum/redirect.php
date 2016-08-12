<?php

require('common.php');

$postid = $_GET['postid'];
$commentid = $_GET['commentid'];
$commentstodisplay = $_GET['ctd'];
$tableName = "post_" . $postid;

$page = ceil($commentid / $commentstodisplay);
redirect("viewpost.php?id=" . $postid . "&page=" . $page . "&comment=" . $commentid);

?>