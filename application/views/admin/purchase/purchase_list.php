<?php
/* Purchases list
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_acc_purchases');?></h3>
    <?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
    <?php if(in_array('12',$role_resources_ids)) {?>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-xs btn-primary" onclick="window.location='<?php echo site_url('admin/purchase/create/')?>'"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_acc_new_purchase');?></button>
    </div>
    <?php } ?>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th width="100"><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('xin_employees_id');?></th>
            <th><?php echo $this->lang->line('xin_acc_purchase_nom');?></th>
            <th><?php echo $this->lang->line('xin_supplier');?></th>
            <th><?php echo $this->lang->line('xin_acc_total');?></th>
            <th><?php echo $this->lang->line('xin_e_details_date');?></th>
            <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
