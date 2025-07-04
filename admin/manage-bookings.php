<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
} else {
    if (isset($_GET['eid'])) {
        $eid = intval($_GET['eid']);
        $status = 2;

        $sql = "UPDATE tblbooking SET Status = :status WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        $query->bindParam(':id', $eid, PDO::PARAM_INT);
        $query->execute();

        $msg = "Booking successfully cancelled.";
    }

    if (isset($_GET['aeid'])) {
        $aeid = intval($_GET['aeid']);
        $status = 1;

        $sql = "UPDATE tblbooking SET Status = :status WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        $query->bindParam(':id', $aeid, PDO::PARAM_INT);
        $query->execute();

        $msg = "Booking successfully confirmed.";
    }
}
?>

    <!doctype html>
    <html lang="en" class="no-js">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
            <meta name="description" content="">
            <meta name="author" content="">
            <meta name="theme-color" content="#3e454c">

            <title>RENTCAR</title>

            <!-- Font awesome -->
            <link rel="stylesheet" href="css/font-awesome.min.css">
            <!-- Sandstone Bootstrap CSS -->
            <link rel="stylesheet" href="css/bootstrap.min.css">
            <!-- Bootstrap Datatables -->
            <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
            <!-- Bootstrap social button library -->
            <link rel="stylesheet" href="css/bootstrap-social.css">
            <!-- Bootstrap select -->
            <link rel="stylesheet" href="css/bootstrap-select.css">
            <!-- Bootstrap file input -->
            <link rel="stylesheet" href="css/fileinput.min.css">
            <!-- Awesome Bootstrap checkbox -->
            <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
            <!-- Admin Stye -->
            <link rel="stylesheet" href="css/style.css">
            <style>
                .errorWrap {
                    padding: 10px;
                    margin: 0 0 20px 0;
                    background: #fff;
                    border-left: 4px solid #dd3d36;
                    -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                    box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                }

                .succWrap {
                    padding: 10px;
                    margin: 0 0 20px 0;
                    background: #fff;
                    border-left: 4px solid #5cb85c;
                    -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                    box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                }
            </style>

        </head>

        <body>
            <?php include('includes/header.php'); ?>

            <div class="ts-main-content">
                <?php include('includes/leftbar.php'); ?>
                <div class="content-wrapper">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-12">

                                <h2 class="page-title">Kelola Pemesanan</h2>

                                <!-- Zero Configuration Table -->
                                <div class="panel panel-default">
                                    <div class="panel-heading">Informasi Pemesanan</div>
                                    <div class="panel-body">
                                        <?php if ($error) { ?>
                                            <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?>
                                            </div><?php } else if ($msg) { ?>
                                                <div class="succWrap"><strong>SUKSES</strong>:<?php echo htmlentities($msg); ?>
                                                </div><?php } ?>
                                        <table id="zctb" class="display table table-striped table-bordered table-hover"
                                            cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama</th>
                                                    <th>Mobil</th>
                                                    <th>Dari Tanggal</th>
                                                    <th>Sampai Tanggal</th>
                                                    <th>Pesan</th>
                                                    <th>Status</th>
                                                    <th>Posting Tanggal</th>
                                                    <th>Pembayaran</th>
                                                    <th>Tindakan</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $sql = "SELECT 
            tblusers.FullName,
            tblbrands.BrandName,
            tblvehicles.VehiclesTitle,
            tblbooking.FromDate,
            tblbooking.ToDate,
            tblbooking.message,
            tblbooking.VehicleId as vid,
            tblbooking.Status,
            tblbooking.PostingDate,
            tblbooking.id,
            tblbooking.payments
        FROM tblbooking 
        JOIN tblvehicles ON tblvehicles.id = tblbooking.VehicleId 
        JOIN tblusers ON tblusers.EmailId = tblbooking.userEmail 
        JOIN tblbrands ON tblvehicles.VehiclesBrand = tblbrands.id";

                                            $results = $dbh->query($sql)->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if (count($results) > 0) {
                                                foreach ($results as $result) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($cnt); ?></td>
                                                        <td><?php echo htmlentities($result->FullName); ?></td>
                                                        <td><a href="edit-vehicle.php?id=<?php echo htmlentities($result->vid); ?>"><?php echo htmlentities($result->BrandName); ?>
                                                                , <?php echo htmlentities($result->VehiclesTitle); ?></a></td>
                                                        <td><?php echo htmlentities($result->FromDate); ?></td>
                                                        <td><?php echo htmlentities($result->ToDate); ?></td>
                                                        <td><?php echo htmlentities($result->message); ?></td>

                                                        <td><?php
                                                        if ($result->Status == 0) {
                                                            echo htmlentities('Not Confirmed yet');
                                                        } else if ($result->Status == 1) {
                                                            echo htmlentities('Confirmed');
                                                        } else if ($result->Status == 2) {
                                                            echo htmlentities('Cancelled');
                                                        } else if ($result->Status == 3) {
                                                            echo htmlentities('Completed');
                                                        } else {
                                                            echo htmlentities('Unknown Status');
                                                        }
                                                        ?></td>
                                                        <td><?php echo htmlentities($result->PostingDate); ?></td>
                                                        <td>
                                                            <?php if ($result->payments): ?>
                                                                <img src="../bukti_pembayaran/<?php echo $result->payments; ?>"
                                                                    width="80" height="50"><br>
                                                                <a href="../bukti_pembayaran/<?php echo $result->payments; ?>"
                                                                    target="_blank">Lihat / Download</a>
                                                            <?php else: ?>
                                                                <span>No Image</span>
                                                            <?php endif; ?>

                                                        </td>
                                                        <td><a href="manage-bookings.php?aeid=<?php echo htmlentities($result->id); ?>"
                                                                onclick="return confirm('Do you really want to Confirm this booking')">
                                                                Confirm</a> /
                                                            <a href="manage-bookings.php?eid=<?php echo htmlentities($result->id); ?>"
                                                                onclick="return confirm('Do you really want to Cancel this Booking')">
                                                                Cancel</a>
                                                        </td>
                                                    </tr>
                                                    <td>

                                                        <?php $cnt = $cnt + 1;
                                                }
                                            } ?>

                                                </tbody>
                                        </table>



                                    </div>
                                </div>



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
<?php  ?>