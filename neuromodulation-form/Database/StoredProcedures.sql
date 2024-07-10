CREATE PROCEDURE InsertPatient
    @FirstName NVARCHAR(50),
    @Surname NVARCHAR(50),
    @DateOfBirth DATE,
    @Age INT,
    @SubmissionDate DATETIME,
    @TotalScore INT,
    @PatientId INT OUTPUT
AS
BEGIN
    INSERT INTO Patients (FirstName, Surname, DateOfBirth, Age, SubmissionDate, TotalScore)
    VALUES (@FirstName, @Surname, @DateOfBirth, @Age, @SubmissionDate, @TotalScore);
    SET @PatientId = SCOPE_IDENTITY();
END

CREATE PROCEDURE InsertPainInventory
    @PatientId INT,
    @Q1 INT,
    @Q2 INT,
    @Q3 INT,
    @Q4 INT,
    @Q5 INT,
    @Q6 INT,
    @Q7 INT,
    @Q8 INT,
    @Q9 INT,
    @Q10 INT,
    @Q11 INT,
    @Q12 INT
AS
BEGIN
    INSERT INTO PainInventory (PatientId, Q1, Q2, Q3, Q4, Q5, Q6, Q7, Q8, Q9, Q10, Q11, Q12)
    VALUES (@PatientId, @Q1, @Q2, @Q3, @Q4, @Q5, @Q6, @Q7, @Q8, @Q9, @Q10, @Q11, @Q12);
END

-- Additional procedures for update, delete and select operations
