<?php
/* Catalog > Product Categories view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="row m-b-1 <?php echo $get_animate;?>">
  <?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
  <div class="col-md-4">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_acc_category');?> </h3>
      </div>
      <div class="box-body">
        <?php $attributes = array('name' => 'add_category', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/products/add_category', $attributes, $hidden);?>
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_name');?></label>
          <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('xin_acc_enter_cat_name');?>">
        </div>
        <div class="form-group">
          <label for="code"><?php echo $this->lang->line('xin_code');?></label>
          <input type="text" class="form-control" name="code" placeholder="<?php echo $this->lang->line('xin_acc_enter_cat_code');?>">
        </div>
        <div class="form-group">
          <label for="message"><?php echo $this->lang->line('xin_description');?></label>
          <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" id="description"></textarea>
        </div>
        <div class="form-actions box-footer">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_categories');?> </h3>
      </div>
      <div class="box-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_action');?></th>
                <th><?php echo $this->lang->line('xin_name');?></th>
                <th><?php echo $this->lang->line('xin_code');?></th>
                <th><?php echo $this->lang->line('xin_created_at');?></th>
                <th><?php echo $this->lang->line('xin_added_by');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
