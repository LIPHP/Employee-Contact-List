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
		DECLARE @HomeId smallint
		DECLARE @MobileId smallint
		DECLARE @OfficeId smallint

		IF @EmployeeId IS NULL
		BEGIN
			RAISERROR('EmployeeId cannot be null.', 16, 1)
		END

		DECLARE @EmployeeIdText char(36)
		SET @EmployeeIdText = CAST(@EmployeeId AS char(36))

		SELECT @HomeId=PhoneNumberTypeId FROM tbPhoneNumberTypes WHERE PhoneNumberType='Home'
		SELECT @MobileId=PhoneNumberTypeId FROM tbPhoneNumberTypes WHERE PhoneNumberType='Mobile'
		SELECT @OfficeId=PhoneNumberTypeId FROM tbPhoneNumberTypes WHERE PhoneNumberType='Office'

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

GRANT EXECUTE ON usp_UpdateEmployee TO PhoneBookAppUser
GO