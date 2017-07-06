$(document).ready(function(){
	$('#makeAdmin').confirmation({
			btnOkLabel:'Si',
			btnCancelLabel:'No',
			title:'Estás seguro?',
			container:'body',
			btnOkClass:'btn btn-sm btn-danger btn-xs',
			btnCancelClass:'btn btn-sm btn-success btn-xs',
			onConfirm:
				function(event,element){
					location.href = '../users/makeAdmin.php?'+window.location.search.substr(1);
				}
		})
});