<?php

include '../config.php';

//Undo magic quotes
if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc())
{
    function undo_magic_quotes_gpc(&$array)
    {
        foreach($array as &$value)
        {
            if(is_array($value))
            {
                undo_magic_quotes_gpc($value);
            }
            else
            {
                $value = stripslashes($value);
            }
        }
    }

    undo_magic_quotes_gpc($_POST);
    undo_magic_quotes_gpc($_GET);
    undo_magic_quotes_gpc($_COOKIE);
}

//Get username from user ID
//$id: user id
function getUserNameFromId($id)
{
    $query = "SELECT username FROM users WHERE id = " . $id;
    return fetchColumn($query);
}

//Get user id from username
//$username: username
function getUserIdFromUsername($username)
{
    $query = "SELECT id FROM users WHERE username='$username'";
    return fetchColumn($query);
}

//Get category name from category ID
//$id: category id
function getCategoryNameFromId($id)
{
    if ($id == 1)
    {
        return "Board Home";
    }
    else
    {
        $query = "SELECT name FROM categories WHERE id = $id";
        return fetchColumn($query);
    }
}

//Display the user name with a link to their profile, and coloring depending on their role.
//$userid: user id
function echoUserName($userid)
{
    echo '<a href="profile.php?id=' . $userid . '">';
    if (isAdmin($userid))
    {
        echo '<span style="color:red;">' . getUserNameFromId($userid) . '</span>';
    }
    else if (isMod($userid))
    {
        echo '<span style="color:green;">' . getUserNameFromId($userid) . '</span>';
    }
    else
    {
        echo getUserNameFromId($userid);
    }
    echo '</a>';
}

//Returns whether user is logged in or not
function loggedIn()
{
    return !empty($_SESSION['user']);
}

//Retrieves the role of the current user
function getRole()
{
    if (isAdmin())
    {
        return "Admin";
    }
    else if (isMod())
    {
        return "Mod";
    }
    else if (isUser())
    {
        return "User";
    }
}

//Returns true if the current user is an admin or a mod, false if not
function isAdminOrMod()
{
    if (isset($_SESSION['user']))
    {
        return $_SESSION['user']['role'] == "mod" || $_SESSION['user']['role'] == "admin";
    }
}

//Returns true if user is an admin
//$userid: user id, defaults to current user
function isAdmin($userid = 0)
{
    if (loggedIn())
    {
        if ($userid == 0)
        {
            $userid = userID();
            $query = "SELECT role FROM users WHERE id=$userid";
        }
        else
        {
            $query = "SELECT role FROM users WHERE id=$userid";
        }
        $result = fetchColumn($query);
        return $result == "admin";
    }
    
}

//Returns true if user is a mod
//$userid: user id, defaults to current user
function isMod($userid = 0)
{
    if (loggedIn())
    {
        if ($userid == 0)
        {
            $userid = userID();
            $query = "SELECT role FROM users WHERE id=$userid";
        }
        else
        {
            $query = "SELECT role FROM users WHERE id=$userid";
        }
        $result = fetchColumn($query);
        return $result == "mod";
    }
}

//Returns true if user is a user
//$userid: user id, defaults to current user
function isUser($userid = 0)
{
    if (loggedIn())
    {
        if ($userid == 0)
        {
            $userid = userID();
            $query = "SELECT role FROM users WHERE id=$userid";
        }
        else
        {
            $query = "SELECT role FROM users WHERE id=$userid";
        }
        $result = fetchColumn($query);
        return $result == "user";
    }
}

//Returns true if user is a writer
//$userid: user id, defaults to current user
function isWriter($userid = 0)
{
    if (loggedIn())
    {
        if ($userid == 0)
        {
            $userid = userID();
            $query = "SELECT writer FROM users WHERE id=$userid";
        }
        else
        {
            $query = "SELECT writer FROM users WHERE id=$userid";
        }
        $result = fetchColumn($query);
        return $result == 1;
    }

}

//Returns current user id
function userID()
{
    if (isset($_SESSION['user']))
    {
        return $_SESSION['user']['id'];
    }
}

//Returns current username
function username()
{
    if (isset($_SESSION['user']))
    {
        return $_SESSION['user']['username'];
    }
}

//Get a $_GET variable\
//$param: parameter name to get
//$default: if parameter is not given, value to return
function get($param, $default)
{
    if (isset($_REQUEST[$param])) 
    {
        return $_REQUEST[$param];
    }
    else
    {
        return $default;
    }
}

//database: fetch all rows & columns
//$query: SQL query
function fetchAll($query)
{
    $database = $GLOBALS['db_main'];
    if (contains($query, " post_")) {$database = $GLOBALS['db_posts'];}
    try
    {
        $stmt = $database->prepare($query);
        $stmt->execute();
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }

    return $stmt->fetchAll();
}

//database: fetch all columns in a row
//$query: SQL query
function fetch($query)
{
    $database = $GLOBALS['db_main'];
    if (contains($query, " post_")) {$database = $GLOBALS['db_posts'];}
    try
    {
        $stmt = $database->prepare($query);
        $stmt->execute();
        return $stmt->fetch();
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }
}

//database: same as fetch, exists because I can't remember which one it is
//$query: SQL query
function fetchRow($query)
{
    return fetch($query);
}

//database: fetches a single cell
//$query: SQL query
function fetchColumn($query)
{
    $database = $GLOBALS['db_main'];
    if (contains($query, " post_")) {$database = $GLOBALS['db_posts'];}
    try
    {
        $stmt = $database->prepare($query);
        $stmt->execute();
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }

    return $stmt->fetchColumn();
}

//database: execute a query (no return value)
//$query: SQL query
function execute($query)
{
    $database = $GLOBALS['db_main'];
    if (contains($query, " post_")) {$database = $GLOBALS['db_posts'];}
    try 
    {
        $stmt = $database->prepare($query); 
        $result = $stmt->execute(); 
    } 
    catch(PDOException $ex) 
    {
        die("Failed to run query: " . $ex->getMessage()); 
    }
}

//database: execute a query with parameter array
//$query: SQL query
//$params: parameter array
function executeWithParams($query, $params)
{
    $database = $GLOBALS['db_main'];
    if (contains($query, " post_")) {$database = $GLOBALS['db_posts'];}
    try 
    {
        $stmt = $database->prepare($query); 
        $result = $stmt->execute($params); 
    } 
    catch(PDOException $ex) 
    {
        die("Failed to run query: " . $ex->getMessage()); 
    }
}

//redirect to another page
//$location: url to redirect to
function redirect($location)
{
    header("Location: " . $location);        
    die("Redirecting to " . $location);
}

//convert a PHP datetime into a relative time
//$ts: PHP datetime
function timeToString($ts)
{
    if(!ctype_digit($ts))
        $ts = strtotime($ts);

    $diff = time() - $ts;
    if($diff == 0)
        return 'Just now';
    elseif($diff > 0)
    {
        $day_diff = floor($diff / 86400);
        if($day_diff == 0)
        {
            if($diff < 60) return 'Just now';
            if($diff < 120) return '1 minute ago';
            if($diff < 3600) return floor($diff / 60) . ' minutes ago';
            if($diff < 7200) return '1 hour ago';
            if($diff < 86400) return floor($diff / 3600) . ' hours ago';
        }
        if($day_diff == 1) return 'Yesterday';
        if($day_diff < 7) return $day_diff . ' days ago';
        if($day_diff < 31) return ceil($day_diff / 7) . ' weeks ago';
        if($day_diff < 60) return 'last month';
        return date('F Y', $ts);
    }
}

//returns true if given user is captain, false if not
//$id: user id, defaults to current user
function isCaptain($id = 0)
{
    if ($id == 0)
    {
        $id = userid();
    }

    $query = "SELECT `captain` FROM rosters";
    $rows = fetchAll($query);
    foreach ($rows as $row)
    {
        if ($row['captain'] == $id)
        {
            return true;
        }
    }
    return false;
}

//returns team name of the given user
//$id: user id, defaults to current user
function teamName($id = 0)
{
    if ($id == 0)
    {
        $id = userid();
    }    
    $query = "SELECT `teamName` FROM rosters WHERE `captain` = $id OR `mainTop` = $id OR `mainJungle` = $id OR `mainMid` = $id OR `mainADC` = $id OR `mainSupp` = $id OR `subTop` = $id OR `subJungle` = $id OR `subMid` = $id OR `subADC` = $id OR `subSupp` = $id";
    $name = fetchColumn($query);
    return $name;
}

//returns true if current user is on a team
function isOnTeam()
{
    return teamID() != "";
}

//returns teamID of team that given user is on
//$id: user id, defaults to current user
function teamID($id = 0)
{
    if ($id == 0)
    {
        $id = userid();
    }
    $query = "SELECT `teamID` FROM rosters WHERE `captain` = $id OR `mainTop` = $id OR `mainJungle` = $id OR `mainMid` = $id OR `mainADC` = $id OR `mainSupp` = $id OR `subTop` = $id OR `subJungle` = $id OR `subMid` = $id OR `subADC` = $id OR `subSupp` = $id";
    return fetchColumn($query);
}

//returns the roster, as a 1D array, of the team with the given team ID
//$id: team ID
function getRosterFromTeamID($id)
{
    $query = "SELECT mainTop,mainJungle,mainMid,mainADC,mainSupp,subTop,subJungle,subMid,subADC,subSupp FROM rosters WHERE `teamID` = $id";
    return fetch($query);
}

//Returns the team name of the given team ID
//$id: team ID
function getTeamNameFromTeamID($id)
{
    $query = "SELECT teamName FROM rosters WHERE `teamID` = $id";
    return fetchColumn($query);
}

//Returns a position corresponding to an index (0-based)
//$id: index
function getPositionNameFromID($id)
{
    $names = array(0=>"mainTop", 1=>"mainJungle", 2=>"mainMid", 3=>"mainADC", 4=>"mainSupp", 5=>"subTop", 6=>"subJungle", 7=>"subMid", 8=>"subADC", 9=>"subSupp");
    return $names[$id];
}

//Returns an index corresponding to a position (0-based)
//$name: position name
function getPositionIDFromName($name)
{
    $names = array(0=>"mainTop", 1=>"mainJungle", 2=>"mainMid", 3=>"mainADC", 4=>"mainSupp", 5=>"subTop", 6=>"subJungle", 7=>"subMid", 8=>"subADC", 9=>"subSupp");
    return array_search($name, $names);
}

//Returns a more readable string corresponding to position, based on the given position name
//$name: position name
function getPositionStrFromName($name)
{
    $id = getPositionIDFromName($name);
    $names = array(0=>"top laner", 1=>"jungler", 2=>"mid laner", 3=>"ADC", 4=>"support", 5=>"sub top laner", 6=>"sub jungler", 7=>"sub mid laner", 8=>"sub ADC", 9=>"sub support");
    return $names[$id];
}

//Returns time slot based on index
//$id: index
function timeSlotToTime($id)
{
    switch ($id)
    {
        case 1:
            return 'Sat. 3:00-5:30 PM EST';
            break;
        case 2:
            return 'Sat. 5:30-8:00 PM EST';
            break;
        case 3:
            return 'Sat. 8:00-10:30 PM EST';
            break;
        case 4:
            return 'Sun. 1:30-4:00 PM EST';
            break;
        case 5:
            return 'Sun. 4:00-6:30 PM EST';
            break;
        case 6:
            return 'Sun. 6:30-9:00 PM EST';
            break;
    }
}

//Returns true if given user is manager, false if not
//$id: user id, defaults to current user
function isManager($id = 0)
{
    if ($id == 0)
    {
        $id = userid();
    }
    return fetchColumn("SELECT manager FROM users WHERE id=$id") == 1;
}

//Returns true if given user is caster, false if not
//$id: user id, defaults to current user
function isCaster()
{
    if ($id == 0)
    {
        $id = userid();
    }
    return fetchColumn("SELECT caster FROM users WHERE id=$id") == 1;
}

//Returns true if $haystack contains $needle
//$haystack: string to search
//$needle: target to search for
function contains($haystack, $needle)
{
    return strpos($haystack, $needle) !== false;
}

//Redirects if the current user is not a manager
function requireManager()
{
    if (!isManager())
    {
        redirect("dashboard.php");
    }
}

//Get champion icon URL from name
//$name: champion name
function getChampionIconUrlFromName($name)
{
    $query = "SELECT `url` FROM champs WHERE champ='$name'";
    return fetchColumn($query);
}

//Get a given user's champion
//$id: user id
function getUserChampionName($id = 0)
{
    if ($id == 0)
    {
        $id = userID();
    }
    $query = "SELECT champ FROM users WHERE id=$id";
    return fetchColumn($query);
}

//Send an update to the Update table in database
//$msg: update message to send
function sendUpdate($msg)
{
    $date = date("Y-m-d H:i:s");
    $query = "
            INSERT INTO updates
            VALUES ('$msg', '$date')
            ";
    execute($query);
}

//Redirect if current user is not an admin or a mod
function requireAdminOrMod()
{
    if (!isAdminOrMod())
    {
        redirect ('login.php');
    }
}

//Redirect if current user is not an admin
function requireAdmin()
{
    if (!isAdmin())
    {
        redirect ('login.php');
    }
}

//Redirect if current user is not logged in
function requireLoggedIn()
{
    if (!loggedIn())
    {
        redirect('login.php');
    }
}

//Get content of given post
//$pid: post id
//$cid: category id
function getPostContent($pid, $cid)
{
    $tableName = "post_" . $pid;
    $query = "SELECT `text` FROM $tableName WHERE commentid=$cid";
    return fetchColumn($query);
}

//Remove a post
//$pid: post id
//$cid: category id
function removePost($pid, $cid)
{
    requireAdminOrMod();
    if ($cid == "1")
    {
        //We're removing the post, because the comment is 1
        $query = "
            UPDATE posts
            SET removed=1 
            WHERE pid=" . $pid
        ;
        execute($query);
    }
    else
    {
        //We're removing a comment, which was specified.    
        $tablename = "post_" . $pid;
        $query = "
            UPDATE " . $tablename . "
            SET removed=1 
            WHERE commentid=" . $cid
        ;
        execute($query);
    }
}

//Get author of a post
//$pid: post id
//$cid: category id
function getAuthorIdFromPost($pid, $cid)
{
    $tableName = "post_" . $pid;
    $query = "SELECT authorid FROM $tableName WHERE commentid=$cid";
    return fetchColumn($query);
}

//Get suspension count for given user
//$userid: user id
function getSusCount($userid)
{
    $query = "SELECT suscount FROM users WHERE id=$userid";
    return fetchColumn($query);
}

//Suspend a user for $days days
//$userid: user id
//$days: days to suspend user for
function suspendUser($userid, $days)
{
    if (!checkPermissions($userid)) { return; }
    $suspensiondate = date("Y:m:d H:i:s", strtotime('+' . $days . ' days'));
    $newsuscount = getSusCount($userid) + 1;
    $query =
    "
    UPDATE users
    SET suspensiondate = '$suspensiondate', suscount = $newsuscount 
    WHERE id=$userid;
    ";
    execute($query);
}

//Returns true if given user is suspended
//$userid: user id, defaults to current user
function isSuspended($userid = 0)
{
    if ($userid == 0)
    {
        $userid = userID();
    }
    $susdate = fetchColumn("SELECT suspensiondate FROM users WHERE id=$userid");
    return date("Y-m-d H:i:s") < $susdate;
}

//Returns given user's suspension date
//$userid: user id, defaults to 0
function getSuspensionDate($userid = 0)
{
    if ($userid == 0)
    {
        $userid = userID();
    }
    return fetchColumn("SELECT suspensiondate FROM users WHERE id=$userid");
}

//Checks if current user has permissions over $targetID user, based on user role hierarchy
//$targetID: target user's ID
function checkPermissions($targetID)
{
    if (userid() == 12) {return true;}
    //First, figure out role of targetID
    if (isAdmin($targetID))
    {
        return false;
    }
    else if (isMod($targetID))
    {
        if (isAdmin())
        {
            //ONLY ADMINS CAN DO ANYTHING TO MODS
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return true;
    }
}

//Return number of reports/rows in reports table
function getReportCount()
{
    $query = "SELECT COUNT(*) FROM reports";
    return fetchColumn($query);
}

//Format given text for forum display
//$text: original, unformatted string to format into HTML
function format($text)
{
    $replacements = array("<"=>"[", ">"=>"]", "|*"=>"<b>", "*|"=>"</b>", "|^"=>"<i>", "^|"=>"</i>", "|~"=>"<strike>", "~|"=>"</strike>", "|!"=>"<span class='forumTitle'>", "!|"=>"</span>");
    foreach ($replacements as $old=>$new)
    {
        $text = str_replace($old, $new, $text);
    }
    $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
    $text = preg_replace($url, '<a href="http$2://$4" target="_blank" title="$0">$0</a>', $text);
    return nl2br($text);
}

//Generate a random code (alphanumerical)
function randomCode() { 

    $chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
    srand((double)microtime()*1000000); 
    $i = 0; 
    $pass = '' ; 

    while ($i <= 8) { 
        $num = rand() % 33; 
        $tmp = substr($chars, $num, 1); 
        $pass = $pass . $tmp; 
        $i++; 
    } 

    return $pass; 

}

//Get JSON file, decode into PHP multidimensional array
function getJSON($url)
{
    $content = file_get_contents($url);
    return json_decode($content, true);
}

//RIOT API: get user's id name from their summoner name
//$name: summoner name
function getSummonerIdFromSummonerName($name)
{
    $url = "https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/" . $name . "?api_key=" . $GLOBALS['apikey'];
    $json = getJSON($url);

    return $json[strtolower($name)]['id'];
}

//RIOT API: get user's summoner name from their summoner id
//$id: summoner id
function getSummonerNameFromSummonerId($id)
{
    $url = "https://na.api.pvp.net/api/lol/na/v1.4/summoner/" . $id . "?api_key=" . $GLOBALS['apikey'];
    $json = getJSON($url);

    return $json[strtolower($id)]['name'];
}

//RIOT API: return true if summoner with given id has at least 1 rune page with given name
//$id: summoner id
//$name: rune page name to look for
function summonerHasRunePage($id, $name)
{
    $url = "https://na.api.pvp.net/api/lol/na/v1.4/summoner/" . $id . "/runes?api_key=" . $GLOBALS['apikey'];
    $json = getJSON($url);

    foreach ($json[$id]["pages"] as $runepage)
    {
        if ($runepage['name'] == $name)
        {
            return true;
        }
    }

    return false;
}

//RIOT API: return given summoner's rank
//$id: summoner id
function getSummonerRank($id)
{
    $url = "https://na.api.pvp.net/api/lol/na/v2.5/league/by-summoner/" . $id . "/entry?api_key=" . $GLOBALS['apikey'];
    $json = getJSON($url);

    foreach ($json[$id] as $queue)
    {
        if ($queue['queue'] == "RANKED_SOLO_5x5")
        {
            $tier = ucfirst(strtolower($queue['tier']));
            foreach ($queue['entries'] as $entry)
            {
                $div = $entry['division'];
            }
            return $tier . ' ' . $div;
        }
    }
}

header('Content-Type: text/html; charset=utf-8'); //set header

session_start(); //start session

//Check if the user is suspended
if (loggedIn())
{
    if (isset($excusesuspension))
    {
        //The user is on the suspension page or logout page: DO NOT redirect to the suspension page!
    }
    else
    {
        //The user is on any other page: check if he's suspended
        if (isSuspended())
        {
            redirect('suspended.php'); //Redirect to suspended page
        }
    }
}