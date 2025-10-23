<?php
// require_once("../../config/Database.php");

// ambil parameter routing
$page   = $_GET['page'] ?? 'dashboard';
$action = $_GET['action'] ?? 'index';

// Routing halaman admin
switch ($page) {
    case 'dashboard':
        include '../../page/admin/admin-page/dashboard.php';
        break;

    case 'form_product':
        include '../../page/admin/admin-page/form_product.php';
        break;

    default:
        echo "<h2 style='text-align:center;margin-top:40px;'>Halaman tidak ditemukan :(</h2>";
        break;
}
?>