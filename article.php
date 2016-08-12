<?php

require 'common.php';
$id = get('id', 1);

$query = "SELECT * FROM news WHERE id=$id";

$row = fetchRow($query);

if ($row)
{
    $id = $row['id'];
    $title = $row['title'];
    $authorid = $row['authorid'];
    $date = $row['date'];
    $text = nl2br($row['text']);
    ?>

    <DOCTYPE html>
    <html>
        <head>
            <title><?php echo $title . ' - True Minded Gaming';?></title>
            <?php include 'head.php';?>
        </head>
        <body>
            <?php include 'nav.php';?>
            <div class="wrapper">
                <div class="content">
                    <h1 style="text-align:left;"><?php echo $title;?></h1>
                    <?php echo 'By ' . getUserNameFromId($authorid) . ', ' . timeToString($date);
                    if ($authorid == userID())
                    {
                        echo ' (<a href="write.php?mode=edit&id=' . $id . '">edit</a>)';
                    }
                    ?>
                    <hr>
                    <p style="font-family:'Didact Gothic';font-size:18px;"><?php echo $text;?></p>
                </div>
            </div>
        </body>
    </html>

<?php
} 
else {
?>
    <DOCTYPE html>
    <html>
        <head>
            <title>No Article Found - True Minded Gaming</title>
            <?php include 'head.php';?>
        </head>
        <body>
            <?php include 'nav.php';?>
            <div class="wrapper">
                <div class="content">
                    <h1>No Article Found</h1>
                    <hr>
                    <p>No article has been found.</p>
                </div>
            </div>
        </body>
    </html>
<?php
}
?>

