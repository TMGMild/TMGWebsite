<?php

require 'common.php';
requireAdminOrMod();
$id = get('reportid', 0);
if ($id > 0)
{
    $query = "SELECT postid, commentid FROM reports WHERE id=$id";
    $report = fetchRow($query);
    $pid = $report['postid'];
    $cid = $report['commentid'];
    removePost($pid, $cid);
    $authorid = getAuthorIdFromPost($pid, $cid);
    $days = $_REQUEST['time'];
    suspendUser($authorid, $days);
}
else
{
    
}