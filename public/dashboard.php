<?php 
    $title ="Dashboard - "; 
    include "head.php";
    include "sidebar.php";
    include "prueba_mba3.php";
    $IsAdmin=$_SESSION['IsAdmin'];

    $MBA3=new MBA3();
    $MBA3->setQuery("SELECT CODIGO_CLIENTE_EMPRESA FROM CLNT_FICHA_PRINCIPAL LIMIT 0 ");
    $rs = $MBA3->ObtenerDatos();                    
    while (odbc_fetch_row($rs))
    {
    $compname=odbc_result($rs,"CODIGO_CLIENTE_EMPRESA");
    echo "<tr><td>$compname</td>";
    }

    $TicketData=mysqli_query($con, "select * from tckt_ticket_principal where id_user_crea_ticket=".$id." OR id_user_asignado=".$id." and cerrado=0");
    $TicketCerrados=mysqli_query($con, "select * from tckt_ticket_principal where id_user_crea_ticket=".$id." OR id_user_asignado=".$id." and cerrado=1");
    
    if($IsAdmin == TRUE){
        $DptoData=mysqli_query($con, "select * from departamentos order by NOMBRE_DEPARTAMENTO");
        $CategoryData=mysqli_query($con, "select * from tckt_categoria order by nombre_cat");
        $StatusData=mysqli_query($con, "select * from tckt_status order by nombre_status");
        $TypeData=mysqli_query($con, "select * from tckt_tipo order by nombre_tipo");
    }
    
    $UserData=mysqli_query($con, "select * from user_login order by NOMBRE ");
?>
    <div class="right_col" role="main"> <!-- page content -->
        <div class="">
            <div class="page-title">
                <div class="row top_tiles">
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-ticket"></i></div>
                          <div class="count"><?php echo mysqli_num_rows($TicketData) ?></div>
                          <h3>Tickets Pendientes</h3>
                        </div>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-ticket"></i></div>
                          <div class="count"><?php echo mysqli_num_rows($TicketCerrados) ?></div>
                          <h3>Tickets Cerrados</h3>
                        </div>
                    </div>
                    <?php if($IsAdmin==TRUE): ?>
                    <div class="userAdmin">
                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                            <div class="icon"><i class="fa fa-briefcase"></i></div>
                            <div class="count"><?php echo mysqli_num_rows($DptoData) ?></div>
                            <h3>Departamentos</h3>
                            </div>
                        </div>
                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                            <div class="icon"><i class="fa fa-users"></i></div>
                            <div class="count"><?php echo mysqli_num_rows($UserData) ?></div>
                            <h3>Usuarios</h3>
                            </div>
                        </div>
                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                            <div class="icon"><i class="fa fa-align-left"></i></div>
                            <div class="count"><?php echo mysqli_num_rows($CategoryData) ?></div>
                            <h3>Categorías</h3>
                            </div>
                        </div>
                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                            <div class="icon"><i class="fa fa-stethoscope"></i></div>
                            <div class="count"><?php echo mysqli_num_rows($StatusData) ?></div>
                            <h3>Status</h3>
                            </div>
                        </div>
                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                            <div class="icon"><i class="fa fa-dot-circle-o"></i></div>
                            <div class="count"><?php echo mysqli_num_rows($TypeData) ?></div>
                            <h3>Tipos</h3>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <!-- content -->
                <br><br>
                <div class="row">
                    <div class="col-md-4">
                        <div class="image view view-first">
                            <img class="thumb-image" style="width: 100%; display: block;" src="assets/images/profiles/1.png" alt="image" />
                        </div>
                        <span class="btn btn-my-button btn-file">
                            <form method="post" id="formulario" enctype="multipart/form-data">
                            Cambiar Imagen de perfil: <input type="file" name="file">
                            </form>
                        </span>
                        <div id="respuesta"></div>
                    </div>
                    <div class="col-md-8 col-xs-12 col-sm-12">
                        <?php include "assets/lib/alerts.php";
                            profile(); //llamada a la funcion de alertas
                        ?>    
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Información personal</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                            <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <br />
                                <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="action/upd_profile.php" method="post">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nombre
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="name" id="first-name" class="form-control col-md-7 col-xs-12" value="<?php echo $name; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Correo electronico 
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="last-name" name="email" class="form-control col-md-7 col-xs-12" value="<?php echo $email; ?>">
                                        </div>
                                    </div>

                                    <br><br><br>
                                    <h2 style="padding-left: 50px">Cambiar Contraseña</h2>
                            
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Contraseña antigua
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="birthday" name="password" class="date-picker form-control col-md-7 col-xs-12" type="text" placeholder="**********">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nueva contraseña 
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="birthday" name="new_password" class="date-picker form-control col-md-7 col-xs-12" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Confirmar contraseña nueva
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input id="birthday" name="confirm_new_password" class="date-picker form-control col-md-7 col-xs-12" type="text">
                                        </div>
                                    </div>
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <button type="submit" name="token" class="btn btn-success">Actualizar Datos</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /page content -->

<?php include "footer.php" ?>
<script>
    $(function(){
        $("input[name='file']").on("change", function(){
            var formData = new FormData($("#formulario")[0]);
            var ruta = "actions/upload-profile.php";
            $.ajax({
                url: ruta,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(datos)
                {
                    $("#respuesta").html(datos);
                }
            });
        });
    });
</script>