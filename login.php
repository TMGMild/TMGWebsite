<?php

    require("common.php"); 
     
    $submitted_username = '';
    $login_ok = false;
    $e = get('e', "");
    
     
    if(!empty($_POST)) 
    {
        $query = " 
            SELECT * 
            FROM users 
            WHERE ";

        if (filter_var($_POST['username'], FILTER_VALIDATE_EMAIL))
        {
            $query .= "email = '" . $_POST['username'] . "'";
        }
        else
        {
            $query .= "username = '" . $_POST['username'] . "'";
        }       
        
        $row = fetch($query);         
        
        if($row) 
        {
            $check_password = hash('sha256', $_POST['password'] . $row['salt']); 
            for($round = 0; $round < 65536; $round++) 
            { 
                $check_password = hash('sha256', $check_password . $row['salt']); 
            } 
             
            if($check_password === $row['password']) 
            {
                $login_ok = true; 
            } 
        } 
        
        if($login_ok) 
        {
            $name = getSummonerNameFromSummonerId($row['summonerid']);
            $query = "UPDATE users SET username = '$name' WHERE id = " . $row['id'];
            execute($query);
            $row['username'] = $name;

            unset($row['salt']); 
            unset($row['password']); 
            
            $_SESSION['user'] = $row; 
            
            if (isManager())
            {
                redirect("manage.php");
            }
            else
            {
                redirect("dashboard.php");
            }
        } 
        else 
        {
            redirect("login.php?e=1");
        } 
    } 
     
?> 
<html>
    <head>
        <title>Login</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php'; ?>
        <div class="wrapper">
            <div class="content">
                <h1 class="center">Login</h1><br>
                <form class="center" action="login.php" method="post">
                    <?php
                    if ($e == 1)
                    {
                        echo '<div class="block block-red center">Login failed.</div><br>';
                    }
                    ?>
                    <input type="text" class="big" name="username" placeholder="Username"/> 
                    <br /><br />
                    <input type="password" class="big" name="password" placeholder="Password" value="" /> 
                    <br /><br /> 
                    <input type="submit" value="Login" class="big"/>
                    <br><br>
                    <a style="font-size:16px;" href="forgotpassword.php">Forgot password?</a>
                </form>
            </div>
        </div>
    </body>
</html>