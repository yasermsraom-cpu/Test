<?php
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$uid = (int)$_SESSION['user_id'];
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address  = trim($_POST['address']);
    $delivery = $_POST['delivery'];

    // calculate total from cart
    $r = $conn->query("
        SELECT c.quantity, p.price
        FROM cart c INNER JOIN products p ON p.id=c.product_id
        WHERE c.user_id=$uid
    ");
    $total = 0;
    $items = [];
    while ($row = $r->fetch_assoc()) {
        $total += $row['price'] * $row['quantity'];
    }
    if ($delivery === 'Fast') $total += 1.500; // fast delivery fee

    if ($total > 0) {
        // create order
        $stmt = $conn->prepare("INSERT INTO orders (user_id,address,delivery_type,total) VALUES (?,?,?,?)");
        $stmt->bind_param("issd", $uid, $address, $delivery, $total);
        $stmt->execute();
        $oid = $conn->insert_id;

        // copy cart items into order_items
        $r2 = $conn->query("
            SELECT c.product_id, c.quantity, p.price
            FROM cart c INNER JOIN products p ON p.id=c.product_id
            WHERE c.user_id=$uid
        ");
        while ($row = $r2->fetch_assoc()) {
            $stmt2 = $conn->prepare("INSERT INTO order_items (order_id,product_id,quantity,price) VALUES (?,?,?,?)");
            $stmt2->bind_param("iiid", $oid, $row['product_id'], $row['quantity'], $row['price']);
            $stmt2->execute();
        }

        // empty cart
        $conn->query("DELETE FROM cart WHERE user_id=$uid");

        header("Location: orders.php?placed=1");
        exit;
    } else {
        $msg = "<div class='alert alert-danger'>Cart is empty.</div>";
    }
}

include 'includes/header.php';

// Show summary
$r = $conn->query("
    SELECT c.quantity, p.name, p.price
    FROM cart c INNER JOIN products p ON p.id=c.product_id
    WHERE c.user_id=$uid
");
$total = 0;
?>

<h2 class="page-title">Checkout</h2>
<?= $msg ?>

<div class="form-card" style="max-width:600px;">
    <h3 style="color:var(--primary);">Order Summary</h3>
    <table class="table" style="margin:14px 0;">
        <tr><th>Item</th><th>Qty</th><th>Subtotal</th></tr>
        <?php while ($row = $r->fetch_assoc()):
            $sub = $row['price'] * $row['quantity'];
            $total += $sub;
        ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= $row['quantity'] ?> kg</td>
                <td><?= number_format($sub,3) ?> OMR</td>
            </tr>
        <?php endwhile; ?>
        <tr><td colspan="2"><strong>Total</strong></td>
            <td><strong><?= number_format($total,3) ?> OMR</strong></td></tr>
    </table>

    <form method="post">
        <div class="form-group">
            <label>Delivery Address</label>
            <textarea name="address" class="form-control" required
                placeholder="House, street, area, city"></textarea>
        </div>
        <div class="form-group">
            <label>Delivery Type</label>
            <select name="delivery" class="form-control">
                <option value="Free">Normal (Free)</option>
                <option value="Fast">Fast (+1.500 OMR)</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Confirm Order</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
