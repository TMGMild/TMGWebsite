<?php

require 'common.php';

$r = get('r', 0);

if (!empty($_POST))
{
    $code = substr(md5(uniqid(mt_rand(), true)) , 0, 36);
    $link = "http://www.truemindedgaming.com/resetpassword.php?code=$code";
    $email = $_POST['email'];
    $query = "SELECT 1 FROM forgotpassword WHERE email = '$email'";
    $row = fetchRow($query);
    if ($row)
    {
        $query = "DELETE FROM forgotpassword WHERE email = '$email'";
        execute($query);
    }
    $query = "INSERT INTO forgotpassword VALUES('$email', '$code')";
    execute($query);

    $query = "SELECT username FROM users WHERE email = '$email'";
    $username = fetchColumn($query);

    require_once "Mail.php";

    $from = "True Minded Gaming <noreply@truemindedgaming.com>";
    $to = "<$email>";
    $subject = "Forgot password";
    $body = "$username, \r\n \r\nApparently, you've forgotten your password. If this was indeed you, you can reset your password here: $link. Have an extraordinary day. \r\n \r\nYour fellow gamers, \r\nTrue Minded Gaming";

    $host = "mail.truemindedgaming.com";
    $username = "noreply@truemindedgaming.com";
    $password = "!N0Reply1";
    $headers = array ('From' => $from,
      'To' => $to,
      'Subject' => $subject);
    $smtp = Mail::factory('smtp',
      array ('host' => $host,
        'auth' => true,
        'username' => $username,
        'password' => $password));

    $mail = $smtp->send($to, $headers, $body);

    redirect("forgotpassword.php?r=1");
}
else
{
?>

<html>
    <head>
        <title>Forgot Password</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">
                <h2>Forgot your password? We've got your back.</h2>
                <hr>
                <form class="center" action="forgotpassword.php" method="post">
                    <?php 
                    if ($r == 1)
                    {
                        echo '<div class="block block-green center" style="margin-top:0;">Email successfully sent.</div><br>';
                    }?>
                    <input type="text" name="email" placeholder="Email">
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </body>
</html>

<?php
}
?>