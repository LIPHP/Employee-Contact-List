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