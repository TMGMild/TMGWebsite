<?php
require("common.php");
$page = get('page', 1);
$commentstodisplay = 5;
$offset = ($page - 1) * $commentstodisplay;
$postid = $_GET['id'];
$commentid = get('comment', 0);

$query = "SELECT * FROM post_" . $postid . " ORDER BY `date` ASC LIMIT " . $commentstodisplay . " OFFSET " . $offset; //Get all comments
$rows = fetchAll($query);

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
                <h1><?php echo $title;?></h1><br>     
                <table>
                    <?php foreach($rows as $row):
                    if ($row['commentid'] == $commentid)
                    {
                        echo '<tr class="highlight">';
                    }
                    else
                    {
                        echo '<tr>';
                    }
                    $text = format($row['text']);
                    ?>
                        <?php 
                        if($row['removed'] == 1)
                        {
                            if (isAdminOrMod())
                            {
                                echo '<td></td><td>The following comment has been removed. Normal users will not see it:<br><p class="code">' . $text . '</p></td><td><a class="block red" href="unremove.php?postid=' . $postid . '&commentid=' . $row['commentid'] . '&ctd=' . $commentstodisplay . '">UNREMOVE</a></td>';
                            }
                            else
                            {
                                echo '<td></td><td>[Reply removed.]</td><td></td>';
                            }
                        }
                        else
                        {
                        ?>
                            <td style="vertical-align:top;width:10%;">
                                <?php echo echoUserName($row['authorid']);?>
                                <br>
                                <span style="font-size:14px;margin-top:5px;"><?php echo teamName(getUserNameFromId($row['authorid']));?></span>
                            </td>
                            <td style="vertical-align:top;width:65%;">
                                <?php echo $text; ?>
                            </td>
                            <td style="width:25%;">
                                <?php 
                                $time = strtotime($row['date']);
                                $date = date("m/d/y g:i A", $time);
                                echo timeToString($date);?>
                                <br><br>
                                <?php 
                                if ((isAdminOrMod() && !isAdmin($row['authorid'])) || userID() == $row['authorid'])
                                {
                                    //Show admin tools
                                    echo '<a class="block red" href="remove.php?postid=' . $postid . '&commentid=' . $row['commentid'] . '&ctd=' . $commentstodisplay . '">REMOVE</a>';
                                    if ($row['authorid'] == userID())
                                    {
                                        echo ' <a class="block green" href="edit.php?postid=' . $postid . '&commentid=' . $row['commentid'] . '">EDIT</a>';
                                    }
                                    echo '<br><br>';
                                }
                                if (!in_array($row['commentid'], $reports))
                                {
                                ?>
                                <a href="#" style="font-size:14px;" onclick='document.getElementById("report<?php echo $row['commentid'];?>").style.display="block";'>Report</a>
                                <form action="../report.php?pid=<?php echo $postid;?>&cid=<?php echo $row['commentid'];?>" method="post" id="report<?php echo $row['commentid'];?>" style="display:none;">
                                    <textarea style="width:60%;" name="msg" placeholder="Why?" rows="3"></textarea>
                                    <br>
                                    <input type="submit" value="Submit" style="font-size:14px;">
                                </form>
                                <?php
                                }
                                else { echo '<p style="font-size:12px;"><i>This post/comment has already been reported.</i></p>'; }
                                ?>
                            </td>
                        <?php 
                        } 
                        ?>
                    </tr>
                    <?php
                    endforeach; ?>
                    <?php 
                    if(loggedIn() && $page == $pagescount) 
                    { ?>
                        <tr>
                            <td></td>
                            <td>
                                <form action="reply.php?id=<?php echo $postid;?>&ctd=<?php echo $commentstodisplay;?>" method="post"> 
                                    <textarea rows=10 name="text"></textarea>
                                    <br /><br /> 
                                    <input type="submit" value="Submit" /> 
                                </form>
                                <a href="#" style="font-size:14px;" onclick='toggleFormatting();'>Formatting Guide</a>
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
                            <td style="vertical-align:top">
                                
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
                    <h1>This post has been removed</h1>
                    <hr>
                    <a style="font-size:20px;" href="viewforum.php?id=<?php echo $categoryid;?>"><< Return to <?php echo $categoryname; ?></a>
                </div>
            </div>
        </body>
    </html>
<?php 
} 
?>