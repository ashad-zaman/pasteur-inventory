<style type="text/css"></style>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_modules');?> </h3>
      </div>
  <div class="box-body">
    <p class="card-text"><?php echo sprintf($this->lang->line('xin_setting_module_details'),$company[0]->company_name);?> </p>
    <div class="card-datatable table-responsive">
      <table class="datatables-demo table table-striped table-hover table-bordered" id="xin_table">
        <?php $attributes = array('name' => 'modules_info', 'id' => 'modules_info', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => 0);?>
        <?php echo form_open('admin/settings/modules_info', $attributes, $hidden);?>
        <tbody>
          <tr>
            <td><?php echo $this->lang->line('xin_hr_goal_tracking');?></td>
            <td><?php echo $this->lang->line('xin_hr_goal_module_details');?></td>
            <td><label class="switcher">
                  <input type="checkbox" class="switcher-input js-switch switch" id="m-goal-tracking" <?php if($module_goal_tracking=='true'):?> checked="checked" <?php endif;?> value="true">
                  <span class="switcher-indicator">
                    <span class="switcher-yes"></span>
                    <span class="switcher-no"></span>
                  </span>
                </label>
              </td>
          </tr>
          <tr>
            <td><?php echo $this->lang->line('xin_hr_events_meetings');?></td>
            <td><?php echo $this->lang->line('xin_hr_events_meetings_details');?></td>
            <td><label class="switcher">
                  <input type="checkbox" class="switcher-input js-switch switch" id="m-events" <?php if($module_events=='true'):?> checked="checked" <?php endif;?> value="true">
                  <span class="switcher-indicator">
                    <span class="switcher-yes"></span>
                    <span class="switcher-no"></span>
                  </span>
                </label>
              </td>
          </tr>
        </tbody>
      </table>
      <?php echo form_close(); ?> </div>
  </div>
</div>
