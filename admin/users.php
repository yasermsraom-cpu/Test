<?php
include '../includes/db.php';
include 'admin_header.php';

if (isset($_GET['delete'])) {
    $uid = (int)$_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$uid");
    header("Location: users.php?msg=deleted"); exit;
}
?>

<h2>Registered Users</h2>
<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success">User deleted.</div>
<?php endif; ?>

<table class="table">
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Joined</th><th>Action</th></tr>
    <?php
    $r = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
    while ($u = $r->fetch_assoc()):
    ?>
    <tr>
        <td><?= $u['id'] ?></td>
        <td><?= htmlspecialchars($u['full_name']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= htmlspecialchars($u['phone']) ?></td>
        <td><?= ucfirst($u['role']) ?></td>
        <td><?= date('Y-m-d', strtotime($u['created_at'])) ?></td>
        <td>
            <a href="users.php?delete=<?= $u['id'] ?>"
               class="btn btn-danger confirm-delete">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'admin_footer.php'; ?>
