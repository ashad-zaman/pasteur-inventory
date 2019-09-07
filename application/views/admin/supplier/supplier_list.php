<?php
/* Suppliers view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<div class="box mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_supplier');?></h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_supplier', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/suppliers/add_supplier', $attributes, $hidden);?>
        <div class="form-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="trading_name"><?php echo $this->lang->line('xin_acc_supplier_name');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_supplier_name');?>" name="name" type="text">
              </div>
              <div class="form-group">
                <label for="registration_no"><?php echo $this->lang->line('xin_company_registration');?> <small><?php echo $this->lang->line('xin_acc_if_available');?></small></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_add_new');?>" name="registration_no" type="text">
              </div>
              <div class="form-group">
                <label for="email"><?php echo $this->lang->line('dashboard_email');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_email');?>" name="email" type="email">
              </div>
              <div class="form-group">
                <label for="website"><?php echo $this->lang->line('xin_website_url');?> <small><?php echo $this->lang->line('xin_acc_if_available');?></small></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_website_url');?>" name="website" type="text">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="contact_number"><?php echo $this->lang->line('xin_contact_number');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_number" type="number">
              </div>
              <div class="form-group">
                <label for="address"><?php echo $this->lang->line('xin_address');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="address_1" type="text">
                <br>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_2');?>" name="address_2" type="text">
                <br>
                <div class="row">
                  <div class="col-xs-5">
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_city');?>" name="city" type="text">
                  </div>
                  <div class="col-xs-4">
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_state');?>" name="state" type="text">
                  </div>
                  <div class="col-xs-3">
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_zipcode');?>" name="zipcode" type="text">
                  </div>
                </div>
                <br>
                <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_country');?>">
                  <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                  <?php foreach($all_countries as $country) {?>
                  <option value="<?php echo $country->country_id;?>"> <?php echo $country->country_name;?></option>
                  <?php } ?>
                </select>
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
    <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_suppliers');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('xin_acc_supplier_name');?></th>
            <th><?php echo $this->lang->line('dashboard_email');?></th>
            <th><?php echo $this->lang->line('xin_contact_number');?></th>
            <th><?php echo $this->lang->line('xin_city');?></th>
            <th><?php echo $this->lang->line('xin_country');?></th>
            <th><?php echo $this->lang->line('xin_added_by');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
