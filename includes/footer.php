<?php
if (isset($_POST['emailsubscibe'])) {
    $subscriberemail = trim($_POST['subscriberemail']);

    // Validasi format email
    if (!filter_var($subscriberemail, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Format email tidak valid');</script>";
        exit();
    }

    // Cek apakah sudah terdaftar
    $sql = "SELECT SubscriberEmail FROM tblsubscribers WHERE SubscriberEmail = :email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $subscriberemail, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        echo "<script>alert('Sudah berlangganan.');</script>";
    } else {
        // Masukkan email baru
        $sql = "INSERT INTO tblsubscribers (SubscriberEmail) VALUES (:email)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $subscriberemail, PDO::PARAM_STR);
        $query->execute();

        if ($dbh->lastInsertId()) {
            echo "<script>alert('Berhasil berlangganan.');</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan. Coba lagi.');</script>";
        }
    }
}
?>

<footer>
  <div class="footer-top">
    <div class="container">
      <div class="row">
      
        <div class="col-md-6">
          <h6>Tentang Kami</h6>
          <ul>
            <li><a href="page.php?type=aboutus">Tentang Kami</a></li>
            <li><a href="page.php?type=faqs">persratayanS Umum</a></li>
            <li><a href="page.php?type=privacy">Kebijakan Privasi</a></li>
            <li><a href="page.php?type=terms">Syarat dan Ketentuan Penggunaan</a></li>
            <li><a href="admin/">Admin Login</a></li>
          </ul>
        </div>
  
        <div class="col-md-3 col-sm-6">
          <h6>Ikuti Kabar Terbaru</h6>
          <div class="newsletter-form">
            <form method="post">
              <div class="form-group">
                <input type="email" name="subscriberemail" class="form-control newsletter-input" required placeholder="Masukkan Alamat Email" />
              </div>
              <button type="submit" name="emailsubscibe" class="btn btn-block">Berlangganan <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
            </form>
            <p class="subscribed-text">*Kami mengirimkan penawaran menarik dan berita otomotif terbaru kepada pengguna yang berlangganan setiap minggu.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-push-6 text-right">
          <div class="footer_widget">
            <p>Ikuti kami:</p>
            <ul>
              <li><a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-6 col-md-pull-6">
          <p class="copy-right">RENTCAR.</p>
        </div>
      </div>
    </div>
  </div>
</footer>