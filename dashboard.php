<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['nama'])) {
    header("Location: auth.php");
    exit();
}

if ($_SESSION['nama'] == 'admin' && isset($_GET['delete_id'])) {
    $id_hapus = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id_hapus);
    $stmt->execute();
    $stmt->close();
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>Selamat Datang di Dashboard</h2>
    <p>Halo, <?php echo htmlspecialchars($_SESSION['nama']); ?>!</p>

    <?php if ($_SESSION['nama'] == 'admin') : ?>
        <h3>Menu Admin: Kelola Pengguna</h3>
        <?php $result = $conn->query("SELECT id, nama FROM users"); ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                    <a href="dashboard.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>

    <br>
    <a href="logout.php"><button>Logout</button></a>
</body>
</html>