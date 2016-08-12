<?php

requireAdminOrMod();

$query = "SELECT * FROM reports;";
$reports = fetchAll($query);

?>
<h1>Reports</h1>
<hr>
<div id="updater" class="updaterGreen"></div>
<table>
    <tr>
        <td>Content</td>
        <td>Report</td>
        <td>Date</td>
        <td>Actions</td>
    </tr>
    <?php
    foreach ($reports as $report)
    {
        $userid = getAuthorIdFromPost($report['postid'], $report['commentid']); 
        if (userid() != $userid || isAdmin($userid))
        {
        ?>
            <tr id="<?php echo $report['id'];?>">
                <td style="width:35%;vertical-align:top;">
                    <p class="code">
                        <?php
                        $message = nl2br(getPostContent($report['postid'], $report['commentid']));
                        if (strlen($message) > 400) {$str = substr($str, 0, 399) . '...';}
                        echo $message;
                        ?>
                    </p>
                </td>
                <td style="width:35%;vertical-align:top;">
                    <?php echo nl2br($report['description']);?>
                </td>
                <td style="width:10%;vertical-align:top"><?php echo timeToString($report['date']);?></td>
                <td style="width:20%;">
                    <?php
                    $suscount = getSusCount($userid);
                    $display = true;
                    if (isMod($userid))
                    {
                        if (isAdmin()) {$display = true;}
                        else if (isMod()) {$display = false;}
                    }
                    ?>
                    <?php
                    if ($display)
                    { ?>
                        Author's past suspensions: <?php echo $suscount;?><br>
                        <a class="block-green" href="javascript:deleteReport(<?php echo $report['id'];?>)">Dismiss</a>
                        <br>
                        <a class="block-red" href="#" onclick='this.nextElementSibling.style.display="block";'>Act</a>
                        <div style="display:none;">
                            Delete post and suspend author for:
                            <select name="time">
                                <option value="0">0 days</option>
                                <option value="1">1 day</option>
                                <option value="7" selected>7 days</option>
                                <option value="30">30 days</option>
                                <option value="9999">Indefinitely</option>
                            </select>
                            <br>
                            <input type="submit" onclick="act(<?php echo $report['id'];?>, $(this).siblings(0).val())" value="Submit">
                        </div>
                    <?php
                    }
                    else
                    {
                        echo 'Please consult an administrator to deal with this report.';
                    }
                    ?>
                </td>
            </tr>
        <?php
        }
    }
    ?>
</table>