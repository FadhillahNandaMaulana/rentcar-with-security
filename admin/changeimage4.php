<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin']) == 0) {	
    header('location:index.php');
    exit();
} else {
    if(isset($_POST['update'])) {
        if(isset($_FILES["img4"]["name"]) && isset($_GET['imgid']) && is_numeric($_GET['imgid'])) {
            $vimage = $_FILES["img4"]["name"];
            $id = intval($_GET['imgid']); // amankan input ID
            
            // Validasi ekstensi file gambar (opsional tapi penting)
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
            $ext = strtolower(pathinfo($vimage, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed_ext)) {
                $msg = "Format gambar tidak diperbolehkan.";
            } else {
                // Pindahkan file ke folder tujuan
                $target_path = "img/vehicleimages/" . basename($vimage);
                if (move_uploaded_file($_FILES["img4"]["tmp_name"], $target_path)) {
                    // Gunakan prepared statement untuk update
                    $sql = "UPDATE tblvehicles SET Vimage4 = :vimage WHERE id = :id";
                    $stmt = $dbh->prepare($sql);
                    $stmt->bindParam(':vimage', $vimage, PDO::PARAM_STR);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $msg = "Gambar berhasil diperbarui.";
                } else {
                    $msg = "Gagal mengunggah gambar.";
                }
            }
        } else {
            $msg = "Data tidak lengkap.";
        }
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
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap{
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
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

				<div class="row">
					<div class="col-md-12">
					
						<h2 class="page-title">Vehicle Image 4 </h2>

						<div class="row">
							<div class="col-md-10">
								<div class="panel panel-default">
									<div class="panel-heading">Vehicle Image 4 Details</div>
									<div class="panel-body">
										<form method="post" class="form-horizontal" enctype="multipart/form-data">
										
											<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
											else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

                                            <div class="form-group">
												<label class="col-sm-4 control-label">Current Image4</label>
<?php 
if (isset($_GET['imgid']) && is_numeric($_GET['imgid'])) {
    $id = intval($_GET['imgid']);
    $sql = "SELECT Vimage4 FROM tblvehicles WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if($stmt->rowCount() > 0) {
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        foreach($result as $row) {
?>
            <div class="col-sm-8">
                <img src="img/vehicleimages/<?php echo htmlentities($row->Vimage4); ?>" width="300" height="200" style="border:solid 1px #000">
            </div>
<?php
        }
    }
}
?>
											</div>

											<div class="form-group">
												<label class="col-sm-4 control-label">Upload New Image 4<span style="color:red">*</span></label>
												<div class="col-sm-8">
													<input type="file" name="img4" required>
												</div>
											</div>
											<div class="hr-dashed"></div>
											

											<div class="form-group">
												<div class="col-sm-8 col-sm-offset-4">
													<button class="btn btn-primary" name="update" type="submit">Update</button>
												</div>
											</div>

										</form>

									</div>
								</div>
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
<?php ?>