<?php
/* Catalog > Product view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<div class="box mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_product');?></h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_product', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/products/add_product', $attributes, $hidden);?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="product_name"><?php echo $this->lang->line('xin_acc_product_name');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_product_name');?>" name="product_name" type="text" value="">
              </div>
              <input name="user_id" type="hidden" value="<?php echo $session['user_id'];?>">
              <!-- <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="barcode_type"><?php echo $this->lang->line('xin_acc_barcode_type');?></label>
                    <select class="form-control" name="barcode_type" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_barcode_type');?>">
                      <option value=""></option>
                      <option value="CODE39">CODE39</option>
                      <option value="CODE93">CODE93</option>
                      <option value="CODE128">CODE128</option>
                      <option value="ISBN">ISBN</option>
                      <option value="CODABAR">CODABAR</option>
                      <option value="POSTNET">POSTNET</option>
                      <option value="EAN-8">EAN-8</option>
                      <option value="EAN-13">EAN-13</option>
                      <option value="UPC-A">UPC-A</option>
                      <option value="UPC-E">UPC-E</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="bar_code"><?php echo $this->lang->line('xin_acc_barcode');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_barcode');?>" name="barcode" type="text" value="">
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
                      <option value="<?php echo $warehouse->warehouse_id?>"><?php echo $warehouse->warehouse_name?></option>
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
                      <option value="<?php echo $category->category_id?>"><?php echo $category->name?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="sku"><?php echo $this->lang->line('xin_acc_product_sku');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_product_sku');?>" name="sku" type="text" value="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="serial_number"><?php echo $this->lang->line('xin_acc_product_sku_no');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_product_sku_no');?>" name="serial_number" type="text" value="">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="capacity"><?php echo $this->lang->line('xin_acc_capacity');?></label>
                    
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_capacity');?>" name="capacity" type="text" value="">
                    
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="remarks"><?php echo $this->lang->line('xin_acc_remarks');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_remarks');?>" name="remarks" type="text" value="">
                    
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="25" rows="8" id="descriptions"></textarea>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="purchase_price"><?php echo $this->lang->line('xin_acc_product_p_price');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_product_p_price');?>" name="purchase_price" type="number" step="any" value="">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="retail_price"><?php echo $this->lang->line('xin_acc_product_s_price');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_product_s_price');?>" name="retail_price" type="number" step="any" value="">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="product_qty"><?php echo $this->lang->line('xin_acc_product_initial_qty');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_product_initial_qty');?>" name="product_qty" type="number" value="">
              </div>
            </div>
            <!-- <div class="col-md-3">
              <div class="form-group">
                <label for="reorder_stock"><?php echo $this->lang->line('xin_acc_restock_amount');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_default_0');?>" name="reorder_stock" type="number" value="">
              </div>
            </div> -->
            <!-- <div class="col-md-3">
              <div class="form-group">
                <label for="expiration_date"><?php echo $this->lang->line('xin_acc_exp_date');?></label>
                <input class="form-control date" readonly placeholder="<?php echo $this->lang->line('xin_acc_exp_date');?>" name="expiration_date" type="text" value="">
              </div>
            </div> -->
            <div class="col-md-3">
              <div class='form-group'>
                <fieldset class="form-group">
                  <label for="apimage"><?php echo $this->lang->line('xin_acc_p_image');?></label>
                  <input type="file" class="form-control-file" id="apimage" name="apimage">
                  <small><?php echo $this->lang->line('xin_company_file_type');?></small>
                </fieldset>
              </div>
            </div>
          </div>
        </div>
        <div class="form-actions box-footer">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_products');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('xin_acc_image');?></th>
            <th><?php echo $this->lang->line('xin_code');?></th>
            <th><?php echo $this->lang->line('xin_name');?></th>
            <th><?php echo $this->lang->line('xin_acc_capacity');?></th>
            <!-- <th><?php echo $this->lang->line('xin_acc_warehouse');?></th> -->
            <th><?php echo $this->lang->line('xin_acc_qty');?></th>
            <!-- <th><?php echo $this->lang->line('xin_acc_barcode');?></th> -->
            <th><?php echo $this->lang->line('xin_acc_purchase_price');?></th>
            <th><?php echo $this->lang->line('xin_acc_selling_price');?></th>
            <th><?php echo $this->lang->line('xin_acc_category');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
