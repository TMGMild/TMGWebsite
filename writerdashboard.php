<?php

require 'common.php';
$page = get('page', 1);
$atd = 15; //articles to display
$offset = ($page - 1) * $atd;

$query = "SELECT * FROM news WHERE authorid=" . userID() . " ORDER BY `date` DESC LIMIT $atd OFFSET $offset";
$articles = fetchAll($query);

$count = fetchColumn("SELECT COUNT(*) FROM news WHERE authorid=" . userID());
$pagescount = ceil($count / $atd);

?>

<DOCTYPE html>
<html>
    <head>
        <title>Writer's Dashboard</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">
                <h1>Writer's Dashboard</h1>
                <hr>
                <a class="button big" href="write.php">New Article</a>
                <br><br>
                <table>
                    <tr>
                        <td>Title</td>
                        <td>Written</td>
                        <td>Options</td>
                    </tr>
                    <?php
                    if (count($articles) > 0)
                    {
                        foreach ($articles as $article)
                        {?>
                            <tr>
                                <td style="font-size:24px;"><a href="write.php?mode=edit&id=<?php echo $article['id'];?>"><?php echo $article['title'];?></a></td>
                                <td><?php echo timeToString($article['date']);?></td>
                                <td><a href="article.php?id=<?php echo $article['id'];?>">View</a> | <a href="write.php?mode=edit&id=<?php echo $article['id'];?>">Edit</a></td>
                            </tr>
                        <?php
                        }
                    }
                    else
                    {
                        echo "<tr><td>You haven't written anything yet. <a href='write.php'>Click here</a> to write your first article.<td><td></td><td></td></tr>";
                    }
                    ?>
                </table>
                <div id="pagenumbers">
                    <span>
                    <?php
                    if($page > 1)        
                    {
                        echo '<a class="foreblack" href="writerdashboard.php">First</a> | <a class="foreblack" href="writerdashboard.php?page=' . ($page - 1) . '">Prev</a> | ';
                    }        
                    echo $page;
                    if($page != $pagescount)
                    {
                        echo ' | <a class="foreblack" href="writerdashboard.php?page=' . ($page + 1) . '">Next</a> | <a class="foreblack" href="writerdashboard.php?page=' . ($pagescount) . '">Last</a> ';
                    }
                    ?>
                    </span>
                </div>
            </div>
        </div>
    </body>
</html>