<?php

require 'common.php';
//test
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
                    <div class="layout two" style="padding:0;margin:0;width:70%;" id="playerParent">
                        <script src= "http://player.twitch.tv/js/embed/v1.js"></script>
                        <div id="{PLAYER_DIV_ID}"></div>
                        <script type="text/javascript">
                            var playerParent = document.getElementById("playerParent");
                            var options = {
                                width: playerParent.offsetWidth,
                                height: playerParent.offsetWidth * 0.5625,
                                channel: "truemindedgaming", 
                                //video: "{VIDEO_ID}"       
                            };
                            var player = new Twitch.Player("{PLAYER_DIV_ID}", options);
                            player.setVolume(0.5);
                        </script>
                    </div>
                    <div class="layout two" style="padding:0;margin:0;width:30%;">    
                        <iframe frameborder="0" scrolling="no" src="http://twitch.tv/truemindedgaming/chat?popout=" style="width:100%;" id="chat">
                        </iframe>
                    </div>
                    <script>
                    var chat = document.getElementById("chat");
                    chat.height = (playerParent.offsetWidth * 0.56525) + 3;
                    </script>
                    <hr>
                <?php   
                }
                ?>
                <div>
                    <?php
                    foreach ($articles as $article)
                    {?>
                        <div class="layout news">
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