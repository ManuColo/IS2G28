var editing;
var deleting;

$(function() {
	editing = false;
	deleting = false;
	
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
	
	$(document).on('click',"img[title='Editar']",function() {
		var id= $.trim($(this).parent().attr('id'));
		modify(id);
	});
	$(document).on('click',"img[title='Finalizar']",function() {
		var id= $.trim($(this).parent().attr('id'));
		doModify(id);
	});
});

function modify(id) {
	if (editing)
		modify.abort();
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
		}
	});
}

function doModify(id) {
	if (editing)
		modify.abort();
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
		}
	});
}

function doDelete(id) {
	if (editing)
		modify.abort();
	modify = $.ajax({
		data: {id: id},
		url: 'delete.php',
		type: 'post',
		beforeSend: function() {
			deleting = true;
		},
		success: function(response) {
			deleting = false;
			$('.categoryList').html(response);
		}
	});
}