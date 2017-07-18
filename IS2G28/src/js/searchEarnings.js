var searching;

$(function() {
	searching = false;
	$('.searchControl').keyup(function() {
		doSearch();
	});
	$('#searchDateIn').on('change',function() {
		if(moment($(this).val()).isValid()) {
			doSearch();
		}
	});
	$('#searchDateEnd').on('change',function() {
		if(moment($(this).val()).isValid()) {
			doSearch();
		}
	});
	$('.submitBuscar').click(function() {
		doSearch();
	});
});

function doSearch() {
	var dateIn = $.trim($('#searchDateIn').val());
	var dateEnd = $.trim($('#searchDateEnd').val());
	var user = $.trim($('#searchUser').val());
	if (searching)
		search.abort();
	search = $.ajax({
		data: {dateIn: dateIn, dateEnd: dateEnd, userId: userId},
		url: 'searchEarnings.php',
		type: 'post',
		beforeSend: function() {
			searching = true;
		},
		success: function(response) {
			searching = false;
			$('.earningsList').html(response);
		}
	});
}