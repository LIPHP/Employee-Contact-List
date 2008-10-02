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

-- This is just a script to show how TRY/CATCH works.
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