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

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[usp_UpdateEmployee]') AND type in (N'P', N'PC'))
DROP PROCEDURE [dbo].[usp_UpdateEmployee]
GO

CREATE PROCEDURE usp_UpdateEmployee (
	@EmployeeId uniqueidentifier,
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


		IF @EmployeeId IS NULL
		BEGIN
			RAISERROR('EmployeeId cannot be null.', 16, 1)
		END

		DECLARE @EmployeeIdText char(36)
		SET @EmployeeIdText = CAST(@EmployeeId AS char(36))

		UPDATE tbEmployees
			SET
				LastName = @LastName,
				FirstName = @FirstName,
				Suffix = @Suffix,
				Address1 = @Address1,
				Address2 = @Address2,
				City = @City,
				State = @State,
				Zip = @Zip
			WHERE EmployeeId=@EmployeeId

		IF @@ROWCOUNT = 0
		BEGIN
			RAISERROR('EmployeeId %s not found', 16, @EmployeeIdText)
		END

		-- Insert phone numbers
		IF @OfficeNumber IS NOT NULL
		BEGIN
			EXEC usp_UpdateEmployeeNumber 
				@EmployeeId, 'Office', @OfficeNumber
		END

		IF @HomeNumber IS NOT NULL
		BEGIN
			EXEC usp_UpdateEmployeeNumber 
				@EmployeeId, 'Home', @HomeNumber
		END

		IF @MobileNumber IS NOT NULL
		BEGIN
			EXEC usp_UpdateEmployeeNumber 
				@EmployeeId, 'Mobile', @MobileNumber
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

GRANT EXECUTE ON usp_UpdateEmployee TO PhoneBookAppUser
GO