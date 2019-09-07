function update_total() { 
	var product_total = 0;
	var sub_total = 0;
	var st_tax = 0;
	var grand_total = 0;
	var gdTotal = 0;
	var rdiscount = 0;
	
	i = 1;	


	$('.sub-total-item').each(function(i) {
        var total = $(this).val();
		
		total = parseFloat(total);
		product_total= total+product_total;
		//sub_total = total+sub_total;
    });
	// $('.tax-rate-item').each(function(i) {
    //     var tax_rate = $(this).val();
		
	// 	tax_rate = parseFloat(tax_rate);
		
	// 	st_tax = tax_rate+st_tax;
    // });
	// $('.tax_total').html(st_tax.toFixed(2));
	$('.product_total').html(product_total.toFixed(2));
	$('.product-total-amount').val(product_total.toFixed(2));
	
	var item_sub_total = product_total;
	


	var total_vat = $('.vat_total').val();
	var total_tax = $('.tax_total').val();
	
	var product_total_inc_vat=parseFloat(product_total)+parseFloat(total_vat);

	$('.product_total_inc_vat').html(product_total_inc_vat.toFixed(2));
	$('.product-total-amount-inc-vat').val(product_total_inc_vat.toFixed(2));
	sub_total=parseFloat(product_total_inc_vat)+parseFloat(total_tax);
	//alert(product_total_inc_vat+"="+total_tax+"="+sub_total);
	$('.sub_total').html(sub_total.toFixed(2));


	var discount_figure = $('.discount_figure').val();
	//var fsub_total = item_sub_total - discount_figure;
	//$('.items-tax-total').val(st_tax.toFixed(2));
	$('.items-sub-total').val(sub_total.toFixed(2));
	
	//var discount_type = $('.discount_type').val(); 
	//var sub_total = $('.items-sub-total').val();

	 if($('.discount_type').val() == '1'){
		 var fsub_total = sub_total - discount_figure;
		  //var discount_amval = discount_figure;//.toFixed(2);
		  $('.discount_amount').val(discount_figure);
		  //$('.grand_total').html(grand_total.toFixed(2));	 
	 } else {
		 var discount_percent = sub_total / 100 * discount_figure;
		 var fsub_total = sub_total - discount_percent;
		// var discount_amval = discount_percent.toFixed(2);
		$('.discount_amount').val(discount_percent.toFixed(2));
		 //$('.grand_total').html(grand_total.toFixed(2));	 
	 }
	 
	$('.fgrand_total').val(fsub_total.toFixed(2));
	$('.grand_total').html(fsub_total.toFixed(2));
	
	}//Update total function ends here.

	

	jQuery(document).on('click','.remove-invoice-item', function () {
        $(this).closest('.item-row').fadeOut(300, function() {
            $(this).remove();
			update_total();
			generateVat();
			update_total();
			generateTax();
			update_total();
        });
    });	
	
	jQuery(document).on('click','.eremove-item', function () {
        var record_id = $(this).data('record-id');
		var invoice_id = $(this).data('invoice-id');
		$(this).closest('.item-row').fadeOut(300, function() {
			jQuery.get(base_url+"/delete_item/"+record_id+"/isajax/", function(data, status){
			});
			$(this).remove();
			update_total();
			generateVat();
			update_total();
			generateTax();
			update_total();
		});
	});
	
  // for qty
 jQuery(document).on('click keyup change','.qty_hrs,.unit_price',function() {
	 var qty = 0;
	 var unit_price = 0;
	 var tax_rate = 0;
	 var qty = $(this).closest('.item-row').find('.qty_hrs').val();
	 var unit_price = $(this).closest('.item-row').find('.unit_price').val();
	 var tax_rate = $(this).closest('.item-row').find('.tax_type').val();
	 var element = $(this).closest('.item-row').find('.tax_type').find('option:selected'); 
	 var tax_type = element.attr("tax-type"); 
	 var tax_rate = element.attr("tax-rate");
	 if(qty == ''){
		 var qty = 0;
	 } if(unit_price == ''){
		 var unit_price = 0;
	 } if(tax_rate == ''){
		 var tax_rate = 0;
	 }
	 // calculation
	 var sbT = (qty * unit_price);
	 if(tax_type==='fixed'){
		var taxPP = 1 / 1 * tax_rate;
		var singleTax = taxPP;
		//var subTotal = sbT + taxPP;
		var subTotal = sbT ;
		var sub_total = subTotal.toFixed(2);
		
		
	 } else {
		var taxPP = sbT / 100 * tax_rate;
		var singleTax = taxPP;
	//	var subTotal = sbT + taxPP;
		var subTotal = sbT ;
		var sub_total = subTotal.toFixed(2);
	 }	 
	jQuery(this).closest('.item-row').find('.sub-total-item').val(sub_total); 
	jQuery(this).closest('.item-row').find('.sub-total-item').val(sub_total);
	update_total();
	generateVat();
	update_total();
	generateTax();
	update_total();
});
jQuery(document).on('change click','.tax_type', function () {
	var qty = 0;
	 var unit_price = 0;
	 var tax_rate = 0;
	 var qty = $(this).closest('.item-row').find('.qty_hrs').val();
	 var unit_price = $(this).closest('.item-row').find('.unit_price').val();
	 var tax_rate = $(this).closest('.item-row').find('.tax_type').val();
	 var element = $(this).closest('.item-row').find('.tax_type').find('option:selected'); 
	 var tax_type = element.attr("tax-type"); 
	 var tax_rate = element.attr("tax-rate");
	 if(qty == ''){
		 var qty = 0;
	 } if(unit_price == ''){
		 var unit_price = 0;
	 } if(tax_rate == ''){
		 var tax_rate = 0;
	 }
	 // calculation
	 var sbT = (qty * unit_price);
	 if(tax_type==='fixed'){
		var taxPP = 1 / 1 * tax_rate;
		var singleTax = taxPP;
		var subTotal = sbT + taxPP;
		var sub_total = subTotal.toFixed(2);
		jQuery(this).closest('.item-row').find('.tax-rate-item').val(singleTax);
		jQuery(this).closest('.item-row').find('.sub-total-item').val(sub_total);
		update_total();
	 } else {
		var taxPP = sbT / 100 * tax_rate;
		var singleTax = taxPP;
		var subTotal = sbT + taxPP;
		var sub_total = subTotal.toFixed(2);
		jQuery(this).closest('.item-row').find('.tax-rate-item').val(singleTax);
		jQuery(this).closest('.item-row').find('.sub-total-item').val(sub_total);
		update_total();
	 }
	 jQuery(this).closest('.item-row').find('.sub-total-item').val(sub_total); 
	update_total();
});

jQuery(document).on('change','.tax_type_total', function () {
	var qty = 0;
	 var unit_price = 0;
	 var tax_rate = 0;
	//  var qty = $(this).closest('.item-row').find('.qty_hrs').val();
	//  var unit_price = $(this).closest('.item-row').find('.unit_price').val();
	 var product_total=$('.product_total_inc_vat').text();
	// alert(product_total)
	 var tax_rate = $(this).closest('.form-group').find('.tax_type_total').val();
	 var element = $(this).closest('.form-group').find('.tax_type_total').find('option:selected'); 
	 var tax_type = element.attr("tax-type"); 
	 var tax_rate = element.attr("tax-rate");
	
	// alert("tax_type:"+tax_type+"=tax_rate:"+tax_rate);
	 if(tax_rate == ''){
		 var tax_rate = 0;
	 }
	 // calculation
	 var sbT =parseFloat(product_total);
	 if(tax_type==='fixed'){
		var taxPP = 1 / 1 * tax_rate;
		var singleTax = taxPP.toFixed(2);
		var subTotal = sbT + taxPP;
		var sub_total = subTotal.toFixed(2);
		
		
		$('.tax_total').val(taxPP.toFixed(2));
		$('.sub_total').html(sub_total);
		update_total();
	 } else {
		var taxPP = sbT / 100 * tax_rate;
		var singleTax = taxPP.toFixed(2);
		var subTotal = sbT + taxPP;
		var sub_total = subTotal.toFixed(2);
		//alert(singleTax)
		//alert(sub_total)
	
		$('.tax_total').val(taxPP.toFixed(2));
		
		$('.sub_total').html(sub_total);
		update_total();
	 }
	$('.sub_total').html(sub_total);
	update_total();
});

jQuery(document).on('change','.vat_type_total', function () {
	
	 var tax_rate = 0;

	 var product_total=$('.product_total').text();
	
	 var tax_rate = $(this).closest('.form-group').find('.vat_type_total').val();
	 var element = $(this).closest('.form-group').find('.vat_type_total').find('option:selected'); 
	 var tax_type = element.attr("tax-type"); 
	 var tax_rate = element.attr("tax-rate");
	
	// alert("tax_type:"+tax_type+"=tax_rate:"+tax_rate);
	 if(tax_rate == ''){
		 var tax_rate = 0;
	 }
	 // calculation
	 var sbT =parseFloat(product_total);
	 if(tax_type==='fixed'){
		var taxPP = 1 / 1 * tax_rate;
		var singleTax = taxPP.toFixed(2);
		var subTotal = sbT + taxPP;
		var sub_total = subTotal.toFixed(2);
		
		
		$('.vat_total').val(taxPP.toFixed(2));
		$('.product_total_inc_vat').html(sub_total);
		update_total();
	 } else {
		var taxPP = sbT / 100 * tax_rate;
		var singleTax = taxPP.toFixed(2);
		var subTotal = sbT + taxPP;
		var sub_total = subTotal.toFixed(2);
		//alert(singleTax)
		//alert(sub_total)
	
		$('.vat_total').val(taxPP.toFixed(2));
		
		$('.product_total_inc_vat').html(sub_total);
		update_total();
	 }
	$('.product_total_inc_vat').html(sub_total);
	update_total();
});

jQuery(document).on('click keyup change','.discount_figure',function() {
	 var qty = 0;
	 var unit_price = 0;
	 var tax_rate = 0;
	 var discount_figure = $('.discount_figure').val();
	 var discount_type = $('.discount_type').val(); 
	 var sub_total = $('.items-sub-total').val();

	if(parseFloat(discount_figure) <= parseFloat(sub_total)) {
	 if($('.discount_type').val() == '1'){
		 var grand_total = sub_total - discount_figure;
		  var discount_amval = discount_figure;//.toFixed(2);
		  $('.discount_amount').val(discount_amval);
		  $('.grand_total').html(grand_total.toFixed(2));	 
	 } else {
		 var discount_percent = sub_total / 100 * discount_figure;
		 var grand_total = sub_total - discount_percent;
		 var discount_amval = discount_percent.toFixed(2);
		 $('.discount_amount').val(discount_amval);
		 $('.grand_total').html(grand_total.toFixed(2));	 
	 }
	} else {
		//
		$('.discount_amount').val(0);
		$('.discount_figure').val(0)
	//	var grand_total = sub_total;
		$('.grand_total').html(sub_total);
		alert('Discount price should be less than Sub Total.');
	}
	update_total();
});

jQuery(document).on('change click','.discount_type',function() {
	 var qty = 0;
	 var unit_price = 0;
	 var tax_rate = 0;
	 var discount_figure = $('.discount_figure').val();
	 var discount_type = $('.discount_type').val(); 
	 var sub_total = $('.items-sub-total').val();

	 if($('.discount_type').val() == '1'){
		 var grand_total = sub_total - discount_figure;
		  var discount_amval = discount_figure;//.toFixed(2);
		  $('.discount_amount').val(discount_amval);
		  $('.grand_total').html(grand_total.toFixed(2));	 
	 } else {
		 var discount_percent = sub_total / 100 * discount_figure;
		 var grand_total = sub_total - discount_percent;
		 var discount_amval = discount_percent.toFixed(2);
		 $('.discount_amount').val(discount_amval);
		 $('.grand_total').html(grand_total.toFixed(2));	 
	 }
	 
	 
	 
	//jQuery(this).closest('.item-row').find('.sub-total-item').val(sub_total); 
	//jQuery(this).closest('.item-row').find('.amount-html').html(sub_total);
	update_total();
});

jQuery(document).on('change click','.item_name', function () {
	var qty = 0;
	 var item_price = 0;
	 var tax_rate = 0;
	 var element = $(this).closest('.item-row').find('.item_name').find('option:selected');
	 var item_price = element.attr("item-price");

	 var value=element.attr("item-attribute");
	 var value_array=value.split('|');
	 var code=value_array[1];
	 var capacity=value_array[2];
	 var remarks=value_array[3];

	 jQuery(this).closest('.item-row').find('.code').val(code);
	 jQuery(this).closest('.item-row').find('.capacity').val(capacity);
	 jQuery(this).closest('.item-row').find('.remarks').val(remarks);

	 jQuery(this).closest('.item-row').find('.unit_price').val(item_price);
	 jQuery(this).closest('.item-row').find('.sub-total-item').val(item_price);
	 update_total();
	 generateVat();
	 update_total();
	 generateTax();
	 update_total();
});

function generateVat(){
	var tax_rate = 0;
	var product_total=$('.product_total').text();

 var tax_rate = $('.vat_type_total').val();
 var element = $('.vat_type_total').find('option:selected'); 
 var tax_type = element.attr("tax-type"); 
 var tax_rate = element.attr("tax-rate");

//alert("tax_type:"+tax_type+"=tax_rate:"+tax_rate);
 if(tax_rate == ''){
	 var tax_rate = 0;
 }
 // calculation
 var sbT =parseFloat(product_total);
 if(tax_type==='fixed'){
	var taxPP = 1 / 1 * tax_rate;
	var singleTax = taxPP.toFixed(2);
	var subTotal = sbT + taxPP;
	var sub_total = subTotal.toFixed(2);
	
	
	$('.vat_total').val(taxPP.toFixed(2));
	
 } else {
	var taxPP = sbT / 100 * tax_rate;
	var singleTax = taxPP.toFixed(2);
	var subTotal = sbT + taxPP;
	var sub_total = subTotal.toFixed(2);
	//alert(singleTax)
	

	$('.vat_total').val(taxPP.toFixed(2));
	
}

}
function generateTax()
{
	
	
	 var tax_rate = 0;
	
	 var product_total=$('.product_total_inc_vat').text();
	// alert(product_total)
	 var tax_rate = $('.tax_type_total').val();
	 var element = $('.tax_type_total').find('option:selected'); 
	 var tax_type = element.attr("tax-type"); 
	 var tax_rate = element.attr("tax-rate");
	
	//alert("tax_type:"+tax_type+"=tax_rate:"+tax_rate);
	 if(tax_rate == ''){
		 var tax_rate = 0;
	 }
	 // calculation
	 var sbT =parseFloat(product_total);
	 if(tax_type==='fixed'){
		var taxPP = 1 / 1 * tax_rate;
		
		
		//alert(taxPP)
		$('.tax_total').val(taxPP.toFixed(2));
		
	 } else {
		var taxPP = sbT / 100 * tax_rate;
		
		//alert(taxPP)
		$('.tax_total').val(taxPP.toFixed(2));
	 }
}
function getAddress(company_id) 
	{
			//alert("company_id=>"+company_id);
			jQuery.get(base_url+"/get_company_address?company_id="+company_id, function(data, status){
				
				$('#customer_id_list').html('');
				$('#customer_id_list').append(data).fadeIn(500);
				
			}).then(function(){

				jQuery.get(base_url+"/get_quation_number?company_id="+company_id, function(data, status){
				
					$('#quote_number').val(data);
					
				});	
			});
			
			
			
	}
$(document).ready(function(){	
						
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 

	
	

	/* Add data */
	$("#xin-form").submit(function(e){
		
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=challan_create&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('.save').prop('disabled', false);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					window.location = site_url+'challan/';
				}
			}
		});
	});
	// Date
	$('.date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat:'yy-mm-dd',
		yearRange: '1980:' + (new Date().getFullYear() + 10),
		beforeShow: function(input) {
			$(input).datepicker("widget").show();
		}
	});
		
	}); // jquery load
	