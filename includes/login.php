<?php
session_start();
include('includes/config.php');

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Format email tidak valid');</script>";
        exit();
    }

    $sql = "SELECT EmailId, Password, FullName FROM tblusers WHERE EmailId = :email LIMIT 1";

    try {
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();

        $user = $query->fetch(PDO::FETCH_OBJ);

        if ($user) {
            $isPasswordValid = false;

            // Jika sudah bcrypt
            if (password_verify($password, $user->Password)) {
                $isPasswordValid = true;
            } 
            // Jika password masih plain text dan cocok
            elseif ($password === $user->Password) {
                $isPasswordValid = true;

                // Hash password lama dan update di database
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $updateSql = "UPDATE tblusers SET Password = :newpass WHERE EmailId = :email";
                $updateQuery = $dbh->prepare($updateSql);
                $updateQuery->bindParam(':newpass', $hashedPassword, PDO::PARAM_STR);
                $updateQuery->bindParam(':email', $email, PDO::PARAM_STR);
                $updateQuery->execute();
            }

            if ($isPasswordValid) {
                $_SESSION['login'] = $user->EmailId;
                $_SESSION['fname'] = $user->FullName;

                $currentpage = $_SERVER['REQUEST_URI'];
                echo "<script type='text/javascript'> 
                    var url = '$currentpage';
                    url += (url.indexOf('?') >= 0) ? '&id=1' : '?id=1';
                    document.location = url;
                </script>";
            } else {
                echo "<script>alert('Email atau password salah');</script>";
            }
        } else {
            echo "<script>alert('Email tidak ditemukan');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Kesalahan sistem.');</script>";
        error_log("Database error: " . $e->getMessage());
    }
}
?>

<div class="modal fade" id="loginform">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Login</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="login_wrap">
            <div class="col-md-12 col-sm-6">
              <form method="post">
                <div class="form-group">
                  <input type="email" class="form-control" name="email" placeholder="Email address*">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="password" placeholder="Password*">
                </div>
                <div class="form-group checkbox">
                  <input type="checkbox" id="remember">
                </div>
                <div class="form-group">
                  <input type="submit" name="login" value="Login" class="btn btn-block">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer text-center">
        <p>Tidak punya akun? <a href="#signupform" data-toggle="modal" data-dismiss="modal">Daftar Disini</a></p>
        <p><a href="#forgotpassword" data-toggle="modal" data-dismiss="modal">Lupa Password ?</a></p>
      </div>
    </div>
  </div>
</div>