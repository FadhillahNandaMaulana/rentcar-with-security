<?php 
require_once("includes/config.php");

if (!empty($_POST["emailid"])) {
	$email = $_POST["emailid"];

	// Gunakan prepared statement dan bindParam agar aman dari SQL Injection
	$sql = "SELECT EmailId FROM tblusers WHERE EmailId = :email";
	$query = $dbh->prepare($sql);
	$query->bindParam(':email', $email, PDO::PARAM_STR);
	$query->execute();

	$results = $query->fetchAll(PDO::FETCH_OBJ);

	if ($query->rowCount() > 0) {
		echo "<span style='color:red'> Email sudah digunakan .</span>";
		echo "<script>$('#submit').prop('disabled',true);</script>";
	} else {
		echo "<span style='color:green'> Email tersedia untuk registrasi .</span>";
		echo "<script>$('#submit').prop('disabled',false);</script>";
	}
}
?>