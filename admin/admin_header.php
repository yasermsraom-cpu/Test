<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php"); exit;
}
$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>SAMAK Admin</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header class="site-header">
    <div class="container header-inner">
        <a href="index.php" class="logo">SAMAK Admin</a>
        <span class="user-name">Welcome, <?= htmlspecialchars($_SESSION['admin_user']) ?></span>
        <a href="logout.php" class="btn btn-light">Logout</a>
    </div>
</header>

<div class="container">
    <div class="admin-wrap">
        <aside class="admin-sidebar">
            <h3>Your Dashboard</h3>
            <a href="index.php"        class="<?= $current=='index.php'        ? 'active' : '' ?>">Dashboard</a>
            <a href="products.php"     class="<?= $current=='products.php' || $current=='add_product.php' || $current=='edit_product.php' ? 'active' : '' ?>">Listings</a>
            <a href="orders.php"       class="<?= $current=='orders.php'       ? 'active' : '' ?>">Orders</a>
            <a href="users.php"        class="<?= $current=='users.php'        ? 'active' : '' ?>">Users</a>
        </aside>

        <section class="admin-content">
