/*
Post-Deployment Script Template							
--------------------------------------------------------------------------------------
 This file contains SQL statements that will be appended to the build script.		
 Use SQLCMD syntax to include a file in the post-deployment script.			
 Example:      :r .\myfile.sql								
 Use SQLCMD syntax to reference a variable in the post-deployment script.		
 Example:      :setvar TableName MyTable							
               SELECT * FROM [$(TableName)]					
--------------------------------------------------------------------------------------
*/
-- Drop Constraints and Indexes if needed
ALTER TABLE [dbo].[Table1] DROP CONSTRAINT FK_UserType;
ALTER TABLE [dbo].[Table1] DROP CONSTRAINT UQ_Username;
ALTER TABLE [dbo].[Table1] DROP CONSTRAINT UQ_EmailAddress;

DROP INDEX IF EXISTS IX_Username ON [dbo].[Table1];
DROP INDEX IF EXISTS IX_EmailAddress ON [dbo].[Table1];

-- Drop Tables
DROP TABLE IF EXISTS [dbo].[Table1];
DROP TABLE IF EXISTS [dbo].[UserTypeTable];


