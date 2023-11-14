<?php
require_once __DIR__ . '/../bootstrap.php';
use website\labs\Customer;
session_start();

if (!isset($_SESSION['id_owner'])) {
    header('Location: Dangnhap.php');
}

$customer = new Customer($PDO);

if (isset($_GET['id_customer']) && is_numeric($_GET['id_customer'])) {
    $id_customer = $_GET['id_customer'];
    $deleted = $customer->deleteCustomer($id_customer);

    if ($deleted) {
        $success = 'Xóa khách hàng thành công!';
        header('Location: dsCustomer.php');
    } else {
        $error = 'Lỗi khi xóa khách hàng.';
    }
}