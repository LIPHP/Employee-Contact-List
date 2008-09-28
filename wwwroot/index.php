<?php
require_once('../lib/Session.php');

$session = new Session();

$smarty = $session->CreateSmarty();
$dba = $session->GetDba();

// I should scrub my input. Don't use this code.
if (isset($_REQUEST['EmployeeId']))
{
	$action= isset($_REQUEST['action']) 
		? $_REQUEST['action']
		: 'view';
	$template="employee_details.tpl";
	$phoneRecord = $dba->GetEmployeeByEmployeeId($_REQUEST['EmployeeId']);
	$smarty->assign('action', $action);
	$smarty->assign('phoneRecord', $phoneRecord);
}
else
{
	$template='index.tpl';
	$phoneList = $dba->GetPhoneList();
	$smarty->assign('phoneList', $phoneList);
}

$dba->Disconnect();
$smarty->display($template);
?>

