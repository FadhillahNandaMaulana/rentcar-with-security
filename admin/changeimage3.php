<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (isset($_POST['update']) && isset($_GET['imgid']) && is_numeric($_GET['imgid'])) {
    $id = intval($_GET['imgid']);

    if (isset($_FILES["img3"]) && $_FILES["img3"]["error"] == 0) {
        $vimage = basename($_FILES["img3"]["name"]);
        $target_dir = "img/vehicleimages/";
        $target_file = $target_dir . $vimage;

        // Validasi ekstensi file (opsional tapi disarankan)
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $file_ext = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed)) {
            $msg = "Format file tidak didukung.";
        } else {
            // Pindahkan file
            move_uploaded_file($_FILES["img3"]["tmp_name"], $target_file);

            // Update database dengan prepared statement
            $sql = "UPDATE tblvehicles SET Vimage3 = :vimage WHERE id = :id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':vimage', $vimage, PDO::PARAM_STR);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();

            $msg = "Gambar berhasil diperbarui.";
        }
    } else {
        $msg = "Tidak ada file yang diunggah atau terjadi kesalahan.";
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
						<h2 class="page-title">Vehicle Image 3</h2>
						<div class="row">
							<div class="col-md-10">
								<div class="panel panel-default">
									<div class="panel-heading">Vehicle Image 3 Details</div>
									<div class="panel-body">
										<form method="post" class="form-horizontal" enctype="multipart/form-data">
											<?php if($error){ ?>
												<div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>
											<?php } else if($msg){ ?>
												<div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
											<?php } ?>

											<div class="form-group">
												<label class="col-sm-4 control-label">Current Image3</label>
												<?php 
if (isset($_GET['imgid']) && is_numeric($_GET['imgid'])) {
    $id = intval($_GET['imgid']); // pastikan hanya angka
    
    $sql = "SELECT Vimage3 FROM tblvehicles WHERE id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        foreach ($results as $result) { ?>
            <div class="col-sm-8">
                <img src="img/vehicleimages/<?php echo htmlentities($result->Vimage3); ?>" width="300" height="200" style="border:solid 1px #000">
            </div>
<?php
        }
    }
}
?>
											</div>

											<div class="form-group">
												<label class="col-sm-4 control-label">Upload New Image 3<span style="color:red">*</span></label>
												<div class="col-sm-8">
													<input type="file" name="img3" required>
												</div>
											</div>

											<div class="hr-dashed"></div>

											<div class="form-group">
												<div class="col-sm-8 col-sm-offset-4">
													<button class="btn btn-primary" name="update" type="submit">Update</button>
												</div>
											</div>
										</form>
									</div> <!-- panel-body -->
								</div> <!-- panel -->
							</div>
						</div> <!-- row -->
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
<?php // } ?>