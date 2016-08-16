<?php
require("common.php");
$poststodisplay = 10;
$page = get('page', 1);
$offset = ($page - 1) * $poststodisplay;
$categoryid = get('id', 1);
$categoryname = getCategoryNameFromId($categoryid);
$targetlength = 1 + strlen($categoryid);

$query = "SELECT * FROM categories WHERE LENGTH(id) = " . $targetlength . " AND id LIKE '" . $categoryid . "%'";
$categories = fetchAll($query);

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
            <h2 class="left inline"><?php echo $categoryname;?></h2>
            <form action="search.php" method="get" style="display:inline;">
                <input type="text" name="q" style="float:right;" placeholder="Search <?php echo $categoryname;?>">
                <input type="submit" style="display:none;">
            </form>
            <hr>
            
            <?php
            if ($categoryid != 1)
            {
            ?>
                <a style="font-size:15px;" href="viewforum.php?id=<?php echo $uponeid;?>"><< Return to <?php echo $uponename; ?></a><br><br>
            <?php
            }
            
            if (count($categories) > 0)
            { 
            ?>
                <h3>Categories</h3>
                <br>
                <table>
                    <?php
                    foreach($categories as $category)
                    {
                    ?>
                        <tr>
                            <td>
                                <a class="huge" href="viewforum.php?id=<?php echo $category['id'];?>"><?php echo $category['name']; ?></a><br>
                                <p class="small gray"><?php echo $category['description']; ?></p>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            <?php
            }
            
            if (count($posts) > 0)
            {
            ?>
                <br>
                <br>
                <h3 class="inline">Posts</h3>
                <?php
                if(loggedIn()) 
                {
                    echo '<a class="button grayScale small" href="newpost.php?id=' . $categoryid . '">New</a><br>';
                }
                ?>

                <table>
                    <?php 
                    foreach($posts as $post)
                    {
                    ?>
                    <tr>
                        <td width="60%">
                            <a class="big" href="viewpost.php?id=<?php echo $post['pid'];?>"><?php echo $post['title']; ?></a>

                            <?php
                            if ($post['stickied'] == 1)
                            {
                            ?> 
                                <span class="notice green">STICKIED</span>
                            <?php 
                            } 
                            ?>
                        </td>
                        <td width="15%">
                            <?php echo echoUserName($post['authorid']);?>
                        </td>
                        <td width="10%">
                            <?php
                            $count = fetchColumn("SELECT COUNT(*) FROM post_" . $post['pid']);
                            echo "Replies: " . ($count - 1);
                            ?>
                        </td>
                        <td width="15%">
                            <?php echo timeToString($post['date']); ?>
                            <br>
                            <?php 
                            if ((isAdminOrMod() && !isAdmin($post['authorid'])) || userID() == $post['authorid'])
                            {
                                echo '<a href="remove.php?postid=' . $post['pid'] . '"><span class="notice red">REMOVE</a></span>';
                            }

                            if (isAdminOrMod() && !(isMod() && isAdmin($post['authorid'])))
                            {
                                if ($post['stickied'] == 1)
                                {
                                    echo '<a href="unsticky.php?postid=' . $post['pid'] . '"><span class="notice green">UNSTICKY</a></span>';
                                }
                                else
                                {
                                    echo '<a href="sticky.php?postid=' . $post['pid'] . '"><span class="notice green">STICKY</span></a>';
                                }?>

                                <span id="<?php echo $post['pid'];?>" style="display:none;">
                                    <br><br>
                                    Move post from <i><?php echo $categoryname;?></i> to 
                                    <form action="move.php?pid=<?php echo $post['pid'];?>" method="post">
                                        <select name="cid" class="small">
                                            <?php
                                            foreach (fetchAll("SELECT `id`,`name` FROM categories") as $category)
                                            {
                                                echo '<option value="' . $category['id'] . '">' . $category['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <br>
                                        <input type="submit" value="Move" class="small"/>
                                    </form>
                                    <br>
                                </span>

                                <a href="javascript:$('#<?php echo $post['pid'];?>').toggle(300)"><span class="notice green">MOVE</span></a>
                                <?php
                            }

                            ?>
                        </td>
                    </tr>
                    <?php 
                    }
                    ?>                
                </table>
            
            <?php
            }
            ?>
            
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
            echo fetchColumn("SELECT COUNT(*) FROM users") . ' total registered players';
            ?>
            <br><br>
        </div>
    </div>
  </body>
</html>