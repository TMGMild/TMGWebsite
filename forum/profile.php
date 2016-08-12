<?php
require 'common.php';
$profileID = get('id', userID());

if (!loggedIn())
{
    redirect("login.php");
}
?>

<html>
    <head>
        <title>My Profile</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="container">
            <span><h1 class="big inline"><?php echo getUserNameFromId($profileID);?></h1> <div class="spacer"></div> <h2 class="inline big"><?php echo getRole();?></h2></span>
            <hr>
            <div class="left">
                <h2>Recent Posts</h2>
                <table>
                    <tr>
                        <td>Test</td>
                    </tr>
                </table>
            </div>
            <div class="right">
                <h2>User Info</h2>
                <table>
                    <tr>
                        <td>Test</td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>