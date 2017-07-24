var editing;

$(function() {
	editing = false;
	$(document).on('click',"img[title='Editar']",function() {
		var id= $.trim($(this).parent().attr('id'));
		doModify(id);
	});
});

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