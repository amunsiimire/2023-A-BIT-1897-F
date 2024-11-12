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

    $stmt = $pdo->prepare("SELECT balance FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if ($user['balance'] >= $amount) {
        $stmt = $pdo->prepare("UPDATE users SET balance = balance - ? WHERE id = ?");
        $stmt->execute([$amount, $userId]);

        $stmt = $pdo->prepare("INSERT INTO transactions (user_id, transaction_type, amount) VALUES (?, 'withdraw', ?)");
        $stmt->execute([$userId, $amount]);

        header("Location: dashboard.php");
    } else {
        echo "Insufficient balance!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Withdraw</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Withdraw Money</h2>
        <form method="POST">
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" class="form-control" name="amount" required>
            </div>
            <button type="submit" class="btn btn-warning">Withdraw</button>
        </form>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
