DECLARE @i int

-- PLAIN RAISERROR()
SET @i = 0
WHILE (@i < 25)
BEGIN
	RAISERROR('Message: @i=%d', @i, 1, @i)
	SET @i = @i + 1
END

-- DECLARE @i int
-- RAISERROR() WITH LOG
SET @i = 0
WHILE (@i < 25)
BEGIN
	RAISERROR('Message: @i=%d', @i, 1, @i) WITH LOG
	SET @i = @i + 1
END

-- DECLARE @i int
-- IN A TRY/CATCH
SET @i = 0
BEGIN TRY
	WHILE (@i < 25)
	BEGIN
		RAISERROR('Message: @i=%d', @i, 1, @i) WITH LOG
		SET @i = @i + 1
	END
END TRY
BEGIN CATCH
	RAISERROR('Error caught sending to the event log', 16, 1)
	DECLARE @Message varchar(max)
	DECLARE @Severity int
	DECLARE @State int
	SELECT @Message=ERROR_MESSAGE(), @Severity=ERROR_SEVERITY(), @State=ERROR_STATE()
	RAISERROR('Message: %s', @Severity, @State, @Message) WITH LOG
END CATCH