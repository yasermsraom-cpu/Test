<?php
include '../includes/db.php';
include 'admin_header.php';

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    // remove image file if it's in uploads/
    $row = $conn->query("SELECT image FROM products WHERE id=$id")->fetch_assoc();
    if ($row && file_exists("../uploads/" . $row['image'])) {
        unlink("../uploads/" . $row['image']);
    }
    $conn->query("DELETE FROM products WHERE id=$id");
    header("Location: products.php?msg=deleted");
    exit;
}

// Handle availability toggle
if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    $conn->query("UPDATE products SET in_service = 1 - in_service WHERE id=$id");
    header("Location: products.php");
    exit;
}
?>

<h2>Manage Products (Listings)</h2>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success">Action completed successfully.</div>
<?php endif; ?>

<a href="add_product.php" class="btn btn-primary" style="margin-bottom:14px;">+ Add New Product</a>

<table class="table">
    <tr>
        <th>Image</th><th>Name</th><th>Category</th>
        <th>Price (OMR)</th><th>Qty (kg)</th><th>Status</th><th>Actions</th>
    </tr>
    <?php
    $r = $conn->query("SELECT * FROM products ORDER BY id DESC");
    while ($p = $r->fetch_assoc()):
        $img = "../uploads/" . $p['image'];
        if (!file_exists($img)) $img = "../assets/images/fish/" . $p['image'];
    ?>
    <tr>
        <td><img src="<?= $img ?>" onerror="this.src='../assets/images/fish/default.png'"></td>
        <td><?= htmlspecialchars($p['name']) ?></td>
        <td><?= $p['category'] ?></td>
        <td><?= number_format($p['price'],3) ?></td>
        <td><?= $p['quantity_kg'] ?></td>
        <td>
            <?php if ($p['in_service']): ?>
                <span class="status status-Delivered">In service</span>
            <?php else: ?>
                <span class="status status-Cancelled">Out of service</span>
            <?php endif; ?>
        </td>
        <td>
            <a href="edit_product.php?id=<?= $p['id'] ?>" class="btn btn-light">Edit</a>
            <a href="products.php?toggle=<?= $p['id'] ?>" class="btn btn-light">Toggle</a>
            <a href="products.php?delete=<?= $p['id'] ?>"
               class="btn btn-danger confirm-delete">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'admin_footer.php'; ?>
