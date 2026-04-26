<?php
include '../includes/db.php';
include 'admin_header.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name']);
    $description = trim($_POST['description']);
    $category    = $_POST['category'];
    $price       = (float)$_POST['price'];
    $quantity    = (float)$_POST['quantity'];

    // ============================================
    // IMAGE UPLOAD (this is the feature you asked for)
    // ============================================
    $imageName = 'default.png';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed   = ['jpg','jpeg','png','gif','webp'];
        $ext       = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $msg = "<div class='alert alert-danger'>Only JPG, PNG, GIF, WEBP allowed.</div>";
        } elseif ($_FILES['image']['size'] > 5 * 1024 * 1024) {
            $msg = "<div class='alert alert-danger'>Image must be less than 5MB.</div>";
        } else {
            // unique filename so users can't overwrite each other's
            $imageName = time() . "_" . preg_replace('/[^a-z0-9_.-]/i', '', $_FILES['image']['name']);
            $target    = "../uploads/" . $imageName;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $msg = "<div class='alert alert-danger'>Could not move uploaded file.</div>";
                $imageName = 'default.png';
            }
        }
    }

    if ($msg === '') {
        $stmt = $conn->prepare("
            INSERT INTO products (name,description,category,price,quantity_kg,image)
            VALUES (?,?,?,?,?,?)
        ");
        $stmt->bind_param("sssdds", $name, $description, $category, $price, $quantity, $imageName);
        if ($stmt->execute()) {
            header("Location: products.php?msg=added");
            exit;
        } else {
            $msg = "<div class='alert alert-danger'>Insert failed: " . $conn->error . "</div>";
        }
    }
}
?>

<h2>Add New Product</h2>
<?= $msg ?>

<form method="post" enctype="multipart/form-data" style="max-width:600px;">
    <div class="form-group">
        <label>Fish Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label>Category</label>
        <select name="category" class="form-control">
            <option value="Premium Fish">Premium Fish</option>
            <option value="Local Fish">Local Fish</option>
        </select>
    </div>
    <div class="form-group">
        <label>Price (OMR per kg)</label>
        <input type="number" step="0.001" name="price" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Quantity available (kg)</label>
        <input type="number" step="0.1" name="quantity" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Product Image</label>
        <input type="file" name="image" id="imageInput" accept="image/*" class="form-control">
        <img id="imagePreview" src="" style="display:none;max-width:160px;margin-top:10px;border-radius:10px;">
        <small style="color:var(--muted)">JPG / PNG / GIF / WEBP, max 5MB</small>
    </div>

    <button type="submit" class="btn btn-primary">Save Product</button>
    <a href="products.php" class="btn btn-light">Cancel</a>
</form>

<?php include 'admin_footer.php'; ?>
