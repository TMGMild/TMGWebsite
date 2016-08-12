<?php

require 'common.php';

?>

<html>
    <head>
        <?php include 'head.php';?>
        <title>Contribute to True Minded Gaming</title>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">
                <h2 style="font-size:100px;">Make a Difference</h2>
                <p align="center" style="font-size:28px;font-weight:100;">We're a nonprofit, and we run entirely in thanks to <span style="font-weight:400">you</span>.</p>
                <hr>
                <div style="float:left;width:calc(50% - 2px);min-height:200px;border-right:1px solid #cccccc;text-align:center;">
                    <h2>Make a One-Time Contribution</h2>
                    <p style="font-size:20px;font-weight:100;">Contribute any amount, one-time, via PayPal.</p>
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
                        <input type="submit" class="fancy" name="submit" value="Contribute via PayPal" style="margin-top:8px;">
                    </form>
                </div>
                <div style="float:left;width:50%;min-height:200px;text-align:center;">
                    <h2>Make a Monthly Pledge</h2>
                    <p style="font-size:20px;font-weight:100;">Make a recurring monthly contribution via Patreon, and receive rewards.</p>
                    <br>
                    <a href="https://www.patreon.com/user?u=3804953" class="fancy" target="_blank">Contribute via Patreon</a>
                </div>
            </div>
        </div>
    </body>
</html>