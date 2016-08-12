<?php

require('common.php');

$postid = $_GET['postid'];

//Make sure that we're a mod or administrator
if (isAdminOrMod())
{
    //Authorized: continue
}
else
{
    redirect("viewpost.php?id=" . $postid);
}

$query = "
    UPDATE posts
    SET stickied=0 
    WHERE pid=" . $postid
;
execute($query);

$query = "
    SELECT cid 
    FROM posts 
    WHERE pid=$postid";
$cid = fetchColumn($query);

redirect("viewforum.php?id=$cid");

?>