<?php

require('common.php');

$postid = $_GET['postid'];
$commentid = $_GET['commentid'];
$ctd = $_GET['ctd'];

//Make sure that we're a mod or administrator
if (isAdminOrMod())
{
    //Authorized: continue
}
else
{
    redirect("viewpost.php?id=" . $postid);
}

if ($commentid == "")
{
    //We're removing the post, because a comment was not specified.
    $query = "
        UPDATE posts
        SET removed=0 
        WHERE pid=" . $postid
    ;
    execute($query);

    redirect("viewforum.php");
}
else
{
    //We're removing a comment, which was specified.    
    $tablename = "post_" . $postid;
    $query = "
        UPDATE " . $tablename . "
        SET removed=0 
        WHERE commentid=" . $commentid
    ;
    execute($query);

    //Successful, redirect:
    redirect("redirect.php?postid=" . $postid . "&commentid=" . $commentid . "&ctd=" . $ctd);
}

?>