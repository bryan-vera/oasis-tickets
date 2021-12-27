<?php
    include "../config/config.php";//Contiene funcion que conecta a la base de datos
    
    $id_categoria=intval($_POST['categories_id']);
    $result=mysqli_query($con,"SELECT * from tckt_subcategoria where id_categoria=".$id_categoria." order by nombre_subcat");
    
    foreach($result as $p):        
        echo "<option value=".$p['id_subcategoria'].">".$p['nombre_subcat']."</option>";
    endforeach;   
?>