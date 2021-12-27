<?php

    $projects =mysqli_query($con, "select * from tckt_categoria");
    $priorities =mysqli_query($con, "select * from tckt_tipo");
    $statuses =mysqli_query($con, "select * from tckt_categoria");
    $kinds =mysqli_query($con, "select * from tckt_categoria");
    $categories =mysqli_query($con, "select * from tckt_categoria order by nombre_cat");
    $departamentos =mysqli_query($con, "select * from departamentos order by NOMBRE_DEPARTAMENTO");
?>

    <div id="AddTicket"> <!-- Modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg-add"><i class="fa fa-plus-circle"></i> Agregar Ticket</button>
    </div>
    <div class="modal fade bs-example-modal-lg-add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Agregar Ticket</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left input_mask" method="post" id="add" name="add" enctype="multipart/form-data">
                        <div id="result"></div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Departamento
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control" name="departamento_id" id="departamento_id" >
                                        <option value="">--Selecciona --</option>
                                      <?php foreach($departamentos as $p):?>
                                        <option value="<?php echo $p['ID_DPTO']; ?>"><?php echo $p['NOMBRE_DEPARTAMENTO']; ?></option>
                                      <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Categoría
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control" name="categories_id" id="categories_id">
                                    <option value=""> Seleccione categoría </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Subcategoría
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control" name="subcategories_id" id="subcategories_id">
                                    <option value=""> Seleccione subcategoría </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Titulo<span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="text" name="title" class="form-control" placeholder="Titulo" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Descripción </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <textarea name="description" class="form-control col-md-7 col-xs-12"  placeholder="Descripción"></textarea>
                            </div>
                        </div>                     
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Prioridad
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control" name="priority_id" >
                                    <option selected="" value="">-- Selecciona --</option>
                                  <?php foreach($priorities as $p):?>
                                    <option value="<?php echo $p['id_tipo']; ?>"><?php echo $p['nombre_tipo']; ?></option>
                                  <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">                            
                            <div class="col-md-11 col-sm-9 col-xs-12 col-xs-offset-1">
                                <div class="input-group">
                                    <label class="input-group-btn">
                                        <span class="btn btn-primary">
                                            Agregar archivo<input id="file "type="file" name="file" style="display: none;" multiple="">
                                                                                        
                                        </span>
                                        <div id="respuesta"></div>
                                    </label>
                                    <input type="text" class="form-control" readonly="">
                                </div>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                              <button id="save_data" type="submit" class="btn btn-success">Generar</button>
                            </div>
                        </div>    
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div> <!-- /Modal -->
    <script>
    $('#departamento_id').change(function(){  
        $('categories_id option').remove();
        var parametros = $(this).serialize();
        $.ajax({
			url: './assets/ajax/get_categorias.php',
            datatype: 'html',
            type: 'POST',
            data: parametros,
			success: function(response){
                $(categories_id).html(response);                 
                SubcategoriaDinamica();         
			},
			error: function(error){
				console.log(error);
			}
        });
    }); 

    $('#categories_id').change(function(){  
        $('subcategories_id option').remove();
        var parametros = $(this).serialize();
        $.ajax({
			url: './assets/ajax/get_subcategorias.php',
            datatype: 'html',
            type: 'POST',
            data: parametros,
			success: function(response){
                $(subcategories_id).html(response);           
			},
			error: function(error){
				console.log(error);
			}
		});
    }); 

    document.getElementById("AddTicket").onload = function() {CategoriaDinamica()};
    document.getElementById("AddTicket").onload = function() {SubcategoriaDinamica()};
  
    $(document).on('change', ':file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    }); 

    // We can watch for our custom `fileselect` event like this
    $(document).ready( function() {
        $(':file').on('fileselect', function(event, numFiles, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;

            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }

        });
    });

    function CategoriaDinamica() {
        $('categories_id option').remove();
        var parametros = $(this).serialize();
        $.ajax({
			url: './assets/ajax/get_categorias.php',
            datatype: 'html',
            type: 'POST',
            data: parametros,
			success: function(response){
                $(categories_id).html(response);           
			},
			error: function(error){
				console.log(error);
			}
		});
    }

    function SubcategoriaDinamica() {
        $('subcategories_id option').remove();
        var parametros = $('#categories_id').serialize();
        $.ajax({
			url: './assets/ajax/get_subcategorias.php',
            datatype: 'html',
            type: 'POST',
            data: parametros,
			success: function(response){
                $(subcategories_id).html(response);           
			},
			error: function(error){
				console.log(error);
			}
		});
    }
    </script>