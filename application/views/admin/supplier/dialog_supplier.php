<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['supplier_id']) && $_GET['data']=='supplier'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_acc_edit_supplier');?></h4>
</div>
<?php $attributes = array('name' => 'edit_supplier', 'id' => 'edit_supplier', 'autocomplete' => 'off');?>
<?php $hidden = array('_token' => $_GET['supplier_id'],'_method' => 'EDIT');?>
<?php echo form_open('admin/suppliers/update/'.$supplier_id, $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-sm-6">
      <div class="form-group">
        <label for="supplier_name"><?php echo $this->lang->line('xin_acc_supplier_name');?></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_supplier_name');?>" name="name" type="text" value="<?php echo $supplier_name;?>">
      </div>
      <div class="form-group">
        <label for="registration_no"><?php echo $this->lang->line('xin_company_registration');?></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_company_registration');?>" name="registration_no" type="text" value="<?php echo $registration_no;?>">
      </div>
      <div class="form-group">
        <label for="email"><?php echo $this->lang->line('dashboard_email');?></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_email');?>" name="email" type="email" value="<?php echo $email;?>">
      </div>
      <div class="form-group">
        <label for="website"><?php echo $this->lang->line('xin_website_url');?></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_website_url');?>" name="website" type="text" value="<?php echo $website_url;?>">
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        <label for="contact_number"><?php echo $this->lang->line('xin_contact_number');?></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_number" type="number" value="<?php echo $contact_number;?>">
      </div>
      <div class="form-group">
        <label for="address"><?php echo $this->lang->line('xin_address');?></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="address_1" type="text" value="<?php echo $address_1;?>">
        <br>
        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="address_2" type="text" value="<?php echo $address_2;?>">
        <br>
        <div class="row">
          <div class="col-xs-5">
            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_city');?>" name="city" type="text" value="<?php echo $city;?>">
          </div>
          <div class="col-xs-4">
            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_state');?>" name="state" type="text" value="<?php echo $state;?>">
          </div>
          <div class="col-xs-3">
            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_zipcode');?>" name="zipcode" type="text" value="<?php echo $zipcode;?>">
          </div>
        </div>
        <br>
        <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_country');?>">
          <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
          <?php foreach($all_countries as $country) {?>
          <option value="<?php echo $country->country_id;?>" <?php if($countryid==$country->country_id):?> selected="selected"<?php endif;?>> <?php echo $country->country_name;?></option>
          <?php } ?>
        </select>
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

		/* Edit data */
		$("#edit_supplier").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=supplier&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('.save').prop('disabled', false);
				} else {
					// On page load: datatable
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/suppliers/supplier_list") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('.edit-modal-data').modal('toggle');
					$('.save').prop('disabled', false);
				}
			}
		});
	});
});	
 </script>
<?php } else if(isset($_GET['jd']) && $_GET['data']=='view_supplier' && isset($_GET['supplier_id']) ){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_acc_view_supplier');?></h4>
</div>
<form class="m-b-1">
<div class="modal-body">
  <div class="table-responsive" data-pattern="priority-columns">
    <table class="footable-details table table-striped table-hover toggle-circle">
      <tbody>
      <tr>
        <th><?php echo $this->lang->line('xin_acc_supplier_name');?></th>
        <td style="display: table-cell;"><?php echo $supplier_name;?></span></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_company_registration');?></th>
        <td style="display: table-cell;"><?php echo $registration_no;?></span></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_contact_number');?></th>
        <td style="display: table-cell;"><?php echo $contact_number;?></span></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('dashboard_email');?></th>
        <td style="display: table-cell;"><?php echo $email;?></span></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_website_url');?></th>
        <td style="display: table-cell;"><?php echo $website_url;?></span></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_address');?></th>
        <td style="display: table-cell;"><?php echo $address_1;?></span></td>
      </tr>
      <?php if($address_2!='') { ?>
      <tr>
        <th>&nbsp;</th>
        <td style="display: table-cell;"><?php echo $address_2;?></span></td>
      </tr>
      <?php } ?>
      <tr>
        <th><?php echo $this->lang->line('xin_city');?></th>
        <td style="display: table-cell;"><?php echo $city;?></span></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_state');?></th>
        <td style="display: table-cell;"><?php echo $state;?></span></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_zipcode');?></th>
        <td style="display: table-cell;"><?php echo $zipcode;?></span></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_country');?></th>
        <td style="display: table-cell;"><?php foreach($all_countries as $country) {?>
          <?php if($countryid==$country->country_id):?>
          <?php echo $country->country_name;?>
          <?php endif;?>
          <?php } ?></td>
      </tr>
        </tbody>
      
    </table>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
</div>
<?php echo form_close(); ?>
<?php }
?>
