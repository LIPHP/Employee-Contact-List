DECLARE @TextParam varchar(30)
SET @TextParam = 'Text parameter'
DECLARE @NullTextParam varchar(10)
SET @NullTextParam = null
DECLARE @FixWidthTextParam char(50)
SET @FixWidthTextParam = 'Less than 50 chars wide'
DECLARE @NumericParam int
SET @NumericParam=5

RAISERROR('Information Query', 0, 1)
RAISERROR('Danger Will Robinson', 16, 1)
RAISERROR('Text: %s Numeric: %d', 16, 1, @TextParam, @NumericParam)
RAISERROR('Null Text Parameter: %s', 16, 1, @NullTextParam)
RAISERROR('Fixed width param : ''%s''-----', 16, 1, @FixWidthTextParam)
RAISERROR('This will *NOT* cause an error %d', 16, 1, @NullTextParam)
RAISERROR('This *WILL* cause an error %d', 16, 1, @TextParam)