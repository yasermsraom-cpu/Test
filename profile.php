<?php
include 'includes/db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); exit;
}
$uid = (int)$_SESSION['user_id'];
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $stmt = $conn->prepare("UPDATE users SET full_name=?, email=?, phone=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $email, $phone, $uid);
    if ($stmt->execute()) {
        $_SESSION['user_name'] = $name;
        $msg = "<div class='alert alert-success'>Profile updated.</div>";
    } else {
        $msg = "<div class='alert alert-danger'>Update failed.</div>";
    }
}

$user = $conn->query("SELECT * FROM users WHERE id=$uid")->fetch_assoc();
include 'includes/header.php';
?>

<h2 class="page-title">My Profile</h2>

<div class="form-card">
    <?= $msg ?>
    <form method="post">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" class="form-control"
                   value="<?= htmlspecialchars($user['full_name']) ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control"
                   value="<?= htmlspecialchars($user['phone']) ?>">
        </div>
        <div class="form-group">
            <label>Account Type</label>
            <input type="text" class="form-control" value="<?= ucfirst($user['role']) ?>" disabled>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
