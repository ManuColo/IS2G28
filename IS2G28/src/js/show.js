$(document).ready(function(){
	$('#unpublish').confirmation({
			btnOkLabel:'Si',
			btnCancelLabel:'No',
			title:'No podrás volver a publicar esta gauchada. Estás seguro?',
			container:'body',
			btnOkClass:'btn btn-sm btn-danger btn-xs',
			btnCancelClass:'btn btn-sm btn-success btn-xs',
			onConfirm:
				function(event,element){
					location.href = 'unpublish.php?'+window.location.search.substr(1);
				}
		})
});

$(document).ready(function(){
	$('.choose').confirmation({
			btnOkLabel:'Si',
			btnCancelLabel:'No',
			title:'Estás seguro?',
			container:'body',
			btnOkClass:'btn btn-sm btn-danger btn-xs',
			btnCancelClass:'btn btn-sm btn-success btn-xs',
			onConfirm:
				function(event,element){
					location.href = '../postulations/accept.php?'+window.location.search.substr(1)+'&user='+$(this).attr('id');
				}
		})
});

$(document).ready(function(){
	$('.btnDespost').confirmation({
			btnOkLabel:'Si',
			btnCancelLabel:'No',
			title:'Estás seguro?',
			container:'body',
			btnOkClass:'btn btn-sm btn-danger btn-xs',
			btnCancelClass:'btn btn-sm btn-success btn-xs',
			onConfirm:
				function(event,element){
					location.href = '../postulations/deletePostulation.php?postulation='+$(this).attr('id');
				}
		})
});