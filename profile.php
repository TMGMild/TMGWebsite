<?php

require 'common.php';
$id = get('id', 12);

$user = fetchRow("SELECT * FROM users WHERE id=$id");
$username = $user['username'];
$summonerid = $user['summonerid'];
$role = $user['role'];
$manager = $user['manager'] == 1;
$writer = $user['writer'] == 1;
$caster = $user['caster'] == 1;
$streamer = $user['streamer'] == 1;

if (teamName($id))
{
    $teamName = teamName($id);
}
else
{
    $teamName = "";
}

$posts = fetchAll("SELECT * FROM posts WHERE authorid=$id AND removed=0 LIMIT 6");

?>

<html>
    <head>
        <title><?php echo $username;?>'s Profile - True Minded Gaming</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">
                <span style="font-size:100px;font-weight:100;"><?php echo $username;?></span> &nbsp;&nbsp;&nbsp; 
                <span style="font-size:28px;font-weight:100;">
                    <?php echo getSummonerRank($summonerid);?>
                    <?php echo $teamName; ?> &bull; 
                    <?php echo ucfirst($role);?>
                    <?php if ($manager) { echo ' &bull; League Manager'; } ?>
                    <?php if ($writer) { echo ' &bull; Writer'; } ?>
                    <?php if ($caster) { echo ' &bull; Caster'; } ?>
                    <?php if ($streamer) { echo ' &bull; Streamer'; } ?>
                </span>
                <hr style="margin-top:0;">
                <h1>Recent Posts</h1>
                <table>
                    <?php
                    foreach ($posts as $post)
                    {
                    $content = fetchColumn("SELECT `text` FROM post_" . $post['pid'] . " WHERE commentid=1");
                    if (strlen($content) > 1000) {$content = substr($content, 0, 399) . '...';}
                    ?>
                        <tr>
                            <td style="margin:40px;">
                                <br>
                                <a href="forum/viewpost.php?id=<?php echo $post['pid'];?>" style="font-size:22px;font-weight:100;"><?php echo $post['title']; ?></a> 
                                &nbsp; 
                                <i><a href="forum/viewforum.php?id=<?php echo $post['cid'];?>"><?php echo getCategoryNameFromId($post['cid']);?></a>, <?php echo timeToString($post['date']);?></i><br>
                                <p style="margin-top:5px;"><?php echo $content; ?></p>
                                <br>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>