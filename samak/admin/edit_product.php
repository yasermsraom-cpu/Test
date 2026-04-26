<?php
include '../includes/db.php';
include 'admin_header.php';

$id  = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$msg = '';
$p   = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
if (!$p) { echo "<div class='alert alert-danger'>Product not found.</div>"; include 'admin_footer.php'; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name']);
    $description = trim($_POST['description']);
    $category    = $_POST['category'];
    $price       = (float)$_POST['price'];
    $quantity    = (float)$_POST['quantity'];
    $imageName   = $p['image']; // keep old by default

    // Optional new image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg','jpeg','png','gif','webp'];
        $ext     = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed) && $_FILES['image']['size'] <= 5*1024*1024) {
            $newName = time() . "_" . preg_replace('/[^a-z0-9_.-]/i','',$_FILES['image']['name']);
            if (move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $newName)) {
                // delete old uploaded image
                if (file_exists("../uploads/" . $imageName)) unlink("../uploads/" . $imageName);
                $imageName = $newName;
            }
        }
    }

    $stmt = $conn->prepare("
        UPDATE products SET name=?, description=?, category=?, price=?, quantity_kg=?, image=?
        WHERE id=?
    ");
    $stmt->bind_param("sssddsi", $name, $description, $category, $price, $quantity, $imageName, $id);
    if ($stmt->execute()) {
        header("Location: products.php?msg=updated"); exit;
    } else {
        $msg = "<div class='alert alert-danger'>Update failed.</div>";
    }
}

// Fresh row
$p = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
$img = "../uploads/" . $p['image'];
if (!file_exists($img)) $img = "../assets/images/fish/" . $p['image'];
?>

<h2>Edit Product</h2>
<?= $msg ?>

<form method="post" enctype="multipart/form-data" style="max-width:600px;">
    <div class="form-group">
        <label>Fish Name</label>
        <input type="text" name="name" class="form-control"
               value="<?= htmlspecialchars($p['name']) ?>" required>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control"><?= htmlspecialchars($p['description']) ?></textarea>
    </div>
    <div class="form-group">
        <label>Category</label>
        <select name="category" class="form-control">
            <option <?= $p['category']=='Premium Fish'?'selected':'' ?>>Premium Fish</option>
            <option <?= $p['category']=='Local Fish'  ?'selected':'' ?>>Local Fish</option>
        </select>
    </div>
    <div class="form-group">
        <label>Price (OMR / kg)</label>
        <input type="number" step="0.001" name="price" class="form-control"
               value="<?= $p['price'] ?>" required>
    </div>
    <div class="form-group">
        <label>Quantity (kg)</label>
        <input type="number" step="0.1" name="quantity" class="form-control"
               value="<?= $p['quantity_kg'] ?>" required>
    </div>

    <div class="form-group">
        <label>Current image:</label><br>
        <img src="<?= $img ?>" style="max-width:120px;border-radius:8px;"
             onerror="this.src='../assets/images/fish/default.png'">
    </div>
    <div class="form-group">
        <label>Replace image (optional)</label>
        <input type="file" name="image" id="imageInput" accept="image/*" class="form-control">
        <img id="imagePreview" src="" style="display:none;max-width:160px;margin-top:10px;border-radius:10px;">
    </div>

    <button type="submit" class="btn btn-primary">Update Product</button>
    <a href="products.php" class="btn btn-light">Cancel</a>
</form>

<?php include 'admin_footer.php'; ?>
