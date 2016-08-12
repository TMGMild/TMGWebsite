<?php
    $excusesuspension = true; //need to allow suspended users to log out
    require("common.php");
    unset($_SESSION['user']);
    redirect("login.php");