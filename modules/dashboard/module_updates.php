<?php

$limit = 10;
$query = "SELECT * FROM updates ORDER BY `time` DESC LIMIT $limit";
$rows = fetchAll($query);

?>
<h2>Updates</h2>
<hr>
<table>

    <?php foreach ($rows as $row)
    {
        if (strpos($row['text'], teamName()) !== false) {
            //this entry contains the user's team
            echo '<tr class="highlight">';
        }
        else
        {
            echo '<tr>';
        } ?>

        <td><?php echo $row['text']; ?></td>
        <td style="font-size:16px;"><?php echo timeToString($row['time']); ?></td>

    <?php }
    ?>

</table>