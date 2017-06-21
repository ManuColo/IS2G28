var searching;

$(function() {
	searching = false;
	$('.searchControl').keyup(function() {
		doSearch();
	});
	$('#searchDeadline').on('change',function() {
		if(moment($(this).val()).isValid()) {
			doSearch();
		}
	});
	$('#submitBuscar').click(function() {
		doSearch();
	});
});

function doSearch() {
	var title = $('#searchTitle').val();
	var city = $('#searchCity').val();
	var deadline = $('#searchDeadline').val();
	var owner = $('#searchOwner').val();
	if (searching)
		search.abort();
	search = $.ajax({
		data: {title: title, city: city, deadline: deadline, owner: owner},
		url: 'search.php',
		type: 'post',
		beforeSend: function() {
			searching = true;
		},
		success: function(response) {
			searching = false;
			$('.favorList').html(response);
		}
	});
}