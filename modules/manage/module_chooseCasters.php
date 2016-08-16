<h2>Select Casters</h2>
<hr>
<div class="updater green" id="chooseCastersUpdater"></div>
<form action="chooseCasters.php" method="post">
    <table>
            <?php
            for ($i = 1; $i < 7; $i++)
            {?>            
                 <tr>
                    <td><?php echo timeSlotToTime($i);?></td>
                    <td>
                        <select name="<?php echo $i . 'a';?>">
                            <?php
                            $query = "SELECT * FROM casterRequestsSlot" . $i;
                            $rows = fetchAll($query);
                            $query = "SELECT caster1 FROM casterSchedule WHERE slot = $i";
                            $casterid = fetchColumn($query);
                            foreach ($rows as $row)
                            {
                                if ($casterid == $row['casterID'])
                                {
                                    echo '<option value="' . $row['casterID'] . '" selected>' . getUserNameFromId($row['casterID']) . '</option>';
                                }
                                else
                                {
                                    echo '<option value="' . $row['casterID'] . '">' . getUserNameFromId($row['casterID']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select name="<?php echo $i . 'b';?>">
                            <?php
                            $query = "SELECT * FROM casterRequestsSlot" . $i;
                            $rows = fetchAll($query);
                            $query = "SELECT caster2 FROM casterSchedule WHERE slot = $i";
                            $casterid = fetchColumn($query);
                            foreach ($rows as $row)
                            {
                                if ($casterid == $row['casterID'])
                                {
                                    echo '<option value="' . $row['casterID'] . '" selected>' . getUserNameFromId($row['casterID']) . '</option>';
                                }
                                else
                                {
                                    echo '<option value="' . $row['casterID'] . '">' . getUserNameFromId($row['casterID']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                 </tr>
            <?php
            }
            ?>
    </table>
    <input type="submit" class="right margin" value="Save">
</form>