<?php

$query = "SELECT * FROM staff ORDER BY id";
$staff = fetchAll($query);

?>

<p style="text-align:center;">We're always looking for new staff. Interested in working with us? <a href="apply.php">Tell us</a>.</p>
<br><br>
<hr>
<?php
foreach ($staff as $staffMember)
{
?>
    <div class="tile">
        <img src="<?php echo getChampionIconUrlFromName(getUserChampionName($staffMember['id']));?>">
        <br>
        <a href="profile.php?id=<?php echo $staffMember['id'];?>"><?php echo getUsernameFromId($staffMember['id']);?></a>
        <br>
        <span><?php echo $staffMember['positions'];?></span>
    </div>
<?php
}
?>