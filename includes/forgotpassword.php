<?php
if (isset($_POST['update'])) {
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $newpassword_plain = $_POST['newpassword'];

    // Validasi input dasar
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Format email tidak valid');</script>";
        exit();
    }

    // Hash password baru dengan bcrypt
    $newpassword_hashed = password_hash($newpassword_plain, PASSWORD_BCRYPT);

    // Cek apakah kombinasi email dan no HP cocok
    $sql = "SELECT EmailId FROM tblusers WHERE EmailId = :email AND ContactNo = :mobile";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        // Update password
        $update_sql = "UPDATE tblusers SET Password = :newpassword WHERE EmailId = :email AND ContactNo = :mobile";
        $update_query = $dbh->prepare($update_sql);
        $update_query->bindParam(':newpassword', $newpassword_hashed, PDO::PARAM_STR);
        $update_query->bindParam(':email', $email, PDO::PARAM_STR);
        $update_query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $update_query->execute();

        echo "<script>alert('Password berhasil diganti');</script>";
    } else {
        echo "<script>alert('Email atau nomor HP salah');</script>";
    }
}
?>

<script type="text/javascript">
function valid()
{
if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)
{
alert("New Password and Confirm Password Field do not match  !!");
document.chngpwd.confirmpassword.focus();
return false;
}
return true;
}
</script>

<div class="modal fade" id="forgotpassword">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Pemulihan Password</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="forgotpassword_wrap">
            <div class="col-md-12">
              <form name="chngpwd" method="post" onSubmit="return valid();">
                <div class="form-group">
                  <input type="email" name="email" class="form-control" placeholder="Your Email address*" required="">
                </div>
                <div class="form-group">
                  <input type="text" name="mobile" class="form-control" placeholder="Your Reg. Mobile*" required="">
                </div>
                <div class="form-group">
                  <input type="password" name="newpassword" class="form-control" placeholder="New Password*" required="">
                </div>
                <div class="form-group">
                  <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password*" required="">
                </div>
                <div class="form-group">
                  <input type="submit" value="Reset My Password" name="update" class="btn btn-block">
                </div>
              </form>
              <div class="text-center">
                <p class="gray_text">Untuk keamanan, kami tidak menyimpan kata sandi Anda. Kata sandi Anda akan direset dan kata sandi baru akan dikirimkan kepada Anda.</p>
                <p><a href="#loginform" data-toggle="modal" data-dismiss="modal"><i class="fa fa-angle-double-left" aria-hidden="true"></i> Kembali ke Login</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>