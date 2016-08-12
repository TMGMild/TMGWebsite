<?php

require 'common.php';
requireAdminOrMod();
$categoryid = get('id', 1);

$categoryname = getCategoryNameFromId($categoryid);
$targetlength = 1 + strlen($categoryid);

$query = "SELECT * FROM categories WHERE LENGTH(id) = " . $targetlength . " AND id LIKE '" . $categoryid . "%'"; //Get categories
$posts = fetchAll($query);
 
if ($categoryid != 1)
{
    $uponeid = substr($categoryid, 0, -1);
    $uponename = getCategoryNameFromId($uponeid);
}

?>


<DOCTYPE html>
<html>
    <head>
        <?php include 'head.php';?>
        <title>Edit Forum Categories</title>
    </head>
    <body>
        <?php include 'nav.php';?>
        <div class="wrapper">
            <div class="content">\
                
                <br>
                <h2>Edit <?php echo getCategoryNameFromId($categoryid);?></h2>
                <hr>
                <?php
                if ($categoryid != 1) 
                {
                ?>
                    <a href="editcategories.php?id=<?php echo $uponeid;?>"><< Return to <?php echo $uponename;?></a>
                    <br><br>
                <?php
                }
                ?>
                <table>
                    <?php
                    foreach ($posts as $post)
                    { ?>
                        <tr>
                            <form action="modifycategory.php?id=<?php echo $post['id'];?>" method="post" style="font-size:18px;">
                                <td style="width:10%;">
                                    <a href="editcategories.php?id=<?php echo $post['id'];?>"><?php echo $post['name'];?></a>
                                </td>
                                <td style="width:5%;">
                                    <a style="font-size:14px;color:red;" href="removecategory.php?id=<?php echo $post['id'];?>">Remove</a>
                                </td>
                                <td style="width:15%;"><input type="text" style="width:100%;background-color:#222222;" name="name" value="<?php echo $post['name'];?>"></td>
                                <td style="width:55%;"><input type="text" style="width:100%;background-color:#222222;" name="desc" value="<?php echo $post['description'];?>"></td>
                                <td style="width:15%;"><input type="submit" style="width:100%;" value="Submit"></td>
                            </form>
                        </tr>
                    <?php 
                    }
                    if (count($posts) != 10)
                    {
                    ?>
                    <tr>
                        <form action="addcategory.php?id=<?php echo $categoryid;?>" method="post" style="font-size:18px;">
                                <td>New Category</td>
                                <td></td>
                                <td><input type="text" style="width:100%;" name="name" placeholder="New Category"></td>
                                <td><input type="text" style="width:100%;" name="desc" placeholder="New description"></td>
                                <td><input type="submit" style="width:100%;" value="Add"></td>
                        </form>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>