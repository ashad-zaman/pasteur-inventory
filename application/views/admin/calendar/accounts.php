<?php 
$session = $this->session->userdata('username');
$user_info = $this->Xin_model->read_user_info($session['user_id']);
$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>

<div class="row">
  <div class="col-md-12">
    <div class="box box-info">
      <div class="box-body">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('xin_hr_calendar_options');?> </h3>
        </div>
        <p class="lead">
        <div class="row">
          <div class="col-md-3">
            <?php if(in_array('11',$role_resources_ids)) { ?>
            <span class="list-group-item calendar-options text-green"> <?php echo $this->lang->line('xin_sales');?></span>
            <?php } ?>
          </div>
          <div class="col-md-3">
            <?php if(in_array('8',$role_resources_ids)) { ?>
            <span class="list-group-item calendar-options text-light-blue"> <?php echo $this->lang->line('xin_acc_purchases');?></span>
            <?php } ?>
          </div>
          <!-- <div class="col-md-3">
            <?php if(in_array('16',$role_resources_ids)) { ?>
            <span class="list-group-item calendar-options text-red"> <?php echo $this->lang->line('xin_expenses');?></span>
            <?php } ?>
          </div> -->
        </div>
        </p>
        <div id='calendar_hr'></div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
.calendar-options { padding: .3rem 0.4rem !important; color:#FFF; font-weight:bold;}
</style>
