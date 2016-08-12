<?php

require 'common.php';
requireLoggedIn();
$pid = get('pid', 0);
$cid = get('cid', 0);
$date = date("Y-m-d H:i:s");

$msg = addslashes($_POST['msg']);

$query = 
"
INSERT INTO reports (`postid`, `commentid`, `description`, `date`)
VALUES($pid, $cid, '$msg', '$date');
";
execute($query);

redirect("reportsent.php?pid=" . $pid . "&cid=" . $cid);

?>