<?php

require 'common.php';

if(empty($_SESSION['user'])) 
{
    redirect("login.php");
}

?>

<DOCTYPE html>
<html>
    <head>
        <title>Dashboard</title>
        <?php include 'head.php'; ?>
    </head>
    <body>
        <?php include 'nav.php'; ?>
        <div class="wrapper">
            <div class="content">
                <h1>Dashboard</h1>
                <hr>
                <div class="left">
                    <?php include 'modules/dashboard/module_team.php'; ?>
                </div>
                <div class="right">
                    <?php include 'modules/dashboard/module_schedule.php'; ?>            
                </div>
                <div class="left">
                    <?php include 'modules/dashboard/module_standings.php'; ?>
                </div>
                <div class="right">
                    <?php include 'modules/dashboard/module_updates.php'; ?>
                </div>
                <?php 
                if (isCaster())
                {?>
                    <div class="left">
                        <?php include 'modules/module_casters.php'; ?>
                    </div>
                <?php
                }
                ?>                
            </div>
        </div>
    </body>
</html>