<?php

require 'common.php';
requireAdminOrMod();
$confirmed = get('c', 0);
$id = $_REQUEST['id'];

if ($confirmed == 1)
{
    $query = 
    "
    DELETE FROM categories WHERE `id` = $id;
    ";
    execute($query); //Delete the actual category

    $query = 
    "
    SELECT pid FROM posts WHERE `cid` LIKE '" . $id . "%'
    ";
    $templist = fetchAll($query);
    $list = array();
    foreach ($templist as $temp)
    {
        array_push($list, $temp['pid']);
    } //Get a list of post ids in the category (and subcategories)

    foreach ($list as $postid)
    {
        //foreach post that is in the target category or any of its subcategories
        $query = "DELETE FROM posts WHERE `pid` = $postid";
        execute($query); //removes post from table "posts"

        $query = "DROP TABLE post_$postid";
        execute($query); //delete the table of the post
    }

    $query =
    "
    DELETE FROM categories WHERE `id` LIKE '" . $id . "%'
    ";
    execute($query); //Delete all subcategories

    redirect('editcategories.php?id=' . substr($id, 0, -1));
}
else
{
?>
<html>
    <head>
        <title>Are you sure?</title>
        <?php include 'head.php';?>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">
                <h2>Are you sure?</h2>
                <hr>
                <p class="huge">
                    Are you absolutely sure you want to delete the category "<?php echo getCategoryNameFromId($id);?>"?
                    <b>All of the categories and posts inside of it will also be deleted, never to be seen again.</b> This action is <b>IRREVERSIBLE</b>.
                    <br><br>
                    Are you absolutely sure?
                </p>
                <br>
                <a style="font-size:30px;" href="editcategories.php?id=<?php echo $id;?>">No (cancel)</a>
                <br><br>
                <a style="font-size:14px;font-color:red;" href="removecategory.php?c=1&id=<?php echo $id;?>">Yes, completely obliterate this category, as well as everything inside of it</a>
            </div>
        </div>
        <br><br>
</html>
<?php
}
?>