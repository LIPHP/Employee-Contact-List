<?php

/*
 * Justin's Employee Contact List
 * Copyright (C) 2008  Justin Dearing <zippy1981@gmail.com>
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

/**
 * Contains class Dba
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
		$this->Connect();
	}


	/**
	 * Takes a 10 character string of numeric characters and formats it as a phone number.
	 * @param &$EmployeeRecord Array An employee record as a associative array.
	 */
	private function formatPhoneNumbers(Array &$EmployeeRecord)
	{
		$EmployeeRecord['HomeNumber'] = preg_replace('/([0-9]{3})([0-9]{3})([0-9]{4})/', '\1-\2-\3', $EmployeeRecord['HomeNumber']);
		$EmployeeRecord['MobileNumber'] = preg_replace('/([0-9]{3})([0-9]{3})([0-9]{4})/', '\1-\2-\3', $EmployeeRecord['MobileNumber']);
		$EmployeeRecord['OfficeNumber'] = preg_replace('/([0-9]{3})([0-9]{3})([0-9]{4})/', '\1-\2-\3', $EmployeeRecord['OfficeNumber']);
		return $EmployeeRecord;
	}


	private function getQuery ($tsql, array $params=null) {
		$ret = sqlsrv_query( $this->conn, $tsql, $params);
		if( $ret === false )
		{
			throw new DbaException(sqlsrv_errors());
		}
		return $ret;
	}


	private function Connect()
	{
		$this->conn = sqlsrv_connect
			($this->serverName, $this->connectionInfo);
		if( $this->conn === false )
		{
			throw new DbaException(sqlsrv_errors());
		}
	}


	public function Disconnect()
	{
		sqlsrv_close($this->conn);
	}



	/**
	 * Gets the employee record from the EmployeeId
	 * @parameter $EmployeeId uniqueidentifier The guid of the employee record.
	 * @return array
	 */
	public function GetEmployeeByEmployeeId($EmployeeId)
	{
		$stmt = $this->getQuery('SELECT * FROM fn_GetEmployeeByEmployeeId(?)', array($EmployeeId));
		$ret = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
		sqlsrv_free_stmt($stmt);
		return $this->formatPhoneNumbers($ret);
	}

	
	/**
	 * Gets the entire phone list.
	 * @Returns Array an array of employee records. The employee records are associateive arrays.
	 */
	public function GetPhoneList() {
		$stmt = $this->getQuery('SELECT * FROM fn_GetAllEmployees()');
		/* Retrieve each row as an associative array and display the results.*/
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
		{
			$ret[] = $this->formatPhoneNumbers($row);
		}
		sqlsrv_free_stmt($stmt);
		return $ret;
	}


	/**
	 * Updates an employees Information
	 * @todo Document all the parameters.
	 */
	public function UpdateEmployeeInfo
		($EmployeeId, $LastName, $FirstName, $Suffix, 
		 $Address1, $Address2, $City, $State, $Zip,
		 $OfficeNumber, $HomeNumber, $MobileNumber)
	{
		$SQL =
			"EXECUTE usp_UpdateEmployee " .
			"@EmployeeId=?, @LastName=?, @FirstName=?, @Suffix=?, " .
			"@Address1=?, @Address2=?, @City=?, @State=?, @Zip=?, " .
			"@OfficeNumber=?, @HomeNumber=?, @MobileNumber=?";
		$stmt = $this->getQuery($SQL);
		sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
		sqlsrv_free_stmt($stmt);
	}
}

?>
