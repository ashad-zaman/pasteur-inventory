<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>


<div class="modal-header">
</div>

<div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="company_name"><?php echo $this->lang->line('xin_company_name');?>:</label>
                <?php echo $name;?>
              </div>
              <div class="form-group">
                <label for="company_short_name"><?php echo $this->lang->line('xin_company_short_name');?>:</label>
                <?php echo $short_name;?>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="email"><?php echo $this->lang->line('xin_company_type');?>:</label>
                    <?php foreach($get_company_types as $ctype) {?>
                        <?php if($type_id==$ctype->type_id){?>
                        <?php echo $ctype->name;?>
                        <?php } } ?>
                  </div>
                  <div class="col-md-6">
                    <label for="trading_name"><?php echo $this->lang->line('xin_company_trading');?>:</label>
                    <?php echo $trading_name;?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="registration_no"><?php echo $this->lang->line('xin_company_registration');?>:</label>
                    <?php echo $registration_no;?>
                  </div>
                  <div class="col-md-6">
                    <label for="contact_number"><?php echo $this->lang->line('xin_contact_number');?>:</label>
                    <?php echo $contact_number;?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="email"><?php echo $this->lang->line('xin_email');?>:</label>
                    <?php echo $email;?>
                  </div>
                  <div class="col-md-6">
                    <label for="website"><?php echo $this->lang->line('xin_website');?>:</label>
                    <?php echo $website_url;?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <div class="row">

                  <div class="col-md-6">
                    <label for="code"><?php echo $this->lang->line('xin_company_code');?>:</label>
                    <?php echo $code;?>
                  </div>

                  <div class="col-md-6">
                    <label for="xin_gtax"><?php echo $this->lang->line('xin_gtax');?>:</label>
                    <?php echo $government_tax;?>
                  </div>
                  
                </div>

                
              </div>
              <div class="form-group">
                <label for="address"><?php echo $this->lang->line('xin_address');?>:</label>
                <?php echo $address_1;?>
                <br>
                <?php echo isset($address_2)?$address_2:'';?>
                <br>
                <div class="row">
                  <div class="col-md-4">
                  <?php echo $city;?>
                  </div>
                  <div class="col-md-4">
                  <?php echo $state;?>
                  </div>
                  <div class="col-md-4">
                  <?php echo $zipcode;?>
                  </div>
                </div>
                <br>
                <?php foreach($all_countries as $country) {?>
            <?php if($countryid==$country->country_id):?>
            <?php echo $country->country_name;?>
            <?php endif;?>
            <?php } ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <fieldset class="form-group">
                <label for="logo"><?php echo $this->lang->line('xin_company_logo');?>:</label>
                <?php if($logo!='' || $logo!='no-file'){?>
            <div class="avatar box-48 mr-0-5"> <img class="d-block ui-w-100 rounded-circle" src="<?php echo base_url();?>uploads/company/<?php echo $logo;?>" alt="" width="50"></a> </div>
            <?php } ?>
              </fieldset>
            </div>
          </div>
        </div>



        <div class="box mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_customer');?></h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_customer', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/customers/add_customer', $attributes, $hidden);?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="customer_name"><?php echo $this->lang->line('xin_customer_name');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_customer_name');?>" name="name" type="text">
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="company_name"><?php echo $this->lang->line('xin_company_name');?></label>
                    
                    <?php  //print_r($all_companies);exit;?>
                    <select class=" form-control select2" name="company_id" id="company_id" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                      <option value=""></option>
                      <?php
                     
                      foreach($all_companies as $company) {
                          
                          $select="";
                          ?>
                          <?php if($company->company_id==$company_id){$select="selected";}?>
                      <option value="<?php echo $company->company_id?>" <?=$select?>><?php echo $company->name?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="contact_number"><?php echo $this->lang->line('xin_contact_number');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_number" type="number">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="email"><?php echo $this->lang->line('xin_email');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_email');?>" name="email" type="email">
                  </div>
                  <div class="col-md-6">
                    <label for="website"><?php echo $this->lang->line('xin_website');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_website_url');?>" name="website" type="text">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
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
          <div class="row">
            <div class="col-md-3">
              <label for="website"><?php echo $this->lang->line('xin_employee_password');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_password');?>" name="password" type="text">
            </div>
            <div class="col-md-3">
              <fieldset class="form-group">
                <label for="logo"><?php echo $this->lang->line('xin_customer_photo');?></label>
                <input type="file" class="form-control-file" id="profile_picture" name="profile_picture">
                <small><?php echo $this->lang->line('xin_company_file_type');?></small>
              </fieldset>
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
    <h3 class="box-title"> <?php echo $this->lang->line('xin_list');?> <?php echo $this->lang->line('xin_customers');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('xin_client_name');?></th>
            <th><?php echo $this->lang->line('module_company_title');?></th>
            <th><?php echo $this->lang->line('xin_email');?></th>
            <th><?php echo $this->lang->line('xin_website');?></th>
            <th><?php echo $this->lang->line('xin_city');?></th>
            <th><?php echo $this->lang->line('xin_country');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>