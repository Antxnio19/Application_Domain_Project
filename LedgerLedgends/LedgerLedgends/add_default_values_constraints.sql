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
-- Default Values
ALTER TABLE [dbo].[Table1]
ADD CONSTRAINT DF_DateOfBirth DEFAULT GETDATE() FOR [DateOfBirth];

-- Check Constraints
ALTER TABLE [dbo].[Table1]
ADD CONSTRAINT CHK_DateOfBirth CHECK ([DateOfBirth] <= GETDATE());