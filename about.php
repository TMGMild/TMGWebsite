<?php
require 'common.php';
$page = get('p', 'season');
?>
<DOCTYPE html>
<html>
    <head>
        <title>About the TMG Series</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">
                <div class="subMenu">
                    <a style="width:calc(25% - 1px);" href="about.php?p=season"><span>The Season</span></a><a style="width:calc(25% - 1px);" href="about.php?p=schedule"><span>The Schedule</span></a><a style="width:calc(25% - 1px);" href="about.php?p=rules"><span>The Rules</span></a><a style="width:calc(25% - 1px);" href="about.php?p=staff"><span>The Staff</span></a>
                </div>
                <br><br>
                <?php include 'about/' . $page . '.php';?>
            </div>
        </div>
    </body>
</html>