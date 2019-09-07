<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['invoice_id']) && $_GET['data']=='invoice'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_invoice_no').' '.$invoice_number;?></h4>
</div>
<?php $attributes = array('name' => 'add_payment', 'id' => 'add_payment', 'autocomplete' => 'off');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $invoice_id, 'invoice_id' => $invoice_id);?>
<?php echo form_open('admin/orders/add_invoice_payment/'.$invoice_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="month_year"><?php echo $this->lang->line('xin_amount');?></label>
              <input class="form-control" name="amount" type="text" value="<?php echo $grand_total;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="add_invoice_date"><?php echo $this->lang->line('xin_e_details_date');?></label>
              <input class="form-control d_date" placeholder="<?php echo date('Y-m-d');?>" readonly name="add_invoice_date" type="text" value="">
            </div>
          </div>
        </div>
        <div class="row">
      <div class="col-md-6">
        <div class="form-group">
        <?php $payment_methods = $get_all_payment_method->result();?>
          <label for="payment_method"><?php echo $this->lang->line('xin_payment_method');?></label>
          <select name="payment_method" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_payment_method');?>">
            <option value=""></option>
            <?php foreach($payment_methods as $payment_method) {?>
            <option value="<?php echo $payment_method->payment_method_id;?>"> <?php echo $payment_method->method_name;?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="employee"><?php echo $this->lang->line('xin_acc_ref_no');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_ref_example');?>" name="reference" type="text" value="">
          <br />
        </div>
      </div>
    </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('xin_description');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="30" rows="5" id="description2"></textarea>
        </div>
        
      </div>
    </div>
    
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){ 

	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
			
	$('.d_date').datepicker({
	changeMonth: true,
	changeYear: true,
	dateFormat:'yy-mm-dd',
	yearRange: '1900:' + (new Date().getFullYear() + 15),
	beforeShow: function(input) {
		$(input).datepicker("widget").show();
	}
	});
	
	/* Edit data */
	$("#add_payment").submit(function(e){
	var fd = new FormData(this);
	var obj = $(this), action = obj.attr('name');
	fd.append("is_ajax", 1);
	fd.append("add_type", 'invoice_payment');
	fd.append("form", action);
	e.preventDefault();
	$('.icon-spinner3').show();
	$('.save').prop('disabled', true);
	$.ajax({
		url: e.target.action,
		type: "POST",
		data:  fd,
		contentType: false,
		cache: false,
		processData:false,
		success: function(JSON)
		{
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
			} else {
				toastr.success(JSON.result);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.icon-spinner3').hide();
				window.location = '';
				$('.save').prop('disabled', false);
			}
		},
		error: function() 
		{
			toastr.error(JSON.error);
			$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
			$('.icon-spinner3').hide();
			$('.save').prop('disabled', false);
		} 	        
   });
});
});	
</script>
<?php }
?>
