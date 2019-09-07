<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function initialize_elfinder($value=''){
	$CI =& get_instance();
	$CI->load->helper('path');
	$opts = array(
	    //'debug' => true, 
	    'roots' => array(
	      array( 
	        'driver' => 'LocalFileSystem', 
	        'path'   => './uploads/files_manager/', 
	        'URL'    => site_url('uploads/files_manager').'/'
	        // more elFinder options here
	      ) 
	    )
	);
	return $opts;
}
if ( ! function_exists('system_settings_info'))
{
		function system_settings_info($id) {
			$CI =&	get_instance();
			$CI->db->from('xin_system_setting');
			$CI->db->where('setting_id',$id);
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}else{
			return "";
		}
	}

}
if ( ! function_exists('xin_company_info'))
{
		function xin_company_info($id) {
			$CI =&	get_instance();
			$CI->db->from('xin_company_info');
			$CI->db->where('company_info_id',$id);
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}else{
			return "";
		}
	}

}
if ( ! function_exists('read_invoice_record'))
{
		function read_invoice_record($id) {
			$CI =&	get_instance();
			$CI->db->from('xin_hrsale_invoices');
			$CI->db->where('invoice_id',$id);
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}else{
			return "";
		}
	}
}
if ( ! function_exists('get_invoice_transaction_record'))
{
	function get_invoice_transaction_record($id) {
		$CI =&	get_instance();
		$CI->db->from('xin_finance_transaction');
		$CI->db->where('transaction_type','income');
		$CI->db->where('invoice_id',$id);
		$query=$CI->db->get();
		return $query;
	}
}
if ( ! function_exists('system_currency_sign'))
{
	//set currency sign
	function system_currency_sign($number) {
		
		// get details
		$system_setting = system_settings_info(1);
		// currency code/symbol
		if($system_setting->show_currency=='code'){
			$ar_sc = explode(' -',$system_setting->default_currency_symbol);
			$sc_show = $ar_sc[0];
		} else {
			$ar_sc = explode('- ',$system_setting->default_currency_symbol);
			$sc_show = $ar_sc[1];
		}
		if($system_setting->currency_position=='Prefix'){
			$sign_value = $sc_show.''.$number;
		} else {
			$sign_value = $number.''.$sc_show;
		}
		return $sign_value;
	}
}
if ( ! function_exists('customer_invoices'))
{
	function customer_invoices($customer_id) {
			$CI =&	get_instance();
			$CI->db->from('xin_hrsale_invoices');
			$CI->db->where('customer_id',$customer_id);
			$CI->db->order_by('invoice_id','desc');
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
	}

}
if ( ! function_exists('customer_total_invoices'))
{
	function customer_total_invoices($customer_id) {
			$CI =&	get_instance();
			$CI->db->from('xin_hrsale_invoices');
			$CI->db->where('customer_id',$customer_id);
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return "";
		}
	}

}
if ( ! function_exists('delete_transaction_purchase_data'))
{
	function delete_transaction_purchase_data($id) {
		$CI =&	get_instance();
		$CI->db->where('transaction_type','purchases');
		$CI->db->where('invoice_id',$id);
		$CI->db->delete('xin_finance_transaction');
	}
}
if ( ! function_exists('delete_sales_transaction_data'))
{
	function delete_sales_transaction_data($id) {
		$CI =&	get_instance();
		$CI->db->where('transaction_type','income');
		$CI->db->where('invoice_id',$id);
		$CI->db->delete('xin_finance_transaction');
	}
}
if ( ! function_exists('delete_expense_transaction_data'))
{
	function delete_expense_transaction_data($id) {
		$CI =&	get_instance();
		$CI->db->where('transaction_type','expense');
		$CI->db->where('invoice_id',$id);
		$CI->db->delete('xin_finance_transaction');
	}
}
if ( ! function_exists('customer_transactions'))
{
	function customer_transactions($customer_id) {
			$CI =&	get_instance();
			$sql = "SELECT transaction_date,dr_cr,amount,account_id,payment_method_id,reference,transaction_type,description,IF(dr_cr='dr',amount,NULL) as debit,IF(dr_cr='cr',amount,NULL) as credit FROM xin_finance_transaction where payer_payee_id = ?";
			$binds = array($customer_id);
			$query = $CI->db->query($sql, $binds);
			$result = $query->result();
			return $result;
	}

}
?>