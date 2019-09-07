<?php
/* Catalog > Product Low stock view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_acc_low_stock_products');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('xin_acc_image');?></th>
            <th><?php echo $this->lang->line('xin_code');?></th>
            <th><?php echo $this->lang->line('xin_name');?></th>
            <th><?php echo $this->lang->line('xin_acc_warehouse');?></th>
            <th><?php echo $this->lang->line('xin_acc_qty');?></th>
            <!-- <th><?php echo $this->lang->line('xin_acc_barcode');?></th> -->
            <th><?php echo $this->lang->line('xin_acc_purchase_price');?></th>
            <th><?php echo $this->lang->line('xin_acc_selling_price');?></th>
            <th><?php echo $this->lang->line('xin_acc_category');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
