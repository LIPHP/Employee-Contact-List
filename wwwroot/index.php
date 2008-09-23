<?php
require_once('../lib/Session.php');

$session = new Session();

$smarty = $session->CreateSmarty();
$dba = $session->GetDba();
$phoneList = $dba->GetPhoneList();
$dba->Disconnect();

$smarty->assign('phoneList', $phoneList);
$smarty->display("index.tpl");

?>

