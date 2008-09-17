<?php
require_once('../lib/Dba.php');

$dba = new Dba();
$phoneList = $dba->GetPhoneList();
# TODO: smartify everything
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
                      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
<head>
<title>Employee Phonebook</title>
</head>
<body>
<h1>Employee Phone Book App</h1>
<?php
#<p>Nothing here yet.</p>
print_r($phoneList);
?>
</body>
</html>
