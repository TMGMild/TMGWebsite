<?php
require("common.php");
$page = get('page', 1);
$commentstodisplay = 5;
$offset = ($page - 1) * $commentstodisplay;
$postid = get('id', 1);
$commentid = get('comment', 0);

$query = "SELECT * FROM post_" . $postid . " ORDER BY `date` ASC LIMIT " . $commentstodisplay . " OFFSET " . $offset; //Get all comments
$replies = fetchAll($query);

//Fetch reported comments from this thread
$query = "SELECT commentid FROM reports WHERE postid=$postid";
$reportsarray = fetchAll($query);
$reports = array();
foreach ($reportsarray as $report)
{
    array_push($reports, $report['commentid']);
}

$query = "SELECT * FROM posts WHERE pid = " . $postid; //Get entry in posts table
$therow = fetch($query);
$title = $therow['title'];
$categoryid = $therow['cid'];
$categoryname = getCategoryNameFromId($categoryid);
$count = fetchColumn("SELECT COUNT(*) FROM post_" . $postid);
$pagescount = ceil($count / $commentstodisplay);
if ($therow['removed'] == 0)
{
?> 

<html>

    <head>
        <title><?php echo $title;?></title>
        <?php include 'head.php'; ?>
    </head>

    <body>
        <?php include 'nav.php'; ?>
        <div class="wrapper">
            <div class="content">
                <a style="font-size:15px;" href="viewforum.php?id=<?php echo $categoryid;?>"><< Return to <?php echo $categoryname; ?></a><br><br>
                <h2 class="left"><?php echo $title;?></h2><br>     
                <table>
                    <?php 
                    foreach($replies as $reply)
                    {
                        if ($reply['commentid'] == $commentid)
                        {
                            echo '<tr class="highlight">';
                        }
                        else
                        {
                            echo '<tr>';
                        }
                        
                            $text = format($reply['text']);
                            if($reply['removed'] == 1)
                            {
                                if (isAdminOrMod())
                                {
                                    echo '<td></td><td>The following comment has been removed. Normal users will not see it:<br><p class="code">' . $text . '</p></td><td><a href="unremove.php?postid=' . $postid . '&commentid=' . $reply['commentid'] . '&ctd=' . $commentstodisplay . '"><span class="notice red">UNREMOVE</span></a></td>';
                                }
                                else
                                {
                                    echo '<td></td><td>[Reply removed.]</td><td></td>';
                                }
                            }
                            else
                            {
                            ?>
                                <td style="width:10%;" class="top">
                                    <?php echo echoUserName($reply['authorid']);?>
                                    <br>
                                    <span style="font-size:14px;margin-top:5px;"><?php echo teamName(getUserNameFromId($reply['authorid']));?></span>
                                </td>
                                <td style="width:65%;" class="top">
                                    <?php echo $text; ?>
                                </td>
                                <td style="width:25%;" class="top">
                                    <?php
                                    echo timeToString($reply['date']);?>
                                    <br>
                                    <?php 
                                    if ((isAdminOrMod() && isUser($reply['authorid'])) || userID() == $reply['authorid'])
                                    {
                                        //Show admin tools
                                        echo '<a href="remove.php?postid=' . $postid . '&commentid=' . $reply['commentid'] . '&ctd=' . $commentstodisplay . '"><span class="notice green">REMOVE</span></a>';
                                        
                                        if ($reply['authorid'] == userID())
                                        {
                                            echo '<a href="edit.php?postid=' . $postid . '&commentid=' . $reply['commentid'] . '"><span class="notice green">EDIT</span></a>';
                                        }
                                    }
                                
                                    if (!in_array($reply['commentid'], $reports))
                                    {
                                    ?>
                                        <a href="#" onclick='$("#report<?php echo $reply['commentid'];?>").toggle(300);'><span class="notice red">REPORT</span></a>
                                        
                                        <form action="../report.php?pid=<?php echo $postid;?>&cid=<?php echo $reply['commentid'];?>" method="post" id="report<?php echo $reply['commentid'];?>" style="display:none;">
                                            <textarea style="width:60%;font-size:15px;" name="msg" placeholder="What's wrong?" rows="3"></textarea>
                                            <br>
                                            <input type="submit" value="Report" class="button grayScale small">
                                        </form>
                                    <?php
                                    }
                                    else 
                                    { 
                                        echo '<p class="small"><i>This post/comment has already been reported.</i></p>'; 
                                    }
                                    ?>
                                </td>
                            <?php 
                            } 
                            ?>
                        </tr>
                        <?php
                    }
                    ?>
                    
                    <?php 
                    if(loggedIn() && $page == $pagescount) 
                    { 
                    ?>
                        <tr>
                            <td></td>
                            <td>
                                <form action="reply.php?id=<?php echo $postid;?>&ctd=<?php echo $commentstodisplay;?>" method="post"> 
                                    <textarea rows=10 name="text"></textarea>
                                    <br /><br /> 
                                    <input type="submit" value="Submit" /> 
                                </form>                                
                            </td>
                            <td style="vertical-align:top">
                                <a href="javascript:$('#formatting').toggle(300)"><span class="notice green">FORMATTING</span></a>
                                <table class="compact" id="formatting" style="display:none;">
                                    <tr style="font-size:15px;">
                                        <td>You write</td>
                                        <td>You see</td>
                                    </tr>
                                    <tr><td>|*Bold*|</td><td><b>Bold</b></td>
                                    <tr><td>|^Italics^|</td><td><i>Italics</i></td>
                                    <tr><td>|~Strikethrough~|</td><td><strike>Strikethrough</strike></td>
                                    <tr><td>|!Header!|</td><td><span class="forumTitle">Header</span></td>
                                </table>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>            
                </table>

                <div id="pagenumbers">
                    <span>
                    <?php
                    if($page > 1)        
                    {
                        echo '<a class="foreblack" href="viewpost.php?id=' . $postid . '">First</a> | <a class="foreblack" href="viewpost.php?id=' . $postid . '&page=' . ($page - 1) . '">Prev</a> | ';
                    }        
                    echo $page;
                    if($page != $pagescount)
                    {
                        echo ' | <a class="foreblack" href="viewpost.php?id=' . $postid . '&page=' . ($page + 1) . '">Next</a> | <a class="foreblack" href="viewpost.php?id=' . $postid . '&page=' . ($pagescount) . '">Last</a> ';
                    }
                    ?>
                    </span>
                </div>            
            </div>
        </div>
    </body>
</html>

<?php 
}
else
{
    //The post has been removed.
    ?>    
    <html>
        <head>
            <title>Removed post</title>
            <?php include 'head.php'; ?>
        </head>
        <body>
            <?php include 'nav.php';?>
            <div class="wrapper">
                <div class="content">
                    <h2 class="left">This post has been removed</h2>
                    <hr>
                    <a style="font-size:20px;" href="viewforum.php?id=<?php echo $categoryid;?>"><< Return to <?php echo $categoryname; ?></a>
                </div>
            </div>
        </body>
    </html>
<?php 
} 
?>