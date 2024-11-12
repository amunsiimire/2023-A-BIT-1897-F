<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?></h2>
        <h4>Balance: $<?php echo number_format($user['balance'], 2); ?></h4>
        <a href="deposit.php" class="btn btn-success">Deposit</a>
        <a href="withdraw.php" class="btn btn-warning">Withdraw</a>
        <a href="transfer.php" class="btn btn-info">Transfer</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
