<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SAMAK - Fish Marketplace</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="site-header">
    <div class="container header-inner">
        <a href="index.php" class="logo">SAMAK</a>

        <nav class="nav-pills">
            <a href="index.php"  class="<?= $current=='index.php'  ? 'active' : '' ?>">Home</a>
            <a href="browse.php" class="<?= $current=='browse.php' ? 'active' : '' ?>">Browse</a>
            <a href="orders.php" class="<?= $current=='orders.php' ? 'active' : '' ?>">Order</a>
            <a href="profile.php" class="<?= $current=='profile.php' ? 'active' : '' ?>">Profile</a>
        </nav>

        <div class="header-right">
            <a href="cart.php" class="cart-icon" title="Cart">
                Cart
                <?php
                if (isset($_SESSION['user_id'])) {
                    include_once __DIR__ . '/db.php';
                    $uid = (int)$_SESSION['user_id'];
                    $r = $conn->query("SELECT COUNT(*) AS c FROM cart WHERE user_id=$uid");
                    $c = $r ? (int)$r->fetch_assoc()['c'] : 0;
                    if ($c > 0) echo "<span class='badge'>$c</span>";
                }
                ?>
            </a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="user-name">Hi, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                <a href="logout.php" class="btn btn-light">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-light">Login</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<main class="container main-area">
