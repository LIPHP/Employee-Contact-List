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