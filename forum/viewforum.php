<?php
require("common.php");
$poststodisplay = 10;
$page = get('page', 1);
$offset = ($page - 1) * $poststodisplay;
$categoryid = get('id', 1);
$categoryname = getCategoryNameFromId($categoryid);
$targetlength = 1 + strlen($categoryid);

$query = "SELECT * FROM categories WHERE LENGTH(id) = " . $targetlength . " AND id LIKE '" . $categoryid . "%'"; //Get categories
$rows = fetchAll($query);

$query = "SELECT * FROM posts WHERE cid = " . $categoryid . " AND removed = 0 ORDER BY `stickied` DESC, `date` DESC LIMIT " . $poststodisplay . " OFFSET " . $offset; //Get posts
$posts = fetchAll($query);
 
if ($categoryid != 1)
{
    $uponeid = substr($categoryid, 0, -1);
    $uponename = getCategoryNameFromId($uponeid);
}

?> 

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Forum</title>
    <?php include 'head.php'; ?>
  </head>

  <body>
    <?php include 'nav.php'; ?>
    <div class="wrapper">
        <div class="content">
            <span style="font-size:40px;font-weight:100;margin-bottom:40px;"><?php echo $categoryname;?></span>
            <form action="search.php" method="get" style="display:inline;">
                <input type="text" name="q" style="float:right;" placeholder="Search <?php echo $categoryname;?>">
                <input type="submit" style="display:none;">
            </form>
            <hr style="margin:20px 20px 20px 20px;">
            <?php
            if ($categoryid != 1)
            {?>
                <a style="font-size:15px;" href="viewforum.php?id=<?php echo $uponeid;?>"><< Return to <?php echo $uponename; ?></a><br><br>
            <?php
            }
            
            if (count($rows) > 0)
            { ?>
                <table style="border-bottom:1px solid gray;">
                    <tr>
                        <td>
                            <span style="font-size:30px;font-weight:100">Categories</span>
                        </td>
                    </tr>
                <?php
                    foreach($rows as $row):
                    ?>
                    <tr>
                        <td>
                            <a style="font-size:22px;font-weight:100;" href="viewforum.php?id=<?php echo $row['id'];?>"><?php echo $row['name']; ?></a><br>
                            <p class="small"><?php echo $row['description']; ?></p>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php
            }            
            if(loggedIn()) 
            {
                echo '<a class="graybutton sidebutton" style="display:inline-block;font-size:18px;font-weight:300;" href="newpost.php?id=' . $categoryid . '">+New Post</a><br>';
            }
            if (count($posts) > 0)
            {
            ?>
            <table>
                <tr>
                    <td>
                        <span style="font-size:30px;font-weight:100">Posts</span>
                    </td>
                    <td></td><td></td><td></td>
                </tr>
                <?php foreach($posts as $row):
                ?>
                <tr>
                    <td width="60%">
                        <span class="title"><a href="viewpost.php?id=<?php echo $row['pid'];?>"><?php echo $row['title']; ?></a></span>
                        <?php
                        if ($row['stickied'] == 1)
                        {?> 
                            <span class="notice green">STICKIED</span>
                        <?php } ?>
                    </td>
                    <td width="15%">
                        <?php echo echoUserName($row['authorid']);?>
                    </td>
                    <td width="10%">
                        <?php
                        $count = fetchColumn("SELECT COUNT(*) FROM post_" . $row['pid']);
                        echo "Replies: " . ($count - 1);
                        ?>
                    </td>
                    <td width="15%">
                        <?php echo timeToString($row['date']); ?>
                        <br>
                        <?php 
                        if ((isAdminOrMod() && !isAdmin($row['authorid'])) || userID() == $row['authorid'])
                        {
                            echo '<a class="block red" href="remove.php?postid=' . $row['pid'] . '">REMOVE</a>';
                        }
                        if (isAdminOrMod() && !(isMod($_SESSION['user']['id']) && isAdmin($row['authorid'])))
                        {
                            if ($row['stickied'] == 1)
                            {
                                echo '<a class="block green" href="unsticky.php?postid=' . $row['pid'] . '">UNSTICKY</a>';
                            }
                            else
                            {
                                echo '<a class="block green" href="sticky.php?postid=' . $row['pid'] . '">STICKY</a>';
                            }?>
                            <span style="display:none;font-size:13px;font-weight:400;" id="<?php echo $row['pid'];?>">
                                <br><br>
                                Move post from <?php echo $categoryname;?> to 
                                <form action="move.php?pid=<?php echo $row['pid'];?>" method="post" style="margin:0;">
                                    <select name="cid">
                                        <?php
                                        foreach (fetchAll("SELECT `id`,`name` FROM categories") as $category)
                                        {
                                            echo '<option value="' . $category['id'] . '">' . $category['name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <br>
                                    <input type="submit" value="Submit" style="font-size:13px"/>
                                </form>
                                <br>
                            </span>
                            <a class="block green" href="javascript:toggleMove(<?php echo $row['pid'];?>)">MOVE</a>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <?php endforeach; }?>
            </table>
            <br>

            <div id="pagenumbers">
                <span>
                <?php
                $count = fetchColumn("SELECT COUNT(*) FROM posts WHERE cid = " . $categoryid . " AND removed = 0");
                $pagescount = ceil($count / $poststodisplay);
                if ($pagescount == 0) {$pagescount++;}

                if($page > 1)        
                {
                    echo '<a href="viewforum.php?id=' . $categoryid . '">First</a> | <a href="viewforum.php?id=' . $categoryid . '&page=' . ($page - 1) . '">Prev</a> | ';
                }        
                echo $page;
                if($page != $pagescount)
                {
                    echo ' | <a href="viewforum.php?id=' . $categoryid . '&page=' . ($page + 1) . '">Next</a> | <a href="viewforum.php?id=' . $categoryid . '&page=' . ($pagescount) . '">Last</a> ';
                }
            
                ?>
                </span>
            </div>

            <?php 
            $query = "SELECT COUNT(*) FROM users";
            $count = fetchColumn($query);
            echo $count . ' total registered players';
            ?>
            <br><br>
        </div>
    </div>
  </body>
</html>