<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    $userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
    $stmt->execute([$amount, $userId]);

    $stmt = $pdo->prepare("INSERT INTO transactions (user_id, transaction_type, amount) VALUES (?, 'deposit', ?)");
    $stmt->execute([$userId, $amount]);

    header("Location: dashboard.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Deposit</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Deposit Money</h2>
        <form method="POST">
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" class="form-control" name="amount" required>
            </div>
            <button type="submit" class="btn btn-success">Deposit</button>
        </form>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
