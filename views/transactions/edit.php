<?php
    use App\Database\TransactionDAO;
    use App\Database\UserDAO;

    $transDao = new TransactionDAO();
    $userDao = new UserDAO();

    $id = (int) $_GET['id'];
    $trans = $transDao->get($id);
    $user = $userDao->get($trans->getUserId());

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newdate = $_POST['created_at'];

        $db = \App\Database\Connection::getDB();
        $create = $db->prepare("UPDATE transactions SET created_at = ? WHERE id = ?");
        $create->execute([$newdate, $id]);

        header("Location: /transactions");
    }
?>

<h2>Transaction Edit</h2>
<form method="post" action="/transactions/<?= $trans->getId() ?>/edit">
    <p>User ID: <input type="text" value="<?= $trans->getUserId(); ?>" readonly></p>
    <p>Name: <input type="text" value="<?= htmlspecialchars($user->getName()); ?>" readonly></p>
    <p>Amount: <input type="text" value="<?= $trans->getAmount(); ?>" readonly></p>
    <p>Transaction Type: <input type="text" value="<?= ucfirst($trans->getTransactionType()); ?>" readonly></p>
    <p>Created At:
        <input type="datetime-local" name="created_at" value="<?= date('Y-m-d\TH:i', strtotime($trans->getCreatedAt())); ?>" required>
    </p>
    <button type="submit">Save</button>
    <a href="/transactions">Back</a>
</form>

