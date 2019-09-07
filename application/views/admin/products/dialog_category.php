<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['category_id']) && $_GET['data']=='category'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_acc_edit_product_cat');?></h4>
</div>
<?php $attributes = array('name' => 'edit_category', 'id' => 'edit_category', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $category_id, 'ext_name' => $name);?>
<?php echo form_open_multipart('admin/products/update_category/'.$category_id, $attributes, $hidden);?>
<div class="modal-body">
  <div class="form-group">
    <label for="name"><?php echo $this->lang->line('xin_name');?></label>
    <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('xin_acc_enter_cat_name');?>" value="<?php echo $name;?>">
  </div>
  <div class="form-group">
    <label for="code"><?php echo $this->lang->line('xin_code');?></label>
    <input type="text" class="form-control" name="code" placeholder="<?php echo $this->lang->line('xin_acc_enter_cat_code');?>" value="<?php echo $code;?>">
  </div>
  <div class="form-group">
    <label for="message"><?php echo $this->lang->line('xin_description');?></label>
    <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" id="description2"><?php echo $description;?></textarea>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
</div>
<?php echo form_close(); ?> 
<script type="text/javascript">
 $(document).ready(function(){	 
	/* Edit data */
	$("#edit_category").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&edit_type=category&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					$('.edit-modal-data').modal('toggle');
					// On page load: datatable
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/products/category_list") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && $_GET['data']=='view_category' && isset($_GET['category_id']) ){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_acc_view_product_cat');?></h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
    <div class="table-responsive" data-pattern="priority-columns">
      <table class="footable-details table table-striped table-hover toggle-circle">
        <tbody>
          <tr>
            <th><?php echo $this->lang->line('xin_name');?></th>
            <td style="display: table-cell;"><?php echo $name;?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_code');?></th>
            <td style="display: table-cell;"><?php echo $code;?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('xin_description');?></th>
            <td style="display: table-cell;"><?php echo html_entity_decode($description);?></span></td>
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
