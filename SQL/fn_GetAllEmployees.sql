IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[fn_GetAllEmployees]') AND type in (N'FN', N'IF', N'TF', N'FS', N'FT'))
DROP FUNCTION [dbo].[fn_GetAllEmployees]
GO

CREATE FUNCTION fn_GetAllEmployees () RETURNS TABLE AS
	RETURN SELECT * FROM vw_EmployeeContactList
GO

GRANT SELECT ON fn_GetAllEmployees TO PhoneBookAppUser

SELECT * FROM fn_GetAllEmployees()

