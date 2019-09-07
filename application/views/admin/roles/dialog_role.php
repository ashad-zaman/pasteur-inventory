<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['role_id']) && $_GET['data']=='role'){
$role_resources_ids = explode(',',$role_resources);
?>
<div class="modal-header">
  <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_role_editrole');?></h4>
</div>
<?php $attributes = array('name' => 'edit_role', 'id' => 'edit_role', 'autocomplete' => 'off','class' => '"m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'ext_name' => $role_name, '_token' => $role_id);?>
<?php echo form_open('admin/roles/update/'.$role_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-4">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="role_name"><?php echo $this->lang->line('xin_role_name');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_role_name');?>" name="role_name" type="text" value="<?php echo $role_name;?>">
            </div>
          </div>
        </div>
        <div class="row">
        	<input type="checkbox" name="role_resources[]" value="0" checked style="display:none;"/>
          <div class="col-md-12">
            <div class="form-group">
              <label for="role_access"><?php echo $this->lang->line('xin_role_access');?></label>
              <select class="form-control custom-select" id="role_access_modal" name="role_access" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_role_access');?>">
                <option value="">&nbsp;</option>
                <option value="1" <?php if($role_access==1):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('xin_role_all_menu');?></option>
                <option value="2" <?php if($role_access==2):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('xin_role_cmenu');?></option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="resources"><?php echo $this->lang->line('xin_role_resource');?></label>
              <div id="all_resources">
                <div class="demo-section k-content">
                  <div>
                    <div id="treeview_m1"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_close'))); ?> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_update'))); ?> 
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
 $(document).ready(function(){
		
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		 $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
		  checkboxClass: 'icheckbox_minimal-blue',
		  radioClass   : 'iradio_minimal-blue'
		});

		/* Edit data */
		$("#edit_role").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=role&form="+action,
				cache: false,
				success: function (JSON) {
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
					} else {
						// On page load: datatable
						var xin_table = $('#xin_table').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?php echo site_url("admin/roles/role_list") ?>",
								type : 'GET'
							},
							dom: 'lBfrtip',
							"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
							"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
							}
						});
						xin_table.api().ajax.reload(function(){ 
							toastr.success(JSON.result);
						}, true);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.edit-modal-data').modal('toggle');
						$('.save').prop('disabled', false);
					}
				}
			});
		});
	});	
  </script>
  <script>

jQuery("#treeview_m1").kendoTreeView({
checkboxes: {
checkChildren: true,
template: "<label><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'> #= item.text #</label>"
},
check: onCheck,
dataSource: [
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_products');?>",  add_info: "", value: "1", check: "<?php if(isset($_GET['role_id'])) { if(in_array('1',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",  items: [
	
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_products');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "2", check: "<?php if(isset($_GET['role_id'])) { if(in_array('2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_out_of_stock_products');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "3", check: "<?php if(isset($_GET['role_id'])) { if(in_array('3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_low_stock_products');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "4", check: "<?php if(isset($_GET['role_id'])) { if(in_array('4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_product_tax');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "5", check: "<?php if(isset($_GET['role_id'])) { if(in_array('5',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_product_categories');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "6", check: "<?php if(isset($_GET['role_id'])) { if(in_array('6',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_warehouses');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "7", check: "<?php if(isset($_GET['role_id'])) { if(in_array('7',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_suppliers');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "8", check: "<?php if(isset($_GET['role_id'])) { if(in_array('8',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_purchases');?>",  add_info: "", value: "9", check: "<?php if(isset($_GET['role_id'])) { if(in_array('9',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",  items: [
	
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_new_purchase');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "10", check: "<?php if(isset($_GET['role_id'])) { if(in_array('10',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_purchase_list');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "11", check: "<?php if(isset($_GET['role_id'])) { if(in_array('11',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_customers');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "12", check: "<?php if(isset($_GET['role_id'])) { if(in_array('12',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_companies');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "13", check: "<?php if(isset($_GET['role_id'])) { if(in_array('13',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	//
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_sample_order');?>",  add_info: "", value: "35", check: "<?php if(isset($_GET['role_id'])) { if(in_array('35',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",  items: [
	
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_manage_sample_order');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "36", check: "<?php if(isset($_GET['role_id'])) { if(in_array('36',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_add_sample_order');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "37", check: "<?php if(isset($_GET['role_id'])) { if(in_array('37',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},




	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_sales_order');?>",  add_info: "", value: "14", check: "<?php if(isset($_GET['role_id'])) { if(in_array('14',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",  items: [
	
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_manage_order');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "15", check: "<?php if(isset($_GET['role_id'])) { if(in_array('15',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_add_order');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "16", check: "<?php if(isset($_GET['role_id'])) { if(in_array('16',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_quotes_order');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "17", check: "<?php if(isset($_GET['role_id'])) { if(in_array('17',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_add_order_quote');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "18", check: "<?php if(isset($_GET['role_id'])) { if(in_array('18',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},
	
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_calendar');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "19", check: "<?php if(isset($_GET['role_id'])) { if(in_array('19',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_expenditure');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "20", check: "<?php if(isset($_GET['role_id'])) { if(in_array('20',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_reports');?>",  add_info: "", value: "21", check: "<?php if(isset($_GET['role_id'])) { if(in_array('21',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",  items: [
	
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_todays_report');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "22", check: "<?php if(isset($_GET['role_id'])) { if(in_array('22',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_puchases_report');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "23", check: "<?php if(isset($_GET['role_id'])) { if(in_array('23',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_sales_report');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "24", check: "<?php if(isset($_GET['role_id'])) { if(in_array('24',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	]},	
	
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_system');?>",  add_info: "", value: "25", check: "<?php if(isset($_GET['role_id'])) { if(in_array('25',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",  items: [
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_multi_language');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "26", check: "<?php if(isset($_GET['role_id'])) { if(in_array('26',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('left_settings');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "27", check: "<?php if(isset($_GET['role_id'])) { if(in_array('27',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_payment_gateway');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "28", check: "<?php if(isset($_GET['role_id'])) { if(in_array('28',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_theme_settings');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "29", check: "<?php if(isset($_GET['role_id'])) { if(in_array('29',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('left_constants');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "30", check: "<?php if(isset($_GET['role_id'])) { if(in_array('30',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('left_db_backup');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "31", check: "<?php if(isset($_GET['role_id'])) { if(in_array('31',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('left_email_templates');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "32", check: "<?php if(isset($_GET['role_id'])) { if(in_array('32',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('let_staff');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "33", check: "<?php if(isset($_GET['role_id'])) { if(in_array('33',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_acc_view_transactions_log');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "34", check: "<?php if(isset($_GET['role_id'])) { if(in_array('34',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},]},
]
});		
// show checked node IDs on datasource change
function onCheck() {
var checkedNodes = [],
treeView = jQuery("#treeview").data("kendoTreeView"),
message;
//checkedNodeIds(treeView.dataSource.view(), checkedNodes);
jQuery("#result").html(message);
}
$(document).ready(function(){
	$("#role_access_modal").change(function(){
		var sel_val = $(this).val();
		if(sel_val=='1') {
			$('.role-checkbox-modal').prop('checked', true);
		} else {
			$('.role-checkbox-modal').prop("checked", false);
		}
	});
});
</script>
<?php }
?>
