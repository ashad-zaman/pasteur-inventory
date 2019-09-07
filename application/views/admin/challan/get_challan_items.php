<script type="text/javascript">
$(document).ready(function(){		
    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	    });
</script>

<div class="row item-row">
  <hr>
  <div class="form-group mb-1 col-sm-12 col-md-4">
    <label for="item_name"><?php echo $this->lang->line('xin_acc_item');?></label>
    <br>
    <select class="form-control item_name" name="item_name[]" id="item_name" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select');?>">
      <option value=""></option>
      <?php foreach($all_items as $_item) {?>
        <option value="<?php echo $_item->product_id?>" item-attribute="<?php echo $_item->product_id?>|<?php echo $_item->product_serial_number?>|<?php echo $_item->capacity?>|<?php echo $_item->remarks?>" item-price="<?php echo $_item->retail_price?>"><?php echo $_item->product_serial_number.'-'.$_item->product_name.'-'.$_item->capacity?></option>
      
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
  <div class="form-group mb-1 col-sm-12 col-md-2">
    <label for="code" class="cursor-pointer"><?php echo $this->lang->line('xin_acc_code');?></label>
    <br>
    <input type="text" class="form-control code" name="code[]" id="code" value="">
  </div>

  <div class="form-group mb-1 col-sm-12 col-md-2">
    <label for="capacity" class="cursor-pointer"><?php echo $this->lang->line('xin_acc_item_capacity');?></label>
    <br>
    <input type="text" class="form-control capacity" name="capacity[]" id="capacity" value="">
  </div>
  <div class="form-group mb-1 col-sm-12 col-md-2">
    <label for="remarks" class="cursor-pointer"><?php echo $this->lang->line('xin_acc_remarks');?></label>
    <br>
    <input type="text" class="form-control remarks" name="remarks[]" id="remarks" value="">
  </div>
  <div class="form-group mb-2 col-sm-12 col-md-1">
    <label for="qty_hrs" class="cursor-pointer"><?php echo $this->lang->line('xin_acc_item_qtyhrs');?></label>
    <br>
    <input type="text" class="form-control qty_hrs" name="qty_hrs[]" id="qty_hrs" value="1">
  </div>
  <!-- <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-2">
    <label for="unit_price"><?php echo $this->lang->line('xin_acc_unit_price');?></label>
    <br>
    <input class="form-control unit_price" type="text" name="unit_price[]" value="0" id="unit_price" />
  </div>
  <div class="form-group mb-1 col-sm-12 col-md-2">
    <label for="profession"><?php echo $this->lang->line('xin_acc_subtotal');?></label>
    <input type="text" class="form-control sub-total-item" readonly="readonly" name="sub_total_item[]" value="0" />
    <p style="display:none" class="form-control-static"><span class="amount-html">0</span></p>
  </div> -->
  <div class="form-group col-sm-12 col-md-1 text-xs-center mt-2">
    <label for="profession">&nbsp;</label>
    <br>
    <button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light remove-invoice-item" data-repeater-delete=""> <span class="fa fa-trash"></span></button>
  </div>
</div>
