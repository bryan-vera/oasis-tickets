$(document).ready(function(){
	load(1);
});

function load(page){
	var q= $("#q").val();
	$("#loader").fadeIn('slow');
	$.ajax({
		url:'./assets/ajax/status.php?action=ajax&page='+page+'&q='+q,
		beforeSend: function(objeto){
		$('#loader').html('<img src="./assets/images/ajax-loader.gif"> Cargando...');
		},
		success:function(data){
		$(".outer_div").html(data).fadeIn('slow');
		$('#loader').html('');

		}
	})
}



function eliminar (id)
{
	var q= $("#q").val();
	if (confirm("Realmente deseas eliminar la categoria?")){	
		$.ajax({
		type: "GET",
		url: "./assets/ajax/status.php",
		data: "id="+id,"q":q,
		beforeSend: function(objeto){
		$("#resultados").html("Mensaje: Cargando...");
		},
			success: function(datos){
			$("#resultados").html(datos);
			load(1);
			}
		});
	}
}

		
		
		

