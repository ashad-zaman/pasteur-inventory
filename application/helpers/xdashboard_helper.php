<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('dashboard_total_sales'))
{
	function dashboard_total_sales() {
			$CI =&	get_instance();
			$CI->db->from('xin_finance_transaction');
			$CI->db->where('transaction_type','income');
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->amount;
			}
			return $tinc;
		}else{
			return 0;
		}
	}

}
if ( ! function_exists('dashboard_total_expense'))
{
	function dashboard_total_expense() {
			$CI =&	get_instance();
			$CI->db->from('xin_finance_transaction');
			$CI->db->where('transaction_type','expense');
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$texp = 0;
			foreach($result as $exp){
				$texp += $exp->amount;
			}
			return $texp;
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('dashboard_total_purchase'))
{
	function dashboard_total_purchase() {
			$CI =&	get_instance();
			$CI->db->from('xin_finance_transaction');
			$CI->db->where('transaction_type','purchases');
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$texp = 0;
			foreach($result as $exp){
				$texp += $exp->amount;
			}
			return $texp;
		}else{
			return 0;
		}
	}
}
if ( ! function_exists('dashboard_total_customers'))
{
	function dashboard_total_customers() {
		$CI =&	get_instance();
		$CI->db->from("xin_customers");
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('dashboard_total_suppliers'))
{
	function dashboard_total_suppliers() {
		$CI =&	get_instance();
		$CI->db->from("xin_suppliers");
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('dashboard_total_products'))
{
	function dashboard_total_products() {
		$CI =&	get_instance();
		$CI->db->from("xin_catalog_products");
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('dashboard_total_invoices'))
{
	function dashboard_total_invoices() {
		$CI =&	get_instance();
		$CI->db->from("xin_hrsale_invoices");
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('dashboard_total_warehouses'))
{
	function dashboard_total_warehouses() {
		$CI =&	get_instance();
		$CI->db->from("xin_warehouses");
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('dashboard_last_four_purchase'))
{
	function dashboard_last_four_purchase() {
			$CI =&	get_instance();
			$CI->db->from('xin_finance_transaction');
			$CI->db->where('transaction_type','purchases');
			$CI->db->order_by('transaction_id','desc');
			$CI->db->limit(4);
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
if ( ! function_exists('dashboard_last_four_expense'))
{
	function dashboard_last_four_expense() {
			$CI =&	get_instance();
			$CI->db->from('xin_finance_transaction');
			$CI->db->where('transaction_type','expense');
			$CI->db->order_by('transaction_id','desc');
			$CI->db->limit(4);
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
if ( ! function_exists('dashboard_last_two_invoices'))
{
	function dashboard_last_two_invoices() {
			$CI =&	get_instance();
			$CI->db->from('xin_hrsale_invoices');
			$CI->db->order_by('invoice_id','desc');
			$CI->db->limit(2);
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
if ( ! function_exists('dashboard_paid_invoices'))
{
	function dashboard_paid_invoices() {
		$CI =&	get_instance();
		$CI->db->from("xin_hrsale_invoices");
		$CI->db->where('status',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('dashboard_unpaid_invoices'))
{
	function dashboard_unpaid_invoices() {
		$CI =&	get_instance();
		$CI->db->from("xin_hrsale_invoices");
		$CI->db->where('status',0);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('dashboard_cancelled_invoices'))
{
	function dashboard_cancelled_invoices() {
		$CI =&	get_instance();
		$CI->db->from("xin_hrsale_invoices");
		$CI->db->where('status',2);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('dashboard_bankcash'))
{
	function dashboard_bankcash() {
		$CI =&	get_instance();
		$CI->db->from("xin_finance_bankcash");
		$CI->db->order_by('bankcash_id','asc');
		$CI->db->limit(6);
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
?>