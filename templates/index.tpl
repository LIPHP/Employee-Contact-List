<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
                      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<link rel="stylesheet" href="EmployeePhoneBook.css" type="text/css" />
<title>Employee Phonebook</title>
</head>
<body>
<h1>Employee Phone Book App</h1>
<table id='PhoneListTable'>
	<tr>
		<th>LastName</th>
		<th>FirstName</th>
		<th>Address1</th>
		<th>Address2</th>
		<th>City</th>
		<th>State</th>
		<th>Zip</th>
		<th>Mobile Number</th>
		<th>Office Number</th>
		<th>Home Number</th>
	</tr>
{foreach from=$phoneList item=phoneRecord}

	<tr>
		<td>{$phoneRecord.LastName}&nbsp;{$phoneRecord.Suffix}</td>
		<td>{$phoneRecord.FirstName}</td>
		<td>{$phoneRecord.Address1}</td>
		<td>{$phoneRecord.Address2}</td>
		<td>{$phoneRecord.City}</td>
		<td>{$phoneRecord.State}</td>
		<td>{$phoneRecord.Zip}</td>
		<td>{$phoneRecord.MobileNumber}</td>
		<td>{$phoneRecord.OfficeNumber}</td>
		<td>{$phoneRecord.HomeNumber}</td>
	</tr>
{/foreach}
</table>
<p id='ValidatorParagraph'>
	<a href="http://validator.w3.org/check?uri=referer"><img
		src="images/valid-xhtml10-blue.png"
		alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
</p>

</body>
</html>
