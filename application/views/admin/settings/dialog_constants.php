<?php
if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_payment_method' && $_GET['type']=='ed_payment_method'){
$row = $this->Xin_model->read_payment_method($_GET['field_id']);
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_payment_method');?></h4>
</div>
<?php $attributes = array('name' => 'ed_payment_method_info', 'id' => 'ed_payment_method_info', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->payment_method_id, 'ext_name' => $row[0]->method_name);?>
<?php echo form_open('admin/settings/update_payment_method/'.$row[0]->payment_method_id, $attributes, $hidden);?>
<div class="modal-body">
  <div class="form-group">
    <label for="company_name"><?php echo $this->lang->line('module_company_title');?></label>
    <select class="form-control" name="company" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
      <?php foreach($this->Xin_model->get_companies() as $company) {?>
      <option value="<?php echo $company->company_id;?>" <?php if($company->company_id==$row[0]->company_id):?> selected="selected"<?php endif;?>> <?php echo $company->name;?></option>
      <?php } ?>
    </select>
  </div>
  <div class="form-group">
    <label for="name" class="form-control-label"><?php echo $this->lang->line('xin_payment_method');?>:</label>
    <input type="text" class="form-control" name="name" placeholder="Enter <?php echo $this->lang->line('xin_payment_method');?>" value="<?php echo $row[0]->method_name;?>">
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
	/* Edit data */
	$("#ed_payment_method_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=23&type=edit_record&data=ed_payment_method_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var xin_table_payment_method = $('#xin_table_payment_method').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/payment_method_list") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}			
					});
					xin_table_payment_method.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);				
				}
			}
		});
	});
});	
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_expense_type' && $_GET['type']=='ed_expense_type'){
$row = $this->Xin_model->read_expense_type($_GET['field_id']);
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_expense_type');?></h4>
</div>
<?php $attributes = array('name' => 'ed_expense_type_info', 'id' => 'ed_expense_type_info', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->expense_type_id, 'ext_name' => $row[0]->name);?>
<?php echo form_open('admin/settings/update_expense_type/'.$row[0]->expense_type_id, $attributes, $hidden);?>
<div class="modal-body">
  <div class="form-group">
    <label for="company_name"><?php echo $this->lang->line('module_company_title');?></label>
    <select class="form-control" name="company" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
      <?php foreach($this->Xin_model->get_companies() as $company) {?>
      <option value="<?php echo $company->company_id;?>" <?php if($company->company_id==$row[0]->company_id):?> selected="selected"<?php endif;?>> <?php echo $company->name;?></option>
      <?php } ?>
    </select>
  </div>
  <div class="form-group">
    <label for="name" class="form-control-label"><?php echo $this->lang->line('xin_expense_type');?>:</label>
    <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('xin_expense_type');?>" value="<?php echo $row[0]->name;?>">
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
	/* Edit data */
	$("#ed_expense_type_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=42&type=edit_record&data=ed_expense_type_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var xin_table_expense_type = $('#xin_table_expense_type').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/expense_type_list") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}			
					});
					xin_table_expense_type.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);				
				}
			}
		});
	});
});	
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_currency_type' && $_GET['type']=='ed_currency_type'){
$row = $this->Xin_model->read_currency_types($_GET['field_id']);
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_currency_type');?></h4>
</div>
<?php $attributes = array('name' => 'ed_currency_type_info', 'id' => 'ed_currency_type_info', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->currency_id, 'ext_name' => $row[0]->name);?>
<?php echo form_open('admin/settings/update_currency_type/'.$row[0]->currency_id, $attributes, $hidden);?>
<div class="modal-body">
  <div class="form-group">
    <label for="company_name"><?php echo $this->lang->line('module_company_title');?></label>
    <select class="form-control" name="company" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
      <?php foreach($this->Xin_model->get_companies() as $company) {?>
      <option value="<?php echo $company->company_id;?>" <?php if($company->company_id==$row[0]->company_id):?> selected="selected"<?php endif;?>> <?php echo $company->name;?></option>
      <?php } ?>
    </select>
  </div>
  <div class="form-group">
    <label for="name"><?php echo $this->lang->line('xin_currency_name');?></label>
    <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('xin_currency_name');?>" value="<?php echo $row[0]->name;?>">
  </div>
  <div class="form-group">
    <label for="name"><?php echo $this->lang->line('xin_currency_code');?></label>
    <input type="text" class="form-control" name="code" placeholder="<?php echo $this->lang->line('xin_currency_code');?>" value="<?php echo $row[0]->code;?>">
  </div>
  <div class="form-group">
    <label for="name"><?php echo $this->lang->line('xin_currency_symbol');?></label>
    <input type="text" class="form-control" name="symbol" placeholder="<?php echo $this->lang->line('xin_currency_symbol');?>" value="<?php echo $row[0]->symbol;?>">
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
	/* Edit data */
	$("#ed_currency_type_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=46&type=edit_record&data=ed_currency_type_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var xin_table_currency_type = $('#xin_table_currency_type').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/currency_type_list") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}			
					});
					xin_table_currency_type.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);				
				}
			}
		});
	});
});	
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_company_type' && $_GET['type']=='ed_company_type'){
$row = $this->Xin_model->read_company_type($_GET['field_id']);
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_company_type');?></h4>
</div>
<?php $attributes = array('name' => 'ed_company_type_info', 'id' => 'ed_company_type_info', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->type_id, 'ext_name' => $row[0]->name);?>
<?php echo form_open('admin/settings/update_company_type/'.$row[0]->type_id, $attributes, $hidden);?>
<div class="modal-body">
  <div class="form-group">
    <label for="name" class="form-control-label"><?php echo $this->lang->line('xin_company_type');?>:</label>
    <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('xin_company_type');?>" value="<?php echo $row[0]->name;?>">
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
	/* Edit data */
	$("#ed_company_type_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=46&type=edit_record&data=ed_company_type_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var xin_table_company_type = $('#xin_table_company_type').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/company_type_list") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}			
					});
					xin_table_company_type.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);				
				}
			}
		});
	});
});	
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['user_id']) && $_GET['data']=='password' && $_GET['type']=='password'){?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('header_change_password');?></h4>
</div>
<?php $attributes = array('name' => 'e_change_password', 'id' => 'profile_password', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'user_id' => $_GET['user_id']);?>
<?php echo form_open('admin/employees/change_password/'.$row[0]->currency_id, $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="new_password"><?php echo $this->lang->line('xin_e_details_enpassword');?></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_enpassword');?>" name="new_password" type="text">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="new_password_confirm" class="control-label"><?php echo $this->lang->line('xin_e_details_ecnpassword');?></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_ecnpassword');?>" name="new_password_confirm" type="text">
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
	/* change password */
	jQuery("#profile_password").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=31&data=e_change_password&type=change_password&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
				} else {
					$('.pro_change_password').modal('toggle');
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					jQuery('#profile_password')[0].reset(); // To reset form fields
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
});	
</script>
<?php } ?>
