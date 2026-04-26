<?php
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uid = (int)$_SESSION['user_id'];
    $pid = (int)$_POST['product_id'];
    $qty = max(1, (int)$_POST['quantity']);

    // If already in cart -> update quantity, else insert
    $r = $conn->query("SELECT id, quantity FROM cart WHERE user_id=$uid AND product_id=$pid LIMIT 1");
    if ($row = $r->fetch_assoc()) {
        $new = $row['quantity'] + $qty;
        $conn->query("UPDATE cart SET quantity=$new WHERE id=" . $row['id']);
    } else {
        $stmt = $conn->prepare("INSERT INTO cart (user_id,product_id,quantity) VALUES (?,?,?)");
        $stmt->bind_param("iii", $uid, $pid, $qty);
        $stmt->execute();
    }
}

header("Location: cart.php");
exit;
?>
