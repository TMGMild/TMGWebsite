<?php

require 'common.php';
$pid = get('pid', 0);
$cid = get('cid', 0);

?>

<html>
    <head>
        <title>Report Sent</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">
                
                <?php
                if ($cid == 1)
                {
                    echo '<h2>The post has been successfully reported</h2>';
                }
                else
                {
                    echo '<h2>The reply has been successfully reported</h2>';
                }
                ?>
                <hr>
                <p class="huge" align="center">
                It's because of people like you that we enjoy a great community. 
                <?php
                if ($cid == 1)
                { 
                    $link = 'forum/viewpost.php?id=' . $pid;
                }
                else
                {
                    $link = 'forum/redirect.php?postid=' . $pid . '&commentid=' . $cid . '&ctd=5';
                } 
                ?>
                <a href="<?php echo $link;?>">Return to the post.</a>
            </div>
        </div>
    </body>
</html>