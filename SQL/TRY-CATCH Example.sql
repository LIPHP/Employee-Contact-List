BEGIN TRY
	-- DO STUFF
	RAISERROR('Problem found between user and chair.', 16, 1) -- Note this message is initially repressed
END TRY
BEGIN CATCH
	RAISERROR('Error caught sending to the event log', 16, 1)
	DECLARE @Message varchar(max)
	DECLARE @Severity int
	DECLARE @State int
	SELECT @Message=ERROR_MESSAGE(), @Severity=ERROR_SEVERITY(), @State=ERROR_STATE()
	RAISERROR('Message: %s', @Severity, @State, @Message) WITH LOG
END CATCH