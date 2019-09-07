<?php
// Edit Invoice Page

$system_setting = $this->Xin_model->read_setting_info(1);
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="row <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_acc_edit_challan');?> #<?php echo $challan_number;?> </h3>
      </div>
      <div class="box-body" aria-expanded="true" style="">
        <div class="row m-b-1">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'create_challan', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'form');?>
            <?php $hidden = array('user_id' => 0);?>
            <?php echo form_open('admin/challan/update_challan/'.$challan_id, $attributes, $hidden);?>
            <div class="bg-white">
              <div class="box-block">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="challan_number"><?php echo $this->lang->line('xin_challan_number');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_challan_number');?>" name="challan_number" id="challan_number" type="text" value="<?php echo $challan_number;?>">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="company"><?php echo $this->lang->line('xin_company_company');?></label>
                     
                      <?php $companies = $this->company_model->get_companies();?>
                      <select class="form-control" onchange="getAddress(this.value)" id="get_company_address" name="company_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_company_company');?>">
                        <option value=""></option>
                        <?php foreach($companies->result() as $company) {?>
                        <option value="<?php echo $company->company_id?>"
                        <?php if($company->company_id==$company_id):?> selected="selected"<?php endif;?>><?php echo $company->name?></option>
                        <?php } ?>
                      </select>
                      </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="project"><?php echo $this->lang->line('xin_customer_company');?></label>
                      <?php $customers = $this->Customers_model->get_all_customers_bycompany($company_id);?>
                      <select class="form-control" name="customer_id"  id="customer_id_list" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select');?>">
                        <option value=""></option>
						          <?php foreach($customers as $customer) {?>
                        <option value="<?php echo $customer->customer_id?>" <?php if($customer->customer_id==$customer_id):?> selected="selected"<?php endif;?> > <?php echo $customer->name.'-'.$customer->address_1;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="invoice_date"><?php echo $this->lang->line('xin_challan_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_challan_date');?>"  name="challan_date" type="text" value="<?php echo $challan_date;?>">
                    </div>
                  </div>
                  <!-- <div class="col-md-4">
                    <div class="form-group">
                      <label for="invoice_due_date"><?php echo $this->lang->line('xin_invoice_due_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_invoice_due_date');?>" name="challan_due_date" type="text" value="<?php echo $challan_due_date;?>">
                    </div>
                  </div> -->
                  <!-- <div class="col-md-4">
                    <div class="form-group">
                      <label for="prefix"><?php echo $this->lang->line('xin_inv_prefix');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_inv_prefix');?>" name="prefix" type="text" value="<?php echo $prefix;?>">
                    </div>
                  </div> -->
                </div>
                <!-- <div class="form-group">
                    <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="your_ref"><?php echo $this->lang->line('xin_challan_your_ref');?></label>
                      <input class="form-control " placeholder="<?php echo $this->lang->line('xin_challan_your_ref');?>" name="your_ref" type="text" value="<?php echo $your_ref;?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="revision"><?php echo $this->lang->line('xin_challan_Revision');?></label>
                      <input class="form-control " placeholder="<?php echo $this->lang->line('xin_challan_Revision');?>"  name="revision" type="text" value="<?php echo $revision;?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="demand_order_no"><?php echo $this->lang->line('xin_challan_Demand_order_no');?></label>
                      <input class="form-control " placeholder="<?php echo $this->lang->line('xin_challan_Demand_order_no');?>"  name="demand_order_no" type="text" value="<?php echo $demand_order_no;?>">
                    </div>
                  </div>
                  </div>
                  </div> -->

                  <div class="row">
                  <div class="col-md-10">
                    <div class="form-group">
                      <label for="challan_title"><?php echo $this->lang->line('xin_challan_title');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_challan_title');?>" name="challan_title" type="text" value="<?php echo $challan_title;?>">
                    </div>
                  </div>
                  </div>

                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="hrsale-item-values">
                        <div data-repeater-list="items">
                          <div data-repeater-item="">
                            <?php $prod = array(); foreach($this->Challan_model->get_challan_items($challan_id) as $_item):?>
                            <div class="row item-row">
                              <div class="form-group mb-2 col-sm-12 col-md-4">
                                <input type="hidden" name="item[<?php echo $_item->challan_item_id;?>]" value="<?php echo $_item->challan_item_id;?>" />
                                <label for="item_name"><?php echo $this->lang->line('xin_acc_item');?></label>
                                <br>
                                <select class="form-control item_name" name="eitem_name[<?php echo $_item->challan_item_id;?>]" id="item_name" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select');?>">
                                <option value=""></option>
                                <?php foreach($all_items as $_iitem) {?>
                                  <option value="<?php echo $_iitem->product_id?>" <?php if($_iitem->product_id==$_item->item_id):?> selected="selected"<?php endif;?> item-attribute="<?php echo $_iitem->product_id?>|<?php echo $_iitem->product_serial_number?>|<?php echo $_iitem->capacity?>|<?php echo $_iitem->remarks?>" item-price="<?php echo $_iitem->retail_price?>"><?php echo $_iitem->product_serial_number.'-'.$_iitem->product_name.'-'.$_iitem->capacity?></option>
                                <!-- <option value="<?php echo $_iitem->product_id?>" <?php if($_iitem->product_id==$_item->item_id):?> selected="selected"<?php endif;?> item-price="<?php echo $_iitem->retail_price?>"><?php echo $_iitem->product_name?></option> -->
                                <?php } ?>
                              </select>
                              </div>
                              <!-- <div class="form-group mb-1 col-sm-12 col-md-2">
                                <label for="tax_type"><?php echo $this->lang->line('xin_invoice_tax_type');?></label>
                                <br>
                                <select class="form-control tax_type" name="etax_type[<?php echo $_item->challan_item_id;?>]" id="tax_type">
                                  <?php foreach($all_taxes as $_tax){?>
                                  <?php
                                    if($_tax->type=='percentage') {
                                      $_tax_type = $_tax->rate.'%';
                                    } else {
                                      $_tax_type = $this->Xin_model->currency_sign($_tax->rate);
                                    }
                                  ?>
                                  <option tax-type="<?php echo $_tax->type;?>" tax-rate="<?php echo $_tax->rate;?>" value="<?php echo $_tax->tax_id;?>" <?php if($_item->item_tax_type==$_tax->tax_id):?> selected="selected"<?php endif;?>> <?php echo $_tax->name;?> (<?php echo $_tax_type;?>)</option>
                                  <?php } ?>
                                </select>
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-1">
                                <label for="tax_type"><?php echo $this->lang->line('xin_acc_tax_rate');?></label>
                                <br>
                                <input type="text" readonly="readonly" class="form-control tax-rate-item" name="etax_rate_item[<?php echo $_item->challan_item_id;?>]" value="<?php echo $_item->item_tax_rate;?>" />
                              </div> -->


                              <div class="form-group mb-1 col-sm-12 col-md-2">
                                <label for="code" class="cursor-pointer"><?php echo $this->lang->line('xin_acc_code');?></label>
                                <br>
                                <input type="text" class="form-control code" name="ecode[<?php echo $_item->challan_item_id;?>]" id="code" value="<?php echo $_item->code;?>">
                              </div>

                              <div class="form-group mb-1 col-sm-12 col-md-2">
                                <label for="capacity" class="cursor-pointer"><?php echo $this->lang->line('xin_acc_item_capacity');?></label>
                                <br>
                                <input type="text" class="form-control capacity" name="ecapacity[<?php echo $_item->challan_item_id;?>]" id="capacity" value="<?php echo $_item->capacity;?>">
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-2">
                                <label for="remarks" class="cursor-pointer"><?php echo $this->lang->line('xin_acc_remarks');?></label>
                                <br>
                                <input type="text" class="form-control remarks" name="eremarks[<?php echo $_item->challan_item_id;?>]" id="remarks" value="<?php echo $_item->remarks;?>">
                              </div>

                              <div class="form-group mb-1 col-sm-12 col-md-1">
                                <label for="qty_hrs" class="cursor-pointer"><?php echo $this->lang->line('xin_acc_item_qtyhrs');?></label>
                                <br>
                                <input type="text" class="form-control qty_hrs" name="eqty_hrs[<?php echo $_item->challan_item_id;?>]" id="qty_hrs" value="<?php echo $_item->item_qty;?>">
                              </div>
                              <!-- <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-2">
                                <label for="unit_price"><?php echo $this->lang->line('xin_acc_unit_price');?></label>
                                <br>
                                <input class="form-control unit_price" type="text" name="eunit_price[<?php echo $_item->challan_item_id;?>]" style="text-align: right;" value="<?php echo $_item->item_unit_price;?>" id="unit_price" />
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-2">
                                <label for="profession"><?php echo $this->lang->line('xin_acc_subtotal');?></label>
                                <input type="text" class="form-control sub-total-item" readonly="readonly" name="esub_total_item[<?php echo $_item->challan_item_id;?>]" style="text-align: right;" value="<?php echo $_item->item_sub_total;?>" />
                                
                                <p style="display:none" class="form-control-static"><span class="amount-html">0</span></p>
                              </div> -->
                              <div class="form-group col-sm-12 col-md-1 text-xs-center mt-2">
                                <label for="profession">&nbsp;</label>
                                <br>
                                <button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light eremove-item" data-repeater-delete="" data-record-id="<?php echo $_item->challan_item_id;?>" data-invoice-id="<?php echo $challan_id;?>"> <span class="fa fa-trash"></span></button>
                              </div>
                            </div>
                            <?php endforeach;?>
                          </div>
                        </div>
                      </div>
                      <div id="item-list"></div>
                      <div class="form-group overflow-hidden1">
                        <div class="col-xs-12">
                          <button type="button" data-repeater-create="" class="btn btn-primary" id="add-challan-item"> <i class="fa fa-plus"></i> <?php echo $this->lang->line('xin_acc_add_item');?></button>
                        </div>
                      </div>
                      <?php
						$ar_sc = explode('- ',$system_setting[0]->default_currency_symbol);
						$sc_show = $ar_sc[1];
						?>
                       <input type="hidden" class="product-total-amount" name="product_total_amount" value="<?php echo $product_total_amount;?>" />
                      <input type="hidden" class="product-total-amount-inc-vat" name="product_total_amount_inc_vat" value="<?php echo $product_total_amount_inc_vat;?>" />


                      <input type="hidden" class="items-sub-total" name="items_sub_total" value="<?php echo $sub_total_amount;?>" />
                      <input type="hidden" class="items-tax-total" name="items_tax_total" value="<?php echo $total_tax;?>" />
                      <div class="row">
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left">&nbsp; </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="table-responsive">
                            <!-- <table class="table" style="width: 83%;">
                              <tbody>
                              <tr>
                                  <td><?php echo $this->lang->line('xin_acc_product_total');?></td>
                                  <td class="text-xs-right" style="text-align: right;padding-right: 15px !important;"><?php echo $sc_show;?> <span class="product_total"><?php echo $product_total_amount;?></span></td>
                                </tr>
                                <tr>
                                  <td colspan="2" style="border-bottom:1px solid #dddddd; padding:0px !important; text-align:left">
                                   
                                   <table class="table table-bordered">
                                      <tbody>
                                      <tr>
                                       
                                       <td align="left" style="width: 25%;"><div class="form-group">
                                       <?php echo $this->lang->line('xin_acc_vat_type');?>
                                         </div></td>
                                       <td style="width: 39%;"><div class="form-group">
                                       <select class="form-control vat_type_total" name="vat_type_total" id="vat_type_total">
                                       <?php foreach($all_taxes as $_tax){
                                         
                                         $select="";
                                         ?>
                                       <?php
                                           if($_tax->type=='percentage') {
                                             $_tax_type = $_tax->rate.'%';
                                           } else {
                                             $_tax_type = $this->Xin_model->currency_sign($_tax->rate);
                                           }
                                           if($_tax->tax_id==$vat_type) $select="selected";
                                         ?>
                                       <option tax-type="<?php echo $_tax->type;?>" tax-rate="<?php echo $_tax->rate;?>" value="<?php echo $_tax->tax_id;?>" <?=$select?>> <?php echo $_tax->name;?> (<?php echo $_tax_type;?>)</option>
                                       <?php } ?>
                                     </select>
                                         </div>
                                         </td>
                                       <td align="right" style="padding: 0px !important;margin: 0px !important;"><div class="form-group">
                                           <input type="text" style="text-align:right" readonly="" name="vat_total" value="<?php echo $vat_amount;?>" class="vat_total form-control">
                                         </div></td>
                                     </tr>

                                     <tr>
                                       
                                       <td align="left" style="width: 25%;"></td>
                                       <td style="width: 39%;" align="right">
                                       <?php echo $this->lang->line('xin_acc_subtotal_incVat');?>
                                         </td>
                                       <td align="right" style="text-align: right;padding-right:  14px !important;">
                                       <?php echo $sc_show;?>
                                       <span class="product_total_inc_vat"><?php echo $product_total_amount_inc_vat; ?></span>
                                       </td>
                                     </tr>
                                        <tr>
                                       
                                          <td align="left" style="width: 25%;"><div class="form-group">
                                          <?php echo $this->lang->line('xin_acc_tax_type');?>
                                            </div></td>
                                          <td style="width: 39%;"><div class="form-group">
                                          <select class="form-control tax_type_total" name="tax_type_total" id="tax_type_total">
                                          <?php foreach($all_taxes as $_tax){
                                            
                                            $select="";
                                            ?>
                                          <?php
                                              if($_tax->type=='percentage') {
                                                $_tax_type = $_tax->rate.'%';
                                              } else {
                                                $_tax_type = $this->Xin_model->currency_sign($_tax->rate);
                                              }
                                              if($_tax->tax_id==$tax_type) $select="selected";
                                            ?>
                                          <option tax-type="<?php echo $_tax->type;?>" tax-rate="<?php echo $_tax->rate;?>" value="<?php echo $_tax->tax_id;?>" <?=$select?>> <?php echo $_tax->name;?> (<?php echo $_tax_type;?>)</option>
                                          <?php } ?>
                                        </select>
                                            </div>
                                            </td>
                                          <td align="right" style="padding: 0px !important;margin: 0px !important;"><div class="form-group">
                                              <input type="text" style="text-align:right" readonly="" name="tax_total" value="<?php echo $tax_amount;?>" class="tax_total form-control">
                                            </div></td>
                                        </tr>
                                       
                                      </tbody>
                                    </table></td>
                                </tr>      
                                <tr>
                                  <td><?php echo $this->lang->line('xin_acc_subtotal');?></td>
                                  <td class="text-xs-right" style="text-align: right;padding-right: 15px !important;"><?php echo $sc_show;?> <span class="sub_total"><?php echo $sub_total_amount;?></span></td>
                                </tr>
                                 <tr>
                                  <td><?php echo $this->lang->line('xin_acc_tax_item');?></td>
                                  <td class="text-xs-right" style="text-align: right;padding-right: 15px !important;"><?php echo $sc_show;?> <span class="tax_total"><?php echo $total_tax;?></span></td>
                                </tr> 
                                <tr>
                                  <td colspan="2" style="border-bottom:1px solid #dddddd; padding:0px !important; text-align:left"><table class="table table-bordered">
                                      <tbody>
                                        <tr>
                                          <td width="30%" style="border-bottom:1px solid #dddddd; text-align:left"><strong><?php echo $this->lang->line('xin_acc_discount_type');?></strong></td>
                                          <td style="border-bottom:1px solid #dddddd; text-align:center"><strong><?php echo $this->lang->line('xin_acc_discount');?></strong></td>
                                          <td style="border-bottom:1px solid #dddddd; text-align:left"><strong><?php echo $this->lang->line('xin_acc_discount_amount');?></strong></td>
                                        </tr>
                                        <tr>
                                          <td>
                                              <div class="form-group">
                                                <select name="discount_type" class="form-control discount_type">
                                                  <option value="1" <?php if($discount_type==1):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_acc_flat');?></option>
                                                  <option value="2" <?php if($discount_type==2):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('xin_acc_percent');?></option>
                                                </select>
                                              </div>
                                            </td>
                                          <td align="right"><div class="form-group">
                                              <input style="text-align:right" type="text" name="discount_figure" class="form-control discount_figure" value="<?php echo $discount_figure;?>" data-valid-num="required">
                                            </div></td>
                                          <td align="right" style="padding: 0px !important;margin: 0px !important;"><div class="form-group">
                                              <input type="text" style="text-align:right" readonly="" name="discount_amount" value="<?php echo $total_discount;?>" class="discount_amount form-control">
                                            </div></td>
                                        </tr>
                                      </tbody>
                                    </table></td>
                                </tr>
                              <input type="hidden" class="fgrand_total" name="fgrand_total" value="<?php echo $grand_total;?>" />
                              <tr>
                                <td><?php echo $this->lang->line('xin_acc_grand_total');?></td>
                                <td class="text-xs-right" style="text-align: right;padding-right: 15px !important;"><?php echo $sc_show;?> <span class="grand_total"><?php echo $grand_total;?></span></td>
                              </tr>
                                </tbody>
                              
                            </table> -->
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-xs-12 mb-2 file-repeaters"> </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <label for="challan_note"><?php echo $this->lang->line('xin_challan_note');?></label>
                          <textarea name="challan_note" class="form-control"><?php echo $challan_note;?></textarea>
                        </div>
                      </div>

                      <!-- <div class="row">
                        <h3><p><strong>Conditional Terms and Conditions</strong></p></h3>
                        <div class="ol-xs-6 mb-6 col-lg-6">
                          <label for="terms_of_payment"><?php echo $this->lang->line('xin_challan_terms_of_payment');?></label>
                          <input type="text" name="terms_of_payment" class="form-control" value="<?php echo $terms_of_payment;?>">
                        </div>
                        <div class="ol-xs-6 mb-6 col-lg-6">
                          <label for="delivery_condition"><?php echo $this->lang->line('xin_challan_delivery_codition');?></label>
                          <input type="text" name="delivery_condition" class="form-control" value="<?php echo $delivery_condition;?>">
                        </div>
                        <div class="ol-xs-6 mb-6 col-lg-6">
                          <label for="offer_validity"><?php echo $this->lang->line('xin_challan_offer_validity');?></label>
                          <input type="text" name="offer_validity" class="form-control date" value="<?php echo $offer_validity;?>">
                        </div>
                        <div class="ol-xs-6 mb-6 col-lg-6">
                          <label for="delivery_time"><?php echo $this->lang->line('xin_challan_delivery_time');?></label>
                          <input type="text" name="delivery_time" class="form-control" value="<?php echo $delivery_time;?>">
                        </div>
                        <div class="ol-xs-6 mb-6 col-lg-6">
                          <label for="partial_shipment"><?php echo $this->lang->line('xin_challan_partial_shipment');?></label>
                          <input type="text" name="partial_shipment" class="form-control" value="<?php echo $partial_shipment;?>">
                        </div>
                      </div> -->
                    </div>
                  </div>
                </div>
                <div class="row no-print">
                  <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary pull-right print-invoice" name="invoice_submit" style="margin-right: 5px;"> <i class="fa fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_acc_submit');?> </button>
                  </div>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  </div>
</div>
