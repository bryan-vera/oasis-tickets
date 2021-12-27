<?php

include "../config/config.php";

if (isset($_FILES["file"]))
{
    $file = $_FILES["file"];
    $name = MD5($file["name"]);
    $extension = explode(".", strtolower($file["name"]))[1];
    $type = $file["type"];
    $tmp_n = $file["tmp_name"];
    $size = $file["size"];
    $folder = "../assets/images/profiles/";

    if ($type != 'image/jpg' && $type != 'image/jpeg' && $type != 'image/png' && $type != 'image/gif')
    {
      echo "Error, el archivo no es una imagen"; 
    }
    else if ($size > 10240*10240)
    {
      echo "Error, el tamaño máximo permitido es un 10MB";
    }
    else
    {
      $src = $folder.$name.".".$extension;
       @move_uploaded_file($tmp_n, $src);

       $query=mysqli_query($con, "UPDATE user_login set profile_pic=\"$name.".".$extension\" ");
       if($query){
        echo "<div class='alert alert-success' role='alert'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <strong>¡Bien hecho!</strong> Perfil Actualizado Correctamente
        </div>";
       }
    }
}