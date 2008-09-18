<?php
/**
 * Generates a vcard
 * @todo fix redirect when no employeeid is specified
 */

if (!isset($_REQUEST['EmployeeId']))
{
	$host=$_SERVER['HTTP_HOST'];
	header("Location: http://$host/EmployeePhoneBook/");
	return;
}

require_once('../lib/Session.php');

$session = new Session();
$smarty = $session->CreateSmarty();
$dba = $session->GetDba();
$phoneList = $dba->GetPhoneList();

$smarty->assign('phoneList', $phoneList);
$smarty->display("index.tpl");

header( "Content-type: text/x-Vcard" );
header("Content-Disposition: inline; filename=\"$mimeBaseName.flv\"");

?>
