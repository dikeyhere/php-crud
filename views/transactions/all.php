<?php
    use App\Database\TransactionDAO;
    use App\Database\UserDAO;

    $transDao = new TransactionDAO();
    $userDao = new UserDAO();
    $transactions = $transDao->all();
?>

<h2>Transaction List</h2>
<a href="/transactions/create">Create Transaction</a>
<br><br>

<table cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>User Name</th>
            <th>Amount</th>
            <th>Transaction Type</th>
            <th>Created At</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($transactions as $trans):
            $user = $userDao->get($trans->getUserId());
        ?>
            <tr>
                <td><?= htmlspecialchars($user->getName()) ?></td>
                <td><?= $trans->getAmount() ?></td>
                <td><?= ucfirst($trans->getTransactionType()) ?></td>
                <td><?= $trans->getCreatedAt() ?></td>
                <td>
                    <a href="/transactions/<?= $trans->getId() ?>">Detail</a> |
                    <a href="/transactions/<?= $trans->getId() ?>/edit">Edit</a> |
                    <a href="/transactions/<?= $trans->getId() ?>/delete">Hapus</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>