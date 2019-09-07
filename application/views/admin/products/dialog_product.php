<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['product_id']) && $_GET['data']=='product'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_acc_edit_product');?></h4>
</div>
<?php $attributes = array('name' => 'edit_product', 'id' => 'edit_product', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $product_id, 'ext_name' => $product_name);?>
<?php echo form_open_multipart('admin/products/update_product/'.$product_id, $attributes, $hidden);?>
<div class="modal-body">
  <div class="row m-b-1">
    <div class="col-md-12">
      <div class="bg-white">
        <div class="box-block">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="product_name"><?php echo $this->lang->line('xin_acc_product_name');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_product_name');?>" name="product_name" type="text" value="<?php echo $product_name;?>">
              </div>
              <!-- <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="barcode_type"><?php echo $this->lang->line('xin_acc_barcode_type');?></label>
                    <select class="form-control" name="barcode_type" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_barcode_type');?>">
                      <option value=""></option>
                      <option value="CODE39" <?php if($barcode_type=='CODE39'){?> selected="selected"<?php }?>>CODE39</option>
                      <option value="CODE93" <?php if($barcode_type=='CODE93'){?> selected="selected"<?php }?>>CODE93</option>
                      <option value="CODE128" <?php if($barcode_type=='CODE128'){?> selected="selected"<?php }?>>CODE128</option>
                      <option value="ISBN" <?php if($barcode_type=='ISBN'){?> selected="selected"<?php }?>>ISBN</option>
                      <option value="CODABAR" <?php if($barcode_type=='CODABAR'){?> selected="selected"<?php }?>>CODABAR</option>
                      <option value="POSTNET" <?php if($barcode_type=='POSTNET'){?> selected="selected"<?php }?>>POSTNET</option>
                      <option value="EAN-8" <?php if($barcode_type=='EAN-8'){?> selected="selected"<?php }?>>EAN-8</option>
                      <option value="EAN-13" <?php if($barcode_type=='EAN-13'){?> selected="selected"<?php }?>>EAN-13</option>
                      <option value="UPC-A" <?php if($barcode_type=='UPC-A'){?> selected="selected"<?php }?>>UPC-A</option>
                      <option value="UPC-E" <?php if($barcode_type=='UPC-E'){?> selected="selected"<?php }?>>UPC-E</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="bar_code"><?php echo $this->lang->line('xin_acc_barcode');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_barcode');?>" name="barcode" type="text" value="<?php echo $barcode;?>">
                  </div>
                </div>
              </div> -->
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="warehouse"><?php echo $this->lang->line('xin_acc_warehouse');?></label>
                    <select class="form-control" name="warehouse" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_warehouse');?>">
                      <option value=""></option>
                      <?php foreach($all_warehouses as $warehouse) {?>
                      <option value="<?php echo $warehouse->warehouse_id?>" <?php if($warehouse_id==$warehouse->warehouse_id){?> selected="selected" <?php } ?>><?php echo $warehouse->warehouse_name?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="category"><?php echo $this->lang->line('xin_acc_category');?></label>
                    <select class="form-control" name="category" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_category');?>">
                      <option value=""></option>
                      <?php foreach($all_product_categories as $category) {?>
                      <option value="<?php echo $category->category_id?>" <?php if($category_id==$category->category_id){?> selected="selected" <?php } ?>><?php echo $category->name?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="sku"><?php echo $this->lang->line('xin_acc_product_sku');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_product_sku');?>" name="sku" type="text" value="<?php echo $product_sku;?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="serial_number"><?php echo $this->lang->line('xin_acc_product_sku_no');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_product_sku_no');?>" name="serial_number" type="text" value="<?php echo $product_serial_number;?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="capacity"><?php echo $this->lang->line('xin_acc_capacity');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_capacity');?>" name="capacity" type="text" value="<?php echo $capacity;?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="remarks"><?php echo $this->lang->line('xin_acc_remarks');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_remarks');?>" name="remarks" type="text" value="<?php echo $remarks;?>">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="25" rows="8" id="description3"><?php echo $product_description;?></textarea>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="purchase_price"><?php echo $this->lang->line('xin_acc_product_p_price');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_product_p_price');?>" name="purchase_price" type="number" step="any" value="<?php echo $purchase_price;?>">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="retail_price"><?php echo $this->lang->line('xin_acc_product_s_price');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_product_s_price');?>" name="retail_price" type="number" step="any" value="<?php echo $retail_price;?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="product_qty"><?php echo $this->lang->line('xin_acc_product_initial_qty');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_product_initial_qty');?>" name="product_qty"  type="number" value="<?php echo $product_qty;?>">
              </div>
            </div>
            <!-- <div class="col-md-3">
              <div class="form-group">
                <label for="reorder_stock"><?php echo $this->lang->line('xin_acc_restock_amount');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_default_0');?>" name="reorder_stock" type="number" value="<?php echo $reorder_stock;?>">
              </div>
            </div> -->
            <!-- <div class="col-md-3">
              <div class="form-group">
                <label for="expiration_date"><?php echo $this->lang->line('xin_acc_exp_date');?></label>
                <input class="form-control expiration_date" readonly placeholder="<?php echo $this->lang->line('xin_acc_exp_date');?>" name="expiration_date" type="text" value="<?php echo $expiration_date;?>">
              </div>
            </div> -->
            <div class="col-md-3">
              <div class='form-group'>
                <fieldset class="form-group">
                  <label for="product_image"><?php echo $this->lang->line('xin_acc_p_image');?></label>
                  <input type="file" class="form-control-file" id="pimage" name="pimage">
                  <small><?php echo $this->lang->line('xin_company_file_type');?></small>
                </fieldset>
                <?php if($product_image!='' && $product_image!='no file') {?>
                <br />
                <img src="<?php echo base_url();?>uploads/products/<?php echo $product_image;?>" width="80" height="80" />
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
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
		
		$('.expiration_date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat:'yy-mm-dd',
		yearRange: '1900:' + (new Date().getFullYear() + 10),
		beforeShow: function(input) {
			$(input).datepicker("widget").show();
		}
		});
		/* Edit data */
		$("#edit_product").submit(function(e){
			var fd = new FormData(this);
			var obj = $(this), action = obj.attr('name');
			fd.append("is_ajax", 2);
			fd.append("edit_type", 'product');
			fd.append("form", action);
			e.preventDefault();
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
					} else {
						// On page load: datatable
						var xin_table = $('#xin_table').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?php echo site_url("admin/products/product_list") ?>",
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
						$('.edit-modal-data').modal('toggle');
						$('.save').prop('disabled', false);
					}
				},
				error: function() 
				{
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} 	        
		   });
		});
	});	
  </script>
<?php } else if(isset($_GET['jd']) && $_GET['data']=='view_product' && isset($_GET['product_id']) ){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_acc_view_product');?></h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
    <div class="table-responsive" data-pattern="priority-columns">
    <table class="footable-details table table-striped table-hover toggle-circle">
      <tbody>
        <tr>
          <th><?php echo $this->lang->line('xin_acc_product_name');?></th>
          <td style="display: table-cell;"><?php echo $product_name;?></td>
        </tr>
        <!-- <tr>
          <th><?php echo $this->lang->line('xin_acc_barcode_type');?></th>
          <td style="display: table-cell;"><?php if($barcode_type=='CODE39'){ $btype = 'CODE39'; }?>
		  <?php if($barcode_type=='CODE93'){ $btype = 'CODE93'; }?>
          <?php if($barcode_type=='CODE128'){ $btype = 'CODE128'; }?>
          <?php if($barcode_type=='ISBN'){ $btype = 'ISBN'; }?>
          <?php if($barcode_type=='CODABAR'){$btype = 'CODABAR'; }?>
          <?php if($barcode_type=='POSTNET'){ $btype = 'POSTNET'; }?>
          <?php if($barcode_type=='EAN-8'){ $btype = 'EAN-8'; }?>
          <?php if($barcode_type=='EAN-13'){ $btype = 'EAN-13'; }?>
          <?php if($barcode_type=='UPC-A'){ $btype = 'UPC-A'; }?>
          <?php if($barcode_type=='UPC-E'){ $btype = 'UPC-E'; }?>
          <?php echo isset($btype)?$btype:''; ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_acc_barcode');?></th>
          <td style="display: table-cell;"><?php echo $barcode;?></td>
        </tr> -->
        <tr>
          <th><?php echo $this->lang->line('xin_acc_warehouse');?></th>
          <td style="display: table-cell;"><?php foreach($all_warehouses as $warehouse) {?><?php if($warehouse_id==$warehouse->warehouse_id):?><?php echo $warehouse->warehouse_name;?><?php endif;?><?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_acc_category');?></th>
          <td style="display: table-cell;"><?php foreach($all_product_categories as $category) {?><?php if($category_id==$category->category_id):?><?php echo $category->name;?><?php endif;?><?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_acc_product_sku');?></th>
          <td style="display: table-cell;"><?php echo $product_sku;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_acc_product_sku_no');?></th>
          <td style="display: table-cell;"><?php echo $product_serial_number;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_acc_product_p_price');?></th>
          <td style="display: table-cell;"><?php echo $purchase_price;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_acc_product_s_price');?></th>
          <td style="display: table-cell;"><?php echo $retail_price;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_acc_product_initial_qty');?></th>
          <td style="display: table-cell;"><?php echo $product_qty;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_acc_restock_amount');?></th>
          <td style="display: table-cell;"><?php echo $reorder_stock;?></td>
        </tr>
        <!-- <tr>
          <th><?php echo $this->lang->line('xin_acc_exp_date');?></th>
          <td style="display: table-cell;"><?php echo $expiration_date;?></td>
        </tr> -->
        <tr>
          <th><?php echo $this->lang->line('xin_acc_p_image');?></th>
          <td style="display: table-cell;"><?php if($product_image!='' || $product_image!='no-file'){?>
            <div class="avatar box-48 mr-0-5"> <img src="<?php echo base_url();?>uploads/products/<?php echo $product_image;?>" alt="" class="user-image-hr100 ui-w-100 rounded-circle" width="80" height="80" ></a> </div>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_description');?></th>
          <td style="display: table-cell;"><?php echo html_entity_decode($product_description);?></td>
        </tr>
      </tbody>
    </table></div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  </div>
</form>
<?php } ?>
