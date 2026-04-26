<?php
include 'includes/db.php';
$msg = '';

if (isset($_GET['registered'])) {
    $msg = "<div class='alert alert-success'>Account created! Please login.</div>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, full_name, password, role FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        if (password_verify($pass, $row['password'])) {
            $_SESSION['user_id']   = $row['id'];
            $_SESSION['user_name'] = $row['full_name'];
            $_SESSION['user_role'] = $row['role'];
            header("Location: index.php");
            exit;
        }
    }
    $msg = "<div class='alert alert-danger'>Invalid email or password.</div>";
}

include 'includes/header.php';
?>

<div class="form-card">
    <h2>Login</h2>
    <?= $msg ?>

    <form method="post">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Login</button>

        <p class="form-link">
            Don't have an account? <a href="register.php">Sign Up</a>
        </p>
        <p class="form-link" style="font-size:12px;">
            By continuing, you agree to our<br>
            Privacy Policy & Terms of Use
        </p>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
