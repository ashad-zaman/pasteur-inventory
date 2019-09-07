<?php
/* Invoice view
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
      <?php $inv_record = get_invoice_transaction_record($invoice_id);?>
      <?php if ($inv_record->num_rows() < 1) { ?>
      <a href="<?php echo site_url('admin/orders/mark_as_paid/'.$invoice_id);?>" class="btn btn-github btn-sm"><i class="fa fa-credit-card" aria-hidden="true"></i> <?php echo $this->lang->line('xin_acc_mark_as_paid');?> </a>
      <a href="javascript:void(0);" class="btn btn-success btn-sm" data-toggle="modal" data-target=".edit-modal-data" data-invoice_id="<?php echo $invoice_id;?>"><i class="fa fa-credit-card" aria-hidden="true"></i> <?php echo $this->lang->line('xin_acc_inv_add_payment');?> </a> <a href="<?php echo site_url('admin/orders/edit/'.$invoice_id);?>" class="btn btn-default btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $this->lang->line('xin_edit');?></a>
      <?php } ?>
      <a href="<?php echo site_url('admin/orders/preview/'.$invoice_id);?>" class="btn btn-flickr btn-sm" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $this->lang->line('xin_acc_inv_preview');?>
      <div class="ripple-wrapper"></div>
      </a>
      <button type="button" id="print-invoice" class="btn btn-vk btn-sm print-invoice"><i class="fa fa-print" aria-hidden="true"></i> <?php echo $this->lang->line('xin_print');?></button>
    </div>
    </small> </div>
  <!-- /.col --> 
</div>
<div id="print_invoice_hr" class="invoice  <?php echo $get_animate;?>" style="margin:10px 10px;"> 
  <!-- title row -->
  <div class="row">
    <div class="col-xs-12">
      <h2 class="page-header"> <i class="fa fa-globe"></i> <?php echo $company_name;?> <small class="pull-right"><?php echo $this->lang->line('xin_e_details_date');?>: <?php echo date('d-m-Y');?></small> </h2>
    </div>
    <!-- /.col --> 
  </div>
  <!-- info row -->
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
      <?php echo isset($client_city)?$client_city:''.', '.isset($client_country)?$client_country[0]->country_name:'';?><br>
      <?php echo $this->lang->line('xin_phone');?>: <?php echo $client_contact_number;?><br>
      <?php echo $this->lang->line('dashboard_email');?>: <?php echo $client_email;?>
      </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-4 invoice-col"> <b><?php echo $this->lang->line('xin_acc_inv_orders_invoice');?> <?php echo $prefix.' '.$invoice_number;?></b><br>
      <br>
      <b><?php echo $this->lang->line('xin_createdp');?>:</b> <?php echo $this->Xin_model->set_date_format($invoice_date);?><br>
      <b><?php echo $this->lang->line('xin_invoice_due_date');?>:</b> <?php echo $this->Xin_model->set_date_format($invoice_due_date);?><br>
      <?php
		if($status == 0){
			$_status = '<span class="label label-danger">'.$this->lang->line('xin_payroll_unpaid').'</span>';
		} else if($status == 1) {
			$_status = '<span class="label label-success">'.$this->lang->line('xin_payment_paid').'</span>';
		} else {
			$_status = '<span class="label label-info">'.$this->lang->line('xin_acc_inv_cancelled').'</span>';
		}
		echo $_status;
		?>
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
          <?php $prod = array(); $i=1; foreach($this->Invoices_model->get_invoice_items($invoice_id) as $_item):?>
          <tr>
            <td class="py-3"><div class="font-weight-semibold"><?php echo $i;?></div></td>
            <td class="py-3" style="width:"><div class="font-weight-semibold"><?php echo $_item->item_name;?></div></td>
            <td class="py-3"><?php echo $this->Xin_model->currency_sign($_item->item_tax_rate);?></td>
            <td class="py-3"><?php echo $_item->item_qty;?></td>
            <td class="py-3"><?php echo $this->Xin_model->currency_sign($_item->item_unit_price);?></td>
            <td class="py-3"><?php echo $this->Xin_model->currency_sign($_item->item_sub_total);?></td>
          </tr>
          <?php $i++;endforeach;?>
        </tbody>
      </table>
    </div>
    <!-- /.col --> 
  </div>
  <!-- /.row -->
  
  <div class="row"> 
    <!-- accepted payments column -->
    <div class="col-xs-6">
      <?php if($invoice_note!=''):?>
      <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;"> <?php echo $invoice_note;?> </p>
      <?php endif;?>
    </div>
    <!-- /.col -->
    <div class="col-xs-6"> 
      <!-- <p class="lead">Amount Due 2/22/2014</p>-->
      
      <div class="table-responsive">
        <table class="table">
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
        </table>
      </div>
    </div>
    <!-- /.col -->
    <div class="clear"></div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <?php $invoice_tr = $this->Xin_model->read_invoice_transaction($invoice_id);?>
      <?php if ($invoice_tr->num_rows() > 0) {?>
      <?php $inv_info = $invoice_tr->result();?>
      <h4><?php echo $this->lang->line('xin_acc_inv_relared_tra');?></h4>
      <?php
        $payment_method = $this->Xin_model->read_payment_method($inv_info[0]->payment_method_id);
        $method_name = '';
        if(!is_null($payment_method)){
            $method_name = $payment_method[0]->method_name;
        } else {
            $method_name = '--';	
        }
        ?>
      <table class="table table-bordered" style="margin-top:20px;">
        <thead style="background:#dce9f9;">
          <tr>
            <th><?php echo $this->lang->line('xin_e_details_date');?></th>
            <th><?php echo $this->lang->line('xin_description');?></th>
            <th><?php echo $this->lang->line('xin_amount');?></th>
            <th><?php echo $this->lang->line('xin_payment_method');?></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo $this->Xin_model->set_date_format($inv_info[0]->transaction_date);?></td>
            <td style="text-align:left;"><?php echo $inv_info[0]->description;?></td>
            <td><?php echo $this->Xin_model->currency_sign($inv_info[0]->amount);?></td>
            <td><?php echo $method_name;?></td>
          </tr>
        </tbody>
      </table>
      <?php } ?>
    </div>
  </div>
  <!-- /.row --> 
</div>
