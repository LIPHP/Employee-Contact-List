EXEC usp_AddNewEmployee 
	@LastName = 'Dearing',
	@FirstName = 'Justin',
	@Address1 = '80 Orvilla Drive',
	@City = 'Bohemia',
	@Zip = '11716',
	@OfficeNumber = '6318732016',
	@HomeNumber = '2125551212',
	@MobileNumber = '9173632391'
GO

-- Ken, its all info from http://secdat.com
EXEC usp_AddNewEmployee 
	@LastName = 'Downs',
	@FirstName = 'Kenneth',
	@Address1 = '347 Main Street',
	@City = 'East Setauket',
	@Zip = '11733',
	@OfficeNumber = '6316897200'
GO

-- Lewis, its all info from http://www.2rosenthals.com/
EXEC usp_AddNewEmployee 
	@LastName = 'Rosenthal',
	@FirstName = 'Lewis',
	@Address1 = '203 Loudoun Street SW',
	@City = 'Leesburg',
	@State= 'NY',
	@Zip = '20175',
	@OfficeNumber = '7037790477'
GO

-- We're going to update some info
/*
--DECLARE @EmployeeId UniqueIdentifier
SELECT @EmployeeId=EmployeeId FROM tbEmployees
	WHERE LastName='RosenThal' AND FirstName='Lewis' AND Suffix IS NULL

EXEC usp_UpdateEmployee 
	@EmployeeId = @EmployeeId,
	@LastName = 'Ryan',
	@FirstName = 'Tom',
	@Address1 = 'Fake Address',
	@City = 'Commack',
	@State= 'NY',
	@Zip = '20175',
	@OfficeNumber = '7037790477'
GO
*/

DECLARE @EmployeeId uniqueidentifier
SELECT @EmployeeId=EmployeeId FROM tbEmployees WHERE LastName = 'Dearing' AND FirstName = 'Justin'
EXEC usp_UpdateEmployeeNumber
	@EmployeeId = @EmployeeId,
	@PhoneNumberType = 'Mobile',
	@Number = '3215551212'

SELECT @EmployeeId=EmployeeId FROM tbEmployees WHERE LastName = 'Downs' AND FirstName = 'Kenneth'
EXEC usp_UpdateEmployeeNumber
	@EmployeeId = @EmployeeId,
	@PhoneNumberType = 'Mobile',
	@Number = '3215551212'