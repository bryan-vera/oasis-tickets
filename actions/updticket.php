<?php
	session_start();
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;
	require '../assets/PHPMailer/PHPMailer-master/src/Exception.php';
	require '../assets/PHPMailer/PHPMailer-master/src/PHPMailer.php';
	require '../assets/PHPMailer/PHPMailer-master/src/SMTP.php';

	$IsAdmin=$_SESSION['IsAdmin'];
	//String de almacenaje de cambios
	$mensaje_cambios="";
	//$ticketid=0;

	
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        } else if (empty($_POST['title'])){
			$errors[] = "Titulo vacío";
		} else if (empty($_POST['description'])){
			$errors[] = "Description vacío";
		}  else if (
			!empty($_POST['title']) &&
			!empty($_POST['description'])
		){

		include "../config/config.php";//Contiene funcion que conecta a la base de datos
		
		//Ticket ID
		$id=$_POST['mod_id'];
		//usuario actual
		$user_id=$_SESSION["user_id"];
		//Fecha actual
		
		//Datos info
		$created_at=date("Y-m-d H:i:s");
		$title = $_POST["title"];
		$description = $_POST["description"];
		$updated_at=date("Y-m-d H:i:s");	

		//Obtencion de datos del usuario creador del ticket
		$sql_user = mysqli_query($con, "select usr.NOMBRE,usr.APELLIDO, usr.EMAIL from tckt_ticket_principal tckt INNER JOIN user_login usr on tckt.id_user_crea_ticket = usr.ID_USER where tckt.id_tckt=$id");
		
		if($c=mysqli_fetch_array($sql_user)) {
            $nombre_user=$c['NOMBRE'];
            $apellido_user=$c['APELLIDO'];
            $email_user=$c['EMAIL'];
		}

		// Obtencion de datos del responsable asignado
		$sql = mysqli_query($con,"select usr.NOMBRE,usr.APELLIDO, usr.EMAIL from tckt_ticket_principal tckt INNER JOIN user_login usr on tckt.id_user_asignado = usr.ID_USER where tckt.id_tckt=$id");
                if($c=mysqli_fetch_array($sql)) {
                    $nombre_resp_asignado=$c['NOMBRE'];
                    $apellido_resp_asignado=$c['APELLIDO'];
                    $email_resp_asignado=$c['EMAIL'];
				}
		$nombre_completo_resp_asignado = ucfirst(strtolower($nombre_resp_asignado))." ".ucfirst(strtolower($apellido_resp_asignado));
		

		if($IsAdmin){		
			
		$id_categoria = $_POST["categories_id"];
		$id_tipo = $_POST["priority_id"];
		$id_status = $_POST["status_id"]; //Todos los tickets se generan como status pendiente
		$id_user_asignado = $_POST["user_asignado_id"];

		// Evaluamos si hubo algun cambia con el ticket anterior
		$revisar_tckt =  mysqli_query($con,"SELECT * FROM tckt_ticket_principal WHERE id_tckt=".$id."");
		$val_revisar_tckt= mysqli_fetch_array($revisar_tckt);
		$ant_id_departamento=$val_revisar_tckt['id_departamento'];
		$ant_id_categoria=$val_revisar_tckt['id_categoria'];
		$ant_id_tipo=$val_revisar_tckt['id_tipo'];
		$ant_id_status=$val_revisar_tckt['id_status'];
		$ant_id_user_asignado=$val_revisar_tckt['id_user_asignado'];
		//Revision
		$cam_id_categoria=FALSE;
		$cam_id_tipo=FALSE;
		$cam_id_status=FALSE;
		$cam_id_user_asignado=FALSE;
		
		if($ant_id_categoria!==$id_categoria){
			$cam_id_categoria=TRUE;
			$revisar_categoria =  mysqli_query($con,"SELECT * FROM tckt_categoria WHERE id_categoria=".$id_categoria."");
			$val_revisar_categoria= mysqli_fetch_array($revisar_categoria);
			$mensaje_cambios.=" La categoría ha sido cambiada a ".$val_revisar_categoria['nombre_cat'];
		} 
		if($ant_id_tipo!==$id_tipo){
			$cam_id_tipo=TRUE;
			$revisar_tipo =  mysqli_query($con,"SELECT * FROM tckt_tipo WHERE id_tipo=".$id_tipo."");
			$val_revisar_tipo= mysqli_fetch_array($revisar_tipo);
			$mensaje_cambios.=" El tipo ha sido cambiado a ".$val_revisar_tipo['nombre_tipo'];
		} 
		if($ant_id_status!==$id_status){
			$cam_id_status=TRUE;
			$revisar_status =  mysqli_query($con,"SELECT * FROM tckt_status WHERE id_status=".$id_status."");
			$val_revisar_status= mysqli_fetch_array($revisar_status);
			$mensaje_cambios.=" El status ha sido cambiado a ".$val_revisar_status['nombre_status'];
		} 
		if($ant_id_user_asignado!==$id_user_asignado){
			$cam_id_user_asignado=TRUE;
			$revisar_user_asignado =  mysqli_query($con,"SELECT * FROM user_login WHERE ID_USER=".$id_user_asignado."");
			$val_revisar_user_asignado= mysqli_fetch_array($revisar_user_asignado);
			$nombre = ucfirst(strtolower($val_revisar_user_asignado['NOMBRE']))." ".ucfirst(strtolower($val_revisar_user_asignado['APELLIDO']));
			$mensaje_cambios.=" Se ha asignado un nuevo encargado ".$nombre;
		}


		//echo "<option value=".$val_user_asignado['ID_USER'].">".$val_user_asignado['USERNAME']."</option>";
	
		$sql = "update tckt_ticket_principal set id_categoria=$id_categoria, id_status=$id_status,id_user_asignado=$id_user_asignado, updated_at=\"$updated_at\" where id_tckt=$id";
		$query_update = mysqli_query($con,$sql);
		$ticketid = mysqli_insert_id($con);
			if ($query_update){
				$messages[] = "El ticket ha sido actualizado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		// } else {
		// 	$errors []= "Error desconocido.";
		// }

		// Insercion de mensaje en tabla de eventos de ticket
		$mensaje_cambios.= $_POST["respuesta"];
		// Revision de documentos en modal
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
						//"INSERT INTO tckt_eventos set id_tckt=$id, respuesta=$mensaje_cambios,id_user=$user_id, updated_at=\"$updated_at\" where id_tckt=$id";
						$query=mysqli_query($con, "INSERT INTO tckt_eventos (id_ticket, id_user,respuesta,file_name, created_at) values ($id,$user_id,\"$mensaje_cambios\",\"$filename\",\"$created_at\")");
						$query=mysqli_query($con, "INSERT INTO tckt_uploading (file_name, name, id_user, id_ticket) values (\"$name.$extension\", \"$filename\",$user_id , $ticketid)");
						if($query){
							echo "<div class='alert alert-success' role='alert'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>
								<strong>¡Bien hecho!</strong> Se ha agregado el documento al ticket
							</div>";
						}
					}
				}
				//$test_query= "INSERT INTO tckt_eventos (id_ticket, id_user,respuesta, created_at) values ($id,$user_id,\"$mensaje_cambios\",\"$created_at\")";
				$query=mysqli_query($con, "INSERT INTO tckt_eventos (id_ticket, id_user,respuesta, created_at) values ($id,$user_id,\"$mensaje_cambios\",\"$created_at\")");
				$insert_id = mysqli_insert_id($con);
				//$sql = "INSERT INTO tckt_eventos set id_tckt=$id, respuesta=$mensaje_cambios ,id_user_asignado=$id_user_asignado, updated_at=\"$created_at\" where id_tckt=$id";
			} else { 
				$mensaje_cambios=$_POST["respuesta"];
				$query=mysqli_query($con, "INSERT INTO tckt_eventos (id_ticket, id_user,respuesta, created_at) values ($id,$user_id,\"$mensaje_cambios\",\"$created_at\")");
				if ($query){
					$messages[] = "El ticket ha sido actualizado satisfactoriamente.";
				} else{
					$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
				}
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
				// Envio de correo al responsable y usuario
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
					$mail->setFrom('oasis@grupolabovida.com', 'Ticket #'.$id);
					$mail->addAddress($email_resp_asignado, $nombre_completo_resp_asignado);     // Add a recipient
					$mail->addAddress($email_user);
					//Contenido
					$mail->isHTML(true);                                  // Set email format to HTML
					$mail->Subject = "Se ha actualizado un ticket";
					
					$body = file_get_contents('../mail/actualizacion_ticket.html');
					$email_vars = array(  
						'ticket' =>$id,
						//'nombre' =>ucfirst(strtolower($nombre_user_asignado)),
						//'nombre' =>ucfirst(strtolower($_SESSION['nombre'])),
					);

					if(isset($email_vars)){
						foreach($email_vars as $k=>$v){
							$body = str_replace('{'.strtoupper($k).'}', $v, $body);
						}
					}		

					$mail->Body    = $body;
					$mail->AltBody = 'Se ha actualizado el ticket #'.$id.'';
					$mail->send();
				} catch (Exception $e) {
					echo "El mensaje no pudo ser enviado. Error de correo: {$mail->ErrorInfo}";
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
		}
?>