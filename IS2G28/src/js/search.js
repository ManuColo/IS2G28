var searching;

$(function() {
	searching = false;
	$('.searchControl').keyup(function() {
		doSearch();
	});
	$('#searchDeadline').keyup(function() {
		if(moment($(this).val()).isValid() || ($(this).val() == '')) {
			doSearch();
		}
	});
	$('#searchDeadline').on('change',function() {
		if(moment($(this).val()).isValid()) {
			doSearch();
		}
	});
	$('.submitBuscar').click(function() {
		doSearch();
	});
});

function doSearch() {
	var title = $.trim($('#searchTitle').val());
	var city = $.trim($('#searchCity').val());
	var deadline = $.trim($('#searchDeadline').val());
	var owner = $.trim($('#searchOwner').val());
	var category = $.trim($('#searchCategory').val());
	if (searching)
		search.abort();
	search = $.ajax({
		data: {title: title, city: city, deadline: deadline, owner: owner, category: category},
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