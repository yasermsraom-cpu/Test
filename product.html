<?php
include 'includes/db.php';
include 'includes/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$r  = $conn->query("SELECT * FROM products WHERE id = $id LIMIT 1");
if (!$r || $r->num_rows == 0) {
    echo "<div class='alert alert-danger'>Fish not found.</div>";
    include 'includes/footer.php';
    exit;
}
$p   = $r->fetch_assoc();
$img = "uploads/" . $p['image'];
if (!file_exists($img)) $img = "assets/images/fish/" . $p['image'];
?>

<div class="form-card" style="max-width:600px;">
    <img src="<?= $img ?>" alt="<?= htmlspecialchars($p['name']) ?>"
         style="display:block;margin:0 auto 20px;max-width:220px;"
         onerror="this.src='assets/images/fish/default.png'">

    <h2 style="text-align:center;"><?= strtoupper($p['name']) ?></h2>
    <p style="text-align:center;color:var(--muted);margin-bottom:14px;">
        <?= htmlspecialchars($p['description']) ?>
    </p>
    <p style="text-align:center;">
        <strong>Category:</strong> <?= $p['category'] ?><br>
        <strong>Price:</strong> <?= number_format($p['price'],3) ?> OMR / kg<br>
        <strong>Available:</strong> <?= $p['quantity_kg'] ?> kg
    </p>

    <?php if (isset($_SESSION['user_id'])): ?>
    <form action="add_to_cart.php" method="post" style="margin-top:20px;">
        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
        <div class="form-group">
            <label>Quantity (kg)</label>
            <input type="number" name="quantity" value="1" min="1"
                   max="<?= (int)$p['quantity_kg'] ?>" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Add to Cart</button>
    </form>
    <?php else: ?>
        <p class="form-link">
            Please <a href="login.php">login</a> to add this fish to your cart.
        </p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
