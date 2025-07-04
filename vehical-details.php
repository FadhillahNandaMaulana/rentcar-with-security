<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (isset($_POST['submit'])) {
    // Kosongkan atau tambahkan logika jika memang ada proses yang ingin dilakukan saat form disubmit
}
?>

<!DOCTYPE HTML>
<html lang="en">

  <head>
    <title>RENTCAR</title>
    <!--Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <!--Custome Style -->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <!--OWL Carousel slider-->
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <!--slick-slider -->
    <link href="assets/css/slick.css" rel="stylesheet">
    <!--bootstrap-slider -->
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <!--FontAwesome Font Style -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">

    <!-- SWITCHER -->
    <link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all"
      data-default-color="true" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
      href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
      href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
      href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
  </head>

  <body>

    <!-- Start Switcher -->
    <?php include('includes/colorswitcher.php'); ?>
    <!-- /Switcher -->

    <!--Header-->
    <?php include('includes/header.php'); ?>
    <!-- /Header -->

    <!--Listing-Image-Slider-->
<?php
$vhid = $_GET['vhid'];
$sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbrands.id as bid 
        FROM tblvehicles 
        JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
        WHERE tblvehicles.id = :vhid";
$query = $dbh->prepare($sql);
$query->bindParam(':vhid', $vhid, PDO::PARAM_INT);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() > 0) {
  foreach ($results as $result) {
    $_SESSION['brndid'] = $result->bid;

?>

        <section id="listing_img_slider">
          <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" class="img-responsive"
              alt="image" width="900" height="560"></div>
          <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage2); ?>" class="img-responsive"
              alt="image" width="900" height="560"></div>
          <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage3); ?>" class="img-responsive"
              alt="image" width="900" height="560"></div>
          <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage4); ?>" class="img-responsive"
              alt="image" width="900" height="560"></div>
          <?php if ($result->Vimage5 == "") {
          } else {
            ?>
            <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage5); ?>" class="img-responsive"
                alt="image" width="900" height="560"></div>
          <?php } ?>
        </section>
        <!--/Listing-Image-Slider-->

        <!--Listing-detail-->
        <section class="listing-detail" style="background-color:rgb(198, 198, 198)">
          <div class="container" >
            <div class="listing_detail_head row" >
              <div class="col-md-9">
                <h2><?php echo htmlentities($result->BrandName); ?> , <?php echo htmlentities($result->VehiclesTitle); ?></h2>
              </div>
              <div class="col-md-3">
                <div class="price_info">
                  <p>Rp.<?php echo htmlentities($result->PricePerDay); ?> </p>Per Hari
                </div>
              </div>
            </div>
            <div class="row" >
              <div class="col-md-9">
                <div class="main_features" >
                  <ul>
                    <li> <i class="fa fa-calendar" aria-hidden="true" style="color: black;"></i>
                      <h5><?php echo htmlentities($result->ModelYear); ?></h5>
                      <p>Tahun.Daftar</p>
                    </li>
                    <li> <i class="fa fa-cogs" aria-hidden="true" style="color: black;" ></i>
                      <h5><?php echo htmlentities($result->FuelType); ?></h5>
                      <p>Tipe Bensin</p>
                    </li>
                    <li> <i class="fa fa-user-plus" aria-hidden="true" style="color: black;"></i>
                      <h5><?php echo htmlentities($result->SeatingCapacity); ?></h5>
                      <p>Kursi</p>
                    </li>
                  </ul>
                </div>
                <div class="listing_more_info">
                  <div class="listing_detail_wrap">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs gray-bg" role="tablist">
                      <li role="presentation" class="active"><a href="#vehicle-overview" aria-controls="vehicle-overview"
                          role="tab" data-toggle="tab">Ringkasan Kendaraan</a></li>
                      <li role="presentation"><a href="#accessories" aria-controls="accessories" role="tab"
                          data-toggle="tab">Aksesoris</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                      <!-- vehicle-overview -->
                      <div role="tabpanel" class="tab-pane active" id="vehicle-overview" >
                        <p><?php echo htmlentities($result->VehiclesOverview); ?></p>
                      </div>

                      <!-- Accessories -->
                      <div role="tabpanel" class="tab-pane" id="accessories" style="background-color: #ffffff">
                        <!--Accessories-->
                        <table>
                          <thead>
                            <tr>
                              <th colspan="2">Aksesoris</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Air Condition (AC)</td>
                              <?php if ($result->AirConditioner == 1) { ?>
                                <td><i class="fa fa-check" aria-hidden="true"></i></td>
                              <?php } else { ?>
                                <td><i class="fa fa-close" aria-hidden="true"></i></td>
                              <?php } ?>
                            </tr>
                            <tr>
                              <td>AntiLock Braking System (ABS)</td>
                              <?php if ($result->AntiLockBrakingSystem == 1) { ?>
                                <td><i class="fa fa-check" aria-hidden="true"></i></td>
                              <?php } else { ?>
                                <td><i class="fa fa-close" aria-hidden="true"></i></td>
                              <?php } ?>
                            </tr>
                            <tr>
                              <td>Kemudi Daya</td>
                              <?php if ($result->PowerSteering == 1) { ?>
                                <td><i class="fa fa-check" aria-hidden="true"></i></td>
                              <?php } else { ?>
                                <td><i class="fa fa-close" aria-hidden="true"></i></td>
                              <?php } ?>
                            </tr>
                            <tr>
                              <td>Jendela Otomatis</td>
                              <?php if ($result->PowerWindows == 1) { ?>
                                <td><i class="fa fa-check" aria-hidden="true"></i></td>
                              <?php } else { ?>
                                <td><i class="fa fa-close" aria-hidden="true"></i></td>
                              <?php } ?>
                            </tr>
                            <tr>
                              <td>CD Player</td>
                              <?php if ($result->CDPlayer == 1) { ?>
                                <td><i class="fa fa-check" aria-hidden="true"></i></td>
                              <?php } else { ?>
                                <td><i class="fa fa-close" aria-hidden="true"></i></td>
                              <?php } ?>
                            </tr>
                            <tr>
                              <td>Jok Kulit</td>
                              <?php if ($result->LeatherSeats == 1) { ?>
                                <td><i class="fa fa-check" aria-hidden="true"></i></td>
                              <?php } else { ?>
                                <td><i class="fa fa-close" aria-hidden="true"></i></td>
                              <?php } ?>
                            </tr>
                            <tr>
                              <td>Penguncian Sentral</td>
                              <?php if ($result->CentralLocking == 1) { ?>
                                <td><i class="fa fa-check" aria-hidden="true"></i></td>
                              <?php } else { ?>
                                <td><i class="fa fa-close" aria-hidden="true"></i></td>
                              <?php } ?>
                            </tr>
                            <tr>
                              <td>Kunci Pintu Listrik</td>
                              <?php if ($result->PowerDoorLocks == 1) { ?>
                                <td><i class="fa fa-check" aria-hidden="true"></i></td>
                              <?php } else { ?>
                                <td><i class="fa fa-close" aria-hidden="true"></i></td>
                              <?php } ?>
                            </tr>
                            <tr>
                              <td>Bantuan Rem</td>
                              <?php if ($result->BrakeAssist == 1) { ?>
                                <td><i class="fa fa-check" aria-hidden="true"></i></td>
                              <?php } else { ?>
                                <td><i class="fa fa-close" aria-hidden="true"></i></td>
                              <?php } ?>
                            </tr>
                            <tr>
                              <td>Kantong Udara Pengemudi</td>
                              <?php if ($result->DriverAirbag == 1) { ?>
                                <td><i class="fa fa-check" aria-hidden="true"></i></td>
                              <?php } else { ?>
                                <td><i class="fa fa-close" aria-hidden="true"></i></td>
                              <?php } ?>
                            </tr>
                            <tr>
                              <td>Kantong Udara Penumpang</td>
                              <?php if ($result->PassengerAirbag == 1) { ?>
                                <td><i class="fa fa-check" aria-hidden="true"></i></td>
                              <?php } else { ?>
                                <td><i class="fa fa-close" aria-hidden="true"></i></td>
                              <?php } ?>
                            </tr>
                            <tr>
                              <td>Sensor Kecelakaan</td>
                              <?php if ($result->CrashSensor == 1) { ?>
                                <td><i class="fa fa-check" aria-hidden="true"></i></td>
                              <?php } else { ?>
                                <td><i class="fa fa-close" aria-hidden="true"></i></td>
                              <?php } ?>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              <?php }
    } ?>

          </div>

          <!--Side-Bar-->
          <aside class="col-md-3">
            <div class="sidebar_widget">
              <div class="widget_heading">
                <h5><i class="fa fa-envelope" aria-hidden="true"></i>Pesan Sekarang</h5>
              </div>
              <form method="post" action="booking.php?vhid=<?php echo $vhid; ?>">
                <?php if ($_SESSION['login']) { ?>
                  <div class="form-group">
                    <input type="submit" class="btn" name="submit" value="Book Now">
                  </div>
                <?php } else { ?>
                  <a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Login untuk Pemesanan</a>
                <?php } ?>
              </form>
            </div>
          </aside>
          <!--/Side-Bar-->

        </div>

        <div class="space-20"></div>
        <div class="divider"></div>

<?php
$bid = $_SESSION['brndid'];
$currentVehicleId = $_GET['vhid'];

$sql = "SELECT tblvehicles.VehiclesTitle, tblbrands.BrandName, tblvehicles.PricePerDay, tblvehicles.FuelType,
        tblvehicles.ModelYear, tblvehicles.id, tblvehicles.SeatingCapacity, tblvehicles.VehiclesOverview, tblvehicles.Vimage1 
        FROM tblvehicles 
        JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
        WHERE tblvehicles.VehiclesBrand = :bid AND tblvehicles.id != :currentVehicleId";

$query = $dbh->prepare($sql);
$query->bindParam(':bid', $bid, PDO::PARAM_INT);
$query->bindParam(':currentVehicleId', $currentVehicleId, PDO::PARAM_INT);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() > 0) {
?>
  <div class="col-md-3 grid_listing">
    <div class="product-listing-m gray-bg">
      <div class="product-listing-img">
        <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
          <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" class="img-responsive" alt="image" />
        </a>
      </div>
      <div class="product-listing-content">
        <h5>
          <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
            <?php echo htmlentities($result->BrandName); ?> , <?php echo htmlentities($result->VehiclesTitle); ?>
          </a>
        </h5>
        <p class="list-price">Rp.<?php echo htmlentities($result->PricePerDay); ?></p>
        <ul class="features_list">
          <li><i class="fa fa-user" aria-hidden="true"></i> <?php echo htmlentities($result->SeatingCapacity); ?> seats</li>
          <li><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo htmlentities($result->ModelYear); ?> model</li>
          <li><i class="fa fa-car" aria-hidden="true"></i> <?php echo htmlentities($result->FuelType); ?></li>
        </ul>
      </div>
    </div>
  </div>
<?php
  }
?>

      </div>
    </section>
    <!--/Listing-detail-->

    <!--Footer -->
    <?php include('includes/footer.php'); ?>
    <!-- /Footer-->

    <!--Back to top-->
    <div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
    <!--/Back to top-->

    <!--Login-Form -->
    <?php include('includes/login.php'); ?>
    <!--/Login-Form -->

    <!--Register-Form -->
    <?php include('includes/registration.php'); ?>
    <!--/Register-Form -->

    <!--Forgot-password-Form -->
    <?php include('includes/forgotpassword.php'); ?>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/interface.js"></script>
    <script src="assets/switcher/js/switcher.js"></script>
    <script src="assets/js/bootstrap-slider.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>

  </body>

</html>