<?php
include('includes/config.php');

if (isset($_GET['del'])) {
    $id = intval($_GET['del']); // sanitasi tambahan
    $sql = "DELETE FROM tblbrands WHERE id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $msg = "Data berhasil dihapus.";
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

    <!-- Styles -->
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
        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
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

                    <h2 class="page-title">Pengguna Terdaftar</h2>

                    <div class="panel panel-default">
                        <div class="panel-heading">Pengguna Terdaftar</div>
                        <div class="panel-body">
                            <?php if (isset($error)) { ?>
                                <div class="errorWrap"><strong>ERROR</strong>:<?php echo $error; ?> </div>
                            <?php } else if (isset($msg)) { ?>
                                <div class="succWrap"><strong>SUKSES</strong>:<?php echo $msg; ?> </div>
                            <?php } ?>

                            <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Nomor Kontak</th>
                                        <th>DOB</th>
                                        <th>Alamat</th>
                                        <th>Kota</th>
                                        <th>Negara</th>
                                        <th>Tanggal Register</th>
                                        <th>Foto KTP</th>
                                    </tr>
                                </thead>
                                    <?php 
                                    $sql = "SELECT * FROM tblusers";
                                    $query = $dbh->query($sql);
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    foreach ($results as $result) { ?>	
                                        <tr>
                                            <td><?php echo $cnt; ?></td>
                                            <td><?php echo $result->FullName; ?></td>
                                            <td><?php echo $result->EmailId; ?></td>
                                            <td><?php echo $result->ContactNo; ?></td>
                                            <td><?php echo $result->dob; ?></td>
                                            <td><?php echo $result->Address; ?></td>
                                            <td><?php echo $result->City; ?></td>
                                            <td><?php echo $result->Country; ?></td>
                                            <td><?php echo $result->RegDate; ?></td>
                                            <td>
                                                <?php if ($result->KtpImage): ?>
                                                    <img src="../ktp_uploads/<?php echo $result->KtpImage; ?>" width="80" height="50"><br>
                                                    <a href="../ktp_uploads/<?php echo $result->KtpImage; ?>" target="_blank">Lihat / Download</a>
                                                <?php else: ?>
                                                    <span>No Image</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php $cnt++; } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Scripts -->
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