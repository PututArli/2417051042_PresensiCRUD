<?php
$conn = mysqli_connect("localhost", "root", "", "praktikum_crud");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    mysqli_query($conn, "INSERT INTO mahasiswa (nama) VALUES ('$nama')");
    header("Location: index.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id=$id");
    header("Location: index.php");
    exit;
}

$edit = false;
$row = ['id' => '', 'nama' => ''];

if (isset($_GET['edit'])) {
    $edit = true;
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id=$id");
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    mysqli_query($conn, "UPDATE mahasiswa SET nama='$nama' WHERE id=$id");
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Sederhana</title>
</head>
<body>
    <h2>CRUD Sederhana</h2>
    
    <form method="POST">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <input type="text" name="nama" placeholder="Masukkan nama" value="<?= $row['nama'] ?>" required>
        <?php if ($edit): ?>
            <button type="submit" name="update">Update</button>
        <?php else: ?>
            <button type="submit" name="tambah">Tambah</button>
        <?php endif; ?>
    </form>

    <br>

    <table border="1" cellpadding="10" style="text-align: left;">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Aksi</th>
        </tr>
        <?php
        $data = mysqli_query($conn, "SELECT * FROM mahasiswa");
        $no = 1;
        while ($d = mysqli_fetch_assoc($data)) {
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $d['nama']; ?></td>
            <td>
                <a href="?edit=<?= $d['id']; ?>">Edit</a> 
                <a href="?hapus=<?= $d['id']; ?>">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>