<p style="text-align:center;">We're always looking for new staff. Interested in working with us? <a href="apply.php">Tell us</a>.</p>
<br><br>
<h2>Administrators</h2>
<hr>
<div class="staffprofile">
    <img src="<?php echo getChampionIconUrlFromName(getUserChampionName(16));?>">
    <br>
    <span class="fontNormal">Cone</span>
    <br>
    <span class="light">Owner</span>
</div>
<div class="staffprofile">
    <img src="<?php echo getChampionIconUrlFromName(getUserChampionName(12));?>">
    <br>
    <span class="fontNormal">Mild</span>
    <br>
    <span class="light">Co-owner &bull; Website designer</span>
</div>
<div class="staffprofile">
    <img src="<?php echo getChampionIconUrlFromName(getUserChampionName(15));?>">
    <br>
    <span class="fontNormal">SP Geno</span>
    <br>
    <span class="light">Staff manager</span>
</div>
<div class="staffprofile">
    <img src="<?php echo getChampionIconUrlFromName(getUserChampionName(13));?>">
    <br>
    <span class="fontNormal">Ryomasa</span>
    <br>
    <span class="light">Stream manager &bull; Head caster</span>
</div>

<div class="clear">
<br><br>
<h2>Casters & Streamers</h2>
<hr>
<?php
$users = fetchAll("SELECT id,caster,streamer FROM users WHERE caster = 1 OR streamer = 1"); 
foreach ($users as $user)
{
    $id = $user['id'];
    $caster = $user['caster'];
    $streamer = $user['streamer'];
    ?>
    <div class="staffprofile">
        <img src="<?php echo getChampionIconUrlFromName(getUserChampionName($id));?>">
        <br>
        <span class="fontNormal"><?php echo getUserNameFromId($id);?></span>
        <br>
        <span class="light">
        <?php
        if ($caster == 1 && $streamer == 0) { echo 'Caster';}
        if ($streamer == 1 && $caster == 0) { echo 'Streamer';}
        if ($streamer == 1 && $caster == 1) { echo 'Caster &bull; Streamer';}
        ?>
        </span>
    </div>
    <?php
}
?>