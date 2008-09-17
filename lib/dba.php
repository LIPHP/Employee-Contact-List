<?php
/**
 * @Summary Contains class Dba
**/

require_once('DbaException.php');

/**
 * Dba stands for Database access. This is our simple data access
 * layer.
**/
class Dba {
	private $serverName = "(local)";
	private $connectionInfo = array( "Database"=>"EmployeePhoneBook");
	private $conn;


	public function __construct () {
		$this->conn = sqlsrv_connect
			($this->serverName, $this->connectionInfo);
		if( $this->conn === false )
		{
			throw new DbaException(sqlsrv_errors());
		}
	}

	private function getQuery ($tsql) {
		$ret = sqlsrv_query( $this->conn, $tsql);
		if( $ret === false )
		{
			throw new DbaException(sqlsrv_errors());
		}
		return $ret;
	}

	public function GetPhoneList() {
		$stmt = $this->getQuery('SELECT * FROM fn_GetAllEmployees()');
		/* Retrieve each row as an associative array and display the results.*/
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
		{
			$ret[] = $row;
		}
		return $ret;
	}
}

?>
