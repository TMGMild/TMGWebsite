<?php

if (isset($_REQUEST['q']))
{
    require 'common.php';
    requireAdmin();
    $query = 
    "
    SELECT * FROM users WHERE username LIKE '%" . $_REQUEST['q'] . "%' LIMIT 20
    ";
    $results = fetchAll($query);
    $output = "";
    if (count($results) > 0)
    {
        foreach ($results as $result)
        {
            $role = $result['role'];
            $output .= 
            "
            <tr>
                <td><a href='profile.php?id=" . $result['id'] . "'>" . $result['username'] . "</a></td>
                <td>
                    <select onchange='changeRole(" . $result['id'] . ", this.value)'>
                        <option value='admin'";
                        if ($role == "admin") {$output .= " selected";}
                        $output .= ">Admin</option>" . 
                        "<option value='mod'";
                        if ($role == "mod") {$output .= " selected";}
                        $output .= ">Mod</option>" . 
                        "<option value='user'";
                        if ($role == "user") {$output .= " selected";}
                        $output .= ">User</option>" . "
                    </select>
                </td>
                <td>
                    <label><input onclick='toggleColumn(\"manager\", " . $result['id'] . ", this.checked)' type='checkbox'";
                    if ($result['manager'] == 1) {$output .= " checked";}
                    $output .= " />Manager</label>
                </td>
                <td>
                    <input onclick='toggleColumn(\"writer\", " . $result['id'] . ", this.checked)' type='checkbox'";
                    if ($result['writer'] == 1) {$output .= " checked";}
                    $output .= " />Writer</label>
                </td>
                <td>
                    <input onclick='toggleColumn(\"caster\", " . $result['id'] . ", this.checked)' type='checkbox'";
                    if ($result['caster'] == 1) {$output .= " checked";}
                    $output .= " />Caster</label>
                </td>
                <td>
                    <input onclick='toggleColumn(\"streamer\", " . $result['id'] . ", this.checked)' type='checkbox'";
                    if ($result['streamer'] == 1) {$output .= " checked";}
                    $output .= " />Streamer</label>
                </td>
                <td>Past suspensions: " . $result['suscount'] . "</td>
                <td id='sus" . $result['id'] . "'>";
                    if (isSuspended($result['id']))
                    {
                        if (date('Y-m-d H:i:s', strtotime('+1000 days')) < $result['suspensiondate'])
                        { $result['suspensiondate'] = "indefinitely"; }
                        else { $result['suspensiondate'] = "until " . $result['suspensiondate'];}
                        $output .=
                        "
                        <span style='color:#b30000;'>Suspended " . $result['suspensiondate'] . 
                        "</span><br><input type='submit' value='Lift Suspension' onclick='liftSuspension(" . $result['id'] . ")' />";
                    }
                    else
                    {
                        $output .=
                        "
                        Suspend for:
                        <select>
                            <option value='1' selected>1 day</option>
                            <option value='7'>7 days</option>
                            <option value='30'>30 days</option>
                            <option value='9999'>Indefinitely</option>
                        </select>
                        <input type='submit' value='Suspend' onclick='suspendUser(" . $result['id'] . ")' />
                        ";
                    }
                $output .= "
                </td>
            </tr>
            ";
        }
    }
    else
    {
        $output = "<tr>No results found.</tr>";
    }
    echo $output;
}
else {
?>

<h1>User Panel</h1>
<hr>
<input type="text" style="background-color:white;width:100%;font-size:28px;font-weight:100;padding:10px;color:black;" id="search" placeholder="Search..." oninput="searchUsers(this.value)"/>
<br><br>
<div>
    <table id="results" style="font-size:18px;">
                        
    </table>
</div>

<?php
}
?>