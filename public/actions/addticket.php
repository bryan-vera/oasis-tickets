<?php	
	session_start();	
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['title'])) {
           $errors[] = "Titulo vacío";
        }  else if (
			!empty($_POST['title'])
		){
		
		
		include "../config/config.php";//Contiene funcion que conecta a la base de datos

		$title = $_POST["title"];
		$description = $_POST["description"];
		$category_id = $_POST["categories_id"];
		$departamento_id = $_POST["departamento_id"];
		$tipo_id = $_POST["priority_id"];
		$user_id = $_SESSION["user_id"];
		$status_id = 2; //Todos los tickets se generan como status pendiente
		
		$sql = mysqli_query($con, "select * from departamentos where ID_DPTO=$departamento_id");
                if($c=mysqli_fetch_array($sql)) {
                    $id_user_asignado=$c['ID_JEFE_AREA'];
				}
		$sql = mysqli_query($con, "select * from user_login where ID_USER=$id_user_asignado");
                if($c=mysqli_fetch_array($sql)) {
                    $nombre_user_asignado=$c['NOMBRE'];
                    $apellido_user_asignado=$c['APELLIDO'];
                    $email_user_asignado=$c['EMAIL'];
				}
		$nombre_completo_user_asignado = ucfirst(strtolower($nombre_user_asignado))." ".ucfirst(strtolower($apellido_user_asignado));
		
		//$status_id = $_POST["status_id"];
		//$kind_id = $_POST["kind_id"];
		$created_at=date("Y-m-d H:i:s");

		// $user_id=$_SESSION['user_id'];

		$sql="insert into tckt_ticket_principal (titulo,descripcion,id_tipo,id_status,id_categoria,id_user_crea_ticket,id_departamento,updated_at,created_at, id_user_asignado) value (\"$title\",\"$description\",$tipo_id, $status_id,$category_id,$user_id,$departamento_id,\"$created_at\",\"$created_at\",$id_user_asignado)";

		$query_new_insert = mysqli_query($con,$sql);		
		$ticketid = mysqli_insert_id($con);
			if ($query_new_insert){
				$messages[] = "Tu ticket ha sido ingresado satisfactoriamente.";		
				
				require '../assets/PHPMailer/PHPMailer-master/src/Exception.php';
				require '../assets/PHPMailer/PHPMailer-master/src/PHPMailer.php';
				require '../assets/PHPMailer/PHPMailer-master/src/SMTP.php';

				// Instantiation and passing `true` enables exceptions
				$mail = new PHPMailer(true);

				try {
					//Server settings
					$mail->isSMTP();                                            // Send using SMTP
					$mail->CharSet = "UTF-8";
					$mail->Host       = 'mail.grupolabovida.com';                    // Set the SMTP server to send through
					$mail->SMTPAuth   = true;      
					$mail->SMTPAutoTLS = false;                              // Enable SMTP authentication
					$mail->Username   = 'oasis@grupolabovida.com';                     // SMTP username
					$mail->Password   = '2d{uC(_v4jr=';                               // SMTP password
					$mail->Port       =587;                                    // TCP port to connect to

					//Receptores
					$mail->setFrom('oasis@grupolabovida.com', 'Ticket #'.$ticketid);
					$mail->addAddress($email_user_asignado, $nombre_completo_user_asignado);     // Add a recipient
					
					//Contenido
					$mail->isHTML(true);                                  // Set email format to HTML
					$mail->Subject = "Se ha generado un nuevo ticket";
					
					$body = file_get_contents('../mail/soporte_asignado.html');
					$email_vars = array(  
						'ticket' =>$ticketid,
						'nombre' =>ucfirst(strtolower($nombre_user_asignado)),
						//'nombre' =>ucfirst(strtolower($_SESSION['nombre'])),
					);

					if(isset($email_vars)){
						foreach($email_vars as $k=>$v){
							$body = str_replace('{'.strtoupper($k).'}', $v, $body);
						}
					}		

					$mail->Body    = $body;
					$mail->AltBody = 'Se ha generado el ticket #'.$ticketid.'';
					$mail->send();
					
					// Enviar mensaje a la persona creadora del ticket
					$mail = new PHPMailer(true);
					$mail->isSMTP();                                            // Send using SMTP
					$mail->CharSet = "UTF-8";
					$mail->Host       = 'mail.grupolabovida.com';                    // Set the SMTP server to send through
					$mail->SMTPAuth   = true;      
					$mail->SMTPAutoTLS = false;                              // Enable SMTP authentication
					$mail->Username   = 'oasis@grupolabovida.com';                     // SMTP username
					$mail->Password   = '2d{uC(_v4jr=';                               // SMTP password
					$mail->Port       =587;

					//Receptores
					$mail->setFrom('oasis@grupolabovida.com', 'Ticket #'.$ticketid);
					$mail->addAddress($_SESSION['email'],$_SESSION['nombre']);     // Add a recipient
					
					//Contenido
					$mail->isHTML(true);                                  // Set email format to HTML
					$mail->Subject = "Se ha generado un nuevo ticket";
					
					$body = file_get_contents('../mail/usuario_ticket.html');
					$email_vars = array(  
						'ticket' =>$ticketid,
						'nombre' =>ucfirst(strtolower($_SESSION['nombre'])),
						'responsable'=> $nombre_completo_user_asignado
						//'nombre' =>ucfirst(strtolower($_SESSION['nombre'])),
					);

					if(isset($email_vars)){
						foreach($email_vars as $k=>$v){
							$body = str_replace('{'.strtoupper($k).'}', $v, $body);
						}
					}		

					$mail->Body    = $body;
					$mail->AltBody = 'Se ha generado el ticket #'.$ticketid.'';
					$mail->send();
					

				} catch (Exception $e) {
					echo "El mensaje no pudo ser enviado. Error de correo: {$mail->ErrorInfo}";
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
				
				if (isset($_FILES["file"]))
				{
					if($_FILES["file"]['size'] != 0)
					{
						$file = $_FILES["file"];
						$filename = $file["name"];
						$name = MD5($file["name"].'_'.time());
						$extension = explode(".", strtolower($file["name"]))[1];
						$type = $file["type"];
						$tmp_n = $file["tmp_name"];
						$size = $file["size"];
						$folder = "../assets/files/";
					
						$src = $folder.$name.".".$extension;
						@move_uploaded_file($tmp_n, $src);		
						$query=mysqli_query($con, "insert into tckt_uploading (file_name, name, id_user, id_ticket) value (\"$name.$extension\", \"$filename\",$user_id , $ticketid)");
						
						
						
						
						
						if($query){
							echo "<div class='alert alert-success' role='alert'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>
								<strong>¡Bien hecho!</strong> Se ha agregado el documento al ticket
							</div>";
						}
					}
				}
				
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