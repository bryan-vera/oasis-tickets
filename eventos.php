<?php
    $title ="Tickets | ";
    include "config/config.php";//Contiene funcion que conecta a la base de datos
    
    $id_ticket=intval($_GET['id_ticket']);
    $result=mysqli_query($con,"SELECT * from tckt_eventos where id_ticket=".$id_ticket);   
    $now = time(); // or your date as well
    $ticket_info=mysqli_query($con,"SELECT titulo,id_user_crea_ticket from tckt_ticket_principal where id_tckt=".$id_ticket);
    $titulo= mysqli_fetch_array($ticket_info);
    
    //foreach($result as $p):        
    //    echo "<option value=".$p['ID_USER'].">".$p['USERNAME']."</option>";
    //endforeach;  
?>

<link href="assets/css/eventos.css" rel="stylesheet">
<!--
<div class="right_col" role="main">
        <div class="">
        <div class="page-title">
        <div class="clearfix"></div> 
-->
        <div class="col-md-12 col-sm-12 col-xs-12">
        <a href="tickets.php"><button type="button" class="btn btn-primary"><i class="fa fa-arrow"></i> Regresar</button></a>
        <!-- <div class="x_panel"> -->
            <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="page-header">                                
                                <h1>Ticket <?php echo $id_ticket ?></h1>
                                <br>
                                <h2><?php echo $titulo['titulo']; ?></h2>
                                </div>                                
                                <ul class="timeline timeline-horizontal">
                                    <?php 
                                    foreach($result as $p):        
                                        $usuarios=mysqli_query($con,"SELECT NOMBRE, APELLIDO from user_login where id_user=".$p["id_user"]);
                                        $usuario= mysqli_fetch_array($usuarios);
                                        $nombre = ucfirst(strtolower($usuario['NOMBRE']))." ".ucfirst(strtolower($usuario['APELLIDO']));                                        
                                        $fecha_creacion = strtotime($p["created_at"]);
                                        $datediff = $now - $fecha_creacion;
                                    ?>    
                                    <!-- //    echo "<option value=".$p['ID_USER'].">".$p['USERNAME']."</option>"; -->
                                        <li class="timeline-item">
                                            <?php
                                                if($p["id_user"]==$titulo["id_user_crea_ticket"]){                                                    
                                            ?>
                                            <div class="timeline-badge primary">
                                            <?php 
                                                } else {
                                            ?>
                                            <div class="timeline-badge success">                                            
                                            <?php }?>
                                            <i class="glyphicon glyphicon-check"></i></div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h4 class="timeline-title"><?php echo $nombre?> escribió...</h4>
                                                    <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> Hace <?php echo round($datediff / (60 * 60));?> horas...</small></p>
                                                </div>
                                                <div class="timeline-body">
                                                    <p><?php echo $p['respuesta']; ?></p>
                                                    <?php
                                                    if($p['file_name']){
                                                    ?>
                                                        <br>
                                                        <p><a href="assets/files/<?php echo $p['file_name'];?>" class="evt_descargar" download> <small class="text-muted"><i class="glyphicon glyphicon-download-alt" ></i> Descargar archivo </small></a></p>
                                                    <?php
                                                    }                                                    
                                                    ?>
                                                </div>
                                            </div>
                                        </li>
                                    <?php
                                    endforeach;
                                    ?>                                    
                                    <li class="timeline-item"></li>
                                    <!-- <li class="timeline-item">
                                        <div class="timeline-badge success"><i class="glyphicon glyphicon-check"></i></div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title">Mussum ipsum cacilds 2</h4>
                                                <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 hours ago via Twitter</small></p>
                                            </div>
                                            <div class="timeline-body">
                                                <p>Mussum ipsum cacilds, vidis faiz elementum girarzis, nisi eros gostis.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-item">
                                        <div class="timeline-badge info"><i class="glyphicon glyphicon-check"></i></div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title">Mussum ipsum cacilds 3</h4>
                                                <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 hours ago via Twitter</small></p>
                                            </div>
                                            <div class="timeline-body">
                                                <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipisci. Mé faiz elementum girarzis, nisi eros gostis.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-item">
                                        <div class="timeline-badge danger"><i class="glyphicon glyphicon-check"></i></div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title">Mussum ipsum cacilds 4</h4>
                                                <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 hours ago via Twitter</small></p>
                                            </div>
                                            <div class="timeline-body">
                                                <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-item">
                                        <div class="timeline-badge warning"><i class="glyphicon glyphicon-check"></i></div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title">Mussum ipsum cacilds 5</h4>
                                                <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 hours ago via Twitter</small></p>
                                            </div>
                                            <div class="timeline-body">
                                                <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-item">
                                        <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title">Mussum ipsum cacilds 6</h4>
                                                <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 hours ago via Twitter</small></p>
                                            </div>
                                            <div class="timeline-body">
                                                <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis.</p>
                                            </div>
                                        </div>
                                    </li> -->
                                </ul>
                            </div>
                            </div>
                        </div>			
            </div>
        </div>
        <!-- </div> -->
        <!--
        </div>
        </div>
</div>
-->

<?php 
//include "footer.php" 
?>
