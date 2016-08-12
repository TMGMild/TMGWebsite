<?php

require 'common.php';

$query = "SELECT * FROM news ORDER BY `date` DESC LIMIT 4";
$articles = fetchAll($query);

?>

<DOCTYPE html>
<html>
    <head>
        <title>True Minded Gaming</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">
                <h1 style="font-size:80px;font-weight:300;">TRUE MINDED GAMING</h1>
                <hr>
                <?php                
                if (date('H') > 12 && date('H') < 20 && (date('w') == 6 || date('w') == 0)) { ?>
                    <div class="left bare">
                        <script src= "http://player.twitch.tv/js/embed/v1.js"></script>
                        <div id="{PLAYER_DIV_ID}"></div>
                        <script type="text/javascript">
                            var options = {
                                width: 1150,
                                height: 647,
                                channel: "truemindedgaming", 
                                //video: "{VIDEO_ID}"       
                            };
                            var player = new Twitch.Player("{PLAYER_DIV_ID}", options);
                            player.setVolume(0.5);
                        </script>
                    </div>
                    <div class="right bare" style="width:406px;background-color:white;">    
                        <iframe frameborder="0" scrolling="no" src="http://twitch.tv/truemindedgaming/chat?popout=" height="647" width="406">
                        </iframe>
                    </div>
                    <hr>
                <?php   
                }
                ?>
                <div class="news">
                    <?php
                    foreach ($articles as $article)
                    {?>
                        <div class="slider">
                            <a href="article.php?id=<?php echo $article['id'];?>"><img src="<?php echo $article['image'];?>" alt="">
		                    <div id="group">
			                    <div id="title"><?php echo $article["title"];?></div>
			                    <div id="description"><?php echo $article["tagline"];?></div>
		                    </div>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>