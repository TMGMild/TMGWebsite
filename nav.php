<div class="nav">
    <div class="menu">
        <div class="menuleft">
            <a href="index.php">HOME</a>
            <a href="about.php">ABOUT</a>
            <a href="schedule.php">SCHEDULE</a>
            <a href="teams.php">TEAMS</a>
            <a href="standings.php">STANDINGS</a>
            <a href="forum/viewforum.php">FORUM</a>
            <a href="donate.php" style="color:#ff6666;">CONTRIBUTE</a>
        </div>
        <div class="menuright">
            <?php 
            if (loggedIn())
            { ?>
                <a href="profile.php?id=<?php echo userid();?>" style="font-family:Josefin Sans;color:#bababa;"><?php echo strtoupper(username());?></a>
                <a href="dashboard.php">DASHBOARD</a>
                <?php
                if (isManager())
                {?>
                    <a href="manage.php">MANAGE</a>
                <?php
                }
                if (isAdminOrMod())
                { ?>
                    <a href="moderate.php">MODERATE</a>
                <?php
                }
                if (isWriter())
                {?>
                    <a href="writerdashboard.php">WRITE</a>
                <?php
                }
                if (isAdmin())
                { ?>
                    <a href="staff.php">STAFF</a>
                <?php
                }
                ?>
                <a href="account.php">ACCOUNT</a>
                <a href="logout.php">LOGOUT</a>
                <?php
            }
            else
            { ?>
                <a href="login.php">LOGIN</a>
                <a href="register.php">REGISTER</a>
            <?php    
            }
            ?>
        </div>
    </div>
</div>