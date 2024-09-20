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
INSERT INTO [dbo].[UserTypeTable] ([UserTypeId], [Description])
VALUES 
    ('ADMIN', 'Administrator'),
    ('USER', 'Regular User');

INSERT INTO [dbo].[Table1] ([Id], [UserTypeId], [Username], [Password], [EmailAddress], [DateOfBirth], [FirstName], [LastName], [Address])
VALUES 
    (1, 'ADMIN', 'admin1', 'password123', 'admin1@example.com', '1980-01-01', 'Admin', 'User', '123 Admin St'),
    (2, 'USER', 'user1', 'password123', 'user1@example.com', '1990-01-01', 'John', 'Doe', '456 User Ave');
