  <?php
$koneksi = new mysqli("localhost", "root", "", "lakistro");

// --- VAR UNTUK NOTIFIKASI ---
$notifikasi = "";

// --- HAPUS DATA ---
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  $koneksi->query("DELETE FROM product WHERE ID_product = '$id'");
  $notifikasi = "<div class='alert alert-warning text-center fade-alert'>
        Data product dengan ID <b>$id</b> berhasil dihapus!
    </div>";
}

// --- AMBIL DATA UNTUK EDIT ---
$edit_mode = false;
$edit_id = "";
$edit_nama = "";
$edit_harga = "";
$edit_ukuran = "";
$edit_deskripsi = "";

if (isset($_GET['edit'])) {
  $edit_id = $_GET['edit'];
  $data_edit = $koneksi->query("SELECT * FROM product WHERE ID_product = '$edit_id'");
  if ($data_edit->num_rows > 0) {
    $row = $data_edit->fetch_assoc();
    $edit_mode = true;
    $edit_id = $row['ID_product'];
    $edit_nama = $row['Nama_product'];
    $edit_harga = $row['Harga'];
    $edit_ukuran = $row['Ukuran'];
    $edit_deskripsi = $row['Deskripsi'];
  }
}

// --- SIMPAN DATA (TAMBAH / UPDATE) ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $ID_product = trim($_POST['ID_product']);
  $Nama_product  = trim($_POST['Nama_product']);
  $Harga = trim($_POST['Harga']);
  $Ukuran = trim($_POST['Ukuran']);
  $Deskripsi = trim($_POST['Deskripsi']);

  if (!empty($ID_product) && !empty($Nama_product)) {
    if (isset($_POST['update'])) {
      $old_id = $_POST['old_id'];
      $koneksi->query("UPDATE product SET 
                ID_product='$ID_product', 
                Nama_product='$Nama_product', 
                Harga='$Harga', 
                Ukuran='$Ukuran', 
                Deskripsi='$Deskripsi' 
                WHERE ID_product='$old_id'");
      $notifikasi = "<div class='alert alert-info text-center fade-alert'>Data product berhasil diperbarui!</div>";
    } else {
      $cek = $koneksi->query("SELECT * FROM product WHERE ID_product='$ID_product'");
      if ($cek->num_rows > 0) {
        $notifikasi = "<div class='alert alert-danger text-center fade-alert'>
                    ID product <b>$ID_product</b> sudah ada! Gunakan ID lain.
                </div>";
      } else {
        $koneksi->query("INSERT INTO product (ID_product, Nama_product, Harga, Ukuran, Deskripsi)
                    VALUES ('$ID_product', '$Nama_product', '$Harga', '$Ukuran', '$Deskripsi')");
        $notifikasi = "<div class='alert alert-success text-center fade-alert'>
                    Data product berhasil disimpan!
                </div>";
      }
    }
  }
}

// --- AMBIL SEMUA DATA PRODUCT ---
$data_product = $koneksi->query("SELECT * FROM product ORDER BY ID_product");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Manajemen Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .fade-alert {
      opacity: 1;
      transition: opacity 1s ease-out;
    }

    .fade-alert.hide {
      opacity: 0;
    }
  </style>
  <script>
    function konfirmasiHapus(id) {
      if (confirm('Yakin ingin menghapus data dengan ID ' + id + '?')) {
        window.location = '?page=form_product&hapus=' + id;
      }
    }

    document.addEventListener("DOMContentLoaded", () => {
      const alertBox = document.querySelector(".fade-alert");
      if (alertBox) {
        setTimeout(() => {
          alertBox.classList.add("hide");
          setTimeout(() => alertBox.remove(), 800);
        }, 1500);
      }
    });
  </script>
</head>

<body class="bg-light">
  <div class="container mt-4">

    <!-- Notifikasi -->
    <?php if (!empty($notifikasi)) echo $notifikasi; ?>

    <div class="card shadow-lg p-4 rounded-4 mb-4">
      <h3 class="mb-4 text-center"><?= $edit_mode ? 'Edit Data Product' : 'Tambah Product' ?></h3>

      <form action="?page=form_product" method="POST">
        <div class="mb-3">
          <label class="form-label">ID Product</label>
          <input type="text" name="ID_product" class="form-control"
            value="<?= $edit_mode ? htmlspecialchars($edit_id) : '' ?>"
            placeholder="Masukkan ID product" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Nama Product</label>
          <textarea name="Nama_product" class="form-control" rows="2"
            placeholder="Tuliskan Nama Product"
            required><?= $edit_mode ? htmlspecialchars($edit_nama) : '' ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Harga</label>
          <input type="number" name="Harga" class="form-control"
            value="<?= $edit_mode ? htmlspecialchars($edit_harga) : '' ?>"
            placeholder="Tuliskan Harga" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Ukuran</label>
          <input type="text" name="Ukuran" class="form-control"
            value="<?= $edit_mode ? htmlspecialchars($edit_ukuran) : '' ?>"
            placeholder="Tuliskan Ukuran" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Deskripsi</label>
          <textarea name="Deskripsi" class="form-control" rows="3"
            placeholder="Tuliskan Deskripsi"
            required><?= $edit_mode ? htmlspecialchars($edit_deskripsi) : '' ?></textarea>
        </div>

        <?php if ($edit_mode): ?>
          <input type="hidden" name="old_id" value="<?= htmlspecialchars($edit_id) ?>">
          <button type="submit" name="update" class="btn btn-warning w-100">Update Data</button>
          <a href="?page=form_product" class="btn btn-secondary w-100 mt-2">Batal Edit</a>
        <?php else: ?>
          <button type="submit" class="btn btn-primary w-100">Simpan</button>
        <?php endif; ?>
      </form>
    </div>

    <div class="card shadow-lg p-4 rounded-4">
      <h4 class="mb-3 text-center">Daftar Product</h4>
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark text-center">
          <tr>
            <th>No</th>
            <th>ID Product</th>
            <th>Nama Product</th>
            <th>Harga</th>
            <th>Ukuran</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          if ($data_product->num_rows > 0) {
            while ($row = $data_product->fetch_assoc()) {
              echo "<tr>
                <td class='text-center'>$no</td>
                <td class='text-center'>{$row['ID_product']}</td>
                <td class='text-center'>{$row['Nama_product']}</td>
                <td class='text-center'>" . "Rp " . number_format($row['Harga'], 0, ',', '.') . "</td>
                <td class='text-center'>{$row['Ukuran']}</td>
                <td class='text-center'>{$row['Deskripsi']}</td>
                <td class='text-center'>
                    <a href='?page=form_product&edit={$row['ID_product']}' class='btn btn-warning btn-sm me-1'>Edit</a>
                    <button class='btn btn-danger btn-sm' onclick=\"konfirmasiHapus('{$row['ID_product']}')\">Hapus</button>
                </td>
            </tr>";
              $no++;
            }
          } else {
            echo "<tr><td colspan='7' class='text-center text-muted'>Belum ada data Product.</td></tr>";
          }
          ?>
        </tbody>

        </tbody>
      </table>
    </div>
  </div>
</body>

</html>