<?php
/* Invoices view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_acc_orders');?></h3>
    <?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-xs btn-primary" onclick="window.location='<?php echo site_url('admin/orders/create/')?>'"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_acc_create_order_invoice');?></button>
    </div>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('xin_acc_order_no');?></th>
            <th><?php echo $this->lang->line('xin_customer');?></th>
            <th><?php echo $this->lang->line('xin_acc_total');?></th>
            <th><?php echo $this->lang->line('xin_invoice_date');?></th>
            <th><?php echo $this->lang->line('xin_invoice_due_date');?></th>
            <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
