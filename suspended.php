<?php

$excusesuspension = true;
require 'common.php';
$date = date('F jS, Y \a\t g:ia', strtotime(getSuspensionDate()));

if (!isSuspended())
{
    redirect('dashboard.php');
}

?>

<html>
    <head>
        <title>Suspended</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <div class="wrapper">
            <div class="content">
                <div style="min-height:40px;"></div>
                <div style="clear:both;"></div>
                <br>
                <a style="padding:8px;border:1px solid white;text-transform:uppercase;margin:0;color:white;" href="logout.php">Logout</a>
                <br>
                <br>
                <p style="font-size:24px;font-weight:100;">
                <?php
                if (getSuspensionDate() < date('Y-m-d H:i:s', strtotime('+1000 days')))
                {
                    echo username() . 
                    ', <br><br>

                    You are suspended from signing into True Minded Gaming\'s website and forum, or participating in any of its leagues until ' . $date . '. 
                    We assure you that your suspension was not an easy decision to make, and was not taken lightly. We hope that during this time, 
                    you will reconsider the actions which lead to this suspension. The community is confident that you will return with a newfound 
                    motivation to make it more positive.<br><br>

                    Best,<br>
                    True Minded Gaming
                    ';
                }
                else
                {
                    echo username() . 
                    ',<br><br>

                    You are suspended indefinitely from signing into True Minded Gaming\'s website and forum, or participating in any of its leagues. 
                    We assure you that very much thought and consideration was put into this decision, and it was not an easy one to make. We hope 
                    that you will reconsider your actions which lead to this suspension. <br><br>

                    If you are unsure what lead to your ban, or would like to discuss it, please contact Mild@truemindedgaming.com. It is unlikely your 
                    ban will be repealed, but we hope to provide you with a complete understanding of exactly why you were suspended.<br><br>

                    We hope that this will serve as a helpful lesson to you, and that in the future, you will treat everyone with dignity and respect.
                    <br><br>

                    Best regards,<br>
                    True Minded Gaming
                    ';
                }
                ?>
                </p>
            </div>
        </div>
</html>