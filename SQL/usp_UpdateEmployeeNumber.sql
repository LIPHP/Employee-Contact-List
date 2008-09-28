IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[usp_UpdateEmployeeNumber]') AND type in (N'P', N'PC'))
DROP PROCEDURE [dbo].[usp_UpdateEmployeeNumber]
GO

CREATE PROCEDURE usp_UpdateEmployeeNumber (
	@EmployeeId uniqueidentifier,
	@PhoneNumberType varchar(30),
	@Number CHAR(10)
) AS
BEGIN
	BEGIN TRY
		DECLARE @PhoneNumberTypeId smallint
		DECLARE @EmployeeIdExists bit
		
		SELECT @EmployeeIdExists = COUNT(*) FROM tbEmployees WHERE EmployeeId=@EmployeeId

		IF @EmployeeIdExists IS NULL OR @EmployeeIdExists = 0
		BEGIN
			DECLARE @EmployeeIdText CHAR(36)
			SET @EmployeeIdText = CAST(@EmployeeId AS CHAR(36))
			RAISERROR ('EmployeeId {%s} not found', 16, 1, @EmployeeIdText)
		END

		SELECT @PhoneNumberTypeId=PhoneNumberTypeId FROM tbPhoneNumberTypes WHERE PhoneNumberType=@PhoneNumberType
		IF @PhoneNumberTypeId IS NULL
		BEGIN
			RAISERROR ('PhoneNumberType {%s} is invalid.', 16, 1, @PhoneNumberType)
		END

		UPDATE tbPhoneNumbers
			SET PhoneNumber=@Number
			WHERE PhoneNumberTypeId=@PhoneNumberTypeId AND EmployeeId=@EmployeeId
		
		IF @@ROWCOUNT = 0
		BEGIN
			-- We add it
			INSERT INTO tbPhoneNumbers (EmployeeId, PhoneNumberTypeId, PhoneNumber)
				VALUES (@EmployeeId, @PhoneNumberTypeId, @Number)
		END
	END TRY
	BEGIN CATCH
		DECLARE @ErrorMessage NVARCHAR(4000);
		DECLARE @ErrorSeverity INT;
		DECLARE @ErrorState INT;

		SELECT
			@ErrorMessage = ERROR_MESSAGE(),
			@ErrorSeverity = ERROR_SEVERITY(),
			@ErrorState = ERROR_STATE();
		RAISERROR(@ErrorMessage, @ErrorSeverity, @ErrorState)
	END CATCH
	RETURN 0
END
GO

GRANT EXECUTE ON usp_UpdateEmployeeNumber TO PhoneBookAppUser
GO