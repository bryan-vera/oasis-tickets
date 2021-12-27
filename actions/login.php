<?php
	session_start();

	if (isset($_POST['token']) && $_POST['token']!=='') {
			
	//Contiene las variables de configuracion para conectar a la base de datos
	include "../config/config.php";

	$username=mysqli_real_escape_string($con,(strip_tags($_POST["username"],ENT_QUOTES)));
	$dirtypwd = mysqli_real_escape_string($con,(strip_tags($_POST["password"],ENT_QUOTES)));
	$password=sha1(md5($dirtypwd));
	$query_str = ("SELECT * FROM user_login WHERE username =\"$username\" AND pwd=\"$password\"");
	$query = mysqli_query($con,$query_str);
	// echo $username."   ".$password;

		if ($query) {		
			$row = mysqli_fetch_array($query);
			$_SESSION['user_id'] = $row['ID_USER'];
			$_SESSION['IsAdmin'] = $row['ADMIN_PRIV'];
			$_SESSION['nombre'] = $row['NOMBRE'];
			$_SESSION['email'] = $row['EMAIL'];
			header("location: ../dashboard.php");	
		}else{
			$invalid=sha1(md5("contrasena y email invalido"));
			header("location: ../index.php?invalid=$invalid");
		}
	}else{
		header("location: ../");
	}

?>