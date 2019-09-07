<?php
/* Detail view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php //echo $get_animate;?>

<div class="row">
  <div class="col-md-3"> 
    
    <!-- Profile Image -->
    <div class="box box-primary">
      <div class="box-body box-profile">
        <?php if($profile_photo!='' && $profile_photo!='no-file'){?>
        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url();?>uploads/users/<?php echo $profile_photo;?>" alt="">
        <?php } else { ?>
        <?php if($gender == 'Male'){?>
        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url().'uploads/users/default_male.jpg';?>" alt="">
        <?php } else {?>
        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url().'uploads/users/default_female.jpg';?>" alt="">
        <?php } ?>
        <?php }?>
        <h3 class="profile-username text-center"><?php echo $first_name.' '.$last_name;?></h3>
      </div>
      <!-- /.box-body --> 
    </div>
    <!-- /.box --> 
  </div>
  <!-- /.col -->
  <div class="col-md-9">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="tab-info active"><a href="#basic" data-toggle="tab"><?php echo $this->lang->line('xin_e_details_basic');?></a></li>
        <li class="tab-info2"><a href="#change_password" data-toggle="tab"><?php echo $this->lang->line('xin_e_details_cpassword');?></a></li>
      </ul>
      <div class="tab-content">
        <div class="active tab-pane" id="basic">
          <div class="box-body">
            <?php $attributes = array('name' => 'edit_user', 'id' => 'edit_user', 'autocomplete' => 'off');?>
            <?php $hidden = array('_token' => $session['user_id'],'ext_name' => $first_name);?>
            <?php echo form_open('admin/users/update_profile/'.$user_id, $attributes, $hidden);?>
            <div class="form-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="first_name"><?php echo $this->lang->line('xin_employee_first_name');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_first_name');?>" name="first_name" type="text" value="<?php echo $first_name;?>">
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                        <label for="email"><?php echo $this->lang->line('xin_email');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_email');?>" name="email" type="email" value="<?php echo $email;?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="username"><?php echo $this->lang->line('dashboard_username');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_username');?>" name="username" type="text" value="<?php echo $username;?>">
                      </div>
                      <div class="col-md-6">
                        <label for="contact_number"><?php echo $this->lang->line('xin_contact_number');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_number" value="<?php echo $contact_number;?>" type="number">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="gender" class="control-label"><?php echo $this->lang->line('xin_employee_gender');?></label>
                        <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_gender');?>">
                          <option value="Male" <?php if('Male'==$gender):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_gender_male');?></option>
                          <option value="Female"<?php if('Female'==$gender):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_gender_female');?></option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="role"><?php echo $this->lang->line('xin_employee_role');?></label>
                        <select class="form-control" name="role" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_role');?>">
                          <option value=""></option>
                          <?php foreach($all_user_roles as $role) {?>
                          <option value="<?php echo $role->role_id?>" <?php if($role->role_id==$user_role_id):?> selected="selected"<?php endif;?>><?php echo $role->role_name?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <fieldset class="form-group">
                        <label for="photo"><?php echo $this->lang->line('xin_user_myphoto');?></label>
                        <input type="file" class="form-control-file" id="photo" name="photo">
                        <small><?php echo $this->lang->line('xin_company_file_type');?></small>
                      </fieldset>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="last_name" class="control-label"><?php echo $this->lang->line('xin_employee_last_name');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_last_name');?>" name="last_name" type="text" value="<?php echo $last_name;?>">
                  </div>
                  <div class="form-group">
                    <label for="address"><?php echo $this->lang->line('xin_address');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="address_1" type="text" value="<?php echo $address_1;?>">
                    <br>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_2');?>" name="address_2" type="text" value="<?php echo $address_2;?>">
                    <br>
                    <div class="row">
                      <div class="col-md-4">
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_city');?>" name="city" type="text" value="<?php echo $city;?>">
                      </div>
                      <div class="col-md-4">
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_state');?>" name="state" type="text" value="<?php echo $state;?>">
                      </div>
                      <div class="col-md-4">
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_zipcode');?>" name="zipcode" type="text" value="<?php echo $zipcode;?>">
                      </div>
                    </div>
                    <br>
                    <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_country');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <?php foreach($all_countries as $country) {?>
                      <option value="<?php echo $country->country_id;?>" <?php if($country->country_id==$icountry):?> selected="selected"<?php endif;?>> <?php echo $country->country_name;?></option>
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
        <div class="tab-pane" id="change_password" >
          <div class="box-body">
            <?php $attributes = array('name' => 'e_change_password', 'id' => 'e_change_password', 'autocomplete' => 'off');?>
            <?php $hidden = array('u_basic_info' => 'UPDATE');?>
            <?php echo form_open('admin/users/change_password/', $attributes, $hidden);?>
            <?php
			  $data_usr11 = array(
					'type'  => 'hidden',
					'name'  => 'user_id',
					'value' => $session['user_id'],
			 );
			echo form_input($data_usr11);
			?>
            <?php if($this->input->get('change_password')):?>
            <input type="hidden" id="change_pass" value="<?php echo $this->input->get('change_password');?>" />
            <?php endif;?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="new_password"><?php echo $this->lang->line('xin_e_details_enpassword');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_enpassword');?>" name="new_password" type="text">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="new_password_confirm" class="control-label"><?php echo $this->lang->line('xin_e_details_ecnpassword');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_ecnpassword');?>" name="new_password_confirm" type="text">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="form-actions"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
      <!-- /.tab-content --> 
    </div>
    <!-- /.nav-tabs-custom --> 
  </div>
  <!-- /.col --> 
</div>
<!-- /.row --> 
