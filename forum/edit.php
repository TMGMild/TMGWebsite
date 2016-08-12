<?php 

require("common.php"); 

$postid = $_GET['postid'];
$commentid = $_GET['commentid'];

$tablename = "post_" . $postid;

//First, we have to check to make sure that the comment was made by that user. Let's find that comment in the database now.

$query = "SELECT * FROM " . $tablename . " WHERE commentid = " . $commentid; 

$comment = fetchRow($query);

if($comment['authorid'] == $_SESSION['user']['id'])
{
    //Authorized: load in the existing comment
    $currenttext = $comment['text'];
}
else
{
    //Not authorized: die
    redirect("viewpost.php?id=" . $postid);
}
    
if(!empty($_POST)) 
{
    //The form has been submitted: let's update the comment
    
    $text = addslashes($_POST['text']);

    $query = "
        UPDATE " . $tablename . "
        SET text='" . $text . "' 
        WHERE commentid=" . $commentid
    ;
    
    execute($query);

    redirect("viewpost.php?id=" . $postid);
}

$url = "edit.php?postid=" . $postid . "&commentid=" . $commentid;

?> 
<html>
    <head>
        <title>Edit</title>
        <?php include 'head.php'; ?>
    </head>
    <body>
        <?php include 'nav.php'; ?>
        <div class="wrapper">
            <div class="content">
                <h1>Edit Post</h1><br>
                <form action="<?php echo $url;?>" method="post">
                    <textarea name="text" rows=20><?php echo $currenttext;?></textarea>
                    <br /><br /> 
                    <input type="submit" value="Submit" /> 
                </form>
            </div>
        </div>
    </body>
</html>