<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Connect to database
$conn = new mysqli('localhost', 'root', '', 'admin_panel'); // Change if needed

// Handle Add Equipment
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $status = $_POST['status'];
    $conn->query("INSERT INTO equipment (name, status) VALUES ('$name', '$status')") or die($conn->error);
}

// Handle Delete Equipment
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM equipment WHERE id=$id") or die($conn->error);
    header("Location: equipment.php");
    exit;
}

// Handle Edit Equipment
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $status = $_POST['status'];
    $conn->query("UPDATE equipment SET name='$name', status='$status' WHERE id=$id") or die($conn->error);
    header("Location: equipment.php");
    exit;
}

// Get equipment list
$result = $conn->query("SELECT * FROM equipment");

// If editing, fetch current data
$edit_mode = false;
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $edit_id = $_GET['edit'];
    $edit_result = $conn->query("SELECT * FROM equipment WHERE id=$edit_id");
    $edit_data = $edit_result->fetch_assoc();
}
?>

<h1>Manage Equipment</h1>

<!-- Add or Edit Form -->
<form method="POST">
    <input type="hidden" name="id" value="<?= $edit_mode ? $edit_data['id'] : '' ?>">
    <input type="text" name="name" placeholder="Equipment Name" required value="<?= $edit_mode ? $edit_data['name'] : '' ?>">
    <select name="status" required>
        <option value="Available" <?= $edit_mode && $edit_data['status'] == 'Available' ? 'selected' : '' ?>>Available</option>
        <option value="Borrowed" <?= $edit_mode && $edit_data['status'] == 'Borrowed' ? 'selected' : '' ?>>Borrowed</option>
    </select>
    <button type="submit" name="<?= $edit_mode ? 'update' : 'add' ?>">
        <?= $edit_mode ? 'Update Equipment' : '+ Add Equipment' ?>
    </button>
    <?php if ($edit_mode): ?>
        <a href="equipment.php">Cancel</a>
    <?php endif; ?>
</form>

<!-- Equipment Table -->
<table border="1" cellpadding="8" cellspacing="0">
    <tr><th>ID</th><th>Name</th><th>Status</th><th>Actions</th></tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= $row['status'] ?></td>
        <td>
            <a href="equipment.php?edit=<?= $row['id'] ?>">Edit</a> |
            <a href="equipment.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
