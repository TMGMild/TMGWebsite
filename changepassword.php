<?php

require 'common.php';
$e = get('e',0);

if(empty($_SESSION['user'])) 
{ 
    redirect("login.php");
}

if(!empty($_POST['password'])) 
{ 
    $login_ok = false;

    $query = " 
            SELECT 
                id, 
                username, 
                password, 
                salt, 
                email,
                role,
                manager,
                writer
            FROM users 
            WHERE 
                username = '" . username() . "'";

    $row = fetch($query);
    
    $check_password = hash('sha256', $_POST['currentpass'] . $row['salt']); 
    for($round = 0; $round < 65536; $round++) 
    { 
        $check_password = hash('sha256', $check_password . $row['salt']); 
    } 
             
    if($check_password === $row['password']) 
    {
        $login_ok = true; 
    }
        
    if($login_ok) 
    {
        unset($row['salt']); 
        unset($row['password']); 
            
        $_SESSION['user'] = $row;

        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
        $password = hash('sha256', $_POST['password'] . $salt); 
        for($round = 0; $round < 65536; $round++) 
        { 
            $password = hash('sha256', $password . $salt); 
        }
        $query = " 
            UPDATE users 
            SET `password` = '$password', `salt` = '$salt'
            WHERE id = " . userID();
         
        execute($query);
    } 
    else 
    {
        redirect("changepassword.php?e=1");
    }

    redirect("dashboard.php");
}
?>
<DOCTYPE html>
<html>
    <head>
        <title>Change Password</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">
                <h1>Change Password</h1><hr>
                <form class="center" action="changepassword.php" method="post"> 
                    <?php
                    if ($e == 1)
                    {
                        echo '<div class="block block-red">The password you entered is incorrect.</div><br>';
                    }
                    ?>
                    <input type="password" class="big" name="currentpass" placeholder="Current password" />
                    <br /><br />
                    <input type="password" class="big" name="password" placeholder="New password" /> 
                    <br /><br />
                    <input type="submit" class="big" value="Update" />
                </form>
            </div>
        </div>
    </body>
</html>