<?php	

	session_start();

	if (empty($_POST['mod_nombre'])) {
           $errors[] = "Nombre vacío";
        }else if (empty($_POST['mod_apellido'])){
			$errors[] = "Correo Vacio vacío";
		}else if (empty($_POST['mod_username'])){
			$errors[] = "Correo Vacio vacío";
		}else if (empty($_POST['mod_email'])){
			$errors[] = "Correo Vacio vacío";		
		} else if ($_POST['mod_departamento']==""){
			$errors[] = "Selecciona el estado";
		}else if (
			!empty($_POST['mod_nombre']) &&
			!empty($_POST['mod_email']) &&
			$_POST['mod_departamento']!=""
		){

		include "../config/config.php";//Contiene funcion que conecta a la base de datos

		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["mod_nombre"],ENT_QUOTES)));
		$apellido=mysqli_real_escape_string($con,(strip_tags($_POST["mod_apellido"],ENT_QUOTES)));
		$username=mysqli_real_escape_string($con,(strip_tags($_POST["mod_username"],ENT_QUOTES)));
		$email=$_POST["mod_email"];
		$password=sha1(md5(mysqli_real_escape_string($con,(strip_tags(($_POST["password"]))))));		
		$id=$_POST['mod_id'];
		$departamento=intval($_POST['mod_departamento']);
		$sql="UPDATE user_login SET USERNAME=\"$username\",NOMBRE=\"$nombre\",APELLIDO=\"$apellido\", EMAIL=\"$email\",ID_DPTO=$departamento  WHERE ID_USER=$id";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Datos actualizados satisfactoriamente.";

				if($_POST["password"]!=""){
					$update_passwd=mysqli_query($con,"update user_login set PWD=\"$password\" where id_user=$id");
					if ($update_passwd) {
						$messages[] = " Y la Contraseña ah sido actualizada.";
					}
				}

			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		} else {
			$errors []= "Error desconocido.";
		}
		
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>