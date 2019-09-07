<?php
/* Customer Detail view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php //echo $get_animate;?>
<?php $cinv_total = 0;
foreach(customer_invoices($customer_id) as $cinv){
	$cinv_total += $cinv->grand_total;
}
?>

<div class="row">
  <div class="col-md-3"> 
    
    <!-- Profile Image -->
    <div class="box box-primary">
      <div class="box-body box-profile">
        <?php if($profile_picture!='' && $profile_picture!='no-file'){?>
        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url();?>uploads/customers/<?php echo $profile_picture;?>" alt="">
        <?php } else { ?>
        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url().'uploads/customers/default_male.jpg';?>" alt="">
        <?php }?>
        <h3 class="profile-username text-center"><?php echo $name;?></h3>
        <ul class="list-group list-group-unbordered">
          <li class="list-group-item"> <b><?php echo $this->lang->line('xin_acc_total_invoices');?> (<?php echo customer_total_invoices($customer_id);?>)</b> <span class="pull-right"><?php echo $this->Xin_model->currency_sign($cinv_total);?></span> </li>
        </ul>
      </div>
      <!-- /.box-body --> 
    </div>
    <!-- /.box --> 
  </div>
  <!-- /.col -->
  <div class="col-md-9">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#basic" data-toggle="tab"><?php echo $this->lang->line('xin_e_details_basic_info');?></a></li>
        <li class="tab-info2"><a href="#change_password" data-toggle="tab"><?php echo $this->lang->line('xin_e_details_cpassword');?></a></li>
        <li><a href="#invoices" data-toggle="tab"><?php echo $this->lang->line('xin_invoices_title');?></a></li>
      </ul>
      <div class="tab-content">
        <div class="active tab-pane" id="basic">
          <div class="box-body">
            <?php $attributes = array('name' => 'edit_customer', 'id' => 'edit_customer', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
            <?php $hidden = array('_method' => 'EDIT', '_token' => $customer_id, 'ext_name' => $name);?>
            <?php echo form_open('admin/customers/update/'.$customer_id, $attributes, $hidden);?>
            <div class="form-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="customer_name"><?php echo $this->lang->line('xin_customer_name');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_customer_name');?>" name="name" type="text" value="<?php echo $name;?>">
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="company_name"><?php echo $this->lang->line('xin_company_name');?></label>
                        <select class=" form-control select2" name="company_id" id="company_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                          <option value=""></option>
                          <?php foreach($all_companies as $company) {?>
                          <option value="<?php echo $company->company_id?>" <?php if($company->company_id == $company_id):?> selected="selected"<?php endif;?>><?php echo $company->name?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="contact_number"><?php echo $this->lang->line('xin_contact_number');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_number" type="number" value="<?php echo $contact_number;?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="email"><?php echo $this->lang->line('xin_email');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_email');?>" name="email" type="email" value="<?php echo $email;?>">
                      </div>
                      <div class="col-md-6">
                        <label for="website"><?php echo $this->lang->line('xin_website');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_website_url');?>" name="website" value="<?php echo $website_url;?>" type="text">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="address"><?php echo $this->lang->line('xin_address');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="address_1" type="text" value="<?php echo $address_1;?>">
                    <br>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_2');?>" name="address_2" type="text" value="<?php echo $address_2;?>">
                    <br>
                    <div class="row">
                      <div class="col-md-4">
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_city');?>" name="city" type="text" value="<?php echo $city;?>">
                      </div>
                      <div class="col-md-4">
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_state');?>" name="state" type="text" value="<?php echo $state;?>">
                      </div>
                      <div class="col-md-4">
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_zipcode');?>" name="zipcode" type="text" value="<?php echo $zipcode;?>">
                      </div>
                    </div>
                    <br>
                    <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_country');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <?php foreach($all_countries as $country) {?>
                      <option value="<?php echo $country->country_id;?>" <?php if($countryid==$country->country_id):?> selected="selected"<?php endif;?>> <?php echo $country->country_name;?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <label for="status" class="control-label"><?php echo $this->lang->line('dashboard_xin_status');?></label>
                  <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
                    <option value="0" <?php if($is_active=='0'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_employees_inactive');?></option>
                    <option value="1" <?php if($is_active=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_employees_active');?></option>
                  </select>
                </div>
                <div class="col-md-3">
                  <fieldset class="form-group">
                    <label for="logo"><?php echo $this->lang->line('xin_project_client_photo');?></label>
                    <small><?php echo $this->lang->line('xin_company_file_type');?></small>
                    <input type="file" class="form-control-file" id="profile_picture" name="profile_picture">
                  </fieldset>
                </div>
              </div>
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="invoices">
          <table class="table table-bordered table-hover" id="customer_invoice_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_invoice_no');?></th>
                <th width="140px;"><?php echo $this->lang->line('xin_amount');?></th>
                <th><?php echo $this->lang->line('xin_invoice_date');?></th>
                <th><?php echo $this->lang->line('xin_invoice_due_date');?></th>
                <th width="80px;"><?php echo $this->lang->line('dashboard_xin_status');?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach(customer_invoices($customer_id) as $linvoices){?>
              <?php
				// get grand_total
			 	$grand_total = $this->Xin_model->currency_sign($linvoices->grand_total);
				$invoice_date = '<i class="fa fa-calendar position-left"></i> '.$this->Xin_model->set_date_format($linvoices->invoice_date);
			  	$invoice_due_date = '<i class="fa fa-calendar position-left"></i> '.$this->Xin_model->set_date_format($linvoices->invoice_due_date);
				if($linvoices->status == 0){
					$status = '<span class="label label-danger">'.$this->lang->line('xin_payroll_unpaid').'</span>';
				} else if($linvoices->status == 1) {
					$status = '<span class="label label-success">'.$this->lang->line('xin_payment_paid').'</span>';
				} else {
					$status = '<span class="label label-info">'.$this->lang->line('xin_acc_inv_cancelled').'</span>';
				}
			?>
              <tr>
                <td><a href="<?php echo site_url('admin/orders/view/');?><?php echo $linvoices->invoice_id;?>" target="_blank"> <?php echo $linvoices->prefix.' '.$linvoices->invoice_number;?> </a></td>
                <td class="amount"><?php echo $grand_total;?></td>
                <td><?php echo $invoice_date;?></td>
                <td><?php echo $invoice_due_date;?></td>
                <td><?php echo $status;?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="change_password" >
          <div class="box-body">
            <?php $attributes = array('name' => 'e_change_password', 'id' => 'e_change_password', 'autocomplete' => 'off');?>
            <?php $hidden = array('u_basic_info' => 'UPDATE');?>
            <?php echo form_open('admin/customers/change_password/', $attributes, $hidden);?>
            <?php
			  $data_usr11 = array(
					'type'  => 'hidden',
					'name'  => 'customer_id',
					'value' => $customer_id,
			 );
			echo form_input($data_usr11);
			?>
            <?php if($this->input->get('change_password')):?>
            <input type="hidden" id="change_pass" value="<?php echo $this->input->get('change_password');?>" />
            <?php endif;?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="new_password"><?php echo $this->lang->line('xin_e_details_enpassword');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_enpassword');?>" name="new_password" type="text">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="new_password_confirm" class="control-label"><?php echo $this->lang->line('xin_e_details_ecnpassword');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_ecnpassword');?>" name="new_password_confirm" type="text">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="form-actions"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
      <!-- /.tab-content --> 
    </div>
    <!-- /.nav-tabs-custom --> 
  </div>
  <!-- /.col --> 
</div>
<!-- /.row --> 
