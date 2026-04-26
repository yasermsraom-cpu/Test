<?php
include '../includes/db.php';
include 'admin_header.php';

// Update status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $oid    = (int)$_POST['order_id'];
    $status = $_POST['status'];
    $valid  = ['Pending','Out for delivery','Delivered','Cancelled'];
    if (in_array($status, $valid)) {
        $stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
        $stmt->bind_param("si", $status, $oid);
        $stmt->execute();
    }
    header("Location: orders.php?msg=updated"); exit;
}
?>

<h2>All Orders</h2>
<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success">Order status updated.</div>
<?php endif; ?>

<table class="table">
    <tr>
        <th>Order #</th><th>Customer</th><th>Total</th>
        <th>Address</th><th>Date</th><th>Status / Update</th>
    </tr>
    <?php
    $r = $conn->query("
        SELECT o.*, u.full_name, u.phone FROM orders o
        INNER JOIN users u ON u.id=o.user_id
        ORDER BY o.created_at DESC
    ");
    while ($o = $r->fetch_assoc()):
    ?>
    <tr>
        <td>
            <a href="../order_details.php?id=<?= $o['id'] ?>">
                #<?= str_pad($o['id'],5,'0',STR_PAD_LEFT) ?>
            </a>
        </td>
        <td>
            <?= htmlspecialchars($o['full_name']) ?><br>
            <small><?= htmlspecialchars($o['phone']) ?></small>
        </td>
        <td><?= number_format($o['total'],3) ?> OMR</td>
        <td style="font-size:12px;"><?= htmlspecialchars($o['address']) ?></td>
        <td><?= date('Y-m-d', strtotime($o['created_at'])) ?></td>
        <td>
            <form method="post" style="display:flex;gap:6px;">
                <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                <select name="status" class="form-control" style="padding:6px;">
                    <?php foreach (['Pending','Out for delivery','Delivered','Cancelled'] as $s): ?>
                        <option <?= $o['status']==$s?'selected':'' ?>><?= $s ?></option>
                    <?php endforeach; ?>
                </select>
                <button class="btn btn-primary" style="padding:6px 14px;">Save</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'admin_footer.php'; ?>
