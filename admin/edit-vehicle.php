<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin']) == 0) {	
    header('location:index.php');
    exit;
} else { 
    if(isset($_POST['submit'])) {
        $vehicletitle = $_POST['vehicletitle'];
        $brand = $_POST['brandname'];
        $vehicleoverview = $_POST['vehicalorcview'];
        $priceperday = $_POST['priceperday'];
        $fueltype = $_POST['fueltype'];
        $modelyear = $_POST['modelyear'];
        $seatingcapacity = $_POST['seatingcapacity'];

        $airconditioner = isset($_POST['airconditioner']) ? 1 : 0;
        $powerdoorlocks = isset($_POST['powerdoorlocks']) ? 1 : 0;
        $antilockbrakingsys = isset($_POST['antilockbrakingsys']) ? 1 : 0;
        $brakeassist = isset($_POST['brakeassist']) ? 1 : 0;
        $powersteering = isset($_POST['powersteering']) ? 1 : 0;
        $driverairbag = isset($_POST['driverairbag']) ? 1 : 0;
        $passengerairbag = isset($_POST['passengerairbag']) ? 1 : 0;
        $powerwindow = isset($_POST['powerwindow']) ? 1 : 0;
        $cdplayer = isset($_POST['cdplayer']) ? 1 : 0;
        $centrallocking = isset($_POST['centrallocking']) ? 1 : 0;
        $crashcensor = isset($_POST['crashcensor']) ? 1 : 0;
        $leatherseats = isset($_POST['leatherseats']) ? 1 : 0;

        $id = intval($_GET['id']);

        $sql = "UPDATE tblvehicles SET 
            VehiclesTitle = :vehicletitle,
            VehiclesBrand = :brand,
            VehiclesOverview = :vehicleoverview,
            PricePerDay = :priceperday,
            FuelType = :fueltype,
            ModelYear = :modelyear,
            SeatingCapacity = :seatingcapacity,
            AirConditioner = :airconditioner,
            PowerDoorLocks = :powerdoorlocks,
            AntiLockBrakingSystem = :antilockbrakingsys,
            BrakeAssist = :brakeassist,
            PowerSteering = :powersteering,
            DriverAirbag = :driverairbag,
            PassengerAirbag = :passengerairbag,
            PowerWindows = :powerwindow,
            CDPlayer = :cdplayer,
            CentralLocking = :centrallocking,
            CrashSensor = :crashcensor,
            LeatherSeats = :leatherseats
            WHERE id = :id";

        $query = $dbh->prepare($sql);
        $query->bindParam(':vehicletitle', $vehicletitle, PDO::PARAM_STR);
        $query->bindParam(':brand', $brand, PDO::PARAM_STR);
        $query->bindParam(':vehicleoverview', $vehicleoverview, PDO::PARAM_STR);
        $query->bindParam(':priceperday', $priceperday, PDO::PARAM_INT);
        $query->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
        $query->bindParam(':modelyear', $modelyear, PDO::PARAM_INT);
        $query->bindParam(':seatingcapacity', $seatingcapacity, PDO::PARAM_INT);
        $query->bindParam(':airconditioner', $airconditioner, PDO::PARAM_INT);
        $query->bindParam(':powerdoorlocks', $powerdoorlocks, PDO::PARAM_INT);
        $query->bindParam(':antilockbrakingsys', $antilockbrakingsys, PDO::PARAM_INT);
        $query->bindParam(':brakeassist', $brakeassist, PDO::PARAM_INT);
        $query->bindParam(':powersteering', $powersteering, PDO::PARAM_INT);
        $query->bindParam(':driverairbag', $driverairbag, PDO::PARAM_INT);
        $query->bindParam(':passengerairbag', $passengerairbag, PDO::PARAM_INT);
        $query->bindParam(':powerwindow', $powerwindow, PDO::PARAM_INT);
        $query->bindParam(':cdplayer', $cdplayer, PDO::PARAM_INT);
        $query->bindParam(':centrallocking', $centrallocking, PDO::PARAM_INT);
        $query->bindParam(':crashcensor', $crashcensor, PDO::PARAM_INT);
        $query->bindParam(':leatherseats', $leatherseats, PDO::PARAM_INT);
        $query->bindParam(':id', $id, PDO::PARAM_INT);

        if ($query->execute()) {
            $msg = "Data updated successfully";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}
?>
<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>RENTCAR</title>

	<!-- CSS includes -->
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

				<h2 class="page-title">Edit Mobil</h2>

				<?php if(isset($msg)){?>
				<div class="succWrap"><strong>SUKSES</strong>: <?php echo htmlentities($msg); ?></div>
				<?php } ?>
				<?php if(isset($error)){?>
				<div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?></div>
				<?php } ?>

<?php 
$id = intval($_GET['id']); // sudah lebih aman, tapi tetap pakai bindParam lebih baik

$sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbrands.id as bid 
        FROM tblvehicles 
        JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
        WHERE tblvehicles.id = :id";

$query = $dbh->prepare($sql);
$query->bindParam(':id', $id, PDO::PARAM_INT);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if($query->rowCount() > 0)
{
    foreach($results as $result)
    {
?>

				<form method="post" class="form-horizontal" enctype="multipart/form-data">
					<div class="form-group">
						<label class="col-sm-2 control-label">Surat Kepemilikan Kendaraan<span style="color:red">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="vehicletitle" class="form-control" value="<?php echo htmlentities($result->VehiclesTitle)?>" required>
						</div>

						<label class="col-sm-2 control-label">Pilih Merek<span style="color:red">*</span></label>
						<div class="col-sm-4">
							<select class="selectpicker" name="brandname" required>
								<option value="<?php echo htmlentities($result->bid);?>"><?php echo htmlentities($result->BrandName); ?></option>
								<?php 
								$ret = "SELECT id, BrandName FROM tblbrands";
								$query = $dbh->prepare($ret);
								$query->execute();
								$allbrands = $query->fetchAll(PDO::FETCH_OBJ);
								foreach($allbrands as $brand) {
									if($brand->BrandName == $result->BrandName) continue;
									echo '<option value="'.htmlentities($brand->id).'">'.htmlentities($brand->BrandName).'</option>';
								}
								?>
							</select>
						</div>
					</div>

					<div class="hr-dashed"></div>

					<div class="form-group">
						<label class="col-sm-2 control-label">Gambaran Umum Kendaraan<span style="color:red">*</span></label>
						<div class="col-sm-10">
							<textarea class="form-control" name="vehicalorcview" rows="4" required><?php echo htmlentities($result->VehiclesOverview);?></textarea>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">Harga Per Hari (Rp)<span style="color:red">*</span></label>
						<div class="col-sm-4">
							<input type="number" name="priceperday" class="form-control" value="<?php echo htmlentities($result->PricePerDay);?>" required>
						</div>

						<label class="col-sm-2 control-label">Tipe Bensin<span style="color:red">*</span></label>
						<div class="col-sm-4">
							<select class="selectpicker" name="fueltype" required>
								<option value="<?php echo htmlentities($result->FuelType); ?>"><?php echo htmlentities($result->FuelType); ?></option>
								<option value="Petrol">Petrol</option>
								<option value="Diesel">Diesel</option>
								<option value="CNG">CNG</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">Tahun Model<span style="color:red">*</span></label>
						<div class="col-sm-4">
							<input type="number" name="modelyear" class="form-control" value="<?php echo htmlentities($result->ModelYear);?>" required>
						</div>

						<label class="col-sm-2 control-label">Kapasitas Kursi<span style="color:red">*</span></label>
						<div class="col-sm-4">
							<input type="number" name="seatingcapacity" class="form-control" value="<?php echo htmlentities($result->SeatingCapacity);?>" required>
						</div>
					</div>

					<h4 class="text-center" style="margin-top: 50px;">Aksesoris</h4>
					<div class="form-group">
						<div class="col-sm-3">
							<div class="checkbox checkbox-primary">
								<input id="airconditioner" name="airconditioner" type="checkbox" <?php if($result->AirConditioner == 1){ echo "checked";} ?>>
								<label for="airconditioner"> Air Condition (AC)</label>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="checkbox checkbox-primary">
								<input id="powerdoorlocks" name="powerdoorlocks" type="checkbox" <?php if($result->PowerDoorLocks == 1){ echo "checked";} ?>>
								<label for="powerdoorlocks"> Kunci Pintu Listrik </label>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="checkbox checkbox-primary">
								<input id="antilockbrakingsys" name="antilockbrakingsys" type="checkbox" <?php if($result->AntiLockBrakingSystem == 1){ echo "checked";} ?>>
								<label for="antilockbrakingsys"> AntiLock Braking System (ABS) </label>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="checkbox checkbox-primary">
								<input id="brakeassist" name="brakeassist" type="checkbox" <?php if($result->BrakeAssist == 1){ echo "checked";} ?>>
								<label for="brakeassist"> Bantuan Rem </label>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3">
							<div class="checkbox checkbox-primary">
								<input id="powersteering" name="powersteering" type="checkbox" <?php if($result->PowerSteering == 1){ echo "checked";} ?>>
								<label for="powersteering"> Kemudi Daya </label>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="checkbox checkbox-primary">
								<input id="driverairbag" name="driverairbag" type="checkbox" <?php if($result->DriverAirbag == 1){ echo "checked";} ?>>
								<label for="driverairbag"> Kantong Udara Pengemudi </label>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="checkbox checkbox-primary">
								<input id="passengerairbag" name="passengerairbag" type="checkbox" <?php if($result->PassengerAirbag == 1){ echo "checked";} ?>>
								<label for="passengerairbag"> Kantong Udara Penumpang </label>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="checkbox checkbox-primary">
								<input id="powerwindow" name="powerwindow" type="checkbox" <?php if($result->PowerWindows == 1){ echo "checked";} ?>>
								<label for="powerwindow"> Jendela Otomatis </label>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3">
							<div class="checkbox checkbox-primary">
								<input id="cdplayer" name="cdplayer" type="checkbox" <?php if($result->CDPlayer == 1){ echo "checked";} ?>>
								<label for="cdplayer"> CD Player </label>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="checkbox checkbox-primary">
								<input id="centrallocking" name="centrallocking" type="checkbox" <?php if($result->CentralLocking == 1){ echo "checked";} ?>>
								<label for="centrallocking"> Penguncian Sentral </label>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="checkbox checkbox-primary">
								<input id="crashcensor" name="crashcensor" type="checkbox" <?php if($result->CrashSensor == 1){ echo "checked";} ?>>
								<label for="crashcensor"> Sensor Kecelakaan </label>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="checkbox checkbox-primary">
								<input id="leatherseats" name="leatherseats" type="checkbox" <?php if($result->LeatherSeats == 1){ echo "checked";} ?>>
								<label for="leatherseats"> Jok Kulit </label>
							</div>
						</div>
					</div>

					<div class="hr-dashed"></div>

<h4 class="text-center" style="margin-top: 50px;">Gambar Mobil</h4>
<div class="form-group">
  <div class="row">
    <div class="col-sm-4 text-center">
      <p>Image 1</p>
      <img src="/RENTCAR/admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" width="300" height="200" style="border:solid 1px #000">
      <br><a href="changeimage1.php?imgid=<?php echo htmlentities($result->id)?>">Change Image 1</a>
    </div>
    <div class="col-sm-4 text-center">
      <p>Image 2</p>
      <img src="/RENTCAR/admin/img/vehicleimages/<?php echo htmlentities($result->Vimage2); ?>" width="300" height="200" style="border:solid 1px #000">
      <br><a href="changeimage2.php?imgid=<?php echo htmlentities($result->id)?>">Change Image 2</a>
    </div>
    <div class="col-sm-4 text-center">
      <p>Image 3</p>
      <img src="/RENTCAR/admin/img/vehicleimages/<?php echo htmlentities($result->Vimage3); ?>" width="300" height="200" style="border:solid 1px #000">
      <br><a href="changeimage3.php?imgid=<?php echo htmlentities($result->id)?>">Change Image 3</a>
    </div>
  </div>

  <div class="row" style="margin-top: 20px;">
    <div class="col-sm-6 text-center">
      <p>Image 4</p>
      <img src="/RENTCAR/admin/img/vehicleimages/<?php echo htmlentities($result->Vimage4); ?>" width="300" height="200" style="border:solid 1px #000">
      <br><a href="changeimage4.php?imgid=<?php echo htmlentities($result->id)?>">Change Image 4</a>
    </div>
    <div class="col-sm-6 text-center">
      <p>Image 5</p>
      <img src="/RENTCAR/admin/img/vehicleimages/<?php echo htmlentities($result->Vimage5); ?>" width="300" height="200" style="border:solid 1px #000">
      <br><a href="changeimage5.php?imgid=<?php echo htmlentities($result->id)?>">Change Image 5</a>
    </div>
  </div>
</div>

					<div class="form-group text-center">
    <button class="btn btn-primary" name="submit" type="submit">Simpan Perubahan</button>
</div>

				</form>

				<?php 
					}
				}
				?>

			</div>
		</div>
	</div>

	<!-- JS includes -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php ?>