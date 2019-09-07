<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['warehouse_id']) && $_GET['data']=='warehouse'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">Edit Warehouse<?php echo $this->lang->line('xin_list_all');?></h4>
</div>
<?php $attributes = array('name' => 'edit_warehouse', 'id' => 'edit_warehouse', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $warehouse_id, 'ext_name' => $warehouse_name);?>
<?php echo form_open('admin/warehouse/update/'.$warehouse_id, $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-sm-6">
      <div class="form-group">
        <label for="name"><?php echo $this->lang->line('xin_acc_warehouse_name');?></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_warehouse_name');?>" name="name" type="text" value="<?php echo $warehouse_name;?>">
      </div>
      <div class="form-group">
        <label for="contact_number"><?php echo $this->lang->line('xin_contact_number');?></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_number" type="number" value="<?php echo $contact_number;?>">
      </div>
      <div class="form-group">
        <label for="pickup_location"><?php echo $this->lang->line('xin_acc_use_a_pickup_location');?></label>
        <select class="form-control" name="pickup_location" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_use_a_pickup_location');?>">
          <option value="0" <?php if($pickup_location==0):?> selected <?php endif;?>><?php echo $this->lang->line('xin_no');?></option>
          <option value="1" <?php if($pickup_location==1):?> selected <?php endif;?>><?php echo $this->lang->line('xin_yes');?></option>
        </select>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        <label for="address"><?php echo $this->lang->line('xin_address');?></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="address_1" type="text" value="<?php echo $address_1;?>">
        <br>
        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_2');?>" name="address_2" type="text" value="<?php echo $address_2;?>">
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
          <option value="<?php echo $country->country_id;?>" <?php if($countryid==$country->country_id):?> selected <?php endif;?>> <?php echo $country->country_name;?></option>
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
		$("#edit_warehouse").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=warehouse&form="+action,
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
								url : "<?php echo site_url("admin/warehouse/warehouse_list") ?>",
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
<?php } else if(isset($_GET['jd']) && isset($_GET['warehouse_id']) && $_GET['data']=='view_warehouse'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_acc_view_warehouse');?></h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
    <div class="table-responsive" data-pattern="priority-columns">
      <table class="footable-details table table-striped table-hover toggle-circle">
        <tbody>
          <tr>
            <th><?php echo $this->lang->line('xin_acc_warehouse_name');?></th>
            <td style="display: table-cell;"><?php echo $warehouse_name;?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_contact_number');?></th>
            <td style="display: table-cell;"><?php echo $contact_number;?></span></td>
          </tr>
          <?php $plocation = ''; if($pickup_location==0): $plocation = $this->lang->line('xin_no');?>
          <?php elseif($pickup_location==1): $plocation = $this->lang->line('xin_yes'); endif;?>
          <tr>
            <th><?php echo $this->lang->line('xin_acc_use_a_pickup_location');?></th>
            <td style="display: table-cell;"><?php echo $plocation;?></td>
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
</form>
<?php }
?>
