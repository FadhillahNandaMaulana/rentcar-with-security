<?php
session_start();

if (!isset($_SESSION['login'])) {
  header("Location: index.php");
  exit();
}

$koneksi = new mysqli("localhost", "root", "", "carrental1");
if ($koneksi->connect_error) {
  die("Koneksi gagal: " . htmlspecialchars($koneksi->connect_error));
}

// Validasi id booking
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
  die("ID booking tidak valid.");
}
$bookingId = (int) $_GET['id'];

// Ambil data booking + data mobil
$sql = "SELECT b.*, v.VehiclesTitle, v.PricePerDay, v.SeatingCapacity, v.ModelYear, v.FuelType, v.Vimage1
        FROM tblbooking b
        JOIN tblvehicles v ON b.VehicleId = v.id
        WHERE b.id = ?";
$stmt = $koneksi->prepare($sql);
if (!$stmt) {
  die("Kesalahan query: " . htmlspecialchars($koneksi->error));
}
$stmt->bind_param("i", $bookingId);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();
$stmt->close();

if (!$booking) {
  die("Booking tidak ditemukan.");
}

// Format tanggal
$fromdate = date("d M Y", strtotime($booking['FromDate']));
$todate = date("d M Y", strtotime($booking['ToDate']));
$postingDate = date("d M Y H:i:s", strtotime($booking['PostingDate']));

// Hitung total bayar (hari * harga)
$diff = (strtotime($booking['ToDate']) - strtotime($booking['FromDate'])) / (60 * 60 * 24) + 1;
$totalBayar = $diff * $booking['PricePerDay'];
?>

<!DOCTYPE html>
<html>

  <head>
    <title>Detail Pesanan - <?php echo htmlspecialchars($booking['VehiclesTitle']); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
      @media print {
        .no-print {
          display: none;
        }
      }
    </style>
  </head>

  <body>
    <div class="container mt-5 mb-5" style="background-color:rgb(198, 198, 198)">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="index.php" class="btn btn-secondary no-print mr-3">Kembali ke Beranda</a>
        <h2 class="flex-grow-1 text-center mb-0">Detail Pemesanan</h2>
        <button onclick="window.print()" class="btn btn-primary no-print ml-3">Print</button>
      </div>


      <div class="card mb-4" style="background-color:rgb(198, 198, 198)">
        <?php if (!empty($booking['Vimage1'])): ?>
          <img src="admin/img/vehicleimages/<?php echo htmlspecialchars($booking['Vimage1']); ?>" class="card-img-top"
            alt="Gambar Mobil">
        <?php else: ?>
          <img src="https://via.placeholder.com/500x300?text=No+Image" class="card-img-top" alt="No Image">
        <?php endif; ?>
        <div class="card-body" >
          <h4 class="card-title"><?php echo htmlspecialchars($booking['VehiclesTitle']); ?></h4>
          <p><strong>Harga per Hari:</strong> Rp.<?php echo number_format($booking['PricePerDay'], 0, ',', '.'); ?></p>
          <p><strong>Kursi:</strong> <?php echo htmlspecialchars($booking['SeatingCapacity']); ?></p>
          <p><strong>Tahun:</strong> <?php echo htmlspecialchars($booking['ModelYear']); ?></p>
          <p><strong>Tipe Bensin:</strong> <?php echo htmlspecialchars($booking['FuelType']); ?></p>
        </div>
      </div>

      <table class="table table-bordered" >
        <tr>
          <th>Pemesanan Nomor</th>
          <td><?php echo htmlspecialchars($booking['BookingNumber']); ?></td>
        </tr>
        <tr>
          <th>Email Pengguna</th>
          <td><?php echo htmlspecialchars($booking['userEmail']); ?></td>
        </tr>
        <tr>
          <th>Dari Tanggal</th>
          <td><?php echo $fromdate; ?></td>
        </tr>
        <tr>
          <th>Sampai Tanggal</th>
          <td><?php echo $todate; ?></td>
        </tr>
        <tr>
          <th>Pesan</th>
          <td><?php echo nl2br(htmlspecialchars($booking['message'])); ?></td>
        </tr>
        <tr>
          <th>Posting Tanggal</th>
          <td><?php echo $postingDate; ?></td>
        </tr>
        <tr>
          <th>Metode Pengambilan</th>
          <td><?php echo htmlspecialchars($booking['metode']); ?></td>
        </tr>
        <tr>
          <th>Total Bayar</th>
          <td>Rp.<?php echo number_format($totalBayar, 2, ',', '.'); ?></td>
        </tr>
        <tr>
          <th>Bukti Pembayaran</th>
          <td>
            <?php if (!empty($booking['payments'])): ?>
              <?php
              $file = $booking['payments'];
              $ext = pathinfo($file, PATHINFO_EXTENSION);
              if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])):
                ?>
                <img src="bukti_pembayaran/<?php echo htmlspecialchars($file); ?>" alt="Bukti Pembayaran"
                  style="max-width:300px;">
              <?php elseif (strtolower($ext) === 'pdf'): ?>
                <a href="bukti_pembayaran/<?php echo htmlspecialchars($file); ?>" target="_blank">Lihat Bukti Pembayaran
                  (PDF)</a>
              <?php else: ?>
                File bukti pembayaran: <?php echo htmlspecialchars($file); ?>
              <?php endif; ?>
            <?php else: ?>
              Belum ada bukti pembayaran.
            <?php endif; ?>
          </td>
        </tr>
      </table>
    </div>
  </body>

</html>