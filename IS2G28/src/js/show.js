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