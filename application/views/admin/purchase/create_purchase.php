<?php
// Create purchase Page

$system_setting = $this->Xin_model->read_setting_info(1);
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="row <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_acc_new_purchase');?> </h3>
      </div>
      <div class="box-body" aria-expanded="true" style="">
        <div class="row m-b-1">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'create_purchase', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'form');?>
            <?php $hidden = array('user_id' => 0);?>
            <?php echo form_open('admin/purchase/create_new_purchase', $attributes, $hidden);?>
            <div class="bg-white">
              <div class="box-block">
              <div class="row">
                <div class="col-md-4">
                      <div class="form-group">
                        <label for="quote_id"><?php echo $this->lang->line('left_quote');?></label>
                        <?php $quotes = $this->Quotes_model->get_quotes()->result(); ?>
                        <select class="form-control" name="quote_id" id="quote_id"  data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select');?>">
                          <option value=""></option>
                          <?php foreach($quotes as $quote) {?>
                          <option value="<?php echo $quote->quote_id?>"><?php echo $quote->quote_number?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                      <label for="supplier_id">&nbsp;</label>
                        <input onclick="getQuoteDetails()" style="width:70%;font-weight:bold" class="form-control" type="button" value="Convert to Purchase Order" />
                      </div>
                    </div>
                  </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="purchase_number"><?php echo $this->lang->line('xin_acc_purchase_no');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_purchase_no');?>" name="purchase_number" type="text" value="<?php //echo $purchases_order_no;?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="supplier_id"><?php echo $this->lang->line('left_supplier');?></label>
                      <?php $suppliers = $all_suppliers->result();?>
                      <select class="form-control" name="supplier_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select');?>">
                        <option value=""></option>
                        <?php foreach($suppliers as $supplier) {?>
                        <option value="<?php echo $supplier->supplier_id?>"><?php echo $supplier->supplier_name?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="purchase_date"><?php echo $this->lang->line('xin_e_details_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_e_details_date');?>" readonly="readonly" name="purchase_date" type="text" value="">
                    </div>
                  </div>
                  <!-- <div class="col-md-4">
                    <div class="form-group">
                      <label for="prefix"><?php echo $this->lang->line('xin_inv_prefix');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_inv_prefix');?>" name="prefix" type="text" value="">
                    </div>
                  </div> -->
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="hrsale-item-values">
                        <div data-repeater-list="items">
                          <div data-repeater-item="">
                            <div class="row item-row">
                              <div class="form-group mb-2 col-sm-12 col-md-2">
                                <label for="item_name"><?php echo $this->lang->line('xin_acc_item');?></label>
                                <br>
                                <select class="form-control item_name" name="item_name[]" id="item_name" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select');?>">
                                  <option value=""></option>
                                  <?php foreach($all_items as $_item) {?>
                                  <option value="<?php echo $_item->product_id?>" item-price="<?php echo $_item->purchase_price?>"><?php echo $_item->product_name?></option>
                                  <?php } ?>
                                </select>
                              </div>
                              <!-- <div class="form-group mb-1 col-sm-12 col-md-2">
                                <label for="tax_type"><?php echo $this->lang->line('xin_invoice_tax_type');?></label>
                                <br>
                                <select class="form-control tax_type" name="tax_type[]" id="tax_type">
                                  <?php foreach($all_taxes as $_tax){?>
                                  <?php
                                  if($_tax->type=='percentage') {
                                    $_tax_type = $_tax->rate.'%';
                                  } else {
                                    $_tax_type = $this->Xin_model->currency_sign($_tax->rate);
                                  }
                                ?>
                                  <option tax-type="<?php echo $_tax->type;?>" tax-rate="<?php echo $_tax->rate;?>" value="<?php echo $_tax->tax_id;?>"> <?php echo $_tax->name;?> (<?php echo $_tax_type;?>)</option>
                                  <?php } ?>
                                </select>
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-1">
                                <label for="tax_type"><?php echo $this->lang->line('xin_acc_tax_rate');?></label>
                                <br>
                                <input type="text" readonly="readonly" class="form-control tax-rate-item" name="tax_rate_item[]" value="0" />
                              </div> -->
                              <div class="form-group mb-1 col-sm-12 col-md-1">
                                <label for="code" class="cursor-pointer"><?php echo $this->lang->line('xin_acc_code');?></label>
                                <br>
                                <input type="text" class="form-control code" name="code[]" id="code" value="">
                              </div>

                              <div class="form-group mb-1 col-sm-12 col-md-1">
                                <label for="capacity" class="cursor-pointer"><?php echo $this->lang->line('xin_acc_item_capacity');?></label>
                                <br>
                                <input type="text" class="form-control capacity" name="capacity[]" id="capacity" value="">
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-2">
                                <label for="remarks" class="cursor-pointer"><?php echo $this->lang->line('xin_acc_remarks');?></label>
                                <br>
                                <input type="text" class="form-control remarks" name="remarks[]" id="remarks" value="">
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-1">
                                <label for="qty_hrs" class="cursor-pointer"><?php echo $this->lang->line('xin_acc_item_qtyhrs');?></label>
                                <br>
                                <input type="text" class="form-control qty_hrs" name="qty_hrs[]" id="qty_hrs" value="1">
                              </div>
                              <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-2">
                                <label for="unit_price"><?php echo $this->lang->line('xin_acc_unit_price');?></label>
                                <br>
                                <input class="form-control unit_price" type="text" name="unit_price[]" value="0" id="unit_price" />
                              </div>
                              <div class="form-group mb-2 col-sm-12 col-md-2">
                                <label for="profession"><?php echo $this->lang->line('xin_acc_subtotal');?></label>
                                <input type="text" class="form-control sub-total-item" readonly="readonly" name="sub_total_item[]" value="0" style="text-align: right;" />
                                <!-- <br>-->
                                <p style="display:none" class="form-control-static"><span class="amount-html">0</span></p>
                              </div>
                              <div class="form-group col-sm-12 col-md-1 text-xs-center mt-2">
                                <label for="profession">&nbsp;</label>
                                <br>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="item-list"></div>
                      <div class="form-group overflow-hidden1">
                        <div class="col-xs-12">
                          <button type="button" data-repeater-create="" class="btn btn-primary" id="add-invoice-item"> <i class="fa fa-plus"></i> <?php echo $this->lang->line('xin_acc_add_item');?></button>
                        </div>
                      </div>
                      <?php
						$ar_sc = explode('- ',$system_setting[0]->default_currency_symbol);
						$sc_show = $ar_sc[1];
						?>

                      <input type="hidden" class="product-total-amount" name="product_total_amount" value="0" />
                      <input type="hidden" class="product-total-amount-inc-vat" name="product_total_amount_inc_vat" value="0" />           
                      <input type="hidden" class="items-sub-total" name="items_sub_total" value="0" />
                      <input type="hidden" class="items-tax-total" name="items_tax_total" value="0" />
                      <div class="row">
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left">&nbsp; </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="table-responsive">
                          <table class="table" style="width: 83%;">
                              <tbody>
                              <tr>
                                  <td><?php echo $this->lang->line('xin_acc_product_total');?></td>
                                  <td class="text-xs-right" style="text-align: right;padding-right: 15px !important;"><?php echo $sc_show;?> <span class="product_total">0</span></td>
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
                                       <?php foreach($all_taxes as $_tax){?>
                                       <?php
                                           if($_tax->type=='percentage') {
                                             $_tax_type = $_tax->rate.'%';
                                           } else {
                                             $_tax_type = $this->Xin_model->currency_sign($_tax->rate);
                                           }
                                         ?>
                                       <option tax-type="<?php echo $_tax->type;?>" tax-rate="<?php echo $_tax->rate;?>" value="<?php echo $_tax->tax_id;?>"> <?php echo $_tax->name;?> (<?php echo $_tax_type;?>)</option>
                                       <?php } ?>
                                     </select>
                                         </div>
                                         </td>
                                       <td align="right" style="padding: 0px !important;margin: 0px !important;"><div class="form-group">
                                           <input type="text" style="text-align:right" readonly="" name="vat_total" value="0" class="vat_total form-control">
                                         </div></td>
                                     </tr>

                                     <tr>
                                       
                                       <td align="left" style="width: 25%;"></td>
                                       <td style="width: 39%;" align="right">
                                       <?php echo $this->lang->line('xin_acc_subtotal_incVat');?> 
                                         </td>
                                       <td align="right" style="text-align: right;padding-right:  14px !important;">
                                       <?php echo $sc_show;?>
                                       <span class="product_total_inc_vat">0</span>
                                       </td>
                                     </tr>
                                        <tr>
                                       
                                          <td align="left" style="width: 25%;"><div class="form-group">
                                          <?php echo $this->lang->line('xin_acc_tax_type');?>
                                            </div></td>
                                          <td style="width: 39%;"><div class="form-group">
                                          <select class="form-control tax_type_total" name="tax_type_total" id="tax_type_total">
                                          <?php foreach($all_taxes as $_tax){?>
                                          <?php
                                              if($_tax->type=='percentage') {
                                                $_tax_type = $_tax->rate.'%';
                                              } else {
                                                $_tax_type = $this->Xin_model->currency_sign($_tax->rate);
                                              }
                                            ?>
                                          <option tax-type="<?php echo $_tax->type;?>" tax-rate="<?php echo $_tax->rate;?>" value="<?php echo $_tax->tax_id;?>"> <?php echo $_tax->name;?> (<?php echo $_tax_type;?>)</option>
                                          <?php } ?>
                                        </select>
                                            </div>
                                            </td>
                                          <td align="right" style="padding: 0px !important;margin: 0px !important;"><div class="form-group">
                                              <input type="text" style="text-align:right" readonly="" name="tax_total" value="0" class="tax_total form-control">
                                            </div></td>
                                        </tr>
                                       
                                      </tbody>
                                    </table></td>
                                </tr>
                                <tr>
                                  <td><?php echo $this->lang->line('xin_acc_subtotal');?></td>
                                  <td class="text-xs-right" style="text-align: right;padding-right:  14px !important;"><?php echo $sc_show;?> <span class="sub_total">0</span></td>
                                </tr>
                                <!-- <tr>
                                  <td><?php echo $this->lang->line('xin_acc_tax_item');?></td>
                                  <td class="text-xs-right" style="text-align: right;padding-right: 20px !important;"><?php echo $sc_show;?> <span class="tax_total">0</span></td>
                                </tr> -->
                                <tr>
                                  <td colspan="2" style="border-bottom:1px solid #dddddd; padding:0px !important; text-align:left">
                                   
                                   <table class="table table-bordered">
                                      <tbody>
                                        
                                        <tr>
                                          <td width="30%" style="border-bottom:1px solid #dddddd; text-align:left"><strong><?php echo $this->lang->line('xin_acc_discount_type');?></strong></td>
                                          <td style="border-bottom:1px solid #dddddd; text-align:center"><strong><?php echo $this->lang->line('xin_acc_discount');?></strong></td>
                                          <td style="border-bottom:1px solid #dddddd; text-align:left"><strong><?php echo $this->lang->line('xin_acc_discount_amount');?></strong></td>
                                        </tr>
                                        <tr>
                                          <td><div class="form-group">
                                              <select name="discount_type" class="form-control discount_type">
                                                <option value="1"> <?php echo $this->lang->line('xin_acc_flat');?></option>
                                                <option value="2"> <?php echo $this->lang->line('xin_acc_percent');?></option>
                                              </select>
                                            </div></td>
                                          <td align="right"><div class="form-group">
                                              <input style="text-align:right" type="text" name="discount_figure" class="form-control discount_figure" value="0" data-valid-num="required">
                                            </div></td>
                                          <td align="right" style="padding: 0px !important;margin: 0px !important;"><div class="form-group">
                                              <input type="text" style="text-align:right" readonly="" name="discount_amount" value="0" class="discount_amount form-control">
                                            </div></td>
                                        </tr>
                                      </tbody>
                                    </table></td>
                                </tr>
                              <input type="hidden" class="fgrand_total" name="fgrand_total" value="0" />
                              <tr>
                                <td><?php echo $this->lang->line('xin_acc_grand_total');?></td>
                                <td class="text-xs-right" style="text-align: right;padding-right: 15px !important;"><?php echo $sc_show;?> <span class="grand_total">0</span></td>
                              </tr>
                                </tbody>
                              
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-xs-12 mb-2 file-repeaters"> </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <label for="purchase_note"><?php echo $this->lang->line('xin_acc_purchase_note');?></label>
                          <textarea name="purchase_note" class="form-control"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="invoice-footer">
                  <div class="row">
                    <div class="col-md-7 col-sm-12"> &nbsp; </div>
                    <div class="col-md-5 col-sm-12 text-xs-center">
                      <button type="submit" name="invoice_submit" class="btn btn-primary pull-right my-1" style="margin-right: 5px;"><i class="fa fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_acc_submit');?></button>
                    </div>
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
