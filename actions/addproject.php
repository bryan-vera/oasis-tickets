<?php	
	session_start();
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['name'])) {
           $errors[] = "Nombre vacío";
		}  
		

		include "../config/config.php";//Contiene funcion que conecta a la base de datos

		$name = $_POST["name"];


		$sql="insert into DEPARTAMENTOS (NOMBRE_DEPARTAMENTO) value (\"$name\")";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "El departamento ha sido ingresado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
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