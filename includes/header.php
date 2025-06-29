<header>
  <div class="default-header" style="background-color:rgb(198, 198, 198)">
    <div class="container">
      <div class="row">
        <div class="col-sm-3 col-md-2">
          <div class="logo"> <a href="index.php"><img src="assets/images/HAHAHA.png" alt="image"/></a> </div>
        </div>
        <div class="col-sm-9 col-md-10">
          <div class="header_info">
         <?php
$sql = "SELECT EmailId, ContactNo FROM tblcontactusinfo LIMIT 1";
$query = $dbh->prepare($sql);
$query->execute();
$result = $query->fetch(PDO::FETCH_OBJ);

if ($result) {
  $email = htmlspecialchars($result->EmailId);
  $contactno = htmlspecialchars($result->ContactNo);
}
?>   
            <div class="header_widgets">
              <div class="circle_icon"> <i class="fa fa-envelope" aria-hidden="true" style="color: black;"></i> </div>
              <p class="uppercase_text">Untuk Dukungan, kirim email ke: </p>
              <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a> </div>
            <div class="header_widgets">
              <div class="circle_icon"> <i class="fa fa-phone" aria-hidden="true" style="color: black;"></i> </div>
              <p class="uppercase_text">Layanan Bantuan Hubungi Kami: </p>
              <a href="tel:<?php echo $contactno; ?>"><?php echo $contactno; ?></a> </div>
            <div class="social-follow">
            </div>
   <?php if (!isset($_SESSION['login']) || strlen($_SESSION['login']) == 0) { ?>  
 <div class="login_btn"> <a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Login / Daftar</a> </div>
<?php } else { 
echo "Selamat Datang di RentCar";
 } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Navigation -->
  <nav id="navigation_bar" class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button id="menu_slide" data-target="#navigation" aria-expanded="false" data-toggle="collapse" class="navbar-toggle collapsed" type="button"> 
          <span class="sr-only">Toggle navigation</span> 
          <span class="icon-bar"></span> 
          <span class="icon-bar"></span> 
          <span class="icon-bar"></span> 
        </button>
      </div>
      <div class="header_wrap">
        <div class="user_login">
          <ul>
            <li class="dropdown"> 
              <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle" aria-hidden="true"></i> 
<?php 
if (isset($_SESSION['login'])) {
  $email = $_SESSION['login'];
  $sql = "SELECT FullName FROM tblusers WHERE EmailId = :email LIMIT 1";
  $query = $dbh->prepare($sql);
  $query->bindParam(':email', $email, PDO::PARAM_STR);
  $query->execute();
  $result = $query->fetch(PDO::FETCH_OBJ);
  if ($result) {
    echo htmlspecialchars($result->FullName);
  }
}
?>
   <i class="fa fa-angle-down" aria-hidden="true"></i></a>
              <ul class="dropdown-menu">
           <?php if (isset($_SESSION['login']) && $_SESSION['login']) { ?>
            <li><a href="profile.php">Atur Profil</a></li>
            <li><a href="update-password.php">Ubah Password</a></li>
            <li><a href="my-booking.php">Pemesanan Saya</a></li>
            <li><a href="post-testimonial.php">Posting Testimoni</a></li>
            <li><a href="my-testimonials.php">Testimoni Saya</a></li>
            <li><a href="logout.php">Keluar</a></li>
            <?php } ?>
          </ul>
            </li>
          </ul>
        </div>
        <div class="header_search">
          <div id="search_toggle"><i class="fa fa-search" aria-hidden="true"></i></div>
          <form action="search.php" method="post" id="header-search-form">
            <input type="text" placeholder="Search..." name="searchdata" class="form-control" required="true">
            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
          </form>
        </div>
      </div>
      <div class="collapse navbar-collapse" id="navigation">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Beranda</a></li>  
          <li><a href="page.php?type=aboutus">Tentang Kami</a></li>
          <li><a href="car-listing.php">Daftar Mobil</a></li>
          <li><a href="page.php?type=faqs">persratayan Umum</a></li>
          <li><a href="contact-us.php">Kontak Kami</a></li>
        </ul>
      </div>
    </div>
  </nav>
</header>
