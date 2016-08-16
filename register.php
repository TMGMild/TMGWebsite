<?php 

    require("common.php");
    $e = get('e', "");
    
    if(!empty($_POST)) 
    {
        $code = $_POST['code'];

        if(empty($_POST['username'])) { redirect("register.php?e=3&code=$code"); }
        if(empty($_POST['password'])) { redirect("register.php?e=4&code=$code"); } 
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { redirect("register.php?e=5&code=$code"); }
        
        $row = fetch("SELECT 1 FROM users WHERE username='" . $_POST['username'] . "'");        
        if($row) { redirect("register.php?e=1&code=$code"); }
        
        $row = fetch("SELECT 1 FROM users WHERE email='" . $_POST['email'] . "'");
        if($row) { redirect("register.php?e=2&code=$code"); }

        $id = getSummonerIdFromSummonerName(str_replace(' ', '', $_POST['username']));
        if (!summonerHasRunePage($id, $code))
        {
            redirect("register.php?e=6&code=$code");
        }
        else
        {
            $summonerid = getSummonerIdFromSummonerName(str_replace(' ', '', $_POST['username']));
        }
        
        $query = " 
            INSERT INTO users ( 
                username, 
                summonerid, 
                password, 
                salt, 
                email,
                role
            ) VALUES ( 
                :username, 
                :summonerid, 
                :password, 
                :salt, 
                :email,
                :role
            ) 
        ";        
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); $password = hash('sha256', $_POST['password'] . $salt);        
        for($round = 0; $round < 65536; $round++) { $password = hash('sha256', $password . $salt); }
        $query_params = array( 
            ':username' => $_POST['username'], 
            ':summonerid' => $summonerid, 
            ':password' => $password, 
            ':salt' => $salt, 
            ':email' => $_POST['email'],
            ':role' => "user"
        ); 
         
        executeWithParams($query, $query_params);
         
        redirect("login.php"); 
    }

    if (isset($_GET['code']))
    {
        $code = $_GET['code'];
    }
    else
    {
        $code = 'TMG' . randomCode();
    }
?> 
<html>
    <head>
        <title>Register</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php'; ?>
        <div class="wrapper">
            <div class="content">
                <h1 class="center">Register</h1><br>
                <?php
                if ($e == 1)
                {
                    echo '<div class="block block-red">Someone else is using this username. If the username you entered is your LoL Summoner Name, please contact Mild.</div><br>';
                }
                else if ($e == 2)
                {
                    echo '<div class="block block-red">Oops! This email is already in use.</div><br>';
                }
                else if ($e == 3)
                {
                    echo '<div class="block block-red">Oops! You need to enter a username.</div><br>';
                }
                else if ($e == 4)
                {
                    echo '<div class="block block-red">Oops! You need to enter a password.</div><br>';
                }
                else if ($e == 5)
                {
                    echo '<div class="block block-red">Oops! The email you provided is invalid.</div><br>';
                }
                else if ($e == 6)
                {
                    echo '<div class="block block-red">We couldn\'t find any Rune Pages under the summoner name you provided. Sometimes, changes to Rune Page names will take a minute or so to register. Thanks for being patient.</div><br>';
                }
                ?>
                <form class="center" action="register.php" method="post"> 
                    <p style="font-size:18px;">Please change the name of any of your rune pages to the following: <b><?php echo $code;?></b></p>
                    <input type="text" class="big" name="username" placeholder="Summoner Name" />
                    <br>
                    <input type="hidden" name="code" value="<?php echo $code;?>" />
                    <br>
                    <input type="text" class="big" name="email" placeholder="Email" /> 
                    <br /><br />
                    <input type="password" class="big" name="password" placeholder="Password" /> 
                    <br /><br /> 
                    <input type="submit" class="big" value="Register" /> 
                </form>
                <br>
            </div>
        </div>
    </body>
</html>