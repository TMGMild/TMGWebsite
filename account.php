<?php 
    require("common.php"); 
    $e = get('e', 0);

    if(empty($_SESSION['user'])) 
    { 
        redirect("login.php");
    }
    if(!empty($_POST)) 
    {
        $userID = $_SESSION['user']['id'];
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
        { 
            redirect("account.php?e=1");
        }

        if($_POST['email'] != $_SESSION['user']['email']) 
        {
            $row = fetch("SELECT 1 FROM users WHERE email = '" . $_POST['email'] . "'"); 
            if($row) { redirect("account.php?e=2"); }

            $email = $_POST['email'];
            execute("UPDATE users SET email = '$email' WHERE id = $userID");
        }

        execute("UPDATE users SET champ = '" . $_POST['champ'] . "' WHERE id=$userID");

        $_SESSION['user']['email'] = $_POST['email'];
        
        redirect("dashboard.php");
    } 

    $query = "SELECT champ FROM champs";
    $champList = fetchAll($query);
    $champs = array();
    foreach ($champList as $champion)
    {
        array_push($champs, $champion['champ']);
    }
?> 
<DOCTYPE html>
<html>
    <head>
        <title>Update Account</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">
                <h1>Edit Account</h1><hr>
                <form class="center" action="account.php" method="post"> 
                    <?php
                    if ($e == 1)
                    {
                        echo '<div class="block block-red">The email you entered is invalid.</div><br>';
                    }
                    if ($e == 2)
                    {
                        echo '<div class="block block-red">Someone else is using this email.</div><br>';
                    }
                    ?>
                    <span style="font-size:26px;"><?php echo $_SESSION['user']['username']; ?></span>
                    <p class="small">Your summoner name will be updated automatically.</p>
                    <br /><br />
                    <input type="text" class="big" name="email" value="<?php echo htmlentities($_SESSION['user']['email'], ENT_QUOTES, 'UTF-8'); ?>" /> 
                    <br /><br />
                    <select name="champ" class="big">
                        <?php
                        foreach ($champs as $champ)
                        {
                            echo '
                            <option value="' . $champ . '"';
                            if (getUserChampionName() == $champ)
                            {
                                echo ' selected';
                            }
                            echo '>' . $champ . '</option>';
                        }
                        ?>
                    </select>
                    <br /><br />
                    <input type="submit" class="big" value="Update" />
                    <br><br><a class="big" href="changepassword.php">Change my password</a>
                </form>
            </div>
        </div>
    </body>
</html>