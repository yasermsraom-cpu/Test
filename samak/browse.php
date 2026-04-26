<?php
include 'includes/db.php';
include 'includes/header.php';
?>

<h2 class="page-title">Browse Fish</h2>

<div class="search-bar">
    <input type="text" id="searchInput" placeholder="Search fish by name...">
    <select id="categoryFilter">
        <option value="all">All Categories</option>
        <option value="Premium Fish">Premium Fish</option>
        <option value="Local Fish">Local Fish</option>
    </select>
    <select id="priceFilter">
        <option value="none">Sort by price</option>
        <option value="low">Price: Low to High</option>
        <option value="high">Price: High to Low</option>
    </select>
</div>

<div class="products-grid">
    <?php
    $r = $conn->query("SELECT * FROM products WHERE in_service=1 ORDER BY name ASC");
    while ($p = $r->fetch_assoc()):
        $img = "uploads/" . $p['image'];
        if (!file_exists($img)) $img = "assets/images/fish/" . $p['image'];
    ?>
    <div class="product-card"
         data-name="<?= htmlspecialchars($p['name']) ?>"
         data-category="<?= $p['category'] ?>"
         data-price="<?= $p['price'] ?>">
        <img src="<?= $img ?>" alt="<?= htmlspecialchars($p['name']) ?>"
             onerror="this.src='assets/images/fish/default.png'">
        <h3><?= strtoupper($p['name']) ?></h3>
        <p class="desc"><?= htmlspecialchars($p['description']) ?></p>
        <div class="price"><?= number_format($p['price'],3) ?> OMR / kg</div>
        <small style="color:var(--muted)">Available: <?= $p['quantity_kg'] ?> kg</small>
        <div style="margin-top:10px;">
            <a href="product.php?id=<?= $p['id'] ?>" class="btn btn-primary">Buy</a>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<?php include 'includes/footer.php'; ?>
