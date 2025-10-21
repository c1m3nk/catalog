<?php

$koneksi = new mysqli("localhost", "root", "", "lakistro");

// ambil data dari tabel kategori
$data_product = $koneksi->query("SELECT * FROM product ORDER BY IDproduct");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Kategori</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow-lg p-4 rounded-4 mb-4">
      <h3 class="mb-4 text-center">Tambah Kategori</h3>

      <form action="" method="POST">
        <div class="mb-3">
          <label class="form-label">IDproduct</label>
          <input type="text" name="IDproduct" class="form-control" placeholder="Masukkan ID product" required>
        </div>

        <div class="mb-3">
          <label class="form-label">product</label>
          <textarea name="product" class="form-control" rows="3" placeholder="Tuliskan nama product"></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Simpan</button>
      </form>
    </div>

    <!-- tabel data kategori -->
    <div class="card shadow-lg p-4 rounded-4">
      <h4 class="mb-3 text-center">Daftar product</h4>
      <table class="table table-bordered table-hover">
        <thead class="table-dark text-center">
          <tr>
            <th>No</th>
            <th>IDproduct</th>
            <th>product</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          while ($row = $data_product->fetch_assoc()) {
              echo "<tr>
                      <td class='text-center'>$no</td>
                      <td>{$row['IDproduct']}</td>
                      <td>{$row['Nama product']}</td>
                    </tr>";
              $no++;
          }

          if ($data_product->num_rows == 0) {
              echo "<tr><td colspan='3' class='text-center text-muted'>Belum ada data kategori.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>