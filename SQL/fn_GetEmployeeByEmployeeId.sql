IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[fn_GetEmployeeByEmployeeId]') AND type in (N'FN', N'IF', N'TF', N'FS', N'FT'))
DROP FUNCTION [dbo].[fn_GetEmployeeByEmployeeId]
GO

CREATE FUNCTION fn_GetEmployeeByEmployeeId (@EmployeeId AS uniqueidentifier) RETURNS TABLE AS
	RETURN SELECT * FROM vw_EmployeeContactList WHERE EmployeeId=@EmployeeId
GO

GRANT SELECT ON fn_GetEmployeeByEmployeeId TO PhoneBookAppUser



