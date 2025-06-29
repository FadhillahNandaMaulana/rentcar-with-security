<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['updatepass'])) {
        $oldpass_input = $_POST['password'];
        $newpass_input = $_POST['newpassword'];
        $email = $_SESSION['login'];

        // Ambil password hash dari database
        $sql = "SELECT Password FROM tblusers WHERE EmailId = :email";
        $query = $dbh->prepare($sql);
        $query->execute([':email' => $email]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($oldpass_input, $user['Password'])) {
            // Hash password baru
            $hashed_new_password = password_hash($newpass_input, PASSWORD_BCRYPT);

            // Update password ke database
            $sql_update = "UPDATE tblusers SET Password = :newpassword WHERE EmailId = :email";
            $stmt = $dbh->prepare($sql_update);
            $stmt->execute([
                ':newpassword' => $hashed_new_password,
                ':email' => $email
            ]);

            $msg = "Password berhasil diperbarui";
        } else {
            $error = "Password lama tidak cocok";
        }
    }
?>

    <!DOCTYPE HTML>
    <html lang="en">
    <head>
        <title>RENTCAR</title>
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
        <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">

        <script type="text/javascript">
            function valid() {
                if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
                    alert("New Password and Confirm Password Field do not match !!");
                    document.chngpwd.confirmpassword.focus();
                    return false;
                }
                return true;
            }
        </script>

        <style>
            .errorWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #dd3d36;
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }
            .succWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #5cb85c;
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }
        </style>
    </head>
    <body>

    <?php include('includes/colorswitcher.php'); ?>
    <?php include('includes/header.php'); ?>

    <section class="page-header profile_page">
        <div class="container">
            <div class="page-header_wrap">
                <div class="page-heading">
                    <h1>Update Password</h1>
                </div>
                <ul class="coustom-breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li>Update Password</li>
                </ul>
            </div>
        </div>
        <div class="dark-overlay"></div>
    </section>

<?php
$useremail = $_SESSION['login'];
$sql = "SELECT * FROM tblusers WHERE EmailId = :email";
$query = $dbh->prepare($sql);
$query->execute([':email' => $useremail]);
$results = $query->fetchAll(PDO::FETCH_OBJ);
if ($query->rowCount() > 0) {
  foreach ($results as $result) { ?>

        <section class="user_profile inner_pages" style="background-color:rgb(198, 198, 198)">
          <div class="container" style="background-color:rgb(198, 198, 198)">
            <div class="user_profile_info gray-bg padding_4x4_40">
              <div class="upload_user_logo"> 
  <img src="assets/images/user.png" alt="User Logo">
</div>

              <div class="dealer_info">
                <h5><?php echo htmlentities($result->FullName); ?></h5>
                <p><?php echo htmlentities($result->Address); ?><br>
                  <?php echo htmlentities($result->City); ?>&nbsp;
                  <?php echo htmlentities($result->Country); ?></p>
              </div>
            </div>
                        <div class="row" style="margin-top: -80px;">
                        <div class="col-md-3 col-sm-3">
                        </div>
                        <div class="col-md-6 col-sm-8">
                            <div class="profile_wrap">
                                <form name="chngpwd" method="post" onSubmit="return valid();">
                                    <div class="gray-bg field-title">
                                        <h6>Ubah password</h6>
                                    </div>
                                    <?php if ($error) { ?>
                                        <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?> </div>
                                    <?php } else if ($msg) { ?>
                                        <div class="succWrap"><strong>SUKSES</strong>: <?php echo htmlentities($msg); ?> </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <label class="control-label">Password Sebelumnya</label>
                                        <input class="form-control white_bg" id="password" name="password" type="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Password</label>
                                        <input class="form-control white_bg" id="newpassword" type="password" name="newpassword" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Konfirmasi Password</label>
                                        <input class="form-control white_bg" id="confirmpassword" type="password" name="confirmpassword" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="Ubah" name="updatepass" id="submit" class="btn btn-block">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        }
    }
    ?>

    <?php include('includes/footer.php'); ?>

    <div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>

    <?php include('includes/login.php'); ?>
    <?php include('includes/registration.php'); ?>
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

<?php } ?>
