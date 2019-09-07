<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $iuser = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="box mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('let_staff');?></h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_user', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/users/add_user', $attributes, $hidden);?>
        <div class="form-body">
              <div class="row">
                <div class="col-md-6">
                 <div class="form-group">
                        <label for="first_name"><?php echo $this->lang->line('xin_employee_first_name');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_first_name');?>" name="first_name" type="text" value="">
                      </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                        <label for="email"><?php echo $this->lang->line('xin_email');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_email');?>" name="email" type="email">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    
                    <div class="row">
                <div class="col-md-6">
                  <label for="email"><?php echo $this->lang->line('dashboard_username');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_username');?>" name="username" type="text">
                </div>
                <div class="col-md-6">
                  <label for="website"><?php echo $this->lang->line('xin_employee_password');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_password');?>" name="password" type="text">
                </div>
              </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                        <label for="contact_number"><?php echo $this->lang->line('xin_contact_number');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_number" type="number">
                      </div>
                      <div class="col-md-6">
                  		<div class="form-group">
                        <label for="gender" class="control-label"><?php echo $this->lang->line('xin_employee_gender');?></label>
                        <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_gender');?>">
                          <option value="Male"><?php echo $this->lang->line('xin_gender_male');?></option>
                          <option value="Female"><?php echo $this->lang->line('xin_gender_female');?></option>
                        </select>
                      </div>
                </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                      <div class="form-group">
                        <label for="role"><?php echo $this->lang->line('xin_employee_role');?></label>
                        <select class="form-control" name="role" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_role');?>">
                          <option value=""></option>
                          <?php foreach($all_user_roles as $role) {?>
                          <?php if($iuser[0]->user_role_id==1):?>
                          	<option value="<?php echo $role->role_id?>"><?php echo $role->role_name?></option>
                          <?php else:?>
								<?php if($role->role_id!=1):?>
                                <option value="<?php echo $role->role_id?>"><?php echo $role->role_name?></option>
                              <?php endif;?>  
                          <?php endif;?>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                      <div class="col-md-6">
                      <fieldset class="form-group">
                        <label for="photo"><?php echo $this->lang->line('xin_acc_staff_photo');?></label>
                        <input type="file" class="form-control-file" id="photo" name="photo">
                        <small><?php echo $this->lang->line('xin_company_file_type');?></small>
                      </fieldset>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="last_name" class="control-label"><?php echo $this->lang->line('xin_employee_last_name');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_last_name');?>" name="last_name" type="text" value="">
                  </div>
                  <div class="form-group">
                    <label for="address"><?php echo $this->lang->line('xin_address');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="address_1" type="text">
                    <br>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_2');?>" name="address_2" type="text">
                    <br>
                    <div class="row">
                      <div class="col-md-4">
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_city');?>" name="city" type="text">
                      </div>
                      <div class="col-md-4">
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_state');?>" name="state" type="text">
                      </div>
                      <div class="col-md-4">
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_zipcode');?>" name="zipcode" type="text">
                      </div>
                    </div>
                    <br>
                    <select class="form-control" name="country" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_country');?>">
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
    <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('let_staff');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
        <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('xin_name');?></th>
            <th><?php echo $this->lang->line('xin_email');?></th>
            <th><?php echo $this->lang->line('dashboard_username');?></th>
            <th><?php echo $this->lang->line('xin_contact_number');?></th>
            <th><?php echo $this->lang->line('xin_country');?></th>
        </tr>
        </thead>
      </table>
    </div>
  </div>
</div>