
### 6. Additional Pages for View, Edit, and Delete Operations
**`view.php`**:
```php
<?php
require 'config.php';

$patientId = $_GET['id'];

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Patient</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>View Patient</h1>
    <div class="card">
        <div class="card-header">Patient Details</div>
        <div class="card-body">
            <p><strong>First Name:</strong> <?= $patient['FirstName'] ?></p>
            <p><strong>Surname:</strong> <?= $patient['Surname'] ?></p>
            <p><strong>Date of Birth:</strong> <?= $patient['DateOfBirth'] ?></p>
            <p><strong>Age:</strong> <?= $patient['Age'] ?></p>
            <p><strong>Date of Submission:</strong> <?= $patient['SubmissionDate'] ?></p>
            <p><strong>Total Score:</strong> <?= $patient['TotalScore'] ?></p>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header">Pain Inventory</div>
        <div class="card-body">
            <?php for ($i = 1; $i <= 12; $i++): ?>
                <p><strong>Question <?= $i ?>:</strong> <?= $painInventory['Q' . $i] ?></p>
            <?php endfor; ?>
        </div>
    </div>
    <a href="admin.php" class="btn btn-secondary mt-3">Back to Admin</a>
</div>
</body>
</html>
