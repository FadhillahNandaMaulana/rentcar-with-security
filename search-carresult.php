<?php
session_start();
include('includes/config.php');
error_reporting(0);
?>

<!DOCTYPE HTML>
<html lang="en">

  <head>
    <title>RENTCAR</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <link href="assets/css/slick.css" rel="stylesheet">
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
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

    <!-- Icons and Fonts -->
    <link rel="apple-touch-icon" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
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

    <!--Page Header-->
    <section class="page-header listing_page">
      <div class="container">
        <div class="page-header_wrap">
          <div class="page-heading">
            <h1>Daftar Mobil</h1>
          </div>
          <ul class="coustom-breadcrumb">
            <li><a href="#">Beranda</a></li>
            <li>Daftar Mobil</li>
          </ul>
        </div>
      </div>
      <div class="dark-overlay"></div>
    </section>
    <!-- /Page Header-->

    <!--Listing-->
    <section class="listing-page">
      <div class="container">
        <div class="row">
          <div class="col-md-9 col-md-push-3">

            <div class="result-sorting-wrapper">
              <div class="sorting-count">

<?php
$brand = isset($_GET['brand']) ? $_GET['brand'] : '';
$fueltype = isset($_GET['fueltype']) ? $_GET['fueltype'] : '';

if ($brand !== '' && $fueltype !== '') {
  $sqlCount = "SELECT COUNT(*) FROM tblvehicles WHERE VehiclesBrand = :brand AND LOWER(FuelType) = LOWER(:fueltype)";
  $query = $dbh->prepare($sqlCount);
  $query->bindParam(':brand', $brand, PDO::PARAM_INT); // jika brand berbentuk ID angka
  $query->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
  $query->execute();
  $cnt = $query->fetchColumn();
  echo "<p><span>" . htmlentities($cnt) . " Listings</span></p>";
} else {
  $sqlCountAll = "SELECT COUNT(*) FROM tblvehicles";
  $cnt = $dbh->query($sqlCountAll)->fetchColumn();
  echo "<p><span>" . htmlentities($cnt) . " Listings</span></p>";
}
?>

              </div>
            </div>

<?php
// Filter aman menggunakan prepared statement
if ($brand !== '' && $fueltype !== '') {
  $sql = "SELECT tblvehicles.*, tblbrands.BrandName FROM tblvehicles 
          JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
          WHERE tblvehicles.VehiclesBrand = :brand 
          AND LOWER(tblvehicles.FuelType) = LOWER(:fueltype)";
  $query = $dbh->prepare($sql);
  $query->bindParam(':brand', $brand, PDO::PARAM_INT); // anggap brand adalah ID (INT)
  $query->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
  $query->execute();
} else {
  $sql = "SELECT tblvehicles.*, tblbrands.BrandName FROM tblvehicles 
          JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand";
  $query = $dbh->query($sql);
}

$results = $query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() > 0) {
  foreach ($results as $result) {
?>
    <div class="product-listing-m gray-bg">
      <div class="product-listing-img">
        <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" class="img-responsive" alt="Image" />
      </div>
      <div class="product-listing-content">
        <h5><a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
          <?php echo htmlentities($result->BrandName); ?> , <?php echo htmlentities($result->VehiclesTitle); ?>
        </a></h5>
        <p class="list-price">Rp.<?php echo htmlentities($result->PricePerDay); ?> Per Hari</p>
        <ul>
          <li><i class="fa fa-user" aria-hidden="true"></i><?php echo htmlentities($result->SeatingCapacity); ?> kursi</li>
          <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($result->ModelYear); ?> model</li>
          <li><i class="fa fa-car" aria-hidden="true"></i><?php echo htmlentities($result->FuelType); ?></li>
        </ul>
        <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>" class="btn">Lihat Detail
          <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
      </div>
    </div>
<?php
  }
} else {
  echo "<p>Tidak ada mobil yang sesuai dengan kriteria Anda.</p>";
}
?>

          </div>

          <!--Side-Bar-->
          <aside class="col-md-3 col-md-pull-9">
            <div class="sidebar_widget">
              <div class="widget_heading">
                <h5><i class="fa fa-filter" aria-hidden="true"></i> Find Your Car </h5>
              </div>
              <div class="sidebar_filter">
                <form action="car-listing.php" method="get">
                  <div class="form-group select">
                    <select class="form-control" name="brand" required>
                      <option value="">Pilih Merek</option>
                      <?php
                      $sqlBrands = "SELECT * FROM tblbrands";
                      $queryBrands = $dbh->query($sqlBrands);
                      $brands = $queryBrands->fetchAll(PDO::FETCH_OBJ);
                      if ($queryBrands->rowCount() > 0) {
                        foreach ($brands as $b) {
                          $selected = ($brand == $b->id) ? "selected" : "";
                          echo "<option value=\"" . htmlentities($b->id) . "\" $selected>" . htmlentities($b->BrandName) . "</option>";
                        }
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group select">
                    <select class="form-control" name="fueltype" required>
                      <option value="">Pilih Tipe Bensin</option>
                      <option value="Petrol" <?php if (strcasecmp($fueltype, "Petrol") == 0)
                        echo "selected"; ?>>Petrol
                      </option>
                      <option value="Diesel" <?php if (strcasecmp($fueltype, "Diesel") == 0)
                        echo "selected"; ?>>Diesel
                      </option>
                      <option value="CNG" <?php if (strcasecmp($fueltype, "CNG") == 0)
                        echo "selected"; ?>>CNG</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-block">
                      <i class="fa fa-search" aria-hidden="true"></i> Pilih Mobil
                    </button>
                  </div>
                </form>
              </div>
            </div>

            <div class="sidebar_widget">
              <div class="widget_heading">
                <h5><i class="fa fa-car" aria-hidden="true"></i> Mobil yang Baru Didaftarkan</h5>
              </div>
              <div class="recent_addedcars">
                <ul>
                  <?php
                  $sqlRecent = "SELECT tblvehicles.*, tblbrands.BrandName FROM tblvehicles 
              JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
              ORDER BY tblvehicles.id DESC LIMIT 4";
                  $queryRecent = $dbh->query($sqlRecent);
                  $recentCars = $queryRecent->fetchAll(PDO::FETCH_OBJ);
                  if ($queryRecent->rowCount() > 0) {
                    foreach ($recentCars as $car) {
                      ?>
                      <li class="gray-bg">
                        <div class="recent_post_img">
                          <a href="vehical-details.php?vhid=<?php echo htmlentities($car->id); ?>">
                            <img src="admin/img/vehicleimages/<?php echo htmlentities($car->Vimage1); ?>" alt="image">
                          </a>
                        </div>
                        <div class="recent_post_title">
                          <a href="vehical-details.php?vhid=<?php echo htmlentities($car->id); ?>">
                            <?php echo htmlentities($car->BrandName); ?> , <?php echo htmlentities($car->VehiclesTitle); ?>
                          </a>
                          <p class="widget_price">$<?php echo htmlentities($car->PricePerDay); ?> Per Day</p>
                        </div>
                      </li>
                      <?php
                    }
                  }
                  ?>
                </ul>
              </div>
            </div>
          </aside>
          <!--/Side-Bar-->
        </div>
      </div>
    </section>
    <!-- /Listing-->

    <!--Footer -->
    <?php include('includes/footer.php'); ?>
    <!-- /Footer-->

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/interface.js"></script>
    <script src="assets/js/bootstrap-slider.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>

  </body>

</html>