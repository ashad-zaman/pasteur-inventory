$(document).ready(function() {
	var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : base_url+"/invoice_payment_list/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	// edit deposit
	$('.view-modal-data-bg').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var deposit_id = button.data('deposit_id');
		var modal = $(this);
	$.ajax({
		url :  site_url+"accounting/read_deposit/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=transaction_deposit&inv=1&deposit_id='+deposit_id,
		success: function (response) {
			if(response) {
				$("#pajax_modal_view").html(response);
			}
		}
		});
	});
});