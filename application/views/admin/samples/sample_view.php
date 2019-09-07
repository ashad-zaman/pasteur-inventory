<?php
/* sample view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $system_setting = $this->Xin_model->read_setting_info(1);?>
<?php
	// get info
	$result2 = $this->Customers_model->read_customer_info($customer_id);
	if(!is_null($result2)) {
		// get company
		$company = $this->Xin_model->read_company_info($result2[0]->company_id);
		if(!is_null($company)){
			$comp_name = $company[0]->name;
		} else {
			$comp_name = '--';	
		}
		$client_name = $result2[0]->name.' ('.$comp_name.')';
		$client_contact_number = $result2[0]->contact_number;
		$client_company_name = $comp_name;
		$client_website_url = $result2[0]->website_url;
		$client_address_1 = $result2[0]->address_1;
		$client_address_2 = $result2[0]->address_2;
		$client_email = $result2[0]->email;
		$client_city = $result2[0]->city;
		$client_zipcode = $result2[0]->zipcode;
		$client_country = $this->Xin_model->read_country_info($result2[0]->country);
	} else {
		$client_name = '--';
	}
	
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="row">
  <div class="col-xs-12"> &nbsp; <small class="pull-right">
    <div class="btn-group pull-right" role="group" style="margin-top:2px">
      <div class="btn-group">
        <button type="button" class="btn btn-dropbox btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-check" aria-hidden="true"></i> <?php echo $this->lang->line('xin_acc_mark_as');?> <span class="caret"></span>
        <div class="ripple-wrapper"></div>
        </button>
        <ul class="dropdown-menu">
          <li><a href="<?php echo site_url('admin/samples/mark_as/'.$sample_id.'/0');?>"><?php echo $this->lang->line('xin_sample_draft');?></a></li>
          <li><a href="<?php echo site_url('admin/samples/mark_as/'.$sample_id.'/1');?>"><?php echo $this->lang->line('xin_sample_delivered');?></a></li>
          <li><a href="<?php echo site_url('admin/samples/mark_as/'.$sample_id.'/2');?>"><?php echo $this->lang->line('xin_sample_on_hold');?></a></li>
          <li><a href="<?php echo site_url('admin/samples/mark_as/'.$sample_id.'/3');?>"><?php echo $this->lang->line('xin_accepted');?></a></li>
          <li><a href="<?php echo site_url('admin/samples/mark_as/'.$sample_id.'/4');?>"><?php echo $this->lang->line('xin_sample_lost');?></a></li>
          <li><a href="<?php echo site_url('admin/samples/mark_as/'.$sample_id.'/5');?>"><?php echo $this->lang->line('xin_sample_dead');?></a></li>
        </ul>
      </div>
      <a href="<?php echo site_url('admin/samples/convert_to_invoice/'.$sample_id);?>" class="btn btn-success btn-sm"><i class="fa fa-exchange" aria-hidden="true"></i> <?php echo $this->lang->line('xin_sample_convert_to_invoice');?> </a> <a href="<?php echo site_url('admin/samples/preview/'.$sample_id);?>" class="btn btn-flickr btn-sm" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $this->lang->line('xin_acc_inv_preview');?>
      <div class="ripple-wrapper"></div>
      </a> <a href="<?php echo site_url('admin/samples/edit/'.$sample_id);?>" class="btn btn-default btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $this->lang->line('xin_edit');?></a>
      <button type="button" id="print-invoice" class="btn btn-vk btn-sm print-invoice"><i class="fa fa-print" aria-hidden="true"></i> <?php echo $this->lang->line('xin_print');?></button>
    </div>
    </small> </div>
  <!-- /.col sample_number--> 
</div>
<div class="invoice  <?php echo $get_animate;?>" style="margin:10px 10px;">
  <div id="">
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header"> <i class="fa fa-globe"></i> <?php echo $company_name;?> <small class="pull-right"><?php echo $this->lang->line('xin_e_details_date');?>: <?php echo date('d-m-Y');?></small> </h2>
      </div>
      <!-- /.col --> 
    </div>
    <!-- info row -->
    <div id="print_invoice_hr">
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col"> <?php echo $this->lang->line('xin_acc_from');?>
          <address>
          <strong><?php echo $company_name;?></strong><br>
          <?php echo $company_address;?><br>
          <?php echo $company_zipcode;?>, <?php echo $company_city;?><br>
          <?php echo $company_country;?><br />
          <?php echo $this->lang->line('xin_phone');?>: <?php echo $company_phone;?><br />
          <?php echo $this->lang->line('dashboard_email');?>: <?php echo $company_email;?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col"> <?php echo $this->lang->line('xin_acc_to');?>
          <address>
          <strong><?php echo $client_name;?></strong><br>
          <?php echo $client_company_name;?><br>
          <?php echo $client_address_1.' '.$client_address_2;?><br>
          <?php
          $city=isset($client_city)?$client_city:'';
          $country=isset($client_country)?$client_country[0]->country_name:'';
          echo $city.', '.$country;?><br>
          <?php echo $this->lang->line('xin_phone');?>: <?php echo $client_contact_number;?><br>
          <?php echo $this->lang->line('dashboard_email');?>: <?php echo $client_email;?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col"> <b><?php echo $this->lang->line('xin_sample_no');?> <?php echo $sample_number;?></b><br>
          <br>
          <b><?php echo $this->lang->line('xin_createdp');?>:</b> <?php echo $this->Xin_model->set_date_format($sample_date);?><br>
          <!-- <b><?php echo $this->lang->line('xin_invoice_due_date');?>:</b> <?php echo $this->Xin_model->set_date_format($sample_due_date);?> -->
          <div class="invoice-status">
            <?php
		if($status == 0){
			$_status = '<span class="label label-info">'.$this->lang->line('xin_sample_draft').'</span>';
		} else if($status == 1) {
			$_status = '<span class="label bg-purple">'.$this->lang->line('xin_sample_delivered').'</span>';
		} else if($status == 2) {
			$_status = '<span class="label label-warning">'.$this->lang->line('xin_sample_on_hold').'</span>';
		} else if($status == 3) {
			$_status = '<span class="label label-success">'.$this->lang->line('xin_accepted').'</span>';
		} else if($status == 4) {
			$_status = '<span class="label bg-maroon">'.$this->lang->line('xin_sample_lost').'</span>';
		} else {
			$_status = '<span class="label label-danger">'.$this->lang->line('xin_sample_dead').'</span>';
		}
		echo $_status;
		?>
          </div>
        </div>
        <!-- /.col --> 
      </div>
      <!-- /.row --> 
      
      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th class="py-3"> # </th>
                <th class="py-3"> <?php echo $this->lang->line('xin_acc_item');?> </th>
                <th class="py-3"> <?php echo $this->lang->line('xin_acc_tax_rate');?> </th>
                <th class="py-3"> <?php echo $this->lang->line('xin_acc_item_qtyhrs');?> </th>
                <th class="py-3"> <?php echo $this->lang->line('xin_acc_unit_price');?> </th>
                <th class="py-3"> <?php echo $this->lang->line('xin_acc_subtotal');?> </th>
              </tr>
            </thead>
            <tbody>
              <?php
				$ar_sc = explode('- ',$system_setting[0]->default_currency_symbol);
				$sc_show = $ar_sc[1];
				?>
              <?php $prod = array(); $i=1; foreach($this->Samples_model->get_sample_items($sample_id) as $_item):?>
              <tr>
                <td class="py-3"><div class="font-weight-semibold"><?php echo $i;?></div></td>
                <td class="py-3" style="width:"><div class="font-weight-semibold"><?php echo $_item->item_name;?></div></td>
                <td class="py-3"><?php echo $this->Xin_model->currency_sign($_item->item_tax_rate);?></td>
                <td class="py-3"><?php echo $_item->item_qty;?></td>
                <td class="py-3"><?php echo $this->Xin_model->currency_sign($_item->item_unit_price);?></td>
                <td class="py-3"><?php echo $this->Xin_model->currency_sign($_item->item_sub_total);?></td>
              </tr>
              <?php endforeach;?>
            </tbody>
          </table>
        </div>
        <!-- /.col --> 
      </div>
      <!-- /.row -->
      
      <div class="row"> 
        <!-- /.col -->
        <div class="col-xs-7">
          <?php if($sample_note!=''):?>
          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;"> <?php echo $sample_note;?> </p>
          <?php endif;?>
        </div>
        <div class="col-lg-5">
          <div class="table-responsive">
            <table class="table">
              <tbody>
                <tr>
                  <th style="width:50%"><?php echo $this->lang->line('xin_acc_subtotal');?>:</th>
                  <td><?php echo $this->Xin_model->currency_sign($sub_total_amount);?></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('xin_acc_tax_item');?></th>
                  <td><?php echo $this->Xin_model->currency_sign($total_tax);?></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('xin_acc_discount');?>:</th>
                  <td><?php echo $this->Xin_model->currency_sign($total_discount);?></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('xin_acc_total');?>:</th>
                  <td><?php echo $this->Xin_model->currency_sign($grand_total);?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.col --> 
      </div>
    </div>
    <!-- /.row --> 
  </div>
</div>
