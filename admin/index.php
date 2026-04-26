<?php
include '../includes/db.php';
include 'admin_header.php';

// quick stats
$nProducts = $conn->query("SELECT COUNT(*) c FROM products")->fetch_assoc()['c'];
$nOrders   = $conn->query("SELECT COUNT(*) c FROM orders")->fetch_assoc()['c'];
$nUsers    = $conn->query("SELECT COUNT(*) c FROM users")->fetch_assoc()['c'];
$revenue   = $conn->query("SELECT IFNULL(SUM(total),0) s FROM orders WHERE status='Delivered'")->fetch_assoc()['s'];
?>

<h2>Dashboard</h2>

<div class="stats-grid">
    <div class="stat-card">
        <div class="num"><?= $nProducts ?></div>
        <div class="lbl">Total Products</div>
    </div>
    <div class="stat-card">
        <div class="num"><?= $nOrders ?></div>
        <div class="lbl">Total Orders</div>
    </div>
    <div class="stat-card">
        <div class="num"><?= $nUsers ?></div>
        <div class="lbl">Registered Users</div>
    </div>
    <div class="stat-card">
        <div class="num"><?= number_format($revenue,3) ?></div>
        <div class="lbl">Revenue (OMR)</div>
    </div>
</div>

<h3 style="color:var(--primary);margin:20px 0 10px;">Recent Orders</h3>
<table class="table">
    <tr><th>Order #</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th></tr>
    <?php
    $r = $conn->query("
        SELECT o.*, u.full_name FROM orders o
        INNER JOIN users u ON u.id=o.user_id
        ORDER BY o.created_at DESC LIMIT 5
    ");
    while ($o = $r->fetch_assoc()):
        $cls = explode(' ', $o['status'])[0];
    ?>
    <tr>
        <td>#<?= str_pad($o['id'],5,'0',STR_PAD_LEFT) ?></td>
        <td><?= htmlspecialchars($o['full_name']) ?></td>
        <td><?= number_format($o['total'],3) ?> OMR</td>
        <td><span class="status status-<?= $cls ?>"><?= $o['status'] ?></span></td>
        <td><?= date('Y-m-d', strtotime($o['created_at'])) ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'admin_footer.php'; ?>
