<?php

require 'common.php';
requireAdminOrMod();
$page = get('p', 'Reports');
$pageName = $page;
$page = strtolower(str_replace(' ', '', $page)) . '.php';

?>

<html>
    <head>
        <title><?php echo $pageName;?> - Moderate</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">
                <div class="subMenu">
                    <a style="width:33%;" href="moderate.php?p=Category%20Manager"><span>Category Manager</span></a><a style="width:33%;" href="moderate.php?p=Reports"><span>Reports (<?php echo getReportCount();?>)</span></a><?php
                    if (isAdmin())
                    { ?><a style="width:33%;" href="moderate.php?p=User%20Panel"><span>User Panel</span></a>
                    <?php
                    } ?>
                </div>
                <br><br>
                <?php include $page;?>
            </div>
        </div>
    </body>
</html>