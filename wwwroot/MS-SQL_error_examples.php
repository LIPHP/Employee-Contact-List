<?php
header("Content-type: text/plain");

/* Specify the server and connection string attributes. */
$serverName = "(local)";
$connectionInfo = array( "Database"=>"EmployeePhoneBook");

/* Connect using Windows Authentication. */
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Unable to connect.</br>";
     die( print_r( sqlsrv_errors(), true));
}
else{
	echo "Connected to database\n\n";
}

###############################################################################
$i = null;	// Declare this variable before the prepare statement
$tsql = "RAISERROR('iSeverity = %d', ?, 1, ?)";

// Note the parameter repetition since
// prepared statement parameters are not named.
$prepared_stmt = sqlsrv_prepare($conn, $tsql, array($i, $i));
for($i=0; $i <= 25; $i++) {
	printf('Query: %s iSeverity: %n', $tsql, $i);
	sqlsrv_execute($prepared_stmt);
	echo "Messages generated:\n";
	print_r(sqlsrv_errors());
	echo "\n\n\n";
}

# Now we add the WITH LOG
$tsql = "RAISERROR('iSeverity = %d', ?, 1, ?) WITH LOG";

$prepared_stmt = sqlsrv_prepare($conn, $tsql, array($i, $i));
for($i=0; $i <= 25; $i++) {
	printf('Query: %s iSeverity: %n', $tsql, $i);
	sqlsrv_execute($prepared_stmt);
	echo "Messages generated:\n";
	print_r(sqlsrv_errors());
	echo "\n\n\n";
}

###############################################################################

/* Free statement and connection resources. */
sqlsrv_free_stmt($prepared_stmt);
sqlsrv_close( $conn);
echo "Program terminated successfully.";
?>
