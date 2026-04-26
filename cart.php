<?php
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$uid = (int)$_SESSION['user_id'];

// Handle remove
if (isset($_GET['remove'])) {
    $cid = (int)$_GET['remove'];
    $conn->query("DELETE FROM cart WHERE id=$cid AND user_id=$uid");
    header("Location: cart.php");
    exit;
}

include 'includes/header.php';

$res = $conn->query("
    SELECT c.id AS cart_id, c.quantity, p.id AS pid, p.name, p.price, p.image
    FROM cart c
    INNER JOIN products p ON p.id = c.product_id
    WHERE c.user_id=$uid
");
$total = 0;
?>

<h2 class="page-title">Your Cart</h2>

<?php if ($res->num_rows == 0): ?>
    <div class="alert alert-info">Your cart is empty.
        <a href="browse.php">Browse Fish</a>
    </div>
<?php else: ?>
    <table class="table">
        <tr>
            <th>Image</th><th>Name</th><th>Price</th><th>Qty (kg)</th>
            <th>Subtotal</th><th>Action</th>
        </tr>
        <?php while ($row = $res->fetch_assoc()):
            $sub = $row['price'] * $row['quantity'];
            $total += $sub;
            $img = "uploads/" . $row['image'];
            if (!file_exists($img)) $img = "assets/images/fish/" . $row['image'];
        ?>
        <tr>
            <td><img src="<?= $img ?>" onerror="this.src='assets/images/fish/default.png'"></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= number_format($row['price'],3) ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= number_format($sub,3) ?> OMR</td>
            <td>
                <a href="cart.php?remove=<?= $row['cart_id'] ?>"
                   class="btn btn-danger confirm-delete">Remove</a>
            </td>
        </tr>
        <?php endwhile; ?>
        <tr>
            <td colspan="4" style="text-align:right;"><strong>Total:</strong></td>
            <td colspan="2"><strong><?= number_format($total,3) ?> OMR</strong></td>
        </tr>
    </table>

    <div style="text-align:center;margin-top:20px;">
        <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
