<?php
    include "../config/config.php";//Contiene funcion que conecta a la base de datos
    
    $id_dpto=intval($_POST['departamento_id']);
    $result=mysqli_query($con,"SELECT * from tckt_categoria where id_dpto=".$id_dpto);
    
    foreach($result as $p):        
        echo "<option value=".$p['id_categoria'].">".$p['nombre_cat']."</option>";
    endforeach;   
?>