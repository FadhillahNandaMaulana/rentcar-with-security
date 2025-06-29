<?php
session_start();
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {    
    header('location:index.php');
    exit;
}

// Proses end of rent jika ada parameter
if (isset($_GET['endrent'])) {
    $bid = intval($_GET['endrent']);

    $sql = "UPDATE tblbooking SET Status = 3 WHERE id = :bid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':bid', $bid, PDO::PARAM_INT);
    $success = $query->execute();

    if ($success) {
        $_SESSION['msg'] = "Booking berhasil diakhiri.";
    } else {
        $_SESSION['error'] = "Gagal memperbarui status booking.";
    }

    header("Location: dataofrent.php");
    exit;
}

// Ambil data booking yang statusnya 3 (selesai)
$status = 3;
$sql = "SELECT 
            tblusers.FullName, 
            tblbrands.BrandName, 
            tblvehicles.VehiclesTitle, 
            tblbooking.FromDate, 
            tblbooking.ToDate, 
            tblbooking.Status, 
            tblbooking.PostingDate, 
            tblbooking.BookingNumber, 
            tblbooking.id 
        FROM tblbooking 
        JOIN tblvehicles ON tblvehicles.id = tblbooking.VehicleId 
        JOIN tblusers ON tblusers.EmailId = tblbooking.userEmail 
        JOIN tblbrands ON tblvehicles.VehiclesBrand = tblbrands.id   
        WHERE tblbooking.Status = :status";

$query = $dbh->prepare($sql);
$query->bindParam(':status', $status, PDO::PARAM_INT);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Booking Selesai</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        .succWrap {
            padding: 10px;
            margin-bottom: 20px;
            background: #dff0d8;
            border-left: 4px solid #5cb85c;
        }
        .errorWrap {
            padding: 10px;
            margin-bottom: 20px;
            background: #f2dede;
            border-left: 4px solid #d9534f;
        }
    </style>
</head>
<body>

<?php include('includes/header.php'); ?>

<div class="ts-main-content">
    <?php include('includes/leftbar.php'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">

            <h2 class="page-title">Laporan Booking Selesai</h2>

            <?php if(isset($_SESSION['msg'])): ?>
                <div class="succWrap"><?php echo htmlentities($_SESSION['msg']); unset($_SESSION['msg']); ?></div>
            <?php endif; ?>

            <?php if(isset($_SESSION['error'])): ?>
                <div class="errorWrap"><?php echo htmlentities($_SESSION['error']); unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <div class="panel panel-default">
                <div class="panel-heading">Data Booking yang Sudah Selesai</div>
                <div class="panel-body">
                    <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Booking No.</th>
                                <th>Kendaraan</th>
                                <th>Dari</th>
                                <th>Sampai</th>
                                <th>Status</th>
                                <th>Tanggal Posting</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if ($results) {
                                $cnt = 1;
                                foreach ($results as $row): ?>
                                    <tr>
                                        <td><?php echo $cnt++; ?></td>
                                        <td><?php echo htmlentities($row->FullName); ?></td>
                                        <td><?php echo htmlentities($row->BookingNumber); ?></td>
                                        <td><?php echo htmlentities($row->BrandName . ', ' . $row->VehiclesTitle); ?></td>
                                        <td><?php echo htmlentities($row->FromDate); ?></td>
                                        <td><?php echo htmlentities($row->ToDate); ?></td>
                                        <td>Completed</td>
                                        <td><?php echo htmlentities($row->PostingDate); ?></td>
                                        <td><a href="booking-details.php?bid=<?php echo $row->id; ?>">View</a></td>
                                    </tr>
                            <?php 
                                endforeach;
                            } else { ?>
                                <tr><td colspan="9">Tidak ada data booking yang selesai.</td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>

</body>
</html>