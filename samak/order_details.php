<?php
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); exit;
}
$uid = (int)$_SESSION['user_id'];
$oid = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$ord = $conn->query("SELECT * FROM orders WHERE id=$oid AND user_id=$uid")->fetch_assoc();
if (!$ord) { header("Location: orders.php"); exit; }

include 'includes/header.php';
?>

<h2 class="page-title">Order #<?= str_pad($ord['id'],5,'0',STR_PAD_LEFT) ?></h2>

<div class="form-card" style="max-width:700px;">
    <p><strong>Date:</strong> <?= $ord['created_at'] ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($ord['address']) ?></p>
    <p><strong>Delivery:</strong> <?= $ord['delivery_type'] ?></p>
    <p><strong>Status:</strong>
        <span class="status status-<?= explode(' ',$ord['status'])[0] ?>"><?= $ord['status'] ?></span>
    </p>

    <h3 style="margin-top:18px;color:var(--primary);">Items</h3>
    <table class="table" style="margin-top:10px;">
        <tr><th>Item</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr>
        <?php
        $items = $conn->query("
            SELECT oi.*, p.name FROM order_items oi
            INNER JOIN products p ON p.id=oi.product_id
            WHERE oi.order_id=$oid
        ");
        while ($it = $items->fetch_assoc()):
            $sub = $it['price'] * $it['quantity'];
        ?>
        <tr>
            <td><?= htmlspecialchars($it['name']) ?></td>
            <td><?= $it['quantity'] ?> kg</td>
            <td><?= number_format($it['price'],3) ?></td>
            <td><?= number_format($sub,3) ?></td>
        </tr>
        <?php endwhile; ?>
        <tr><td colspan="3" style="text-align:right;"><strong>Total</strong></td>
            <td><strong><?= number_format($ord['total'],3) ?> OMR</strong></td></tr>
    </table>

    <p style="margin-top:14px;text-align:center;">
        <a href="orders.php" class="btn btn-light">Back to Orders</a>
    </p>
</div>

<?php include 'includes/footer.php'; ?>
