<?php
    include "../config/config.php";//Contiene funcion que conecta a la base de datos
    
    $id_dpto=intval($_POST['id_departamento']);
    $id_user_asignado=intval($_POST['user_asignado']);
    $user_asignado_query=mysqli_query($con,"SELECT * from user_login where ID_DPTO=".$id_dpto." AND ID_USER=".$id_user_asignado);
    $val_user_asignado= mysqli_fetch_array($user_asignado_query);
    echo "<option value=".$val_user_asignado['ID_USER'].">".$val_user_asignado['USERNAME']."</option>";

    $result=mysqli_query($con,"SELECT * from user_login where ID_DPTO=".$id_dpto." AND ID_USER NOT IN (".$id_user_asignado.")");
    
    foreach($result as $p):        
        echo "<option value=".$p['ID_USER'].">".$p['USERNAME']."</option>";
    endforeach;   
?>