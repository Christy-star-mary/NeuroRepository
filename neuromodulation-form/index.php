<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $surname = $_POST['surname'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $age = $_POST['age'];
    $submissionDate = date('Y-m-d H:i:s');
    $totalScore = array_sum(array_slice($_POST, 3, 11));  // Calculate total score from Q2-Q12

    try {
        $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $conn->prepare("EXEC InsertPatient @FirstName=?, @Surname=?, @DateOfBirth=?, @Age=?, @SubmissionDate=?, @TotalScore=?, @PatientId=? OUTPUT");
        $stmt->bindParam(1, $firstName);
        $stmt->bindParam(2, $surname);
        $stmt->bindParam(3, $dateOfBirth);
        $stmt->bindParam(4, $age);
        $stmt->bindParam(5, $submissionDate);
        $stmt->bindParam(6, $totalScore);
        $stmt->bindParam(7, $patientId, PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4);
        $stmt->execute();

        $stmt = $conn->prepare("EXEC InsertPainInventory @PatientId=?, @Q1=?, @Q2=?, @Q3=?, @Q4=?, @Q5=?, @Q6=?, @Q7=?, @Q8=?, @Q9=?, @Q10=?, @Q11=?, @Q12=?");
        $stmt->execute([$patientId, $_POST['q1'], $_POST['q2'], $_POST['q3'], $_POST['q4'], $_POST['q5'], $_POST['q6'], $_POST['q7'], $_POST['q8'], $_POST['q9'], $_POST['q10'], $_POST['q11'], $_POST['q12']]);

        echo "Record inserted successfully";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Neuromodulation Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Neuromodulation</h1>
    <form method="post" action="">
        <div class="card">
            <div class="card-header">Patient Details</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                </div>
                <div class="form-group">
                    <label for="surname">Surname</label>
                    <input type="text" class="form-control" id="surname" name="surname" required>
                </div>
                <div class="form-group">
                    <label for="dateOfBirth">Date of Birth</label>
                    <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" required>
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" class="form-control" id="age" name="age" readonly>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">Brief Pain Inventory (BPI)</div>
            <div class="card-body">
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <div class="form-group">
                        <label for="q<?= $i ?>">Question <?= $i ?></label>
                        <input type="number" class="form-control" id="q<?= $i ?>" name="q<?= $i ?>" required>
                    </div>
                <?php endfor; ?>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">Total Score</div>
            <div class="card-body">
                <input type="number" class="form-control" id="totalScore" name="totalScore" readonly>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dateOfBirth').change(function() {
            var dob = new Date($(this).val());
            var ageDifMs = Date.now() - dob.getTime();
            var ageDate = new Date(ageDifMs);
            var age = Math.abs(ageDate.getUTCFullYear() - 1970);
            $('#age').val(age);
        });

        $('input[type="number"]').change(function() {
            var totalScore = 0;
            for (var i = 2; i <= 12; i++) {
                totalScore += parseInt($('#q' + i).val()) || 0;
            }
            $('#totalScore').val(totalScore);
        });
    });
</script>
</body>
</html>
