<?php
require 'config.php';

$patientId = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update patient details
    $firstName = $_POST['firstName'];
    $surname = $_POST['surname'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $age = $_POST['age'];
    $totalScore = array_sum(array_slice($_POST, 3, 11));  // Calculate total score from Q2-Q12

    try {
        $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $conn->prepare("UPDATE Patients SET FirstName = ?, Surname = ?, DateOfBirth = ?, Age = ?, TotalScore = ? WHERE Id = ?");
        $stmt->execute([$firstName, $surname, $dateOfBirth, $age, $totalScore, $patientId]);

        $stmt = $conn->prepare("UPDATE PainInventory SET Q1 = ?, Q2 = ?, Q3 = ?, Q4 = ?, Q5 = ?, Q6 = ?, Q7 = ?, Q8 = ?, Q9 = ?, Q10 = ?, Q11 = ?, Q12 = ? WHERE PatientId = ?");
        $stmt->execute([$_POST['q1'], $_POST['q2'], $_POST['q3'], $_POST['q4'], $_POST['q5'], $_POST['q6'], $_POST['q7'], $_POST['q8'], $_POST['q9'], $_POST['q10'], $_POST['q11'], $_POST['q12'], $patientId]);

        header("Location: admin.php");
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
} else {
    try {
        $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $conn->prepare("SELECT * FROM Patients WHERE Id = ?");
        $stmt->execute([$patientId]);
        $patient = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $stmt = $conn->prepare("SELECT * FROM PainInventory WHERE PatientId = ?");
        $stmt->execute([$patientId]);
        $painInventory = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <title>Edit Patient</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Edit Patient</h1>
    <form method="post" action="">
        <div class="card">
            <div class="card-header">Patient Details</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" value="<?= $patient['FirstName'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="surname">Surname</label>
                    <input type="text" class="form-control" id="surname" name="surname" value="<?= $patient['Surname'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="dateOfBirth">Date of Birth</label>
                    <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" value="<?= $patient['DateOfBirth'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" class="form-control" id="age" name="age" value="<?= $patient['Age'] ?>" readonly>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">Brief Pain Inventory (BPI)</div>
            <div class="card-body">
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <div class="form-group">
                        <label for="q<?= $i ?>">Question <?= $i ?></label>
                        <input type="number" class="form-control" id="q<?= $i ?>" name="q<?= $i ?>" value="<?= $painInventory['Q' . $i] ?>" required>
                    </div>
                <?php endfor; ?>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">Total Score</div>
            <div class="card-body">
                <input type="number" class="form-control" id="totalScore" name="totalScore" value="<?= $patient['TotalScore'] ?>" readonly>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Save</button>
    </form>
    <a href="admin.php" class="btn btn-secondary mt-3">Back to Admin</a>
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
