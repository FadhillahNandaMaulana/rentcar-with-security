<?php
session_start();
include('includes/config.php');
error_reporting(0);
?>

<!DOCTYPE HTML>
<html lang="en">

  <head>
    <title>Rental Mobil</title>
    <!--Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <link href="assets/css/slick.css" rel="stylesheet">
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <style>
      .col-list-3 {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
      }
      .recent-car-list {
        display: flex;
        flex-direction: column;
        height: 100%;
        min-height: 400px; /* Atur tinggi minimum untuk konsistensi */
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
      }
      .recent-car-list:hover {
        transform: translateY(-5px);
      }
      .car-info-box {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
      }
      .car-info-box img {
        width: 100%;
        height: 200px; /* Atur tinggi gambar tetap */
        object-fit: cover; /* Pastikan gambar terpotong rapi */
      }
      .car-title-m {
        padding: 10px;
        flex-grow: 1;
      }
      .inventory_info_m {
        padding: 10px;
        flex-grow: 0;
      }
      .car-info-box ul {
        padding: 10px;
        margin: 0;
        flex-grow: 0;
      }
    </style>
  </head>

  <body>
    <!-- Start Switcher -->
    <?php include('includes/colorswitcher.php'); ?>
    <!-- /Switcher -->

    <!--Header-->
    <?php include('includes/header.php'); ?>
    <!-- /Header -->

    <!-- Banners -->
  <section id="banner" class="banner-section" style="background-image: url('assets/images/Banner/banner1.jpg'); background-size: cover; background-position: center; padding: 180px 0; color: white;">
      <div class="container">
        <div class="div_zindex">
          <div class="row">
            <div class="col-md-5 col-md-push-7">
              <div class="banner_content">
                <h1> </h1>
                <p> </p>
              </div>
            </div>
          </div>
        </div>
      </div>
 <div class="dark-overlay" style="padding-top: 100px; padding-bottom: 100px; background-color: rgba(0,0,0,0.6);"></div>
    </section>
    <!-- /Banners -->

    <!-- Resent Cat-->
  <section class="section-padding" style="background-color:rgb(198, 198, 198);">
      <div class="container">
        <div class="section-header text-center">
          <h2> Temukan Mobil terbaik <span>Untukmu</span></h2>
          <p>Ada banyak mobil dari berbagai brand ada Suzuki, Bmw, Audi, Nissan, Toyota, dan ada serinya tiap brand, lalu kami selalu mengupdate perubahan harga pasar mobil yang ada.</p>
        </div>
        <div class="row">
          <!-- Nav tabs -->
          <div class="recent-tab">
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#resentnewcar" role="tab" data-toggle="tab">New Car</a></li>
            </ul>
          </div>
          <!-- Recently Listed New Cars -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="resentnewcar">
              <?php
              $sql = "SELECT tblvehicles.VehiclesTitle,tblbrands.BrandName,tblvehicles.PricePerDay,tblvehicles.FuelType,tblvehicles.ModelYear,tblvehicles.id,tblvehicles.SeatingCapacity,tblvehicles.VehiclesOverview,tblvehicles.Vimage1 from tblvehicles join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand limit 9";
              $query = $dbh->query($sql);
              $results = $query->fetchAll(PDO::FETCH_OBJ);

              if (count($results) > 0) {
                foreach ($results as $result) {
                  ?>
                  <div class="col-list-3">
                    <div class="recent-car-list">
                      <div class="car-info-box">
                        <a href="vehical-details.php?vhid=<?php echo $result->id; ?>">
                          <img src="admin/img/vehicleimages/<?php echo $result->Vimage1; ?>" class="img-responsive" alt="image">
                        </a>
                        <ul>
                          <li><i class="fa fa-car" aria-hidden="true"></i><?php echo $result->FuelType; ?></li>
                          <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo $result->ModelYear; ?> Model</li>
                          <li><i class="fa fa-user" aria-hidden="true"></i><?php echo $result->SeatingCapacity; ?> Kursi</li>
                        </ul>
                      </div>
                      <div class="car-title-m">
                        <h6><a href="vehical-details.php?vhid=<?php echo $result->id; ?>"><?php echo $result->VehiclesTitle; ?></a></h6>
                        <span class="price">Rp.<?php echo $result->PricePerDay; ?> /Hari</span>
                      </div>
                      <div class="inventory_info_m">
                        <p><?php echo substr($result->VehiclesOverview, 0, 70); ?></p>
                      </div>
                    </div>
                  </div>
                <?php }
              } ?>
            </div>
          </div>
        </div>
    </section>
    <!-- /Resent Cat -->

    <!-- Fun Facts-->
    <section class="fun-facts-section" style="background-image: url('assets/images/Halaman/Fun_Fact.jpg'); ">

  <style>
    .fun-facts-section::before {
      content: none !important;
    }
  </style>

      <div class="container div_zindex" >
        <div class="row">
          <div class="col-lg-3 col-xs-6 col-sm-3">
            <div class="fun-facts-m">
              <div class="cell">
                <h2><i class="fa fa-calendar" aria-hidden="true"></i>2000s</h2>
                <p>Terpecaya Sejak</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-xs-6 col-sm-3">
            <div class="fun-facts-m">
              <div class="cell">
                <h2><i class="fa fa-car" aria-hidden="true"></i>100%</h2>
                <p>Kondisi Unit</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-xs-6 col-sm-3">
            <div class="fun-facts-m">
              <div class="cell">
                <h2><i class="fa fa-car" aria-hidden="true"></i>200+</h2>
                <p>Unit Rental Sebanyak</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-xs-6 col-sm-3">
            <div class="fun-facts-m">
              <div class="cell">
                <h2><i class="fa fa-user-circle-o" aria-hidden="true"></i>300+</h2>
                <p>Pelanggan Sebanyak</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Dark Overlay-->
      <div class="dark-overlay"></div>
    </section>
    <!-- /Fun Facts-->

    <!--Testimonial -->
    <section class="section-padding testimonial-section parallex-bg" style="background-image: url('assets/images/Halaman/Slider.jpg')";>
      <div class="container div_zindex">
        <div class="section-header white-text text-center">
          <h2> Utamakan Kenyamanan <span>Pelanggan</span></h2>
        </div>
        <div class="row">
          <div id="testimonial-slider">
            <?php
            $tid = 1;
            $sql = "SELECT tbltestimonial.Testimonial,tblusers.FullName from tbltestimonial join tblusers on tbltestimonial.UserEmail=tblusers.EmailId where tbltestimonial.status=$tid limit 4";
            $query = $dbh->query($sql);
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            if (count($results) > 0) {
              foreach ($results as $result) { ?>
                <div class="testimonial-m">
                  <div class="testimonial-content">
                    <div class="testimonial-heading">
                      <h5><?php echo $result->FullName; ?></h5>
                      <p><?php echo $result->Testimonial; ?></p>
                    </div>
                  </div>
                </div>
              <?php }
            } ?>
          </div>
        </div>
      </div>
      <!-- Dark Overlay-->
      <div class="dark-overlay"></div>
    </section>
    <!-- /Testimonial-->

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
    <!--/Forgot-password-Form -->

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/interface.js"></script>
    <!--Switcher-->
    <script src="assets/switcher/js/switcher.js"></script>
    <!--bootstrap-slider-JS-->
    <script src="assets/js/bootstrap-slider.min.js"></script>
    <!--Slider-JS-->
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
  </body>
</html>