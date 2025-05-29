<?php
require_once '../../vendor/autoload.php';

use App\Database\TransactionDAO;
use App\Database\UserDAO;

$trxDao = new TransactionDAO();
$userDao = new UserDAO();
$transactions = $trxDao->all();
?>

<h2>Daftar Transaksi</h2>
<a href="create.php">+ Tambah Transaksi</a>
<br><br>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama User</th>
            <th>Amount</th>
            <th>Jenis Transaksi</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transactions as $trx): 
            $user = $userDao->get($trx->getUserId());
        ?>
            <tr>
                <td><?= $trx->getId() ?></td>
                <td><?= htmlspecialchars($user ? $user->getName() : 'User tidak ditemukan') ?></td>
                <td><?= $trx->getAmount() ?></td>
                <td><?= ucfirst($trx->getTransactionType()) ?></td>
                <td><?= $trx->getCreatedAt() ?></td>
                <td>
                    <a href="get.php?id=<?= $trx->getId() ?>">Detail</a> |
                    <a href="edit.php?id=<?= $trx->getId() ?>">Edit</a> |
                    <a href="delete.php?id=<?= $trx->getId() ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
