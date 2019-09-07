<?php
/* Settings view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="row match-heights">
  <div class="col-lg-3 col-md-3 <?php echo $get_animate;?>">
    <div class="box-1">
      <div class="box-body">
        <div class="list-group"> <a class="list-group-item list-group-item-action nav-tabs-link active" href="#general" data-setting="1" data-profile-block="general" data-toggle="tab" aria-expanded="true" id="setting_1"> <i class="fa fa-user"></i> <?php echo $this->lang->line('xin_general');?> </a> <a class="list-group-item list-group-item-action nav-tabs-link" href="#system" data-setting="3" data-profile-block="system" data-toggle="tab" aria-expanded="true" id="setting_3"> <i class="fa fa-tv"></i> <?php echo $this->lang->line('xin_system');?> </a> <a class="list-group-item list-group-item-action nav-tabs-link" href="#email" data-profile="8" data-profile-block="email" data-toggle="tab" aria-expanded="true" id="setting_8"> <i class="fa fa-envelope"></i> <?php echo $this->lang->line('xin_email_notifications');?> </a> </div>
      </div>
    </div>
  </div>
  <div class="col-lg-9 col-md-9 current-tab <?php echo $get_animate;?>" id="general"  aria-expanded="false">
    <?php $attributes = array('name' => 'company_info', 'id' => 'company_info', 'autocomplete' => 'off');?>
    <?php $hidden = array('u_company_info' => 'UPDATE');?>
    <?php echo form_open('admin/settings/company_info/'.$company_info_id, $attributes, $hidden);?>
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_general');?> <?php echo $this->lang->line('header_configuration');?> </h3>
      </div>
      <div class="box-body">
        <div class="card-block">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="company_name"><?php echo $this->lang->line('xin_company_name');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_company_name');?>" name="company_name" type="text" value="<?php echo $company_name;?>">
              </div>
              <div class="form-group">
                <label for="contact_person"><?php echo $this->lang->line('xin_contact_person');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_person');?>" name="contact_person" type="text" value="<?php echo $contact_person;?>">
              </div>
              <div class="form-group">
                <label for="email"><?php echo $this->lang->line('xin_email');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_email');?>" name="email" type="email" value="<?php echo $email;?>">
              </div>
              <div class="form-group">
                <label for="phone"><?php echo $this->lang->line('xin_phone');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_phone');?>" name="phone" type="text" value="<?php echo $phone;?>">
              </div>
              <div class="form-group">
                <label for="Fax"><?php echo $this->lang->line('xin_fax');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_fax');?>" name="fax" type="text" value="<?php echo $fax;?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="address"><?php echo $this->lang->line('xin_employee_address');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="address_1" type="text" value="<?php echo $address_1;?>">
                <br>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_2');?>" name="address_2" type="text" value="<?php echo $address_2;?>">
                <br>
                <div class="row">
                  <div class="col-md-5">
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_city');?>" name="city" type="text" value="<?php echo $city;?>">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_state');?>" name="state" type="text" value="<?php echo $state;?>">
                  </div>
                  <div class="col-md-3">
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_zipcode');?>" name="zipcode" type="text" value="<?php echo $zipcode;?>">
                  </div>
                </div>
                <br>
                <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_country');?>">
                  <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                  <?php foreach($all_countries as $scountry) {?>
                  <option value="<?php echo $scountry->country_id;?>" <?php if($country==$scountry->country_id):?> selected <?php endif;?>> <?php echo $scountry->country_name;?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="form-group">
                <label for="address"><?php echo $this->lang->line('xin_employee_registered_address');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="reg_address_1" type="text" value="<?php echo $reg_address_1;?>">
                <br>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_2');?>" name="reg_address_2" type="text" value="<?php echo $reg_address_2;?>">
                <br>
                
              </div>
              <input name="config_type" type="hidden" value="general">
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <div class="form-actions box-footer">
                  <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php echo form_close(); ?> </div>
  <div class="col-md-9 current-tab <?php echo $get_animate;?>" id="system" style="display:none;">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_system');?> <?php echo $this->lang->line('header_configuration');?> </h3>
      </div>
      <div class="box-body">
        <div class="box-block">
          <?php $attributes = array('name' => 'system_info', 'id' => 'system_info', 'autocomplete' => 'off');?>
          <?php $hidden = array('u_basic_info' => 'UPDATE');?>
          <?php echo form_open('admin/settings/system_info/'.$company_info_id, $attributes, $hidden);?>
          <div class="bg-white">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="company_name"><?php echo $this->lang->line('xin_application_name');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_system_settings');?>" name="application_name" type="text" value="<?php echo $application_name;?>" id="application_name">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="email"><?php echo $this->lang->line('xin_default_currency');?></label>
                  <select class="form-control select2-hidden-accessible" name="default_currency_symbol" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_default_currency_symbol');?>" tabindex="-1" aria-hidden="true">
                    <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                    <?php foreach($this->Xin_model->get_currencies() as $currency){?>
                    <?php $_currency = $currency->code.' - '.$currency->symbol;?>
                    <option value="<?php echo $_currency;?>" <?php if($default_currency_symbol==$_currency):?> selected <?php endif;?>> <?php echo $_currency;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="phone"><?php echo $this->lang->line('xin_default_currency_symbol_code');?></label>
                  <select class="form-control" name="show_currency" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_show_currency');?>">
                    <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                    <option value="code" <?php if($show_currency=='code'){?> selected <?php }?>><?php echo $this->lang->line('xin_currency_code');?></option>
                    <option value="symbol" <?php if($show_currency=='symbol'){?> selected <?php }?>><?php echo $this->lang->line('xin_currency_symbol');?></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="phone"><?php echo $this->lang->line('xin_currency_position');?></label>
                  <input type="hidden" name="notification_position" value="Bottom Left">
                  <input type="hidden" name="enable_registration" value="no">
                  <input type="hidden" name="login_with" value="username">
                  <select class="form-control" name="currency_position" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_currency_position');?>">
                    <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                    <option value="Prefix" <?php if($currency_position=='Prefix'){?> selected <?php }?>><?php echo $this->lang->line('xin_prefix');?></option>
                    <option value="Suffix" <?php if($currency_position=='Suffix'){?> selected <?php }?>><?php echo $this->lang->line('xin_suffix');?></option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="phone"><?php echo $this->lang->line('xin_login_employee');?></label>
                  <select class="form-control" name="employee_login_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_login_employee');?>">
                    <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                    <option value="username" <?php if($employee_login_id=='username'){?> selected <?php }?>><?php echo $this->lang->line('xin_login_employee_with_username');?></option>
                    <option value="email" <?php if($employee_login_id=='email'){?> selected <?php }?>><?php echo $this->lang->line('xin_login_employee_with_email');?></option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="phone"><?php echo $this->lang->line('xin_date_format');?></label>
                  <select class="form-control" name="date_format" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_date_format');?>">
                    <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                    <option value="d-m-Y" <?php if($date_format_xi=='d-m-Y'){?> selected <?php }?>>dd-mm-YYYY (<?php echo date('d-m-Y');?>)</option>
                    <option value="m-d-Y" <?php if($date_format_xi=='m-d-Y'){?> selected <?php }?>>mm-dd-YYYY (<?php echo date('m-d-Y');?>)</option>
                    <option value="d-M-Y" <?php if($date_format_xi=='d-M-Y'){?> selected <?php }?>>dd-MM-YYYY (<?php echo date('d-M-Y');?>)</option>
                    <option value="M-d-Y" <?php if($date_format_xi=='M-d-Y'){?> selected <?php }?>>MM-dd-YYYY (<?php echo date('M-d-Y');?>)</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="footer_text"><?php echo $this->lang->line('xin_footer_text');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_footer_text');?>" name="footer_text" type="text" value="<?php echo $footer_text;?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="phone"><?php echo $this->lang->line('xin_setting_timezone');?></label>
                  <select class="form-control" name="system_timezone" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_setting_timezone');?>">
                    <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                    <?php foreach($this->Xin_model->all_timezones() as $tval=>$labels):?>
                    <option value="<?php echo $tval;?>" <?php if($system_timezone==$tval):?> selected <?php endif;?>><?php echo $labels;?></option>
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="contact_role"><?php echo $this->lang->line('xin_enable_year_on_footer');?></label>
                  <br>
                  <div class="pull-xs-left m-r-1">
                    <label>
                      <input type="checkbox" class="minimal switch" id="enable_current_year" name="enable_current_year" <?php if($enable_current_year=='yes'):?> checked="checked" <?php endif;?> value="yes">
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="contact_role"><?php echo $this->lang->line('xin_enable_codeigniter_on_footer');?></label>
                  <br>
                  <div class="pull-xs-left m-r-1">
                    <label>
                      <input type="checkbox" class="minimal switch" id="enable_page_rendered" name="enable_page_rendered" <?php if($enable_page_rendered=='yes'):?> checked="checked" <?php endif;?> value="yes">
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="footer_text"><?php echo $this->lang->line('xin_enable_auth_bg_imgs');?>
                    <button type="button" class="btn icon-btn btn-xs btn-default itheme-btn borderless" data-toggle="popover" data-placement="top" data-content="<?php echo $this->lang->line('xin_enable_auth_bg_imgs_details');?>" data-trigger="hover" data-original-title="<?php echo $this->lang->line('xin_enable_auth_bg_imgs');?>"><span class="fa fa-question-circle"></span></button>
                  </label>
                  <label>
                    <input type="checkbox" class="minimal switch" id="enable_auth_background" name="enable_auth_background" <?php if($enable_auth_background=='yes'):?> checked="checked" <?php endif;?> value="yes">
                  </label>
                </div>
              </div>
            </div> -->
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?> </div>
      </div>
    </div>
  </div>
  <div class="col-md-9 current-tab <?php echo $get_animate;?>" id="email" style="display:none;">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_email_notification_config');?> </h3>
      </div>
      <div class="box-body">
        <div class="box-block">
          <?php $attributes = array('name' => 'email_info', 'id' => 'email_info', 'autocomplete' => 'off');?>
          <?php $hidden = array('u_basic_info' => 'UPDATE');?>
          <?php echo form_open('admin/settings/email_info/'.$company_info_id, $attributes, $hidden);?>
          <div class="bg-white">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="company_name"><?php echo $this->lang->line('xin_email_notification_enable');?></label>
                <br>
                <div class="pull-xs-left m-r-1">
                  <label>
                    <input type="checkbox" class="minimal switch" id="srole_email_notification" name="srole_email_notification" <?php if($enable_email_notification=='yes'):?> checked="checked" <?php endif;?> value="yes">
                  </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?> </div>
      </div>
    </div>
  </div>
</div>
