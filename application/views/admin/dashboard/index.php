<?php 
$session = $this->session->userdata('username');
$user_info = $this->Xin_model->read_user_info($session['user_id']);
if($user_info[0]->profile_photo!='' && $user_info[0]->profile_photo!='no file') {
	$lde_file = base_url().'uploads/users/'.$user_info[0]->profile_photo;
} else { 
	if($user_info[0]->gender=='Male') {  
		$lde_file = base_url().'uploads/users/default_male.jpg'; 
	} else {  
		$lde_file = base_url().'uploads/users/default_female.jpg';
	}
}
?>

<div class="box-widget widget-user-2"> 
  <!-- Add the bg color to the header using any of the bg-* classes -->
  <div class="widget-user-header">
    <div class="widget-user-image"> <img src="<?php echo $lde_file;?>" alt="" class="img-circle ui-w-50 rounded-circle"> </div>
    <h4 class="widget-user-username welcome-hrsale-user"><?php echo $this->lang->line('xin_acc_wback');?>, <?php echo $user_info[0]->first_name.' '.$user_info[0]->last_name?>!</h4>
    <h5 class="widget-user-desc welcome-hrsale-user-text"><?php echo $this->lang->line('xin_acc_today_is');?> <?php echo date('l, j F Y');?></h5>
  </div>
</div>
<hr class="container-m--x mt-0 mb-4">
<div class="row">
  <div class="col-xl-4 col-md-4 col-12">
    <div class="info-box"> <span class="info-box-icon bg-aqua"><i class="ion ion-stats-bars"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->Xin_model->currency_sign(dashboard_total_sales());?></span> <span class="info-box-text"><?php echo $this->lang->line('xin_acc_total_sales');?></span> </div>
      <!-- /.info-box-content --> 
    </div>
    <!-- /.info-box --> 
  </div>
  <div class="col-xl-4 col-md-4 col-12">
    <div class="info-box"> <span class="info-box-icon bg-red"><i class="fa fa-truck"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->Xin_model->currency_sign(dashboard_total_purchase());?></span> <span class="info-box-text"><?php echo $this->lang->line('xin_acc_total_purchases');?></span> </div>
      <!-- /.info-box-content --> 
    </div>
    <!-- /.info-box --> 
  </div>
  <!-- <div class="col-xl-3 col-md-3 col-12">
    <div class="info-box"> <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->Xin_model->currency_sign(dashboard_total_expense());?></span> <span class="info-box-text"><?php echo $this->lang->line('xin_acc_total_expenses');?></span> </div>
      
    </div>
   
  </div> -->
  <div class="col-xl-4 col-md-4 col-12">
    <div class="info-box"> <span class="info-box-icon bg-purple"><i class="fa fa-user"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo dashboard_total_customers();?></span> <span class="info-box-text"><?php echo $this->lang->line('xin_acc_total_customers');?></span> </div>
      <!-- /.info-box-content --> 
    </div>
    <!-- /.info-box --> 
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6"> 
    <!-- small box --> 
    
    <!--<div class="info-box bg-yellow dashbaord-infobox-content"> <span class="info-box-icon dashbaord-box-icon"><i class="fa fa-user"></i></span>
      <div class="info-box-content dashbaord-box-content"> <span class="info-box-text"><?php echo $this->lang->line('xin_acc_total_suppliers');?></span> <span class="info-box-number"><a class="dashboard-box-number" href="<?php echo site_url('admin/suppliers/');?>"><?php echo dashboard_total_suppliers();?></a></span> </div>
      
    </div>-->
  </div>
  <!-- ./col --> 
</div>
<hr />
<div class="row">
  <div class="col-lg-3 col-xs-5">
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3><?php echo dashboard_total_invoices();?></h3>
        <p><?php echo $this->lang->line('xin_acc_inv_orders');?></p>
      </div>
      <div class="icon"> <i class="fa fa-file-text"></i> </div>
      <a href="<?php echo site_url('admin/orders/');?>" class="small-box-footer"> <?php echo $this->lang->line('xin_acc_view_list');?> <i class="fa fa-arrow-circle-right"></i> </a> </div>
    <div class="small-box bg-red">
      <div class="inner">
        <h3><?php echo dashboard_total_warehouses();?></h3>
        <p><?php echo $this->lang->line('xin_acc_total_warehouses');?></p>
      </div>
      <div class="icon"> <i class="fa fa-building"></i> </div>
      <a href="<?php echo site_url('admin/warehouse/');?>" class="small-box-footer"> <?php echo $this->lang->line('xin_acc_more_info');?> <i class="fa fa-arrow-circle-right"></i> </a> </div>
  </div>
  <div class="col-md-9">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo $this->lang->line('xin_acc_order_invoice_summary');?></h3>
        <div class="box-tools pull-right"> <a href="<?php echo site_url('admin/orders/');?>" class="btn btn-primary btn-xs pull-right"><i class="fa fa-list"></i> <?php echo $this->lang->line('xin_acc_inv_orders');?></a> </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-xs-6 col-md-4 text-center">
            <input type="text" class="knob" value="<?php echo dashboard_unpaid_invoices();?>" data-skin="tron" data-thickness="0.2" data-width="90" data-height="90" data-fgColor="#f56954" data-readonly="true">
            <div class="knob-label"><?php echo $this->lang->line('xin_payroll_unpaid');?></div>
          </div>
          <!-- ./col -->
          <div class="col-xs-6 col-md-4 text-center">
            <input type="text" class="knob" value="<?php echo dashboard_paid_invoices();?>" data-skin="tron" data-thickness="0.2" data-width="90" data-height="90" data-fgColor="#00a65a" data-readonly="true">
            <div class="knob-label"><?php echo $this->lang->line('xin_payment_paid');?></div>
          </div>
          <!-- ./col -->
          <div class="col-xs-6 col-md-4 text-center">
            <input type="text" class="knob" value="<?php echo dashboard_cancelled_invoices();?>" data-skin="tron" data-thickness="0.2" data-width="90" data-height="90" data-fgColor="#00c0ef" data-readonly="true">
            <div class="knob-label"><?php echo $this->lang->line('xin_acc_inv_cancelled');?></div>
          </div>
          <!-- ./col --> 
        </div>
        <h4 style="margin-top: 0px; margin-bottom: 5px;font-size: 16px;">Recent Order Invoices</h4>
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('xin_acc_inv_orders_invoice');?></th>
              <th width="130px;"><?php echo $this->lang->line('xin_customer');?></th>
              <th width="100px;"><?php echo $this->lang->line('xin_amount');?></th>
              <th><?php echo $this->lang->line('xin_invoice_date');?></th>
              <th><?php echo $this->lang->line('xin_invoice_due_date');?></th>
              <th width="80px;"><?php echo $this->lang->line('dashboard_xin_status');?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach(dashboard_last_two_invoices() as $linvoices){?>
            <?php
				// get customer
				$customer = $this->Customers_model->read_customer_info($linvoices->customer_id); 
				if(!is_null($customer)){
					$cname = $customer[0]->name;
				} else {
					$cname = '--';	
				}
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
              <td><?php echo $cname;?></td>
              <td class="amount"><?php echo $grand_total;?></td>
              <td><?php echo $invoice_date;?></td>
              <td><?php echo $invoice_due_date;?></td>
              <td><?php echo $status;?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<hr />
<?php $this->load->view('admin/calendar/accounts');?>
