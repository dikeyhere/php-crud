<?php
    session_start();
    use App\Models\Transaction;
    use App\Database\TransactionDAO;
    use App\Database\UserDAO;

    $transDao = new TransactionDAO();
    $userDao = new UserDAO();
    $users = $userDao->all();
    $errors = $_SESSION['errors'] ?? [];
    unset($_SESSION['errors']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_POST['user_id'];
        $amount = isset($_POST['amount']) ? (int) $_POST['amount'] : 0;
        $type = $_POST['transaction_type'];

        $user = $userDao->get((int)$userId);

        $db = \App\Database\Connection::getDB();
        $blc = $db->prepare("SELECT balance FROM users WHERE id = ?");
        $blc->execute([$userId]);
        $currentBalance = (int) $blc->fetchColumn();

        if ($type === 'withdrawal' && $amount > $currentBalance) {
            $_SESSION['errors'][] = "Insufficient Balance";
            header("Location: /transactions/create");
        } else {
            $newBalance = $type === 'deposit'
                ? $currentBalance + $amount
                : $currentBalance - $amount;

            $trans = new Transaction(null, $userId, $amount, $type, null);
            $transDao->create($trans);

            $blc = $db->prepare("UPDATE users SET balance = ? WHERE id = ?");
            $blc->execute([$newBalance, $userId]);

            header("Location: /transactions");
        }
}
?>

<h2>Add Transaction</h2>

<form method="POST">
    <label for="user_id">User ID</label><br>
    <select name="user_id" required>
        <option value="" disabled selected>-- Select User --</option>
        <?php foreach ($users as $user): ?>
            <option value="<?= $user->getId() ?>">
                <?= htmlspecialchars($user->getName()) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="transaction_type">Transaction Type</label><br>
    <select name="transaction_type" required>
        <option value="" disabled selected>-- Select Type --</option>
        <option value="deposit">Deposit</option>
        <option value="withdrawal">Withdrawal</option>
    </select><br><br>

    <label for="amount">Amount</label><br>
    <input type="number" name="amount" required><br><br>

    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <button type="submit">Save</button>
    <a href="/transactions">Back</a>
</form>