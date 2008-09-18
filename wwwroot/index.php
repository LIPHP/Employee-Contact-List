<?php
require_once('../lib/Session.php');

$session = new Session();

$smarty = $session->CreateSmarty();
$dba = $session->GetDba();
$phoneList = $dba->GetPhoneList();

$smarty->assign('phoneList', $phoneList);
$smarty->display("index.tpl");

?>

