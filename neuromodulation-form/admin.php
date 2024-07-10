<?php
require 'config.php';

$patients = []; // Initialize $patients as an empty array

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $conn->prepare("SELECT * FROM Patients");
    $stmt->execute();
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin View</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Admin View</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date of Submission</th>
                <th>First Name</th>
                <th>Surname</th>
                <th>Age</th>
                <th>Date of Birth</th>
                <th>Total Score</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($patients)): ?>
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td><?= $patient['SubmissionDate'] ?></td>
                        <td><?= $patient['FirstName'] ?></td>
                        <td><?= $patient['Surname'] ?></td>
                        <td><?= $patient['Age'] ?></td>
                        <td><?= $patient['DateOfBirth'] ?></td>
                        <td><?= $patient['TotalScore'] ?></td>
                        <td>
                            <a href="view.php?id=<?= $patient['Id'] ?>" class="btn btn-info">View</a>
                            <a href="edit.php?id=<?= $patient['Id'] ?>" class="btn btn-warning">Edit</a>
                            <a href="delete.php?id=<?= $patient['Id'] ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
