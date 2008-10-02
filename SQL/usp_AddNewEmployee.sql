-- Justin's Employee Contact List
-- Copyright (C) 2008  Justin Dearing <zippy1981@gmail.com>
-- 
-- This program is free software; you can redistribute it and/or
-- modify it under the terms of the GNU General Public License
-- as published by the Free Software Foundation; either version 2
-- of the License, or (at your option) any later version.
-- 
-- This program is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU General Public License for more details.
-- 
-- You should have received a copy of the GNU General Public License
-- along with this program; if not, write to the Free Software
-- Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[usp_AddNewEmployee]') AND type in (N'P', N'PC'))
DROP PROCEDURE [dbo].[usp_AddNewEmployee]
GO

CREATE PROCEDURE usp_AddNewEmployee (
	@LastName NVARCHAR(20),
	@FirstName NVARCHAR(20),
	@Suffix VARCHAR(5) = NULL,
	@Address1 VARCHAR(20),
	@Address2 VARCHAR(20) = NULL,
	@City VARCHAR(30),
	@State CHAR(2) = 'NY',
	@Zip CHAR(10),
	@OfficeNumber CHAR(10) = NULL,
	@HomeNumber CHAR(10) = NULL,
	@MobileNumber CHAR(10) = NULL
) AS
BEGIN
	BEGIN TRANSACTION
	BEGIN TRY
		DECLARE @HomeId smallint
		DECLARE @MobileId smallint
		DECLARE @OfficeId smallint
		DECLARE @EmployeeId uniqueidentifier

		SET @EmployeeId=newid()		-- We need to get this id somehow

		SELECT @HomeId=PhoneNumberTypeId FROM tbPhoneNumberTypes WHERE PhoneNumberType='Home'
		SELECT @MobileId=PhoneNumberTypeId FROM tbPhoneNumberTypes WHERE PhoneNumberType='Mobile'
		SELECT @OfficeId=PhoneNumberTypeId FROM tbPhoneNumberTypes WHERE PhoneNumberType='Office'

		INSERT INTO tbEmployees (EmployeeId, LastName, FirstName, Suffix, Address1, Address2, City, State, Zip)
			VALUES (@EmployeeId, @LastName, @FirstName, @Suffix, @Address1, @Address2, @City, @State, @Zip)

		-- Insert phone numbers
		IF @OfficeNumber IS NOT NULL
		BEGIN
			INSERT INTO tbPhoneNumbers (EmployeeId, PhoneNumberTypeId, PhoneNumber)
				VALUES (@EmployeeId, @OfficeId, @OfficeNumber)
		END

		IF @HomeNumber IS NOT NULL
		BEGIN
			INSERT INTO tbPhoneNumbers (EmployeeId, PhoneNumberTypeId, PhoneNumber)
				VALUES (@EmployeeId, @HomeId, @HomeNumber)
		END

		IF @MobileNumber IS NOT NULL
		BEGIN
			INSERT INTO tbPhoneNumbers (EmployeeId, PhoneNumberTypeId, PhoneNumber)
				VALUES (@EmployeeId, @MobileId, @MobileNumber)
		END

		COMMIT TRANSACTION
	END TRY
	BEGIN CATCH
		DECLARE @ErrorMessage NVARCHAR(4000);
		DECLARE @ErrorSeverity INT;
		DECLARE @ErrorState INT;

		SELECT 
			@ErrorMessage = ERROR_MESSAGE(),
			@ErrorSeverity = ERROR_SEVERITY(),
			@ErrorState = ERROR_STATE();
		RAISERROR('Failed to add new employee %s, %s!', 16, 1, @LastName, @FirstName)
		RAISERROR(@ErrorMessage, @ErrorSeverity, @ErrorState)
		ROLLBACK TRANSACTION
	END CATCH
	RETURN 0
END
GO

GRANT EXECUTE ON usp_AddNewEmployee TO PhoneBookAppUser
GO