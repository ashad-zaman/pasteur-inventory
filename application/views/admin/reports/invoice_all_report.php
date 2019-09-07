<?php
/*  Todays Report
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('xin_acc_todays_sales_report');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_e_details_date');?></th>
            <th><?php echo $this->lang->line('xin_invoice_no');?></th>
            <th><?php echo $this->lang->line('xin_customer');?></th>
            <th><?php echo $this->lang->line('xin_payment_method');?></th>
            <th><?php echo $this->lang->line('xin_amount');?></th>
          </tr>
        </thead>
        <?php $sales_report = $this->Reports_model->get_today_sales_report();?>
        <?php if($sales_report->num_rows() > 0){?>
			<?php foreach($sales_report->result() as $r1){?>
            <?php
            // get amount
			$amount = $this->Xin_model->currency_sign($r1->amount);			
			// sales date
			$sales_date = $this->Xin_model->set_date_format($r1->transaction_date);
			// payment method 
			$payment_method = $this->Xin_model->read_payment_method($r1->payment_method_id);
			if(!is_null($payment_method)){
				$method_name = $payment_method[0]->method_name;
			} else {
				$method_name = '--';	
			}
			// get customer
			$customer = $this->Customers_model->read_customer_info($r1->payer_payee_id); 
			if(!is_null($customer)){
				$cname = $customer[0]->name;
			} else {
				$cname = '--';	
			}
			$invoice_info = $this->Invoices_model->read_invoice_info($r1->invoice_id);
			if(!is_null($invoice_info)){
				$inv_no = '<a href="'.site_url('admin/orders/view/'.$r1->invoice_id).'" target="_blank">'.$invoice_info[0]->invoice_number.'</a>';//;
			} else {
				$inv_no = '--';	
			}
            ?>
            <tr>
                <td><?php echo $sales_date;?></td>
                <td><?php echo $inv_no;?></td>
                <td><?php echo $cname;?></td>
                <td><?php echo $method_name;?></td>
                <td><?php echo $amount;?></td>
              </tr>
              <?php }
		  } else {?>
          	<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty" style="text-align: center;"><?php echo $this->lang->line('xin_acc_no_record_found');?></td></tr>
          <?php } ?>
        <tfoot id="get_footer">
        </tfoot>
      </table>
    </div>
  </div>
</div>
<?php $purchase_report = $this->Reports_model->get_today_purchases_report();?>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('xin_acc_todays_purchase_report');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_e_details_date');?></th>
            <th><?php echo $this->lang->line('xin_acc_purchase_nom');?></th>
            <th><?php echo $this->lang->line('xin_supplier');?></th>
            <th><?php echo $this->lang->line('xin_payment_method');?></th>
            <th><?php echo $this->lang->line('xin_amount');?></th>
          </tr>
        </thead>
        <tbody>
        <?php if($purchase_report->num_rows() > 0){?>
			<?php foreach($purchase_report->result() as $r){?>
            <?php
            // get amount
            $amount = $this->Xin_model->currency_sign($r->amount);			
            // purchase_date
            $purchase_date = $this->Xin_model->set_date_format($r->transaction_date);
            // payment method 
            $payment_method = $this->Xin_model->read_payment_method($r->payment_method_id);
            if(!is_null($payment_method)){
                $method_name = $payment_method[0]->method_name;
            } else {
                $method_name = '--';	
            }
            // get customer
            $supplier = $this->Suppliers_model->read_supplier_information($r->payer_payee_id); 
            if(!is_null($supplier)){
                $cname = $supplier[0]->supplier_name;
            } else {
                $cname = '--';	
            }
            $purchase_info = $this->Purchase_model->read_purchase_info($r->invoice_id);
            if(!is_null($purchase_info)){
                $inv_no = '<a href="'.site_url('admin/purchases/view/'.$r->invoice_id).'" target="_blank">'.$purchase_info[0]->purchase_number.'</a>';//;
            } else {
                $inv_no = '--';	
            }
            ?>
            <tr>
                <td><?php echo $purchase_date;?></td>
                <td><?php echo $inv_no;?></td>
                <td><?php echo $cname;?></td>
                <td><?php echo $method_name;?></td>
                <td><?php echo $amount;?></td>
              </tr>
              <?php }
		  } else {?>
          	<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty" style="text-align: center;"><?php echo $this->lang->line('xin_acc_no_record_found');?></td></tr>
          <?php } ?>
        </tbody>
        <tfoot id="get_footer">
        </tfoot>
      </table>
    </div>
  </div>
</div>
