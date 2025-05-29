<?php
    use App\Database\TransactionDAO;
    use App\Database\UserDAO;

    $transDao = new TransactionDAO();
    $userDao = new UserDAO();

    $trans = $transDao->get($id);
    $user = $userDao->get($trans->getUserId());
?>

<h2>Transaction Details</h2>

<p><strong>Transaction ID:</strong> <?= $trans->getId() ?></p>
<p><strong>User Name:</strong> <?= htmlspecialchars($user->getName()); ?></p>
<p><strong>Amount:</strong> <?= $trans->getAmount(); ?></p>
<p><strong>Transaction Type:</strong> <?= ucfirst($trans->getTransactionType()) ?></p>
<p><strong>Created At:</strong> <?= $trans->getCreatedAt() ?></p>

<a href="/transactions">Kembali</a>
