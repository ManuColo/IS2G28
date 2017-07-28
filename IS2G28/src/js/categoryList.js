var editing;
var deleting;

$(function() {
	editing = false;
	deleting = false;

	$(document).on('click',"img[title='Editar']",function() {
		var id= $.trim($(this).parent().attr('id'));
		change(id);
	});
	
	$(document).on('click',"img[title='Cancelar']",function() {
		cancel();
	});
	
	$(document).on('click',"img[title='Finalizar']",function() {
		var id= $.trim($(this).parent().attr('id'));
		doModify(id);
	});
	
	loadConfirmation();
});

function loadConfirmation() {
	$('.delete').confirmation({
		btnOkLabel:'Si',
		btnCancelLabel:'No',
		title:'Se eliminará esta categoría. Las gauchadas que están en esta categoría se moverán a Varios. Estás seguro?',
		container:'body',
		btnOkClass:'btn btn-sm btn-danger btn-xs',
		btnCancelClass:'btn btn-sm btn-success btn-xs',
		onConfirm:
			function(event,element){
				var id= $.trim($(this).parent().attr('id'));
				doDelete(id);
			}
	})
}

function change(id) {
	modify = $.ajax({
		data: {id: id},
		url: 'edit.php',
		type: 'post',
		beforeSend: function() {
			editing = true;
		},
		success: function(response) {
			editing = false;
			$('.categoryList').html(response);
			if ($('#newName')){
				$('#newName').trigger('focus');
			}
			loadConfirmation();
		}
	});
}

function cancel() {
	if (editing)
		modify.abort()
	modify = $.ajax({
		data: {},
		url: 'edit.php',
		type: 'post',
		beforeSend: function() {
			editing = true;
		},
		success: function(response) {
			editing = false;
			$('.categoryList').html(response);
			loadConfirmation();
		}
	});
}

function doModify(id) {
	var name= $.trim($('#newName').val());
	if (editing)
		modify.abort();
	modify = $.ajax({
		data: {id: id,name: name},
		url: 'edit.php',
		type: 'post',
		beforeSend: function() {
			editing = true;
		},
		success: function(response) {
			editing = false;
			$('.categoryList').html(response);
			if ($('#newName')){
				$('#newName').trigger('focus');
			}
			loadConfirmation();
		}
	});
}

function doDelete(id) {
	if (deleting)
		del.abort();
	del = $.ajax({
		data: {id: id},
		url: 'delete.php',
		type: 'post',
		beforeSend: function() {
			deleting = true;
		},
		success: function(response) {
			deleting = false;
			$('.categoryList').html(response);
			loadConfirmation();
		}
	});
}