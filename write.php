<?php

require 'common.php';
$mode = get('mode', 'new');
$id = get('id', 0);
$e = get('e', 0);

if (!isWriter())
{
    redirect("login.php");
}

if (!empty($_POST))
{
    $title = addslashes($_POST['title']);
    $text = addslashes($_POST['text']);
    $authorid = userID();
    $date = date("Y-m-d H:i:s");
    $tagline = addslashes($_POST['tagline']);
    $image = $_POST['image'];

    if ($mode == 'edit')
    {
        $query = 
        "
        UPDATE news
        SET 
            `title` = '$title',
            `tagline` = '$tagline',
            `text` = '$text',
            `authorid` = $authorid,
            `image` = '$image'
        WHERE `id`=$id
        ";
        execute($query);
        
        redirect("writerdashboard.php");
    }
    else
    {
        $query =
        "
        INSERT INTO news
        (`title`, `tagline`, `text`, `authorid`, `date`, `image`) 
        VALUES ('$title', '$tagline', '$text', $authorid, '$date', '$image');
        ";
        execute($query);
                
        redirect("writerdashboard.php");        
    }
}
else
{
    if ($mode == 'edit')
    {
        $query = "SELECT * FROM news WHERE `id`=$id";
        $row = fetch($query);
        $title = $row['title'];
        $tagline = $row['tagline'];
        $image = $row['image'];
        $text = $row['text'];
    }
}

?>
<DOCTYPE html>
<html>
    <head>
        <title>Write - True Minded Gaming</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">
                <h1>Write</h1>
                <hr>
                <form action="write.php?mode=<?php echo $mode;?>&id=<?php echo $id;?>" method="post">
                    <?php
                    if ($e == 1)
                    {
                        echo '<div class="block block-red center">Your image must be .jpg or .png format.</div><br>';
                    }
                    else if ($e == 2)
                    {
                        echo '<div class="block block-red center">There was an error uploading your image.</div><br>';
                    }?>
                    <input type="text" class="big" style="width:400px;" name="title" 
                    <?php
                    if ($mode == 'edit')
                    {
                        echo 'value="' . $title . '"';
                    }
                    else
                    {
                        echo 'placeholder="Title"';
                    }
                    ?>
                    >
                    <br><br>
                    <input type="text" style="width:500px;" name="tagline" 
                    <?php
                    if ($mode == 'edit')
                    {
                        echo 'value="' . $tagline . '"';
                    }
                    else
                    {
                        echo 'placeholder="Tagline"';
                    }
                    ?>
                    >
                    <br><br>
                    <input type="text" name="image" value="<?php if ($mode == 'edit'){echo $image;}?>" placeholder="Link to thumbnail">
                    <p class="small">PNG or JPG format ONLY. Must be 16:9 ratio.</p>
                    <textarea rows="30" name="text"><?php if ($mode == 'edit') {echo nl2br($text);} ?></textarea>
                    <br><br>
                    <input type="submit" class="big" value="Submit">
                </form>
            </div>
        </div>
    </body>
</html>