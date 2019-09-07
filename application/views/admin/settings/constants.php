<?php
/* Constants view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $moduleInfo = $this->Xin_model->read_setting_info(1);?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="row match-heights">
  <div class="col-lg-3 col-md-3 <?php echo $get_animate;?>">
    <div class="box">
      <div class="box-blocks">
        <div class="list-group">
         
        <!-- <a class="list-group-item list-group-item-action nav-tabs-link" href="#expense_type" data-constant="8" data-constant-block="expense_type" data-toggle="tab" aria-expanded="true" id="constant_8"> <i class="fa fa-eur"></i> <?php echo $this->lang->line('xin_expense_type');?> </a> -->

          <a class="list-group-item list-group-item-action nav-tabs-link" href="#payment_method" data-constant="12" data-constant-block="payment_method" data-toggle="tab" aria-expanded="true" id="constant_12"> <i class="fa fa-money"></i> <?php echo $this->lang->line('xin_payment_methods');?> </a>
           <a class="list-group-item list-group-item-action nav-tabs-link" href="#currency_type" data-constant="13" data-constant-block="currency_type" data-toggle="tab" aria-expanded="true" id="constant_13"> <i class="fa fa-dollar"></i> <?php echo $this->lang->line('xin_currency_type');?> </a> <a class="list-group-item list-group-item-action nav-tabs-link" href="#company_type" data-constant="14" data-constant-block="company_type" data-toggle="tab" aria-expanded="true" id="constant_14"> <i class="fa fa-building"></i> <?php echo $this->lang->line('xin_company_type');?> </a></div>
      </div>
    </div>
  </div>
  <div class="col-md-9 current-tab <?php echo $get_animate;?>" id="expense_type" style="display:none;">
    <div class="row">
      <div class="col-md-5">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_expense_type');?> </h3>
          </div>
          <div class="box-body">
            <?php $attributes = array('name' => 'expense_type_info', 'id' => 'expense_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
            <?php $hidden = array('set_expense_type' => 'UPDATE');?>
            <?php echo form_open('admin/settings/expense_type_info/', $attributes, $hidden);?>
            <div class="form-group">
              <label for="company_name"><?php echo $this->lang->line('module_company_title');?></label>
              <select class="form-control" name="company" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
                <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                <?php foreach($all_companies as $company) {?>
                <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="name"><?php echo $this->lang->line('xin_expense_type');?></label>
              <input type="text" class="form-control" name="expense_type" placeholder="<?php echo $this->lang->line('xin_expense_type');?>">
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
      <div class="col-md-7">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_expense_type');?> </h3>
          </div>
          <div class="box-body">
            <div class="box-datatable table-responsive">
              <table class="datatables-demo table table-striped table-bordered" id="xin_table_expense_type">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('left_company');?></th>
                    <th><?php echo $this->lang->line('xin_expense_type');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-9 current-tab <?php echo $get_animate;?>" id="payment_method" >
    <div class="row">
      <div class="col-md-5">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_payment_method');?> </h3>
          </div>
          <div class="box-body">
            <?php $attributes = array('name' => 'payment_method_info', 'id' => 'payment_method_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
            <?php $hidden = array('set_payment_method' => 'UPDATE');?>
            <?php echo form_open('admin/settings/payment_method_info/', $attributes, $hidden);?>
            <div class="form-group">
              <label for="company_name"><?php echo $this->lang->line('module_company_title');?></label>
              <select class="form-control" name="company" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
                <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                <?php foreach($all_companies as $company) {?>
                <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="name"><?php echo $this->lang->line('xin_payment_method');?></label>
              <input type="text" class="form-control" name="payment_method" placeholder="<?php echo $this->lang->line('xin_payment_method');?>">
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
      <div class="col-md-7">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_payment_method');?> </h3>
          </div>
          <div class="box-body">
            <div class="box-datatable table-responsive">
              <table class="datatables-demo table table-striped table-bordered" id="xin_table_payment_method">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('left_company');?></th>
                    <th><?php echo $this->lang->line('xin_payment_method');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-9 current-tab <?php echo $get_animate;?>" id="currency_type" style="display:none;">
    <div class="row">
      <div class="col-md-5">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_currency_type');?> </h3>
          </div>
          <div class="box-body">
            <?php $attributes = array('name' => 'currency_type_info', 'id' => 'currency_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
            <?php $hidden = array('set_currency_type' => 'UPDATE');?>
            <?php echo form_open('admin/settings/currency_type_info/', $attributes, $hidden);?>
            <div class="form-group">
              <label for="company_name"><?php echo $this->lang->line('module_company_title');?></label>
              <select class="form-control" name="company" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
                <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                <?php foreach($all_companies as $company) {?>
                <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="name"><?php echo $this->lang->line('xin_currency_name');?></label>
              <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('xin_currency_name');?>">
            </div>
            <div class="form-group">
              <label for="name"><?php echo $this->lang->line('xin_currency_code');?></label>
              <input type="text" class="form-control" name="code" placeholder="<?php echo $this->lang->line('xin_currency_code');?>">
            </div>
            <div class="form-group">
              <label for="name"><?php echo $this->lang->line('xin_currency_symbol');?></label>
              <input type="text" class="form-control" name="symbol" placeholder="<?php echo $this->lang->line('xin_currency_symbol');?>">
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
      <div class="col-md-7">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_currencies');?> </h3>
          </div>
          <div class="box-body">
            <div class="box-datatable table-responsive">
              <table class="datatables-demo table table-striped table-bordered" id="xin_table_currency_type">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('left_company');?></th>
                    <th><?php echo $this->lang->line('xin_name');?></th>
                    <th><?php echo $this->lang->line('xin_code');?></th>
                    <th><?php echo $this->lang->line('xin_symbol');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-9 current-tab <?php echo $get_animate;?>" id="company_type" style="display:none;">
    <div class="row">
      <div class="col-md-5">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_company_type');?> </h3>
          </div>
          <div class="box-body">
            <?php $attributes = array('name' => 'company_type_info', 'id' => 'company_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
            <?php $hidden = array('set_company_type' => 'UPDATE');?>
            <?php echo form_open('admin/settings/company_type_info/', $attributes, $hidden);?>
            <div class="form-group">
              <label for="name"><?php echo $this->lang->line('xin_company_type');?></label>
              <input type="text" class="form-control" name="company_type" placeholder="<?php echo $this->lang->line('xin_company_type');?>">
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
      <div class="col-md-7">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_company_type');?> </h3>
          </div>
          <div class="box-body">
            <div class="box-datatable table-responsive">
              <table class="datatables-demo table table-striped table-bordered" id="xin_table_company_type">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('xin_company_type');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade edit_setting_datail" id="edit_setting_datail" tabindex="-1" role="dialog" aria-labelledby="edit-modal-data" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="ajax_setting_info"></div>
  </div>
</div>
<style type="text/css">
.table-striped { width:100% !important; }
</style>