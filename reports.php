<?php
    $title ="Reportes | ";
    include "head.php";
    include "sidebar.php";
    $departamentos = mysqli_query($con, "select * from departamentos");
    $categorias = mysqli_query($con,  "select * from tckt_categoria");
    $estados = mysqli_query($con, "select * from tckt_status");
    $tipos = mysqli_query($con, "select * from tckt_tipo");
?>  


    <div class="right_col" role="main"><!-- page content -->
        <div class="">
            <div class="page-title">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Reportes</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>

                        <!-- form search -->
                        <form class="form-horizontal" role="form">
                            <input type="hidden" name="view" value="reports">
                            <div class="form-group">
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-male"></i></span>
                                    <select name="ID_DPTO" class="form-control">
                                    <option value="">DEPARTAMENTO</option>
                                      <?php foreach($departamentos as $p):?>
                                        <option value="<?php echo $p['ID_DPTO']; ?>" <?php 
                                            if(isset($_GET["ID_DPTO"]) && $_GET["ID_DPTO"]==$p['ID_DPTO']){ 
                                                echo "selected"; 
                                            } ?>
                                        ><?php echo $p['NOMBRE_DEPARTAMENTO']; ?></option>
                                      <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-support"></i></span>
                                    <select name="id_categoria" class="form-control">
                                    <option value="">CATEGORIA</option>
                                      <?php foreach($categorias as $p):?>
                                        <option value="<?php echo $p['id_categoria']; ?>" <?php if(isset($_GET["id_categoria"]) && $_GET["id_categoria"]==$p['id_categoria']){ echo "selected"; } ?>><?php echo $p['nombre_cat']; ?></option>
                                      <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group">
                                  <span class="input-group-addon">INICIO</span>
                                  <input type="date" name="start_at" value="<?php if(isset($_GET["start_at"]) && $_GET["start_at"]!=""){ echo $_GET["start_at"]; } ?>" class="form-control" placeholder="Palabra clave">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group">
                                  <span class="input-group-addon">FIN</span>
                                  <input type="date" name="finish_at" value="<?php if(isset($_GET["finish_at"]) && $_GET["finish_at"]!=""){ echo $_GET["finish_at"]; } ?>" class="form-control" placeholder="Palabra clave">
                                </div>
                            </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">ESTADO</span>
                                        <select name="id_status" class="form-control">                                            
                                            <option value="">ESTADO</option>
                                          <?php foreach($estados as $p):?>
                                            <option value="<?php echo $p['id_status']; ?>" 
                                            <?php if(isset($_GET["id_status"]) && $_GET["id_status"]==$p['id_status']){ echo "selected"; } ?>><?php echo $p['nombre_status']; ?></option>
                                          <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">TIPO</span>
                                        <select name="id_tipo" class="form-control">
                                          <?php foreach($tipos as $p):?>
                                            <option value="<?php echo $p['id_tipo']; ?>" <?php if(isset($_GET["id_tipo"]) && $_GET["id_tipo"]==$p['id_tipo']){ echo "selected"; } ?>><?php echo $p['nombre_tipo']; ?></option>
                                          <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <button class="btn btn-primary btn-block">Procesar</button>
                                </div>
                            </div>
                        </form>
                        <!-- end form search -->

                         <?php
                                        $users= array();
                                        if((isset($_GET["id_status"]) && 
                                        isset($_GET["id_tipo"]) && 
                                        isset($_GET["ID_DPTO"]) && 
                                        isset($_GET["id_categoria"]) && 
                                        isset($_GET["start_at"]) && 
                                        isset($_GET["finish_at"]) ) && 
                                        ($_GET["id_status"]!="" ||$_GET["id_tipo"]!="" 
                                        || $_GET["id_departamento"]!="" || 
                                         $_GET["id_categoria"]!="" || 
                                         ($_GET["start_at"]!="" && $_GET["finish_at"]!="") ) ) {
                                        $sql = "select * from tckt_ticket_principal  where ";
                                        if($_GET["id_status"]!=""){
                                            $sql .= " id_status = ".$_GET["id_status"];
                                        }

                                        if($_GET["id_tipo"]!=""){
                                        if($_GET["id_status"]!=""){
                                            $sql .= " and ";
                                        }
                                            $sql .= " id_tipo = ".$_GET["id_tipo"];
                                        }


                                        if($_GET["ID_DPTO"]!=""){
                                        if($_GET["id_status"]!=""||$_GET["id_tipo"]!=""){
                                            $sql .= " and ";
                                        }
                                            $sql .= " id_departamento = ".$_GET["ID_DPTO"];
                                        }

                                        if($_GET["id_categoria"]!=""){
                                        if($_GET["id_status"]!=""||
                                        $_GET["ID_DPTO"]!=""||$_GET["id_tipo"]!=""){
                                            $sql .= " and ";
                                        }

                                            $sql .= " id_categoria = ".$_GET["id_categoria"];
                                        }

                                        

                                        if($_GET["start_at"]!="" && $_GET["finish_at"]){
                                        if($_GET["id_status"]!=""||$_GET["ID_DPTO"]!="" 
                                        ||$_GET["id_categoria"]!="" ||$_GET["id_tipo"]!="" ){
                                            $sql .= " and ";
                                        } 
                                            $sql .= " ( created_at >= \"".$_GET["start_at"]."\" and created_at <= \"".$_GET["finish_at"]."\" ) ";
                                        }

                                        echo $con;
                                        echo $sql;
                                                $users = mysqli_query($con, $sql);

                                        }else{
                                                $users = mysqli_query($con, "select * from tckt_ticket_principal  order by created_at desc");

                                        }
                                        echo $users;

                            if(@mysqli_num_rows($users)>0){
                                // si hay reportes
                                $_SESSION["report_data"] = $users;
                            ?>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <th>Asunto</th>
                        <th>Proyecto</th>
                        <th>Tipo</th>
                        <th>Categoria</th>
                        <th>Prioridad</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Ultima Actualizacion</th>
                    </thead>
            <?php
            $total = 0;
            foreach($users as $user){
                $project_id=$user['ID_DPTO'];
                $priority_id=$user['id_estados'];
                $kind_id=$user['kind_id'];
                $category_id=$user['category_id'];
                $status_id=$user['status_id'];

                $status=mysqli_query($con, "select * from status where id=$status_id");
                $category=mysqli_query($con, "select * from category where id=$category_id");
                $kinds = mysqli_query($con,"select * from kind where id=$kind_id");
                $project  = mysqli_query($con, "select * from project where id=$project_id");
                $medic = mysqli_query($con,"select * from priority where id=$priority_id");

                
                ?>
                <tr>
                <td><?php echo $user['title'] ?></td>
                <?php foreach($project as $pro){?>
                <td><?php echo $pro['name'] ?></td>
                <?php } ?>
                <?php foreach($kinds as $kind){?>
                <td><?php echo $kind['name'] ?></td>
                <?php } ?>
                <?php foreach($category as $cat){?>
                <td><?php echo $cat['name']; ?></td>
                <?php } ?>
                 <?php foreach($medic as $medics){?>
                <td><?php echo $medics['name']; ?></td>
                <?php } ?>
                <?php foreach($status as $stat){?>
                <td><?php echo $stat['name']; ?></td>
                 <?php } ?>
                <td><?php echo $user['created_at']; ?></td>
                <td><?php echo $user['updated_at']; ?></td>
                </tr>
             <?php  
                
                }

              ?>   
       <?php

        }else{
            echo "<p class='alert alert-danger'>No hay tickets</p>";
        }


        ?>
     </table>
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /page content -->

<?php include "footer.php" ?>
