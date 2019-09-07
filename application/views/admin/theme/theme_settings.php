<?php
/* Settings view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>

<section id="basic-listgroup">
  <div class="row match-heights">
    <div class="col-lg-3 col-md-3">
      <div class="card">
        <div class="card-blocks">
          <div class="list-group"> <a class="list-group-item list-group-item-action nav-tabs-link" href="#notification" data-profile="4" data-profile-block="notification" data-toggle="tab" aria-expanded="true" id="setting_4"> <i class="fa fa-exclamation-circle"></i> <?php echo $this->lang->line('xin_notification_position');?> </a> <a class="list-group-item list-group-item-action nav-tabs-link" href="#company_logo" data-profile="6" data-profile-block="company_logo" data-toggle="tab" aria-expanded="true" id="setting_6"> <i class="fa fa-image"></i> <?php echo $this->lang->line('xin_system_logos');?> </a> </div>
        </div>
      </div>
    </div>
    <div class="col-md-9 current-tab animated fadeInRight" id="notification">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('xin_notification_position');?> </h3>
        </div>
        <div class="box-body">
          <div class="box-block">
            <?php $attributes = array('name' => 'notification_position_info', 'id' => 'notification_position_info', 'autocomplete' => 'off');?>
            <?php $hidden = array('theme_info' => 'UPDATE');?>
            <?php echo form_open('admin/theme/notification_position_info/', $attributes, $hidden);?>
            <div class="bg-white">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="notification_position"><?php echo $this->lang->line('dashboard_position');?></label>
                    <select class="form-control" name="notification_position" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_position');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <option value="toast-top-right" <?php if($notification_position=='toast-top-right'){?> selected <?php }?>><?php echo $this->lang->line('xin_top_right');?></option>
                      <option value="toast-bottom-right" <?php if($notification_position=='toast-bottom-right'){?> selected <?php }?>><?php echo $this->lang->line('xin_bottom_right');?></option>
                      <option value="toast-bottom-left" <?php if($notification_position=='toast-bottom-left'){?> selected <?php }?>><?php echo $this->lang->line('xin_bottom_left');?></option>
                      <option value="toast-top-left" <?php if($notification_position=='toast-top-left'){?> selected <?php }?>><?php echo $this->lang->line('xin_top_left');?></option>
                      <option value="toast-top-center" <?php if($notification_position=='toast-top-center'){?> selected <?php }?>><?php echo $this->lang->line('xin_top_center');?></option>
                    </select>
                    <br />
                    <small class="text-muted"><i class="ft-arrow-up"></i> <?php echo $this->lang->line('xin_set_position_for_notifications');?></small> </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="company_name"><?php echo $this->lang->line('xin_close_button');?></label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <label>
                        <input type="checkbox" class="minimal switch" id="sclose_btn" name="sclose_btn" <?php if($notification_close_btn=='true'):?> checked="checked" <?php endif;?> value="true">
                      </label>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="company_name"><?php echo $this->lang->line('xin_progress_bar');?></label>
                    <br>
                    <div class="pull-xs-left m-r-1">
                      <label>
                        <input type="checkbox" class="minimal switch" id="snotification_bar" name="snotification_bar" <?php if($notification_bar=='true'):?> checked="checked" <?php endif;?> value="true">
                      </label>
                    </div>
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
    <div class="col-md-9 current-tab animated fadeInRight" id="company_logo" style="display:none;">
      <div class="box mb-4">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('xin_system_logos');?> </h3>
        </div>
        <div id="hrsale_1" class="box-body">
          <div class="row">
            <?php $attributes = array('name' => 'logo_info', 'id' => 'logo_info', 'autocomplete' => 'off');?>
            <?php $hidden = array('company_logo' => 'UPDATE');?>
            <?php echo form_open_multipart('admin/settings/logo_info/'.$company_info_id, $attributes, $hidden);?>
            <div class="col-md-6">
              <div class='form-group'>
                <fieldset class="form-group">
                  <label for="logo"><?php echo $this->lang->line('xin_first_logo');?></label>
                  <?php if($logo!='' && $logo!='no file') {?>
                  <input type="file" class="form-control-file" id="p_file" name="p_file" value="<?php echo $logo;?>">
                  <?php } else {?>
                  <input type="file" class="form-control-file" id="p_file" name="p_file">
                  <?php } ?>
                </fieldset>
                <?php if($logo!='' && $logo!='no file') {?>
                <img src="<?php echo base_url().'uploads/logo/'.$logo;?>" width="70px" style="margin-left:30px;" id="u_file_1">
                <?php } else {?>
                <img src="<?php echo base_url().'uploads/logo/no_logo.png';?>" width="70px" style="margin-left:30px;" id="u_file_1">
                <?php } ?>
                <br>
                <small>- <?php echo $this->lang->line('xin_logo_files_only');?></small><br />
                <small>- <?php echo $this->lang->line('xin_best_main_logo_size');?></small><br />
                <small>- <?php echo $this->lang->line('xin_logo_whit_background_light_text');?></small> </div>
              <div class="form-actions box-footer">
                <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
              </div>
            </div>
            <?php echo form_close(); ?>
            <?php $attributes = array('name' => 'logo_favicon', 'id' => 'logo_favicon', 'autocomplete' => 'off');?>
            <?php $hidden = array('company_logo' => 'UPDATE');?>
            <?php echo form_open_multipart('admin/settings/logo_favicon/'.$company_info_id, $attributes, $hidden);?>
            <div class="col-md-6">
              <div class='form-group'>
                <fieldset class="form-group">
                  <label for="logo"><?php echo $this->lang->line('xin_favicon');?></label>
                  <input type="file" class="form-control-file" id="favicon" name="favicon">
                </fieldset>
                <?php if($favicon!='' && $favicon!='no file') {?>
                <img src="<?php echo base_url().'uploads/logo/favicon/'.$favicon;?>" width="16px" style="margin-left:30px;" id="favicon1">
                <?php } else {?>
                <img src="<?php echo base_url().'uploads/logo/no_logo.png';?>" width="16px" style="margin-left:30px;" id="favicon1">
                <?php } ?>
                <br>
                <small>- <?php echo $this->lang->line('xin_logo_files_only_favicon');?></small><br />
                <small>- <?php echo $this->lang->line('xin_best_logo_size_favicon');?></small></div>
              <div class="form-actions box-footer">
                <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
      <div class="box mb-4">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('xin_theme_signin_page_logo_title');?> </h3>
        </div>
        <div id="hrsale_2" class="box-body">
        <div class="row">
          <?php $attributes = array('name' => 'singin_logo', 'id' => 'singin_logo', 'autocomplete' => 'off');?>
          <?php $hidden = array('company_logo' => 'UPDATE');?>
          <?php echo form_open_multipart('admin/theme/sign_in_logo/', $attributes, $hidden);?>
          <div class="col-md-6">
          
          
          <div class="row">
            <div class="col-md-6">
              <div class='form-group'>
                <fieldset class="form-group">
                  <label for="logo"><?php echo $this->lang->line('xin_logo');?></label>
                  <input type="file" class="form-control-file" id="p_file3" name="p_file3">
                </fieldset>
                <?php if($sign_in_logo!='' && $sign_in_logo!='no file') {?>
                <img src="<?php echo base_url().'uploads/logo/signin/'.$sign_in_logo;?>" width="70px" style="margin-left:30px;" id="u_file3">
                <?php } else {?>
                <img src="<?php echo base_url().'uploads/logo/no_logo.png';?>" width="70px" style="margin-left:30px;" id="u_file3">
                <?php } ?>
                <br>
                <small>- <?php echo $this->lang->line('xin_logo_files_only');?></small><br />
                <small>- <?php echo $this->lang->line('xin_best_signlogo_size');?></small></div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-actions box-footer">
                <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
              </div>
            </div>
          </div>
          </div>
          <?php echo form_close(); ?> 


          <?php $attributes = array('name' => 'signature', 'id' => 'signature', 'autocomplete' => 'off');?>
          <?php $hidden = array('signature_photo' => 'UPDATE');?>
          <?php echo form_open_multipart('admin/theme/signature/', $attributes, $hidden);?>
          <div class="col-md-6">
          
          
          <div class="row">
            <div class="col-md-6">
              <div class='form-group'>
                <fieldset class="form-group">
                  <label for="logo"><?php echo $this->lang->line('xin_signature');?></label>
                  <input type="file" class="form-control-file" id="p_file4" name="p_file4">
                </fieldset>
                <?php if($signature!='' && $signature!='no file') {?>
                <img src="<?php echo base_url().'uploads/logo/signature/'.$signature;?>" width="70px" style="margin-left:30px;" id="u_file4">
                <?php } else {?>
                <img src="<?php echo base_url().'uploads/logo/no_logo.png';?>" width="70px" style="margin-left:30px;" id="u_file4">
                <?php } ?>
                <br>
                <small>- <?php echo $this->lang->line('xin_logo_files_only');?></small><br />
                <small>- <?php echo $this->lang->line('xin_best_signlogo_size');?></small></div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-actions box-footer">
                <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
              </div>
            </div>
          </div>
          </div>
          <?php echo form_close(); ?> 
      </div>
      </div>
    </div>
  </div>
</section>
