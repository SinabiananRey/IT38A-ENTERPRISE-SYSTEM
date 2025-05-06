<?php
require 'db.php';

// Handle Add Member
if (isset($_POST['add_member'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO members (name, email, role) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $role]);
    header("Location: members.php");
    exit;
}

// Handle Delete Member
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM members WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: members.php");
    exit;
}

// Handle Edit Member
if (isset($_POST['edit_member'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE members SET name = ?, email = ?, role = ? WHERE id = ?");
    $stmt->execute([$name, $email, $role, $id]);
    header("Location: members.php");
    exit;
}

// Fetch Members
$members = $conn->query("SELECT * FROM members")->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Manage Members</h1>

<!-- Add Member Form -->
<form method="POST" style="margin-bottom: 20px;">
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="role" placeholder="Role" value="Member" required>
    <button class="add-button" type="submit" name="add_member">+ Add Member</button>
</form>

<!-- Member Table -->
<table>
    <tr><th>ID</th><th>NAME</th><th>EMAIL</th><th>ROLE</th><th>ACTION</th></tr>
    <?php foreach ($members as $member): ?>
    <tr>
        <td><?= $member['id'] ?></td>
        <td><?= htmlspecialchars($member['name']) ?></td>
        <td><?= htmlspecialchars($member['email']) ?></td>
        <td><?= htmlspecialchars($member['role']) ?></td>
        <td>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="id" value="<?= $member['id'] ?>">
                <input type="text" name="name" value="<?= htmlspecialchars($member['name']) ?>" required>
                <input type="email" name="email" value="<?= htmlspecialchars($member['email']) ?>" required>
                <input type="text" name="role" value="<?= htmlspecialchars($member['role']) ?>" required>
                <button type="submit" name="edit_member">Edit</button>
            </form>
            <a href="members.php?delete=<?= $member['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
