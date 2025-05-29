<?php
    use App\Database\TransactionDAO;

    $id = (int) $_GET['id'];
    $transDao = new TransactionDAO();
    $transDao->delete($id);

    header("Location: /transactions");
