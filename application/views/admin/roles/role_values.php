<script type="text/javascript">
//$(document).ready(function(){
	jQuery("#treeview_r1").kendoTreeView({
	checkboxes: {
	checkChildren: true,
	template: "<label><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'> #= item.text #</label>"
	},
	check: onCheck,
	dataSource: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_products');?>",  add_info: "", value: "1",  items: [
	
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_products');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "2"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_out_of_stock_products');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "3"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_low_stock_products');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "4"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_product_tax');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "5"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_product_categories');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "6"},
	]},
	
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_warehouses');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "7",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_suppliers');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "8",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_purchases');?>",  add_info: "", value: "9",  items: [
	
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_new_purchase');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "10"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_purchase_list');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "11"},
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_customers');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "12",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_companies');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "13",},
	//
	
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_sample_order');?>",  add_info: "", value: "35",  items: [
	
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_manage_sample_order');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "36"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_add_sample_order');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "37"},
	]},

	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_sales_order');?>",  add_info: "", value: "14",  items: [
	
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_manage_order');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "15"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_add_order');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "16"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_quotes_order');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "17"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_add_order_quote');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "18"},
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_calendar');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "19",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_expenditure');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "20",},
	
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_reports');?>",  add_info: "", value: "21",  items: [
	
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_todays_report');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "22"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_puchases_report');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "23"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_sales_report');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "24"},
	]},	
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_system');?>",  add_info: "", value: "25",  items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_multi_language');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "26"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_settings');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "27"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_payment_gateway');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "28"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_theme_settings');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "29"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_constants');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "30"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_db_backup');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "31"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_email_templates');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "32"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('let_staff');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "33"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_view_transactions_log');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "34"},
	]},
	]
	});
//});
// show checked node IDs on datasource change
function onCheck() {
var checkedNodes = [],
		treeView = jQuery("#treeview2").data("kendoTreeView"),
		message;
		jQuery("#result").html(message);
}
</script>