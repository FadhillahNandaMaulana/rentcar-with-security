<?php
session_start();

if (!isset($_SESSION['login'])) {
  header("Location: index.php");
  exit();
}

$koneksi = new mysqli("localhost", "root", "", "carrental1");
if ($koneksi->connect_error) {
  die("Koneksi gagal: " . $koneksi->connect_error);
}

$pesan_sukses = $pesan_error = "";
$fromdate = $todate = $message = $metode = "";
$redirectId = null;

function validTanggal($tgl) {
  return preg_match('/^\d{4}-\d{2}-\d{2}$/', $tgl);
}

if (!isset($_GET['vhid']) || !is_numeric($_GET['vhid'])) {
  die("ID kendaraan tidak valid.");
}
$vehicleId = (int) $_GET['vhid'];

// Ambil data mobil
$sql_mobil = "SELECT * FROM tblvehicles WHERE id = ?";
$stmt_mobil = $koneksi->prepare($sql_mobil);
$stmt_mobil->bind_param("i", $vehicleId);
$stmt_mobil->execute();
$result_mobil = $stmt_mobil->get_result();
$mobil = $result_mobil->fetch_assoc();
$stmt_mobil->close();

if (!$mobil) {
  die("Data mobil tidak ditemukan.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fromdate = $koneksi->real_escape_string($_POST['fromdate'] ?? '');
  $todate = $koneksi->real_escape_string($_POST['todate'] ?? '');
  $message = $koneksi->real_escape_string($_POST['message'] ?? '');
  $metode = $koneksi->real_escape_string($_POST['metode'] ?? '');

  $email = $_SESSION['login'];
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $pesan_error = "Email sesi tidak valid.";
  }

  if (!validTanggal($fromdate) || !validTanggal($todate)) {
    $pesan_error = "Format tanggal tidak valid.";
  }

  $bookingNumber = rand(100000000, 999999999);
  $status = 0;

  $uploadDir = 'bukti_pembayaran/';
  $namaFileBaru = '';

  if (!empty($_FILES['bukti_pembayaran']) && $_FILES['bukti_pembayaran']['error'] === UPLOAD_ERR_OK) {
    $buktiFile = $_FILES['bukti_pembayaran'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
    if (in_array($buktiFile['type'], $allowedTypes) && $buktiFile['size'] <= 2 * 1024 * 1024) {
      $namaFileBaru = time() . '_' . basename($buktiFile['name']);
      $targetFile = $uploadDir . $namaFileBaru;

      if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
      }

      if (!move_uploaded_file($buktiFile['tmp_name'], $targetFile)) {
        $pesan_error = "Upload bukti pembayaran gagal.";
      }
    } else {
      $pesan_error = "Tipe file tidak didukung atau ukuran melebihi 2MB.";
    }
  } else {
    $pesan_error = "Bukti pembayaran wajib diunggah.";
  }

  if (!$pesan_error && $fromdate && $todate && $message && $metode && $namaFileBaru) {
    $sql_cek = "SELECT COUNT(*) as total FROM tblbooking 
                WHERE VehicleId = ? 
                AND Status IN (0,1) 
                AND (
                    (? BETWEEN FromDate AND ToDate) 
                    OR 
                    (? BETWEEN FromDate AND ToDate) 
                    OR 
                    (FromDate BETWEEN ? AND ?) 
                    OR 
                    (ToDate BETWEEN ? AND ?)
                )";

    $stmt_cek = $koneksi->prepare($sql_cek);
    $stmt_cek->bind_param("issssss", $vehicleId, $fromdate, $todate, $fromdate, $todate, $fromdate, $todate);
    $stmt_cek->execute();
    $result_cek = $stmt_cek->get_result();
    $row_cek = $result_cek->fetch_assoc();
    $stmt_cek->close();

    if ($row_cek['total'] > 0) {
      $pesan_error = "Mobil sudah dibooking pada tanggal tersebut.";
    } else {
      $sql = "INSERT INTO tblbooking 
              (BookingNumber, userEmail, VehicleId, FromDate, ToDate, message, Status, PostingDate, metode, payments)
              VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)";
      $stmt = $koneksi->prepare($sql);
      $stmt->bind_param("isisssiss", $bookingNumber, $email, $vehicleId, $fromdate, $todate, $message, $status, $metode, $namaFileBaru);

      if ($stmt->execute()) {
        $redirectId = $stmt->insert_id;
        $pesan_sukses = "Booking berhasil! Anda akan dialihkan ke halaman detail dalam 3 detik.";
      } else {
        $pesan_error = "Gagal menyimpan booking: " . $stmt->error;
      }
      $stmt->close();
    }
  } elseif (!$pesan_error) {
    $pesan_error = "Semua field wajib diisi.";
  }
}
?>

<!DOCTYPE html>
<html>

  <head>
    <title>Pemesanan - <?php echo htmlspecialchars($mobil['VehiclesTitle']); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
      function hitungTotal() {
        const fromDate = document.querySelector('input[name="fromdate"]').value;
        const toDate = document.querySelector('input[name="todate"]').value;
        const pricePerDay = <?php echo (float) $mobil['PricePerDay']; ?>;
        const totalField = document.getElementById('totalBayar');

        if (fromDate && toDate) {
          const start = new Date(fromDate);
          const end = new Date(toDate);

          const diffTime = end - start;
          const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;

          if (diffDays > 0) {
            const total = diffDays * pricePerDay;
            totalField.value = total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
          } else {
            totalField.value = '';
          }
        } else {
          totalField.value = '';
        }
      }

      window.addEventListener('DOMContentLoaded', () => {
        document.querySelector('input[name="fromdate"]').addEventListener('change', hitungTotal);
        document.querySelector('input[name="todate"]').addEventListener('change', hitungTotal);
        hitungTotal();
      });
    </script>
  </head>

  <body>
    <div class="container mt-5" style="background-color:rgb(198, 198, 198)">
      <div class="row" >
        <!-- Kiri: Info Mobil -->
        <div class="col-md-6" >
          <div class="card" style="background-color:rgb(198, 198, 198)">
            <?php if (!empty($mobil['Vimage1'])): ?>
              <img src="admin/img/vehicleimages/<?php echo htmlspecialchars($mobil['Vimage1']); ?>" class="card-img-top"
                alt="Gambar Mobil">
            <?php else: ?>
              <img src="https://via.placeholder.com/500x300?text=No+Image" class="card-img-top" alt="No Image">
            <?php endif; ?>
            <div class="card-body">
              <h4 class="card-title"><?php echo htmlspecialchars($mobil['VehiclesTitle']); ?></h4>
              <p><strong>Harga Per Hari:</strong> Rp. <?php echo number_format($mobil['PricePerDay'], 0, ',', '.'); ?></p>
              <p><strong>Kursi:</strong> <?php echo htmlspecialchars($mobil['SeatingCapacity']); ?></p>
              <p><strong>Tahun:</strong> <?php echo htmlspecialchars($mobil['ModelYear']); ?></p>
              <p><strong>Tipe Bensin:</strong> <?php echo htmlspecialchars($mobil['FuelType']); ?></p>
            </div>
          </div>
        </div>

        <!-- Kanan: Form Booking -->
        <div class="col-md-6">
          <h3>Pesan Sekarang</h3>

          <?php if ($pesan_sukses): ?>
            <div class="alert alert-success"><?php echo $pesan_sukses; ?></div>
          <?php endif; ?>
          <?php if ($pesan_error): ?>
            <div class="alert alert-danger"><?php echo $pesan_error; ?></div>
          <?php endif; ?>

          <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
              <label>Dari Tanggal</label>
              <input type="date" class="form-control" name="fromdate" value="<?php echo htmlspecialchars($fromdate); ?>"
                required>
            </div>
            <div class="form-group">
              <label>Sampai Tanggal</label>
              <input type="date" class="form-control" name="todate" value="<?php echo htmlspecialchars($todate); ?>"
                required>
            </div>
            <div class="form-group">
              <label>Pesan</label>
              <textarea class="form-control" name="message" rows="4"
                required><?php echo htmlspecialchars($message); ?></textarea>
            </div>
            <div class="form-group">
              <label>Metode Pengambilan</label>
              <select class="form-control" name="metode" required>
                <option value="">-- Pilih Metode --</option>
                <option value="Ambil Sendiri" <?php if ($metode == 'Ambil Sendiri')
                  echo 'selected'; ?>>Ambil Sendiri
                </option>
                <option value="Diantar ke Alamat" <?php if ($metode == 'Diantar ke Alamat')
                  echo 'selected'; ?>>Diantar ke
                  Alamat</option>
              </select>
            </div>
            <div class="form-group">
              <label>Transfer Via Bank</label>
              <input type="text" class="form-control" id="Transfer Via Bank" readonly
                placeholder="191883108301039 An RENTCAR">
            </div>

            <div class="form-group">
              <label>Total Bayar</label>
              <input type="text" class="form-control" id="totalBayar" readonly
                placeholder="Total akan dihitung otomatis">
            </div>

            <!-- Bagian upload bukti pembayaran -->
            <div class="form-group">
              <label>Upload Bukti Pembayaran</label>
              <input type="file" class="form-control-file" name="bukti_pembayaran" accept="image/*,application/pdf"
                required>
            </div>

            <button type="submit" class="btn btn-primary">Pesan Sekarang</button>
          </form>

          <?php if (!empty($pesan_sukses) && $redirectId !== null): ?>
            <script>
              setTimeout(function () {
                window.location.href = 'detail-booking.php?id=<?php echo $redirectId; ?>';
              }, 3000);
            </script>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </body>


</html>