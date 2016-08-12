<?php

require 'common.php';

if (isset($_GET['code']))
{    
    $code = $_GET['code'];
}

if (!empty($_POST))
{
    $query = "SELECT email FROM forgotpassword WHERE code = '$code'";
    $email = fetchColumn($query);

    $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));        
    $password = hash('sha256', $_POST['password'] . $salt);        
    for($round = 0; $round < 65536; $round++) 
    { 
        $password = hash('sha256', $password . $salt); 
    }

    $query = "UPDATE users SET password = '$password', salt = '$salt' WHERE email = '$email'";
    execute($query);

    redirect("login.php");
}
else
{?>
    
<html>
    <head>
        <title>Reset Password</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">
                <h2>Reset Password</h2>
                <hr>
                <form class="center" action="resetpassword.php?code=<?php echo $code;?>" method="post">
                    <input type="password" name="password">
                    <input type="submit" value="Update Password">
                </form>
            </div>
        </div>
    </body>
</html>
<?php
}
?>