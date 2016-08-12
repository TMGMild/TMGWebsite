<?php 

    require("common.php");
    $e = get('e', "");
    
    if(!empty($_POST)) 
    {
        if($_POST['code'] != "RvJ5MS6C3UUGZFTf9WzsQUubGYK2RhJB")
        {
            redirect("registercaptain.php?e=6");
        }
        if(empty($_POST['username']))
        {
            redirect("registercaptain.php?e=3");
        } 

        if(empty($_POST['password']))
        {
            redirect("registercaptain.php?e=4");
        } 

        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            redirect("registercaptain.php?e=5");
        }
        
        //Check if the username exists
        $query = "SELECT 1 FROM users WHERE username='" . $_POST['username'] . "'";
        $row = fetch($query);        
        if($row) 
        {
            redirect("registercaptain.php?e=1");
        }
        
        //Check if the email is in use
        $query = "SELECT 1 FROM users WHERE email='" . $_POST['email'] . "'";
        $row = fetch($query);
        if($row) 
        { 
            redirect("registercaptain.php?e=2"); 
        }
        
        //Finally, add the user!
        $query = " 
            INSERT INTO users ( 
                username, 
                password, 
                salt, 
                email,
                role
            ) VALUES ( 
                :username, 
                :password, 
                :salt, 
                :email,
                user
            ) 
        ";        
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));        
        $password = hash('sha256', $_POST['password'] . $salt);        
        for($round = 0; $round < 65536; $round++) 
        { 
            $password = hash('sha256', $password . $salt); 
        }        
        $query_params = array( 
            ':username' => $_POST['username'], 
            ':password' => $password, 
            ':salt' => $salt, 
            ':email' => $_POST['email']
        ); 
         
        executeWithParams($query, $query_params);

        $teamID = $_POST['team'];
        $query = "UPDATE rosters
                SET `captain` = '" . $_POST['username'] . "'
                WHERE `teamID` = " . $teamID;
        echo $query;
        execute($query);
         
        redirect("login.php"); 
    } 

    else
    {
        $query = "SELECT teamID,teamName FROM rosters";
        $teams = fetchAll($query);
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
                <h1>Claim Your Team</h1> <hr>
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
                    echo '<div class="block block-red">The code you entered is incorrect.</div><br>';
                }
                ?>            
                <form action="registercaptain.php" method="post" class="center">
                    <input type="text" class="big" name="username" placeholder="Summoner name">
                    <br>
                    <p class="small">Your account will be terminated if you use a username that is not your current Summoner Name.</p>
                    <br>
                    <select name="team" class="big">
                        <?php foreach ($teams as $team):?>
                        <option value="<?php echo $team['teamID'];?>"><?php echo $team['teamName'];?></option>
                        <?php endforeach; ?>
                    </select>
                    <br>
                    <p class="small">You will be permanently banned from the League if you claim a team that you do not own.</p>
                    <br>
                    <input type="text" name="code" placeholder="Captain's code" class="big">
                    <br>
                    <p class="small">Contact Mild for this information.</p>
                    <br>
                    <input type="text" name="email" placeholder="Email" class="big"> 
                    <br>
                    <input type="password" name="password" placeholder="Password" class="big"> 
                    <br><br>
                    <input type="submit" value="Register" class="big"/> 
                </form>
            </div>
        </div>
    </body>
</html>