<?php
include('includes/config.php');

if (isset($_GET['eid'])) {
    $eid = intval($_GET['eid']);
    $status = 2;
    $sql = "UPDATE tblbooking SET Status = :status WHERE id = :eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':status', $status, PDO::PARAM_INT);
    $query->bindParam(':eid', $eid, PDO::PARAM_INT);
    $query->execute();

    echo "<script>alert('Booking Successfully Cancelled');</script>";
    echo "<script type='text/javascript'> document.location = 'canceled-bookings.php'; </script>";
    exit();
}

if (isset($_GET['aeid'])) {
    $aeid = intval($_GET['aeid']);
    $status = 1;
    $sql = "UPDATE tblbooking SET Status = :status WHERE id = :aeid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':status', $status, PDO::PARAM_INT);
    $query->bindParam(':aeid', $aeid, PDO::PARAM_INT);
    $query->execute();

    echo "<script>alert('Booking Successfully Confirmed');</script>";
    echo "<script type='text/javascript'> document.location = 'confirmed-bookings.php'; </script>";
    exit();
}
?>

<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <title>RENTCAR</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap{
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
    </style>
</head>
<body>
<?php include('includes/header.php');?>
<div class="ts-main-content">
    <?php include('includes/leftbar.php');?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row"><div class="col-md-12">
                <h2 class="page-title">Detail Pemesanan</h2>
                <div class="panel panel-default">
                    <div class="panel-heading">Informasi Pemesanan</div>
                    <div class="panel-body">
                        <div id="print">
                            <table border="1" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                <tbody>
                                <?php
if (isset($_GET['bid'])) {
    $bid = intval($_GET['bid']);
    $sql = "SELECT tblusers.*, tblbrands.BrandName, tblvehicles.VehiclesTitle, tblbooking.FromDate, tblbooking.ToDate, tblbooking.message,
                   tblbooking.VehicleId as vid, tblbooking.Status, tblbooking.PostingDate, tblbooking.id, tblbooking.BookingNumber,
                   (DATEDIFF(tblbooking.ToDate, tblbooking.FromDate) + 1) as totalnodays, tblvehicles.PricePerDay, tblbooking.LastUpdationDate
            FROM tblbooking
            JOIN tblvehicles ON tblvehicles.id = tblbooking.VehicleId
            JOIN tblusers ON tblusers.EmailId = tblbooking.userEmail
            JOIN tblbrands ON tblvehicles.VehiclesBrand = tblbrands.id
            WHERE tblbooking.id = :bid";
    
    $query = $dbh->prepare($sql);
    $query->bindParam(':bid', $bid, PDO::PARAM_INT);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
?>

                                            <h3 style="text-align:center; color:red">#<?php echo htmlentities($result->BookingNumber); ?> Booking Details </h3>
                                            <tr><th colspan="4" style="text-align:center;color:blue">User Details</th></tr>
                                            <tr>
                                                <th>Nomor Pemesanan.</th><td>#<?php echo htmlentities($result->BookingNumber); ?></td>
                                                <th>Nama</th><td><?php echo htmlentities($result->FullName); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Email Id</th><td><?php echo htmlentities($result->EmailId); ?></td>
                                                <th>Nomor Kontak</th><td><?php echo htmlentities($result->ContactNo); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Alamat</th><td><?php echo htmlentities($result->Address); ?></td>
                                                <th>Kota</th><td><?php echo htmlentities($result->City); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Negara</th><td colspan="3"><?php echo htmlentities($result->Country); ?></td>
                                            </tr>
                                            <tr><th colspan="4" style="text-align:center;color:blue">Booking Details</th></tr>
                                            <tr>
                                                <th>Nama Mobil</th>
                                                <td><a href="edit-vehicle.php?id=<?php echo htmlentities($result->vid); ?>"><?php echo htmlentities($result->BrandName . ', ' . $result->VehiclesTitle); ?></a></td>
                                                <th>Tanggal Pemesanan</th><td><?php echo htmlentities($result->PostingDate); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Dari Tanggal</th><td><?php echo htmlentities($result->FromDate); ?></td>
                                                <th>Sampai Tanggal</th><td><?php echo htmlentities($result->ToDate); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Total Hari</th><td><?php echo htmlentities($result->totalnodays); ?></td>
                                                <th>Sewa per Hari</th><td>Rp.<?php echo htmlentities($result->PricePerDay); ?></td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" style="text-align:center">Jumlah Total</th>
                                                <td>Rp.<?php echo htmlentities($result->totalnodays * $result->PricePerDay); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Status Pemesanan</th>
                                                <td>
                                                    <?php
                                                    if ($result->Status == 0) echo 'Not Confirmed yet';
                                                    else if ($result->Status == 1) echo 'Confirmed';
                                                    else if ($result->Status == 2) echo 'Cancelled';
                                                    else if ($result->Status == 3) echo 'Complated';
                                                    ?>
                                                </td>
                                                <th>Tanggal pembaruan terakhir</th>
                                                <td><?php echo !empty($result->LastUpdationDate) ? htmlentities($result->LastUpdationDate) : 'N/A'; ?></td>
                                            </tr>
                                            <?php if ($result->Status == 0) { ?>
                                                <tr>
                                                    <td style="text-align:center" colspan="4">
                                                        <a href="booking-details.php?aeid=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Apakah Anda yakin ingin mengonfirmasi pemesanan ini?')" class="btn btn-primary"> Konfirmasi Pemesanan</a>
                                                        <a href="booking-details.php?eid=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?')" class="btn btn-danger"> Batalkan Pemesanan</a>
                                                    </td>
                                                </tr>
                                            <?php }
                                        }
                                    } else {
                                        echo '<tr><td colspan="4" style="text-align:center;">Booking not found.</td></tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="4" style="text-align:center;">Booking ID not provided.</td></tr>';
                                }
                                ?>
                                </tbody>
                            </table>
                            <form method="post">
                                <input name="Submit2" type="submit" class="txtbox4" value="Print" onClick="return f3();" style="cursor: pointer;"  />
                            </form>
                        </div>
                    </div>
                </div>
            </div></div>
        </div>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/Chart.min.js"></script>
<script src="js/fileinput.js"></script>
<script src="js/chartData.js"></script>
<script src="js/main.js"></script>
<script>
function f3() {
    window.print();
}
</script>
</body>
</html>