<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type" />
<link rel="stylesheet" href="EmployeePhoneBook.css" type="text/css" />
<title>Employee Details</title>
</head>
<body>
<form method="get" action="index.php" name="edit_employee" />
  <input type="hidden" name="EmployeeId" value='{$smarty.request.EmployeeId|default:null}' />
{if $action eq "edit"}
  <input type="hidden" name="action" value="view" />
{elseif $action eq "view"}
  <input type="hidden" name="action" value="edit" />
{/if}
  <h1>Employee Details</h1>
  <h2>Name</h2>
  {ShowField
    action=$action
    heading="First"
    name="fname"
    value=$phoneRecord.FirstName
  }
  {ShowField
    action=$action
    heading="Last"
    name="lname"
    value=$phoneRecord.LastName
  }
  {ShowField
    action=$action
    heading="Suffix"
    name="suffix"
    value=$phoneRecord.Suffix
  }
  <br />
  <h2>Address</h2>
  {ShowField
    action=$action
    heading="Address 1"
    name="address1"
    value=$phoneRecord.Address1
  }
  {ShowField
    action=$action
    heading="Address 2"
    name="address2"
    value=$phoneRecord.Address2
  }
  {ShowField
    action=$action
    heading="City"
    name="city"
    value=$phoneRecord.City
  }
  {ShowField
    action=$action
    heading="State"
    name="state"
    value=$phoneRecord.State
  }
  {ShowField
    action=$action
    heading="Zip"
    name="zip"
    value=$phoneRecord.Zip
  }
{if $action eq "edit"}
  <input type="submit" name="edit_submit" value="Save Profile">
{elseif $action eq "view"}
  <input type="submit" name="edit_submit" value="Edit Profile">
{/if}
</form>
</body>
</html>
