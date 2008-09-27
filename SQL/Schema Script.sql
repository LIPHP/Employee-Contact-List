USE EmployeePhoneBook
GO

-- Drop view(s)
USE [EmployeePhoneBook]
IF  EXISTS (SELECT * FROM sys.views WHERE object_id = OBJECT_ID(N'[dbo].[vw_EmployeeContactList]'))
DROP VIEW [dbo].[vw_EmployeeContactList]
-- Drop tables
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[tbPhoneNumbers]') AND type in (N'U'))
DROP TABLE [dbo].[tbPhoneNumbers]
GO
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[tbPhoneNumberTypes]') AND type in (N'U'))
DROP TABLE [dbo].[tbPhoneNumberTypes]
GO
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[tbEmployees]') AND type in (N'U'))
DROP TABLE [dbo].[tbEmployees]
GO

--Create database
CREATE TABLE tbPhoneNumberTypes (
	PhoneNumberTypeId SMALLINT NOT NULL IDENTITY(1,1) 
		CONSTRAINT PK_tbContactTypes PRIMARY KEY CLUSTERED,	--Explicitly named primary key
	PhoneNumberType NVARCHAR(30) NOT NULL	--UNICODE (UTF-16)
)	--Note the lack of a semi-colon
GO

-- Insert "static" info
-- By default you cannot manually insert a value to an identity (a.k.a. sequence or auto-increment field)
SET IDENTITY_INSERT [tbPhoneNumberTypes] ON	
GO
INSERT INTO tbPhoneNumberTypes (PhoneNumberTypeId, PhoneNumberType) VALUES(1, 'Office')
INSERT INTO tbPhoneNumberTypes (PhoneNumberTypeId, PhoneNumberType) VALUES(2, 'Home')
INSERT INTO tbPhoneNumberTypes (PhoneNumberTypeId, PhoneNumberType) VALUES(3, 'Mobile')
SET IDENTITY_INSERT [tbPhoneNumberTypes] OFF
GO

CREATE TABLE tbEmployees (
	EmployeeId UNIQUEIDENTIFIER NOT NULL
		CONSTRAINT PK_tbEmployees PRIMARY KEY NONCLUSTERED,	-- Never cluster a GUID Column
															-- NEWSEQUENTIALID() is evil
	LastName NVARCHAR(20) NOT NULL,
	FirstName NVARCHAR(20) NOT NULL,
	Suffix VARCHAR(5) NULL,
	Address1 VARCHAR(20) NOT NULL,
	Address2 VARCHAR(20) NULL,
	City VARCHAR(30) NOT NULL,
	State CHAR(2) NOT NULL,
	Zip CHAR(10) NOT NULL
)
GO

-- Indexes for searches
-- The first one also enforces uniqueness to a name
CREATE UNIQUE NONCLUSTERED INDEX IX_tbEmployees_LastName_FirstName_Suffix
	ON tbEmployees(LastName, FirstName, Suffix)
GO
CREATE NONCLUSTERED INDEX IX_tbEmployees_LastName ON tbEmployees(LastName)
GO
CREATE NONCLUSTERED INDEX IX_tbEmployees_FirstName ON tbEmployees(FirstName)
GO

CREATE TABLE tbPhoneNumbers (
	PhoneNumberId UNIQUEIDENTIFIER NOT NULL
		CONSTRAINT PK_tbPhoneNumbers PRIMARY KEY NONCLUSTERED	--Never cluster a GUID Column
		CONSTRAINT DF_tbPhoneNumbers_PhoneNumberId DEFAULT newid(),
	EmployeeId UNIQUEIDENTIFIER NOT NULL
		CONSTRAINT FK_tbPhoneNumbers_EmployeeId FOREIGN KEY REFERENCES tbEmployees,
	PhoneNumberTypeId SMALLINT NOT NULL
		CONSTRAINT FK_tbPhoneNumbers_PhoneNumberTypeId FOREIGN KEY REFERENCES tbPhoneNumberTypes,
	PhoneNumber CHAR(10) NOT NULL
)
GO

-- Each employee can have only one phone number per type
-- This is a design decision that is neither right or wrong.
CREATE UNIQUE NONCLUSTERED INDEX CIX_tbPhoneNumbers_EmployeeId_PhoneNumberTypeId
	ON tbPhoneNumbers (EmployeeId, PhoneNumberTypeId)
GO


-- If you didn't believe me when I said I purposefully wanted to use as many SQL features
-- as reasonably possible, look at this view.
CREATE VIEW vw_EmployeeContactList AS
	SELECT 
			tbEmployees.EmployeeId,
			LastName, FirstName, Suffix, 
			Address1, Address2, City, State, RTRIM(CAST(Zip AS varchar(10))) AS Zip,
			MobileNumbers.PhoneNumber AS MobileNumber,
			OfficeNumbers.PhoneNumber AS OfficeNumber,
			HomeNumbers.PhoneNumber AS HomeNumber
		FROM 
			tbEmployees
			LEFT JOIN (tbPhoneNumbers MobileNumbers INNER JOIN tbPhoneNumberTypes MobileNumberTypes
				ON
					MobileNumbers.PhoneNumberTypeId = MobileNumberTypes.PhoneNumberTypeId AND
					MobileNumberTypes.PhoneNumberType = 'Mobile')
					ON tbEmployees.EmployeeId = MobileNumbers.EmployeeId
			LEFT JOIN (tbPhoneNumbers HomeNumbers INNER JOIN tbPhoneNumberTypes HomePhoneNumberTypes
				ON
					HomeNumbers.PhoneNumberTypeId = HomePhoneNumberTypes.PhoneNumberTypeId AND
					HomePhoneNumberTypes.PhoneNumberType = 'Home')
					ON tbEmployees.EmployeeId = HomeNumbers.EmployeeId
			LEFT JOIN (tbPhoneNumbers OfficeNumbers INNER JOIN tbPhoneNumberTypes OfficePhoneNumberTypes
				ON
					OfficeNumbers.PhoneNumberTypeId = OfficePhoneNumberTypes.PhoneNumberTypeId AND
					OfficePhoneNumberTypes.PhoneNumberType = 'Office')
					ON tbEmployees.EmployeeId = OfficeNumbers.EmployeeId
GO