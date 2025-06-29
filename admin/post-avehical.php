<?php
session_start();
include('includes/config.php');

if (isset($_POST['submit'])) {
    $vehicletitle = $_POST['vehicletitle'];
    $brand = $_POST['brandname'];
    $vehicleoverview = $_POST['vehicalorcview'];
    $priceperday = $_POST['priceperday'];
    $fueltype = $_POST['fueltype'];
    $modelyear = $_POST['modelyear'];
    $seatingcapacity = $_POST['seatingcapacity'];

    // Validasi & upload file
    $upload_dir = "img/vehicleimages/";
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    $images = [];

    for ($i = 1; $i <= 5; $i++) {
        $file = $_FILES["img$i"];
        $filename = basename($file["name"]);
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if ($filename && in_array($ext, $allowed_types)) {
            $target = $upload_dir . $filename;
            if (move_uploaded_file($file["tmp_name"], $target)) {
                $images[] = $filename;
            } else {
                $images[] = "";
            }
        } else {
            $images[] = "";
        }
    }

    // Fitur kendaraan
    $features = [
        'airconditioner', 'powerdoorlocks', 'antilockbrakingsys', 'brakeassist',
        'powersteering', 'driverairbag', 'passengerairbag', 'powerwindow',
        'cdplayer', 'centrallocking', 'crashcensor', 'leatherseats'
    ];
    $feature_values = [];
    foreach ($features as $feature) {
        $feature_values[$feature] = isset($_POST[$feature]) ? 1 : 0;
    }

    // Insert pakai prepared statement
    $sql = "INSERT INTO tblvehicles (
        VehiclesTitle, VehiclesBrand, VehiclesOverview, PricePerDay, FuelType, ModelYear, SeatingCapacity, 
        Vimage1, Vimage2, Vimage3, Vimage4, Vimage5,
        AirConditioner, PowerDoorLocks, AntiLockBrakingSystem, BrakeAssist, PowerSteering, DriverAirbag, 
        PassengerAirbag, PowerWindows, CDPlayer, CentralLocking, CrashSensor, LeatherSeats
    ) VALUES (
        :title, :brand, :overview, :price, :fuel, :year, :seats,
        :img1, :img2, :img3, :img4, :img5,
        :airconditioner, :powerdoorlocks, :antilockbrakingsys, :brakeassist, :powersteering, :driverairbag, 
        :passengerairbag, :powerwindow, :cdplayer, :centrallocking, :crashcensor, :leatherseats
    )";

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':title', $vehicletitle);
    $stmt->bindParam(':brand', $brand);
    $stmt->bindParam(':overview', $vehicleoverview);
    $stmt->bindParam(':price', $priceperday);
    $stmt->bindParam(':fuel', $fueltype);
    $stmt->bindParam(':year', $modelyear);
    $stmt->bindParam(':seats', $seatingcapacity);
    for ($i = 1; $i <= 5; $i++) {
        $stmt->bindParam(":img$i", $images[$i - 1]);
    }
    foreach ($feature_values as $key => $val) {
        $stmt->bindValue(":$key", $val, PDO::PARAM_INT);
    }

    if ($stmt->execute()) {
        $msg = "Vehicle posted successfully";
    } else {
        $error = "Something went wrong. Please try again";
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
					
						<h2 class="page-title">Posting Mobil</h2>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Informasi Dasar</div>
<?php if(isset($error)){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if(isset($msg)){?><div class="succWrap"><strong>SUKSES</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

									<div class="panel-body">
<form method="post" class="form-horizontal" enctype="multipart/form-data">
<div class="form-group">
<label class="col-sm-2 control-label">Judul Mobil<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="vehicletitle" class="form-control" required>
</div>
<label class="col-sm-2 control-label">Pilih Merek<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="brandname" required>
<option value=""> Pilih </option>
<?php
$ret = "select id, BrandName from tblbrands";
foreach($dbh->query($ret) as $result) {
    echo '<option value="' . htmlentities($result['id']) . '">' . htmlentities($result['BrandName']) . '</option>';
}
?>
</select>
</div>
</div>
											

<div class="hr-dashed"></div>
<div class="form-group">
<label class="col-sm-2 control-label">Tinjauan Kendaraan<span style="color:red">*</span></label>
<div class="col-sm-10">
<textarea class="form-control" name="vehicalorcview" rows="3" required></textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Harga Per Hari(in Rp)<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="priceperday" class="form-control" required>
</div>
<label class="col-sm-2 control-label">Pilih Tipe Bensin<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="fueltype" required>
<option value=""> Pilih </option>
<option value="Petrol">Petrol</option>
<option value="Diesel">Diesel</option>
<option value="CNG">CNG</option>
</select>
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Tahun Model<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="modelyear" class="form-control" required>
</div>
<label class="col-sm-2 control-label">Kapasitas Kursi<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="seatingcapacity" class="form-control" required>
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Upload Image 1<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="file" name="img1" required>
</div>
<label class="col-sm-2 control-label">Upload Image 2</label>
<div class="col-sm-4">
<input type="file" name="img2">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Upload Image 3</label>
<div class="col-sm-4">
<input type="file" name="img3">
</div>
<label class="col-sm-2 control-label">Upload Image 4</label>
<div class="col-sm-4">
<input type="file" name="img4">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Upload Image 5</label>
<div class="col-sm-4">
<input type="file" name="img5">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Aksesoris</label>
<div class="col-sm-10">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="airconditioner" name="airconditioner" value="1">
<label for="airconditioner"> Air Conditioner </label>
</div>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="powerdoorlocks" name="powerdoorlocks" value="1">
<label for="powerdoorlocks"> Power Door Locks </label>
</div>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="antilockbrakingsys" name="antilockbrakingsys" value="1">
<label for="antilockbrakingsys"> AntiLock Braking System </label>
</div>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="brakeassist" name="brakeassist" value="1">
<label for="brakeassist"> Brake Assist </label>
</div>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="powersteering" name="powersteering" value="1">
<label for="powersteering"> Power Steering </label>
</div>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="driverairbag" name="driverairbag" value="1">
<label for="driverairbag"> Driver Airbag </label>
</div>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="passengerairbag" name="passengerairbag" value="1">
<label for="passengerairbag"> Passenger Airbag </label>
</div>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="powerwindow" name="powerwindow" value="1">
<label for="powerwindow"> Power Windows </label>
</div>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="cdplayer" name="cdplayer" value="1">
<label for="cdplayer"> CD Player </label>
</div>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="centrallocking" name="centrallocking" value="1">
<label for="centrallocking"> Central Locking </label>
</div>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="crashcensor" name="crashcensor" value="1">
<label for="crashcensor"> Crash Sensor </label>
</div>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="leatherseats" name="leatherseats" value="1">
<label for="leatherseats"> Leather Seats </label>
</div>
</div>
</div>

<div class="hr-dashed"></div>

<div class="form-group">
<div class="col-sm-8 col-sm-offset-2">
<button class="btn btn-primary" name="submit" type="submit">Posting Mobil</button>
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