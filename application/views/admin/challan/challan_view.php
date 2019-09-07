<?php
/* challan view
*/
?>
<?php 
$company_info = $this->Xin_model->read_company_setting_info(1);
$system = $this->Xin_model->read_setting_info(1);
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
     



		$client_name = $result2[0]->name;
		$client_contact_number = $result2[0]->contact_number;
		
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
          <li><a href="<?php echo site_url('admin/challan/mark_as/'.$challan_id.'/0');?>"><?php echo $this->lang->line('xin_challan_draft');?></a></li>
          <li><a href="<?php echo site_url('admin/challan/mark_as/'.$challan_id.'/1');?>"><?php echo $this->lang->line('xin_challan_delivered');?></a></li>
          <!-- <li><a href="<?php echo site_url('admin/challan/mark_as/'.$challan_id.'/2');?>"><?php echo $this->lang->line('xin_challan_on_hold');?></a></li> -->
          <li><a href="<?php echo site_url('admin/challan/mark_as/'.$challan_id.'/3');?>"><?php echo $this->lang->line('xin_accepted');?></a></li>
          <li><a href="<?php echo site_url('admin/challan/mark_as/'.$challan_id.'/4');?>"><?php echo $this->lang->line('xin_challan_lost');?></a></li>
          <!-- <li><a href="<?php echo site_url('admin/challan/mark_as/'.$challan_id.'/5');?>"><?php echo $this->lang->line('xin_challan_dead');?></a></li> -->
        </ul>
      </div>
      <!-- <a href="<?php echo site_url('admin/challan/convert_to_invoice/'.$challan_id);?>" class="btn btn-success btn-sm"><i class="fa fa-exchange" aria-hidden="true"></i> <?php echo $this->lang->line('xin_challan_convert_to_invoice');?> </a>  -->
      <a href="<?php echo site_url('admin/challan/preview/'.$challan_id);?>" class="btn btn-flickr btn-sm" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $this->lang->line('xin_acc_inv_preview');?>
      <div class="ripple-wrapper"></div>
      </a> <a href="<?php echo site_url('admin/challan/edit/'.$challan_id);?>" class="btn btn-default btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $this->lang->line('xin_edit');?></a>
      <button type="button" id="print-invoice" class="btn btn-vk btn-sm print-invoice"><i class="fa fa-print" aria-hidden="true"></i> <?php echo $this->lang->line('xin_print');?></button>
    </div>
    </small> </div>
  <!-- /.col challan_number--> 
</div>

<div class="invoice  <?php echo $get_animate;?>" style="margin:10px 10px;">
  <div id="">
 
    <div class="row">
      <div class="col-xs-12">
        <!-- <h2 class="page-header"> <i class="fa fa-globe"></i> <?php echo $company_name;?> <small class="pull-right"><?php echo $this->lang->line('xin_e_details_date');?>: <?php echo date('d-m-Y');?></small> </h2> -->
      </div>
      </div>
      <div id="print_invoice_hr">
      <div class="row">
        <div class="col-sm-4 ">
        <span class="logo-lg"><img alt="<?php echo $system[0]->application_name;?>" src="<?php echo base_url();?>uploads/logo/<?php echo $company_info[0]->logo;?>" class="brand-logo"> </span>
        </div>
      <div class="col-sm-8 invoice-col" style="float: right; margin-bottom:20px;"> <?php //echo $this->lang->line('xin_acc_from');?>
      <table style="float:right;width: 100%;">
        <tr><td style="text-align: right;font-size:11px;" width="100%"><strong><?php echo $company_name;?></strong></td></tr>
        <tr><td style="text-align: right;white-space:nowrap;font-size:11px;" width="100%"><?php echo $company_address;?></td></tr>
        <tr><td style="text-align: right;white-space:nowrap;font-size:11px;" width="100%"><?php echo $company_city;?>,<?php echo " ".$company_state;?> -<?php echo $company_zipcode;?>, <?php echo $company_country;?></td></tr>
        <tr><td style="text-align: right;white-space:nowrap;font-size:11px;" width="100%"><?php echo $this->lang->line('xin_phone');?>: <?php echo $company_phone;?></td></tr>
        <tr><td style="text-align: right;font-size:11px;" width="100%"><?php echo $this->lang->line('xin_fax');?>: <?php echo $company_fax;?></td></tr>
       
       </table>
      
        </div>
    </div>
    <!-- info row -->
    
      <div class="row invoice-info">
        <!-- <div class="col-sm-4 invoice-col"> <?php echo $this->lang->line('xin_acc_from');?>
          <address>
          <strong><?php echo $company_name;?></strong><br>
          <?php echo $company_address;?><br>
          <?php echo $company_zipcode;?>, <?php echo $company_city;?><br>
          <?php echo $company_country;?><br />
          <?php echo $this->lang->line('xin_phone');?>: <?php echo $company_phone;?><br />
          <?php echo $this->lang->line('dashboard_email');?>: <?php echo $company_email;?>
          </address>
        </div> -->
        <!-- /.col -->
        <?php
        $client_company_name=$comp_name;
        $company_address1 = $company[0]->address_1;
        $company_address2 = $company[0]->address_2;
        $company_city = $company[0]->city;
        $company_state = $company[0]->state;
        $company_zipcode = $company[0]->zipcode;
        $company_country =$this->Xin_model->read_country_info($company[0]->country);
       
        ?>
        <div class="col-sm-6 invoice-col" style="font-size:11px;"> <?php echo $this->lang->line('xin_acc_to');?>
          <address>
          <strong style="font-size:11px;"><?php echo $client_company_name;?></strong><br> 
          <?php echo $company_address1.' '.$company_address2;?><br>
          <?php 
          $client_city=isset($company_city)&&$company_city!=""?$company_city.", ":'';
          $client_state=isset($company_state)&&$company_state!=""?$company_state.", ":'';
          $client_country_name=isset($company_country)?$company_country[0]->country_name:'';
          echo $client_city.''.$client_state.''.$client_country_name;?><br>
          <!-- <?php echo $this->lang->line('xin_phone');?>: <?php echo $client_contact_number;?><br>
          <?php echo $this->lang->line('dashboard_email');?>: <?php echo $client_email;?> -->
          </address>
          <address><table>
            <tr><td style="font-size:11px;"> <strong><?php echo $this->lang->line('xin_acc_kattn');?>:</strong></td>
          <td style="white-space:nowrap;padding-left:10px;font-size:11px;" width="70"><?php echo $client_name;?></td>
            </tr>
            </table>
          </address>
        </div>
        <!-- /.col -->
        <!-- <div class="col-sm-4 invoice-col" style="float:right;"> 
          <table style="float:right;width: 100%;" width="100%">
            <tr><td style="text-align: right;font-size:11px;"><b><?php echo $this->lang->line('xin_createdp');?>:</b></td><td style="text-align: right;white-space:nowrap; padding-left:10px;font-size:11px;"><?php echo $this->Xin_model->set_date_format($challan_date);?></td></tr>
            <tr><td style="text-align: right;font-size:11px;"><b><?php echo $this->lang->line('xin_challan_our_ref');?>: </b></td><td style="text-align: right;white-space:nowrap;padding-left:10px;font-size:11px;" ><?php echo $challan_number;?></td></tr>
            <tr><td style="text-align: right;font-size:11px;"><b><?php echo $this->lang->line('xin_challan_your_ref');?>: </b></td><td style="text-align: right;white-space:nowrap;padding-left:10px;font-size:11px;"><?php echo $your_ref;?></td></tr>
            <tr><td style="text-align: right;font-size:11px;"><b><?php echo $this->lang->line('xin_challan_Revision');?>: </b></td><td style="text-align: right;white-space:nowrap;padding-left:10px;font-size:11px;"><?php echo $revision;?></td></tr>
            <tr><td style="text-align: right;white-space:nowrap;font-size:11px;" ><b><?php echo $this->lang->line('xin_challan_Demand_order_no');?>: </b></td><td style="text-align: right;white-space:nowrap;padding-left:10px;font-size:11px;"><?php echo $demand_order_no;?></td></tr>
          </table>
        </div> -->
        <!-- /.col --> 
      </div>
      <!-- /.row --> 
      <div class="row">
        <div class="col-xs-12 col-sm-12 table-responsive">
           <p style="text-align:center;text-decoration:underline;font-size:12px;"><strong style="font-size:15px;"> <?php echo $challan_title;?></strong></p>
        </div>
      </div>
      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table productlist">
            <thead>
              <tr>
                <th class="py-3" style="font-size:12px;"> SL No</th>
                <th class="py-3" style="font-size:12px;"> <?php echo $this->lang->line('xin_acc_item_description');?> </th>
                <!-- <th class="py-3"> <?php echo $this->lang->line('xin_acc_tax_rate');?> </th> -->
                <th class="py-3" style="text-align:center;font-size:12px;"> <?php echo $this->lang->line('xin_acc_code');?> </th>
                <th class="py-3" style="text-align:center;font-size:12px;"> <?php echo $this->lang->line('xin_acc_item_capacity');?> </th>
                <th class="py-3" style="text-align:center;font-size:12px;"> <?php echo $this->lang->line('xin_acc_item_qtyhrs');?> </th>
                <th class="py-3" style="text-align:center;font-size:12px;"> <?php echo $this->lang->line('xin_acc_unit_price');?> </th>
                <th class="py-3" style="text-align:center;font-size:12px;"> <?php echo $this->lang->line('xin_acc_total_amount');?> </th>
                <th class="py-3" style="text-align:center;font-size:12px;"> <?php echo $this->lang->line('xin_acc_remarks');?> </th>
              </tr>
            </thead>
            <tbody>
              <?php
				$ar_sc = explode('- ',$system_setting[0]->default_currency_symbol);
				$sc_show = $ar_sc[1];
				?>
              <?php $prod = array(); $i=1; $j=0; foreach($this->Challan_model->get_challan_items($challan_id) as $_item):?>
              
              <?php $style="";if($j%2==0) $style='style="background-color:#e6e1e1 !important;"'; $j++;?>
              <tr <?php //echo $style;?>>
                <td class="py-3"><div class="font-weight-semibold"><?php echo $i;?></div></td>
                <td class="py-3" style="font-size:12px;"><div class="font-weight-semibold"><?php echo $_item->item_name;?></div></td>
                <!-- <td class="py-3"><?php echo $this->Xin_model->currency_sign($_item->item_tax_rate);?></td> -->
                <td class="py-3" style="text-align:center;font-size:12px;"><?php echo $_item->code;?></td>
                <td class="py-3" style="text-align:center;font-size:12px;"><?php echo $_item->capacity;?></td>
                <td class="py-3" style="text-align:center;font-size:12px;"><?php echo $_item->item_qty;?></td>
                <td class="py-3" style="text-align:right;padding-right:10px;font-size:12px;"><?php echo $_item->item_unit_price;//echo $this->Xin_model->currency_sign($_item->item_unit_price);?></td>
                <td class="py-3" style="text-align:right;padding-right:10px;font-size:12px;"><?php echo $_item->item_sub_total;//echo $this->Xin_model->currency_sign($_item->item_sub_total);?></td>
                <td class="py-3" style="text-align:center;font-size:12px;"><?php echo $_item->remarks;?></td>
              </tr>
              <?php $i++ ; endforeach;?>



              <!-- <?php 
                
                $vat_text="";
                foreach($all_taxes as $_tax){
                                            
                                            
                                            
                                              if($_tax->type=='percentage') {
                                                $_vat_type = $_tax->rate.'%';
                                              } else {
                                                $_vat_type = $this->Xin_model->currency_sign($_tax->rate);
                                              }
                                              if($_tax->tax_id===$vat_type)
                                                     $vat_text=$_vat_type;
                                            
                                          
                                           } ?>
              <?php
                 $vatTExt="";
                 if(isset($vat_amount)&&$vat_amount>0){
                 $vatTExt=" Including Vat";
                   
                   ?>    
                 <tr <?php //echo $style;?>>
                <td class="py-3" style="text-align:right;" colspan="6"><b><?php echo $this->lang->line('xin_acc_product_total');?>:</b></td>
                <td class="py-3" style="text-align:right;"><?php echo $product_total_amount;//echo $this->Xin_model->currency_sign($_item->item_sub_total);?></td>
                <td class="py-3" style="text-align:center;"></td>
              </tr>

                                       
              <tr <?php //echo $style;?>>
                <td class="py-3" style="text-align:right;" colspan="6"><b><?php echo $this->lang->line('xin_acc_vat_type')."(".$vat_text.")";?>:</b></td>
                <td class="py-3" style="text-align:right;"><?php echo $vat_amount;//echo $this->Xin_model->currency_sign($_item->item_sub_total);?></td>
                <td class="py-3" style="text-align:center;"></td>
              </tr>
               <?php } ?> -->

               <!--
              <tr <?php //echo $style;?>>
                <td class="py-3" style="text-align:center;border:0px !important;"></td>
                <td class="py-3" style="border:0px !important;"></td>
                
                <td class="py-3" style="border:0px !important;"></td>
                <td class="py-3" style="border:0px !important;"></td>
                <td class="py-3" style="border:0px !important;"></td>
                <td class="py-3" style="text-align:right;border:0px !important;"><b><?php echo $this->lang->line('xin_acc_subtotal_incVat');?>:</b></td>
                <td class="py-3" style="text-align:right;border:0px !important;"><?php echo $product_total_amount_inc_vat;//echo $this->Xin_model->currency_sign($_item->item_sub_total);?></td>
                <td class="py-3" style="text-align:center;border:0px !important;"></td>
              </tr>
              <?php 
                
                $tax_text="";
                foreach($all_taxes as $_tax){
                                            
                      $tax_text="";
                      
                        if($_tax->type=='percentage') {
                          $_tax_type = $_tax->rate.'%';
                        } else {
                          $_tax_type = $this->Xin_model->currency_sign($_tax->rate);
                        }
                        if($_tax->tax_id==$tax_type) $tax_text=$_tax_type;
                      
                    
                      } ?>

              <?php if(isset($tax_amount)&&$tax_amount>0){?>
              <tr <?php //echo $style;?>>
                <td class="py-3" style="text-align:center;border:0px !important;"></td>
                <td class="py-3" style="border:0px !important;"></td>
                
                <td class="py-3" style="border:0px !important;"></td>
                <td class="py-3" style="border:0px !important;"></td>
                <td class="py-3" style="border:0px !important;"></td>
                <td class="py-3" style="text-align:right;border:0px !important;"><b><?php echo $this->lang->line('xin_acc_tax_type');?>:</b></td>
                <td class="py-3" style="text-align:right;border:0px !important;"><?php echo $tax_amount;//echo $this->Xin_model->currency_sign($_item->item_sub_total);?></td>
                <td class="py-3" style="text-align:center;border:0px !important;"></td>
              </tr>
              <?php } ?> 

              <tr <?php //echo $style;?>>
                <td class="py-3" style="text-align:center;border:0px !important;"></td>
                <td class="py-3" style="border:0px !important;"></td>
               
                <td class="py-3" style="border:0px !important;"></td>
                <td class="py-3" style="border:0px !important;"></td>
                <td class="py-3" style="border:0px !important;"></td>
                <td class="py-3" style="text-align:right;border:0px !important;"><b><?php echo $this->lang->line('xin_acc_subtotal');?>:</b></td>
                <td class="py-3" style="text-align:right;border:0px !important;"><?php echo $sub_total_amount;//echo $this->Xin_model->currency_sign($_item->item_sub_total);?></td>
                <td class="py-3" style="text-align:center;border:0px !important;"></td>
              </tr>


           <?php if(isset($total_discount)&&$total_discount>0){?>
              <tr <?php //echo $style;?>>
                <td class="py-3" style="text-align:center;border:0px !important;"></td>
                <td class="py-3" style="border:0px !important;"></td>
               
                <td class="py-3" style="border:0px !important;"></td>
                <td class="py-3" style="border:0px !important;"></td>
                <td class="py-3" style="border:0px !important;"></td>
                <td class="py-3" style="text-align:right;border:0px !important;"><b><?php echo $this->lang->line('xin_acc_discount');?>:</b></td>
                <td class="py-3" style="text-align:right;border:0px !important;"><?php echo $total_discount;//echo $this->Xin_model->currency_sign($_item->item_sub_total);?></td>
                <td class="py-3" style="text-align:center;border:0px !important;"></td>
              </tr>
              <?php } ?>  -->
              <!-- <tr <?php //echo $style;?>> 
                <td class="py-3" style="text-align:right;" colspan="6"><b><?php echo $this->lang->line('xin_acc_grand_total').$vatTExt;?>:</b></td>
                <td class="py-3" style="text-align:right;"><?php echo $grand_total;//echo $this->Xin_model->currency_sign($_item->item_sub_total);?></td>
                <td class="py-3" style="text-align:center;"></td>
              </tr>

              <tr <?php //echo $style;?>>
                <td class="py-3" style="text-align:left;font-size:12px;" colspan="8"><strong>Amount in Words:</strong><?php  echo ' '.$this->Xin_model->convertAmountToWords($grand_total);?></td>
              
              </tr> -->
            </tbody>
          </table>
        </div>
        <!-- /.col --> 
      </div>
      <!-- /.row -->
      
      <div class="row"> 
        <!-- /.col -->
        <div class="col-xs-7">
          <?php if($challan_note!=''):?>
          <!-- <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;"> <?php echo $challan_note;?> </p> -->
          <?php endif;?>
        </div>
        <div class="col-lg-5">
          <div class="table-responsive">
            <table class="table">
              <tbody>
                <!-- <tr>
                  <th style="width:50%"><?php echo $this->lang->line('xin_acc_product_total');?>:</th>
                  <td style="text-align:right;padding-right:10px;"><?php echo $product_total_amount;//echo $this->Xin_model->currency_sign($product_total_amount);?></td>
                </tr>
                <?php 
                
                $vat_text="";
                foreach($all_taxes as $_tax){
                                            
                                            $vat_text="";
                                            
                                              if($_tax->type=='percentage') {
                                                $_vat_type = $_tax->rate.'%';
                                              } else {
                                                $_vat_type = $this->Xin_model->currency_sign($_tax->rate);
                                              }
                                              if($_tax->tax_id==$vat_type) $vat_text=$_vat_type;
                                            
                                          
                                           } ?>

                  <?php if(isset($vat_amount)&&$vat_amount>0){?>
                <tr>
                  <th style="width:50%"><?php echo $this->lang->line('xin_acc_vat_type')."(".$vat_text.")";?>:</th>
                  <td style="text-align:right;padding-right:10px;"><?php echo $vat_amount;//echo $this->Xin_model->currency_sign($vat_amount);?></td>
                </tr>
                <?php } ?>
                <tr>
                  <th style="width:50%"><?php echo $this->lang->line('xin_acc_subtotal_incVat');?>:</th>
                  <td style="text-align:right;padding-right:10px;"><?php echo $product_total_amount_inc_vat; //echo $this->Xin_model->currency_sign($product_total_amount_inc_vat);?></td>
                </tr>
                <?php 
                
                $tax_text="";
                foreach($all_taxes as $_tax){
                                            
                      $tax_text="";
                      
                        if($_tax->type=='percentage') {
                          $_tax_type = $_tax->rate.'%';
                        } else {
                          $_tax_type = $this->Xin_model->currency_sign($_tax->rate);
                        }
                        if($_tax->tax_id==$tax_type) $tax_text=$_tax_type;
                      
                    
                      } ?>

                      <?php if(isset($tax_amount)&&$tax_amount>0){?>
                        <tr>
                          <th style="width:50%"><?php echo $this->lang->line('xin_acc_tax_type')."(".$tax_text.")";?>:</th>
                          <td style="text-align:right;padding-right:10px;"><?php echo $tax_amount;//echo $this->Xin_model->currency_sign($tax_amount);?></td>
                        </tr>
                      <?php } ?> -->
                <!-- <tr>
                  <th style="width:50%"><?php echo $this->lang->line('xin_acc_subtotal');?>:</th>
                  <td style="text-align:right;padding-right:10px;"><?php echo $sub_total_amount;//echo $this->Xin_model->currency_sign($sub_total_amount);?></td>
                </tr> -->
                <!-- <tr>
                  <th><?php echo $this->lang->line('xin_acc_tax_item');?></th>
                  <td><?php echo $this->Xin_model->currency_sign($total_tax);?></td>
                </tr> -->
                <!-- <?php if(isset($total_discount)&&$total_discount>0){?>
                <tr>
                  <th><?php echo $this->lang->line('xin_acc_discount');?>:</th>
                  <td style="text-align:right;padding-right:10px;"><?php echo $total_discount; //echo $this->Xin_model->currency_sign($total_discount);?></td>
                </tr>
                <?php } ?> -->
                <!-- <tr>
                  <th><?php echo $this->lang->line('xin_acc_grand_total');?>:</th>
                  <td style="text-align:right;padding-right:20px;"><?php echo $grand_total;//echo $this->Xin_model->currency_sign($grand_total);?></td>
                  <td style="text-align:right;padding-right:20px;"><?php echo $grand_total;//echo $this->Xin_model->currency_sign($grand_total);?></td>
                </tr> -->
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.col --> 
      </div>

      <div class="row"> 
        <!-- /.col -->
        <!-- <div class="col-xs-12 col-sm-12 table-responsive" style="text-align:left">
                  <table class="table  termscondition" style="float:left">
                    <tr ><td colspan="2" style="padding:5px"><strong style="font-size:15px;">Commercial Terms and Conditions:</strong></td></tr>
                    <tr><td  width="30%" style="font-size:12px;"><b><?php echo $this->lang->line('xin_challan_terms_of_payment');?>:</b></td><td style="font-size:12px;"><?php echo $terms_of_payment;?></td></tr>
                    <tr><td style="font-size:12px;"><b><?php echo $this->lang->line('xin_challan_delivery_codition');?>:</b></td><td style="font-size:12px;"><?php echo $delivery_condition;?></td></tr>
                    <tr><td style="font-size:12px;"><b><?php echo $this->lang->line('xin_challan_offer_validity');?>:</b></td><td style="font-size:12px;"><?php echo $offer_validity;?></td></tr>
                    <tr><td style="font-size:12px;"><b><?php echo $this->lang->line('xin_challan_delivery_time');?>:</b></td><td style="font-size:12px;"><?php echo $delivery_time;?></td></tr>
                    <tr><td style="font-size:12px;"><b><?php echo $this->lang->line('xin_challan_partial_shipment');?>:</b></td style="font-size:12px;"><td><?php echo $partial_shipment;?></td></tr>
                  </table>
        </div> -->
      </div>

<style>
  table.termscondition > tbody > tr > td
  {
    padding: 2px !important;
    border: 0px !important;
  }
  table.productlist> thead > tr > th{
    border: 1px solid #cccccc !important;
  }
  table.productlist> tbody > tr > td{
    border: 1px solid #cccccc !important;
  }
  </style>
      <div class="row"> 
        <!-- /.col -->
        <div class="col-xs-12 col-sm-12 " style="text-align:left;padding-left:20px;">
        <div >
          <span class="logo-lg">
            <img alt="<?php echo $system[0]->application_name;?>" src="<?php echo base_url();?>uploads/logo/signature/<?php echo $company_info[0]->signature;?>" class="brand-logo"> 
          </span>
        </div>
        <div>
        
              <p><strong style="font-size:15px;">Masudur Rahman</strong></p>
              <p style="margin: 0px;padding: 0px;font-size:12px;">Assistant General Manager</p>
              <p style="margin: 0px;padding: 0px;font-size:12px;">Pasteur Pharmatech Solutions</p>
              <p style="margin: 0px;padding: 0px;font-size:12px;">Email: masud@pasteurbd.com, masud.pps@gmail.com</p>
              <p style="margin: 0px;padding: 0px;font-size:12px;">Cell:+8801716123519</p>
          </div>
                 
                  
        </div>
      </div>



      <!-- <div class="row"> 
       
        <div class="col-xs-12 col-sm-12 " style="float:right">
              <table class="table " width="100%" style="width:100%;">
                    <tr><td style="text-align:right;vertical-align: top !important;font-size:11px;" ><b><?php echo $this->lang->line('xin_registered_address');?>:</b></td><td width="35%" style="text-align:right;vertical-align: top !important;font-size:11px;"><?php echo $company_reg_address1;?> <br/>
                   <?php echo $company_reg_address2;?></td></tr>
              </table>
        </div>
      </div> -->
    </div>
    <!-- /.row --> 
  </div>
</div>
