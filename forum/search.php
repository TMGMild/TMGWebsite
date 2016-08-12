<?php

require 'common.php';

$searchQuery = get('q', "");
$targetCategory = get('c', 1);
$page = get('page', 1);
$ptd = 8;
$offset = ($page - 1) * $ptd;

$query = "SELECT * FROM posts WHERE `cid` LIKE '$targetCategory%' AND removed = 0 AND (";

$conditions = "";
$keywords = explode(" ", $searchQuery);
foreach ($keywords as $keyword)
{
    $conditions .= "`title` LIKE '%$keyword%' OR ";
}
$conditions = substr($conditions, 0, -4);

$query .= $conditions . ") LIMIT $ptd OFFSET $offset";

$results = fetchAll($query);

?>

<html>
    <head>
        <title>Search Forum - True Minded Gaming</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">
                <a style="font-size:15px;" href="viewforum.php?id=<?php echo $targetCategory;?>"><< Return to <?php echo getCategoryNameFromId($targetCategory); ?></a><br><br>
                <form action="search.php" method="get" style="display:inline;">
                    <input type="text" class="big" style="width:40%;" name="q" value="<?php echo $searchQuery;?>">
                    <input type="submit" class="big" style="margin-left:2px;"value="Search">
                </form>
                <hr>
                <table>
                    <?php
                    if (count($results) > 0)
                    {
                        foreach ($results as $result)
                        {
                            $pid = $result['pid'];
                            $cid = $result['cid'];
                            $cname = getCategoryNameFromId($cid);
                            $title = $result['title'];
                            $authorid = $result['authorid'];
                            $date = strtotime($result['date']);

                            echo
                            '
                            <tr>
                                <td>
                                    <a style="font-size:20px;font-weight:100;" href="viewpost.php?id=' . $pid . '">' . $title . '</a><br>
                                    <span style="font-size:14px;margin-top:10px;">by ' . getUserNameFromId($authorid) . ' in ' . $cname . '<br>' . 
                                    timeToString($date) . '</span>
                                <td>
                            </tr>
                            ';
                        }
                    }
                    else
                    {
                        echo '<tr><td>No results found.</td></tr>';
                    }
                    ?>
                </table>
                <div id="pagenumbers">
                    <span>
                        <?php
                        $newQuery = str_replace("SELECT * ", "SELECT COUNT(*) ", $query);
                        $newQArray = explode(" OFF", $newQuery); 
                        $newQuery = $newQArray[0]; //These two lines get rid of the offset at the end, because we're only getting a count
                        $count = fetchColumn($newQuery);
                        $pagescount = ceil($count / $ptd);

                        if ($pagescount == 0) {$pagescount++;}

                        if($page > 1)        
                        {
                            echo '<a href="search.php?q=' . $searchQuery . '">First</a> | <a href="search.php?q=' . $searchQuery . '&page=' . ($page - 1) . '">Prev</a> | ';
                        }        
                        echo $page;
                        if($page != $pagescount)
                        {
                            echo ' | <a href="search.php?q=' . $searchQuery . '&page=' . ($page + 1) . '">Next</a> | <a href="search.php?q=' . $searchQuery . '&page=' . ($pagescount) . '">Last</a> ';
                        }
            
                        ?>
                    </span>
                </div>
            </div>
        </div>
    </body>
</html>