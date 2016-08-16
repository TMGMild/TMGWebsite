<?php

require 'common.php';
requireAdmin();

?>

<html>
    <head>
        <title>Staff - True Minded Gaming</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">
                <h1>Staff</h1>
                <hr>
                <div class="updater green" id="updater"></div>
                <table id="staff">
                    
                </table>
            </div>
        </div>
        <script>
        loadStaff();
        </script>
    </body>
</html>