<?php
    use App\Database\TransactionDAO;
    use App\Database\UserDAO;

    $transDao = new TransactionDAO();
    $userDao = new UserDAO();

    $trans = $transDao->get($id);
    $user = $userDao->get($trans->getUserId());
?>

<h2>Transaction Details</h2>

<p><b>Transaction ID:</b> <?= $trans->getId() ?></p>
<p><b>User ID:</b> <?= $trans->getUserId() ?></p>
<p><b>User Name:</b> <?= htmlspecialchars($user->getName()); ?></p>
<p><b>Amount:</b> <?= $trans->getAmount(); ?></p>
<p><b>Transaction Type:</b> <?= ucfirst($trans->getTransactionType()) ?></p>
<p><b>Created At:</b> <?= $trans->getCreatedAt() ?></p>

<a href="/transactions">Back</a>
