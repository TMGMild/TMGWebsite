<?php 
require 'common.php'; 

requireManager();

?>
<DOCTYPE html>
<html>
    <head>
        <title>Manage</title>
        <?php include 'head.php'; ?>
    </head>
    <body>
        <?php include 'nav.php'; ?>
        <div class="wrapper">
            <div class="content">
                <h1>Manage</h1>
                <hr>
                <div class="layout two">
                    <?php include 'modules/manage/module_results.php'; ?>
                </div>
                <div class="layout two">
                    <?php include 'modules/manage/module_staffapplications.php'; ?>
                </div>
                <div class="layout full">
                    <?php include 'modules/manage/module_schedule.php'; ?>
                </div>
                <?php 
                if (isCaster())
                {?>
                    <div class="layout two">
                        <?php include 'modules/module_casters.php'; ?>
                    </div>
                    <div class="layout two">
                        <?php include 'modules/manage/module_chooseCasters.php'; ?>
                    </div>
                    <div class="layout two">
                        <?php include 'modules/manage/module_teams.php'; ?>
                    </div>
                <?php
                }
                else
                {?>
                    <div class="layout two">
                        <?php include 'modules/manage/module_chooseCasters.php'; ?>
                    </div>
                    <div class="layout two">
                        <?php include 'modules/manage/module_teams.php'; ?>
                    </div>
                <?php
                }
                ?>

            </div>
        </div>
    </body>
</html>