# Database Schema Documentation

## Table1
- **Id**: INT, Primary Key
- **UserTypeId**: NCHAR(10), Foreign Key to UserTypeTable
- **Username**: NVARCHAR(50), Unique
- **Password**: NVARCHAR(50)
- **EmailAddress**: NVARCHAR(100), Unique
- **DateOfBirth**: DATE
- **FirstName**: NVARCHAR(50)
- **LastName**: NVARCHAR(50)
- **Address**: NVARCHAR(255)
- **CreatedDate**: DATETIME, Default GETDATE()
- **ModifiedDate**: DATETIME
- **ModifiedBy**: NVARCHAR(50)

## UserTypeTable
- **UserTypeId**: NCHAR(10), Primary Key
- **Description**: NVARCHAR(50)
