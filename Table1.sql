CREATE TABLE [dbo].[Table1]
(
    [Id] INT NOT NULL PRIMARY KEY, 
    [UserTypeId] NCHAR(10) NOT NULL, 
    [Username] NVARCHAR(50) NOT NULL, 
    [Password] NVARCHAR(255) NOT NULL,
    [EmailAddress] NVARCHAR(100) NOT NULL, 
    [DateOfBirth] DATE NOT NULL, 
    [FirstName] NVARCHAR(50) NOT NULL, 
    [LastName] NVARCHAR(50) NOT NULL, 
    [Address] NVARCHAR(255) NOT NULL, 
    [SecurityQuestions] NCHAR(10) NULL, 
    [SecurityAnswers] NCHAR(10) NULL,
    [FailedAttempts] INT DEFAULT 0,
    [LockoutUntil] DATETIME NULL,
    [CreatedDate] DATETIME DEFAULT GETDATE(),
    [ModifiedDate] DATETIME,
    [ModifiedBy] NVARCHAR(50)
);