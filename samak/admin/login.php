<?php
include '../includes/db.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username']);
    $p = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username=?");
    $stmt->bind_param("s", $u);
    $stmt->execute();
    $r = $stmt->get_result();

    if ($row = $r->fetch_assoc()) {
        // Accept either hashed password OR plain "admin123" (first install)
        if (password_verify($p, $row['password']) || ($p === 'admin123' && $u === 'admin')) {
            $_SESSION['admin_id']   = $row['id'];
            $_SESSION['admin_user'] = $u;
            header("Location: index.php");
            exit;
        }
    }
    $msg = "<div class='alert alert-danger'>Invalid admin credentials.</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>SAMAK - Admin Login</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
    <div class="form-card">
        <h2>Admin Login</h2>
        <?= $msg ?>
        <form method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <p class="form-link">
                Default: <strong>admin / admin123</strong>
            </p>
        </form>
    </div>
</div>
</body>
</html>
