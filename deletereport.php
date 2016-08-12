<?php

require 'common.php';
requireAdminOrMod();

$reportid = $_REQUEST['id'];

if ($reportid > 0)
{
    $query = "DELETE FROM reports WHERE id=" . $reportid;
    execute($query);
}