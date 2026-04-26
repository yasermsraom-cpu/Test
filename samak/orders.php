<?php
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$uid = (int)$_SESSION['user_id'];

// Customer can cancel pending orders
if (isset($_GET['cancel'])) {
    $oid = (int)$_GET['cancel'];
    $conn->query("UPDATE orders SET status='Cancelled' WHERE id=$oid AND user_id=$uid AND status='Pending'");
    header("Location: orders.php");
    exit;
}

include 'includes/header.php';

if (isset($_GET['placed'])) {
    echo "<div class='alert alert-success'>Order placed successfully! You will receive a notification when ready.</div>";
}
?>

<h2 class="page-title">Order History</h2>

<?php
$res = $conn->query("SELECT * FROM orders WHERE user_id=$uid ORDER BY created_at DESC");
if ($res->num_rows == 0) {
    echo "<div class='alert alert-info'>You have no orders yet.</div>";
} else {
?>
<table class="table">
    <tr>
        <th>Order #</th><th>Date</th><th>Total</th>
        <th>Delivery</th><th>Status</th><th>Action</th>
    </tr>
    <?php while ($o = $res->fetch_assoc()):
        $statusClass = explode(' ', $o['status'])[0]; // Pending / Out / Delivered / Cancelled
    ?>
    <tr>
        <td>#<?= str_pad($o['id'],5,'0',STR_PAD_LEFT) ?></td>
        <td><?= date('Y-m-d H:i', strtotime($o['created_at'])) ?></td>
        <td><?= number_format($o['total'],3) ?> OMR</td>
        <td><?= $o['delivery_type'] ?></td>
        <td><span class="status status-<?= $statusClass ?>"><?= $o['status'] ?></span></td>
        <td>
            <a href="order_details.php?id=<?= $o['id'] ?>" class="btn btn-light">View</a>
            <?php if ($o['status'] === 'Pending'): ?>
                <a href="orders.php?cancel=<?= $o['id'] ?>"
                   class="btn btn-danger confirm-delete">Cancel</a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<?php } ?>

<?php include 'includes/footer.php'; ?>
