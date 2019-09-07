<?php
/* Catalog > Product Tax view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="box <?php echo $get_animate;?>">
  <div class="box-header  with-border">
    <h3 class="box-title">Import Catalog Products</h3>
  </div>
  <div class="box-body">
    <h5>Import CSV file only</h5>
    <p class="font-100 text-muted mb-1">The first line in downloaded csv file should remain as it is. Please do not change the order of columns in csv file.</p>
    <p class="font-100 text-muted mb-1">The correct column order is (Product Name, Product Qty, Barcode, Qrcode, Warehouse ID, Category ID, Product Sku, Product Serial Number, Purchase Price, Selling Price, Product Tax ID, Expiration Date, Discount Rate, Product Image, Product Description) and <strong>you must follow</strong> the csv file, otherwise you will get an error while importing the csv file.</p>
    <h6><a href="<?php echo base_url();?>uploads/csv/sample-csv-products.csv" class="btn btn-info"> <i class="fa fa-download"></i> Download sample File </a></h6>
    <?php $attributes = array('name' => 'import_products', 'id' => 'xin-form', 'autocomplete' => 'off');?>
    <?php $hidden = array('user_id' => $session['user_id']);?>
    <?php echo form_open_multipart('admin/products/import_csv', $attributes, $hidden);?>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <fieldset class="form-group">
            <label for="file"><?php echo $this->lang->line('xin_employee_upload_file');?></label>
            <input type="file" class="form-control-file" id="file" name="file">
            <small>Please select .csv file (allowed file size 500 KB)</small>
          </fieldset>
        </div>
      </div>
    </div>
    <div class="mt-1">
      <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
    </div>
    <?php echo form_close(); ?> </div>
</div>
