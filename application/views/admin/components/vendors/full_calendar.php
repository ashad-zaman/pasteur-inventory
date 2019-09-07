<?php 
$session = $this->session->userdata('username');
$user_info = $this->Xin_model->read_user_info($session['user_id']);
$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<style type="text/css">
.popover-title {
    font-size: .9rem !important;
    border-color: rgba(0,0,0,.05) !important;
    background-color: #fff !important;
	font-weight:bold !important;
}
.popover-title {
    padding: .5rem .75rem !important;
    margin-bottom: 0 !important;
    color: inherit !important;
    border-bottom: 1px solid #ebebeb !important;
    border-top-left-radius: calc(.3rem - 1px) !important;
    border-top-right-radius: calc(.3rem - 1px) !important;
}
.popover {
    border-color: rgba(0,0,0,.1) !important;
}
.popover {
    color: rgba(70,90,110,.85) !important;
}
.popover .arrow {
    position: absolute !important;
    display: block !important;
}
.popover-content {
    font-size: .8rem !important;
    color: rgba(70,90,110,.85) !important;
}

.popover-content {
    padding: .5rem .75rem !important;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	/* initialize the calendar
	-----------------------------------------------------------------*/
	$('#calendar_hr').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay',
		},
		views: {
			listDay: { buttonText: 'list day' },
			listWeek: { buttonText: 'list week' }
		  },
		 themeSystem: 'bootstrap4',
		bootstrapFontAwesome: {
		  close: ' ion ion-md-close',
		  prev: ' ion ion-ios-arrow-back scaleX--1-rtl',
		  next: ' ion ion-ios-arrow-forward scaleX--1-rtl',
		  prevYear: ' ion ion-ios-arrow-dropleft-circle scaleX--1-rtl',
		  nextYear: ' ion ion-ios-arrow-dropright-circle scaleX--1-rtl'
		}, 
		eventRender: function(event, element) {
		element.attr('title',event.title).tooltip();
		element.attr('href', 'javascript:void(0);');
		element.attr('target', '_blank');
        element.click(function() {
			if(event.unq==3){
				window.location = '<?php echo site_url('admin/orders/view/');?>'+event.invoice_id;
			} else if(event.unq==1){
				window.location = '<?php echo site_url('admin/purchase/view/');?>'+event.invoice_id;
			}
        });
		
		},
		
		
		dayClick: function(date, jsEvent, view) {
        date_last_clicked = $(this);
			var event_date = date.format();
			$('#exact_date').val(event_date);
			var eventInfo = $("#module-opt");
            var mousex = jsEvent.pageX + 20; //Get X coodrinates
            var mousey = jsEvent.pageY + 20; //Get Y coordinates
            var tipWidth = eventInfo.width(); //Find width of tooltip
            var tipHeight = eventInfo.height(); //Find height of tooltip

            //Distance of element from the right edge of viewport
            var tipVisX = $(window).width() - (mousex + tipWidth);
            //Distance of element from the bottom of viewport
            var tipVisY = $(window).height() - (mousey + tipHeight);

            if (tipVisX < 20) { //If tooltip exceeds the X coordinate of viewport
                mousex = jsEvent.pageX - tipWidth - 20;
            } if (tipVisY < 20) { //If tooltip exceeds the Y coordinate of viewport
                mousey = jsEvent.pageY - tipHeight - 0;
            }
            //Absolute position the tooltip according to mouse position
            eventInfo.css({ top: mousey, left: mousex });
            eventInfo.show(); //Show tool tip
		},
		theme:true,
		defaultDate: '<?php echo date('Y-m-d');?>',
		eventLimit: false, // allow "more" link when too many events
		navLinks: true, // can click day/week names to navigate views
		events: [
			<?php if(in_array('8',$role_resources_ids)) { ?>
			<?php foreach(purchase_transaction_record() as $purchase):?>
			{
				transaction_id: '<?php $purchase->transaction_id?>',
				invoice_id: '<?php echo $purchase->invoice_id?>',
				title: '<?php echo $purchase->reference.'\n'.$this->Xin_model->currency_sign($purchase->amount)?>',
				start: '<?php echo $purchase->transaction_date?>',
				color: '#3c8dbc !important',
				unq: '1',
			},
			<?php endforeach;?>
			<?php }?>
			<?php if(in_array('8',$role_resources_ids)) { ?>
			<?php foreach(expense_transaction_record() as $expense):?>
			{
				transaction_id: '<?php echo $expense->transaction_id?>',
				title: '<?php echo $expense->reference.'\n'.$this->Xin_model->currency_sign($expense->amount)?>',
				start: '<?php echo $expense->transaction_date?>',
				color: '#F44336 !important',
				unq: '2',
			},
			<?php endforeach;?>
			<?php }?>
			<?php if(in_array('8',$role_resources_ids)) { ?>
			<?php foreach(sales_transaction_record() as $sales):?>
			{
				transaction_id: '<?php echo $sales->transaction_id?>',
				invoice_id: '<?php echo $sales->invoice_id?>',
				title: '<?php echo $sales->reference.'\n'.$this->Xin_model->currency_sign($sales->amount)?>',
				start: '<?php echo $sales->transaction_date?>',
				color: '#65bb30 !important',
				unq: '3',
			},
			<?php endforeach;?>
			<?php }?>
		]
	});
	$('.fc-icon-x').click(function() {
		$('#module-opt').hide();
	});	
	/* initialize the external events
	-----------------------------------------------------------------*/

	$('#external-events .fc-event').each(function() {

		// Different colors for events
        $(this).css({'backgroundColor': $(this).data('color'), 'borderColor': $(this).data('color')});

		// store data so the calendar knows to render an event upon drop
		$(this).data('event', {
			title: $.trim($(this).text()), // use the element's text as the event title
			color: $(this).data('color'),
			stick: true // maintain when user navigates (see docs on the renderEvent method)
		});

	});


});
</script>
<style type="text/css">
.trumbowyg-box.trumbowyg-editor-visible {
  min-height: 90px !important;
}
.fc-day-grid-event {
    padding: 0px 5px !important;
}
.fc-events-container .fc-event {
    padding: 2px !important;
}
.trumbowyg-editor {
  min-height: 90px !important;
}
.fc-day:hover, .fc-day-number:hover, .fc-content:hover{cursor: pointer;}

.fc-close {
    font-size: .9em !important;
    margin-top: 2px !important;
}
.fc-close {
    float: right !important;
}

.fc-close {
    color: #666 !important;
}
.fc-event.fc-draggable, .fc-event[href], .fc-popover .fc-header .fc-close {
    cursor: pointer;
}
.fc-widget-header {
    background: #E4EBF1 !important;
}
.fc-widget-content {
	background: #FFFFFF;
}

.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
.fc-event { line-height: 2.0 !important; }
</style>
