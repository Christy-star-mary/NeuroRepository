CREATE DATABASE Neuromodulation;

USE Neuromodulation;

CREATE TABLE Patients (
    Id INT PRIMARY KEY IDENTITY(1,1),
    FirstName NVARCHAR(50),
    Surname NVARCHAR(50),
    DateOfBirth DATE,
    Age INT,
    SubmissionDate DATETIME,
    TotalScore INT
);

CREATE TABLE PainInventory (
    Id INT PRIMARY KEY IDENTITY(1,1),
    PatientId INT FOREIGN KEY REFERENCES Patients(Id),
    Q1 INT,
    Q2 INT,
    Q3 INT,
    Q4 INT,
    Q5 INT,
    Q6 INT,
    Q7 INT,
    Q8 INT,
    Q9 INT,
    Q10 INT,
    Q11 INT,
    Q12 INT
);
