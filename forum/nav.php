<div class="nav">
    <div class="menu">
        <div class="menuLeft">
            <a href="../index.php">SITE HOME</a>
            <a href="viewforum.php">FORUM HOME</a>
        </div>
        <div class="menuRight">
            <?php 
            if (loggedIn())
            { ?>
                <a href="../dashboard.php">DASHBOARD</a>
                <a href="../account.php">ACCOUNT</a>
            <?php
                if (isManager())
                {?>
                    <a href="../manage.php">MANAGE</a>
                <?php
                }
                ?>
                <a href="../logout.php">LOGOUT</a>
            <?php
            }
            else
            { ?>
                <a href="../login.php">LOGIN</a>
                <a href="../registeruser.php">SIGN UP</a>
            <?php    
            }
            ?>
        </div>
    </div>
</div>