<?php
/* Purchase view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $system_setting = $this->Xin_model->read_setting_info(1);?>
<?php
	// get info
	$result2 = $supplier = $this->Suppliers_model->read_supplier_information($supplier_id); 
	if(!is_null($result2)) {
		// get company
		//$company = $this->Suppliers_model->read_supplier_information($supplier_id);
		$client_name = $result2[0]->supplier_name;
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
    <div class="btn-group pull-right" role="group" style="margin-top:2px"> <a href="<?php echo site_url('admin/purchase/preview/'.$purchase_id);?>" class="btn btn-flickr btn-sm" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $this->lang->line('xin_acc_inv_preview');?>
      <div class="ripple-wrapper"></div>
      </a> <a href="<?php echo site_url('admin/purchase/edit/'.$purchase_id);?>" class="btn btn-default btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $this->lang->line('xin_edit');?></a>
      <button type="button" id="print-invoice" class="btn btn-vk btn-sm print-invoice"><i class="fa fa-print" aria-hidden="true"></i> <?php echo $this->lang->line('xin_print');?></button>
    </div>
    </small> 
  </div>
  <!-- /.col quote_number--> 
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
          <?php echo $client_address_1.' '.$client_address_2;?><br>
          <?php 
          $client_city=isset($client_city)&&$client_city!=""?$client_city.", ":'';
          //$client_state=isset($company_state)&&$company_state!=""?$company_state.", ":'';
          $client_country_name=isset($client_country)?$client_country[0]->country_name:'';
          echo $client_city.''.$client_country_name;
          //echo $client_city.''.$client_state.''.$client_country_name;?><br>

          <?php //echo $client_city.', '.$client_country[0]->country_name;?><br>
          <?php echo $this->lang->line('xin_phone');?>: <?php echo $client_contact_number;?><br>
          <?php echo $this->lang->line('dashboard_email');?>: <?php echo $client_email;?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col"> <b><?php echo $this->lang->line('xin_acc_purchase');?> #<?php echo $prefix.' '.$purchase_number;?></b><br>
          <b><?php echo $this->lang->line('xin_e_details_date');?>:</b> <?php echo $this->Xin_model->set_date_format($purchase_date);?><br>
        </div>
        <!-- /.col --> 
      </div>
      <!-- /.row --> 
      
      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
      
          <small><button  name="Create Challane" id="createChallan" class="createChallan" style="padding: 5px;font-size: 20px;"><i class="fa fa-truck"></i> Create Challane </button></small>
          
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table productlist">
            <thead>
              <tr>
                <th><input name="all" id="all" type="checkbox" value="all"/></th>
                <th class="py-3" style="font-size:12px;"> SL No</th>
                <th class="py-3" style="font-size:12px;"> <?php echo $this->lang->line('xin_acc_item_description');?> </th>
                <!-- <th class="py-3"> <?php echo $this->lang->line('xin_acc_tax_rate');?> </th> -->
                <th class="py-3" style="text-align:center;font-size:12px;"> <?php echo $this->lang->line('xin_acc_code');?> </th>
                <th class="py-3" style="text-align:center;font-size:12px;"> <?php echo $this->lang->line('xin_acc_item_capacity');?> </th>
                <th class="py-3" style="text-align:center;font-size:12px;"> <?php echo $this->lang->line('xin_acc_item_qtyhrs');?> </th>
                <th class="py-3" style="text-align:center;font-size:12px;"> <?php echo $this->lang->line('xin_acc_remain_item_qtyhrs');?> </th>
                <th class="py-3" style="text-align:center;font-size:12px;"> <?php echo $this->lang->line('xin_acc_challane_item_qtyhrs');?> </th>
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
              <?php $prod = array(); $i=1; foreach($this->Purchase_model->get_purchase_items($purchase_id) as $_item):?>
              <?php //$result = $this->Products_model->read_product_information($_item->item_id);?>
              <tr>
                <td><input name="pid[]" class="item_purchase" type="checkbox" value="<?=$_item->purchase_item_id;?>"/></td>
                <td class="py-3"><div class="font-weight-semibold"><?php echo $i;?></div></td>
                <td class="py-3" style="width:"><div class="font-weight-semibold"><?php echo $_item->item_name;?></div></td>
                <!-- <td class="py-3"><?php echo $this->Xin_model->currency_sign($_item->item_tax_rate);?></td> -->
                <td class="py-3" style="text-align:center;font-size:12px;"><?php echo $_item->code;?></td>
                <td class="py-3" style="text-align:center;font-size:12px;"><?php echo $_item->capacity;?></td>
                <td class="py-3" style="text-align:center;font-size:12px;"><?php echo $_item->item_qty;?></td>
                <td class="py-3" style="text-align:center;font-size:12px;"><?php echo $_item->item_qty-$_item->quantity_for_chalane;?></td>
                <td class="py-3" style="text-align:center;font-size:12px;"><input type="text" style="width:100px;" name="quantity_for_chalane[<?=$_item->purchase_item_id;?>]" id="quantity_for_chalane_<?=$_item->purchase_item_id;?>" value="<?php //echo $_item->quantity_for_chalane;?>"/></td>
 
                <td class="py-3" style="text-align:right;padding-right:10px;font-size:12px;"><?php echo $this->Xin_model->currency_sign($_item->item_unit_price);?></td>
                <td class="py-3" style="text-align:right;padding-right:10px;font-size:12px;"><?php echo $this->Xin_model->currency_sign($_item->item_sub_total);?></td>
                <td class="py-3" style="text-align:center;font-size:12px;"><?php echo $_item->remarks;?></td>
              </tr>
              <?php $i++; endforeach;?>

              
              <?php 
                
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
                <td class="py-3" style="text-align:right;" colspan="7"><b><?php echo $this->lang->line('xin_acc_product_total');?>:</b></td>
                <td class="py-3" style="text-align:right;"><?php echo $product_total_amount;//echo $this->Xin_model->currency_sign($_item->item_sub_total);?></td>
                <td class="py-3" style="text-align:center;"></td>
              </tr>

                                       
              <tr <?php //echo $style;?>>
                <td class="py-3" style="text-align:right;" colspan="7"><b><?php echo $this->lang->line('xin_acc_vat_type')."(".$vat_text.")";?>:</b></td>
                <td class="py-3" style="text-align:right;"><?php echo $vat_amount;//echo $this->Xin_model->currency_sign($_item->item_sub_total);?></td>
                <td class="py-3" style="text-align:center;"></td>
              </tr>
               <?php } ?>

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
              <tr <?php //echo $style;?>> 
                <td class="py-3" style="text-align:right;" colspan="8"><b><?php echo $this->lang->line('xin_acc_grand_total').$vatTExt;?>:</b></td>
                <td class="py-3" style="text-align:right;"><?php echo $grand_total;//echo $this->Xin_model->currency_sign($_item->item_sub_total);?></td>
                <td class="py-3" style="text-align:center;"></td>
              </tr>

              <tr <?php //echo $style;?>>
                <td class="py-3" style="text-align:left;font-size:12px;" colspan="10"><strong>Amount in Words:</strong><?php  echo ' '.$this->Xin_model->convertAmountToWords($grand_total);?></td>
              
              </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col --> 
      </div>
      <!-- /.row -->
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
        <div class="col-xs-7">
          <?php if($purchase_note!=''):?>
          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;"> <?php echo $purchase_note;?> </p>
          <?php endif;?>
        </div>
        <div class="col-lg-5">
          <div class="table-responsive">
            <!-- <table class="table">
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
            </table> -->
          </div>
        </div>
        <!-- /.col --> 
      </div>
    </div>
    <!-- /.row --> 
  </div>
</div>
