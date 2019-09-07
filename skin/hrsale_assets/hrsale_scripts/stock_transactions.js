$(document).ready(function() {
	var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : base_url+"/transaction_list/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	$('.view-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var expense_id = button.data('expense_id');
	var modal = $(this);
	$.ajax({
		url : site_url+"expense/read/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=view_expense&expense_id='+expense_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_view").html(response);
			}
		}
		});
	});
});