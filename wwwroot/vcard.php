<?php
/**
 * Generates a vcard
 * @todo fix redirect when no employeeid is specified
 */

require_once('../lib/Session.php');

if (!isset($_REQUEST['EmployeeId']))
{
	$host=$_SERVER['HTTP_REFERER'];
	header("Location: $host");
	return;
}

$session = new Session();
$dba = $session->GetDba();
$phoneRecord = $dba->GetEmployeeByEmployeeId($_REQUEST['EmployeeId']);
$dba->Disconnect();

# Set the mimetype and set this to be a "download" not an inbrowser document.
header( "Content-type: text/x-Vcard" );
header("Content-Disposition: attachment; filename=\"" . $phoneRecord["LastName"] . '_' . $phoneRecord["FirstName"] . ".vcf\"");
header("Pragma: public");


$smarty = $session->CreateSmarty();
$smarty->assign('phoneRecord', $phoneRecord);
$smarty->display("vcard.tpl");

?>
