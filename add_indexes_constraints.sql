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
-- Unique Constraints
ALTER TABLE [dbo].[Table1]
ADD CONSTRAINT UQ_Username UNIQUE ([Username]);

ALTER TABLE [dbo].[Table1]
ADD CONSTRAINT UQ_EmailAddress UNIQUE ([EmailAddress]);

-- Indexes
CREATE INDEX IX_Username ON [dbo].[Table1] ([Username]);

CREATE INDEX IX_EmailAddress ON [dbo].[Table1] ([EmailAddress]);

-- Foreign Key Constraints
ALTER TABLE [dbo].[Table1]
ADD CONSTRAINT FK_UserType FOREIGN KEY ([UserTypeId]) REFERENCES [dbo].[UserTypeTable]([UserTypeId]);
