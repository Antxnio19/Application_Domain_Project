CREATE TABLE Table1 (
    Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    UserTypeId CHAR(10) NOT NULL, 
    Username VARCHAR(50) NOT NULL, 
    Password VARCHAR(255) NOT NULL,
    EmailAddress VARCHAR(100) NOT NULL, 
    DateOfBirth DATE NOT NULL, 
    FirstName VARCHAR(50) NOT NULL, 
    LastName VARCHAR(50) NOT NULL, 
    Address VARCHAR(255) NOT NULL, 
    SecurityQuestions CHAR(10) NULL, 
    SecurityAnswers CHAR(10) NULL,
    FailedAttempts INT DEFAULT 0,
    LockoutUntil DATETIME NULL,
    CreatedDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    ModifiedDate DATETIME ON UPDATE CURRENT_TIMESTAMP,
    ModifiedBy VARCHAR(50)
);

CREATE TABLE UserTypeTable (
    UserTypeId VARCHAR(10) NOT NULL PRIMARY KEY,
    Description VARCHAR(255) NOT NULL
);

-- Creating Table for IT TICKET SYSTEM ----

CREATE TABLE ticketsTable (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    issue TEXT NOT NULL,
    priority ENUM('low', 'medium', 'high') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
