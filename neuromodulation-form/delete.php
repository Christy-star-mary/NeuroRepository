<?php
require 'config.php';

$patientId = $_GET['id'];

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $conn->prepare("DELETE FROM PainInventory WHERE PatientId = ?");
    $stmt->execute([$patientId]);

    $stmt = $conn->prepare("DELETE FROM Patients WHERE Id = ?");
    $stmt->execute([$patientId]);

    header("Location: admin.php");
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
