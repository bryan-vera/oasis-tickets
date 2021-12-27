<?php

    include "../config/config.php";//Contiene funcion que conecta a la base de datos
    
    $action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    if (isset($_GET['id'])){
        $id_del=intval($_GET['id']);
        $query=mysqli_query($con, "SELECT * from tckt_ticket_principal where id_tckt='".$id_del."'");
        $count=mysqli_num_rows($query);
            if ($cerrado=mysqli_query($con,"UPDATE tckt_ticket_principal SET cerrado = '1' WHERE id_tckt='".$id_del."'")){
?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Aviso!</strong> Ticket cerrado exitosamente.
            </div>
        <?php 
            }else {
        ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
                </div>
    <?php
            } //end else
        } //end if
    ?>

<?php
    if($action == 'ajax'){ 
        session_start();    
        $id=$_SESSION['user_id'];
        // escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         $aColumns = array('titulo','descripcion');//Columnas de busqueda
         $sTable = "tckt_ticket_principal";
         $sWhere = "WHERE cerrado=0 AND (id_user_crea_ticket=".$id." OR id_user_asignado=".$id.")";
        if ( $_GET['q'] != "" )
        {
            $sWhere = "WHERE (";
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
            {
                $sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
            }
            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= ')';
        }
        $sWhere.=" order by created_at desc";
        include 'pagination.php'; //include pagination file
        //pagination variables
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
        $per_page = 10; //how much records you want to show
        $adjacents  = 4; //gap between pages after number of adjacents
        $offset = ($page - 1) * $per_page;
        //Count the total number of row in your table*/
        $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
        $row= mysqli_fetch_array($count_query);
        $numrows = $row['numrows'];
        $total_pages = ceil($numrows/$per_page);
        $reload = './expences.php';
        //main query to fetch the data
        $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
        $query = mysqli_query($con, $sql);
        //loop through fetched data
        if ($numrows>0){
            
            ?>
            <table class="table table-striped jambo_table bulk_action" id="table_tickets">
                <thead>
                    <tr class="headings">
                        <th class="column-title">ID</th>
                        <th class="column-title">Asunto</th>
                        <th class="column-title">Descripción</th>
                        <th class="column-title">Departamento </th>
                        <th class="column-title">Categoría </th>
                        <th class="column-title">Prioridad </th>
                        <th class="column-title">Estado </th>
                        <th class="column-title">Soporte asignado </th>
                        <th>Fecha ingreso</th>
                        <th>Ultima actualizacion</th>
                        <th class="column-title no-link last"><span class="nobr"></span></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                        while ($r=mysqli_fetch_array($query)) {
                            $id=$r['id_tckt'];
                            $created_at=date('d/m/Y H:i:s', strtotime($r['created_at']));
                            $description=$r['descripcion'];
                            $title=$r['titulo'];
                            $departamento_id=$r['id_departamento'];
                            $categoria_id = $r['id_categoria'];
                            $prioridad_id=$r['id_tipo'];
                            $status_id=$r['id_status'];
                            $user_creador=$r['id_user_crea_ticket'];
                            $user_asignado=$r['id_user_asignado'];
                            $updated_at=date('d/m/Y H:i:s', strtotime($r['updated_at']));

                            $sql = mysqli_query($con, "select * from departamentos where ID_DPTO=$departamento_id");
                            if($c=mysqli_fetch_array($sql)) {
                                $nombre_departamento=$c['NOMBRE_DEPARTAMENTO'];
                            }

                            $sql = mysqli_query($con, "select * from tckt_tipo where id_tipo=$prioridad_id");
                            if($c=mysqli_fetch_array($sql)) {
                                $nombre_prioridad=$c['nombre_tipo'];
                            }

                            $sql = mysqli_query($con, "select * from tckt_status where id_status=$status_id");
                            if($c=mysqli_fetch_array($sql)) {
                                $nombre_status=$c['nombre_status'];
                            }

                            $sql = mysqli_query($con, "select * from tckt_categoria where id_categoria=$categoria_id");
                            if($c=mysqli_fetch_array($sql)) {
                                $nombre_categoria=$c['nombre_cat'];
                            }

                            $sql = mysqli_query($con, "select * from user_login where id_user=$user_asignado");
                            if($c=mysqli_fetch_array($sql)) {
                                $nombre_user_asignado=$c['USERNAME'];
                            }


                ?>
                    <input type="hidden" value="<?php echo $id;?>" id="id<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $title;?>" id="title<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $description;?>" id="description<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $departamento_id;?>" id="departamento_id<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $categoria_id;?>" id="category_id<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $prioridad_id;?>" id="priority_id<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $status_id;?>" id="status_id<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $user_asignado;?>" id="user_asignado<?php echo $id;?>">


                    <tr class="even pointer">
                        <td id="id_td"><?php echo $id;?></td>
                        <td><?php echo $title;?></td>
                        <td><?php echo $description; ?></td>
                        <td><?php echo $nombre_departamento; ?></td>
                        <td><?php echo $nombre_categoria; ?></td>
                        <td><?php echo $nombre_prioridad; ?></td>
                        <td><?php echo $nombre_status;?></td>
                        <td><?php echo $nombre_user_asignado;?></td>
                        <td><?php echo $created_at;?></td>
                        <td><?php echo $updated_at;?></td>
                        <td ><span class="pull-right">
                        <?php 
                        $sql = mysqli_query($con, "select * from tckt_uploading where id_ticket=$id");
                        $archivo_adjunto = mysqli_fetch_array($sql);
                        if($archivo_adjunto):
                        ?>                        
                            <a href="assets/files/<?php echo $archivo_adjunto['file_name'];?>" class='btn btn-default' title='Descargar archivo'  download><i class="glyphicon glyphicon-paperclip"></i></a> 
                        <?php 
                        endif;
                        ?>
                        <a href="#" class='btn btn-default' title='Responder ticket' onclick="obtener_datos('<?php echo $id;?>');" data-toggle="modal" data-target=".bs-example-modal-lg-udp"><i class="glyphicon glyphicon-share-alt"></i></a> 
                        <a href="#" class='btn btn-default' title='Cerrar ticket' onclick="cerrar_ticket('<?php echo $id; ?>')"><i class="glyphicon glyphicon-check"></i> </a></span>
                        </td>
                    </tr>
                    <script>
                    </script>
                <?php
                    } //en while
                ?>
                <tr>
                    <td colspan=11><span class="pull-right">
                        <?php echo paginate($reload, $page, $total_pages, $adjacents);?>
                    </span></td>
                </tr>
              </table>
            </div>
            <?php
        }else{
           ?> 
            <div class="alert alert-warning alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Aviso!</strong> No hay datos para mostrar!
            </div>
        <?php    
        }
    }
?>
<script>
$(document).ready(function() {
    //Funcion para obtener detalle del ticker
    // cuando se ha hecho click en la tabla
    $('#table_tickets tr td').click(function() {
        var row_clicked = $(this).closest('tr').find('td:eq(0)').text(); 
        var $row = $(this).closest("tr");
        var td_cercano = $row.closest("td");
        if(!td_cercano.context.getElementsByClassName("pull-right").length){
                var tds = $row.find('td:eq(0)');
                var id_ticket = tds.text();
                //var parametros = $(this).serialize();
                if (confirm('Desea acceder al detalle del ticket #' + tds.text())) {
                    //console.log(id_ticket);
                    $(this).serialize();
                        $.ajax({
                                type: "GET",
                                url: "eventos.php",
                                data: {"id_ticket": id_ticket},
                                //dataType: "json",
                                //contentType: "application/json; charset=utf-8",
                                beforeSend: function(objeto){
                                    $("#x_content").html("Mensaje: Cargando...");
                                },
                                success: function(datos){
                                $("#x_content").html(datos);
                                $('#AddTicket').hide();
                                $('.x_title').hide();
                                $('#gastos').hide();
                                }
                        });
                    event.preventDefault();
                    };  
        //    };  
        };        
        });
    });
//var q= $("#q").val();            
            //window.location.href = "eventos.php";          
            //$.ajax({        
             //   url: "eventos.php",
             //   beforeSend: function(objeto){
             //       $('#loader').html('<img src="./assets/images/ajax-loader.gif"> Cargando...');
            //    },
                //success:function(data){
                    //$(".outer_div").html(data).fadeIn('slow');
                    //$('#loader').html('');
                //}
            //})
        //}
</script>



