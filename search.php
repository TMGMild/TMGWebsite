<?php

require 'common.php';

$searchQuery = get('q', "");
$targetCategory = get('c', 1);

echo $searchQuery;

$query = "SELECT * FROM posts WHERE `cid` LIKE '$targetCategory%' AND MATCH(title) AGAINST('" . addslashes($searchQuery) . ') AND removed = 0 LIMIT 10";

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
                <h1>Search Results</h1>
                <hr>
                <table>
                    <?php
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
                                <a href="viewpost.php?id=' . $pid . '">' . $title . '</a><br>
                                by ' . getUserNameFromId($authorid) . ' in ' . $cname . '<br>' . 
                                timeToString($date) . '
                            <td>
                        </tr>
                        ';
                    }
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>