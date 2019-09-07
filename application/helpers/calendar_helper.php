<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('purchase_transaction_record'))
{
	function purchase_transaction_record() {
			$CI =&	get_instance();
			$CI->db->from('xin_finance_transaction');
			$CI->db->where('transaction_type','purchases');
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
if ( ! function_exists('expense_transaction_record'))
{
	function expense_transaction_record() {
			$CI =&	get_instance();
			$CI->db->from('xin_finance_transaction');
			$CI->db->where('transaction_type','expense');
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
if ( ! function_exists('sales_transaction_record'))
{
	function sales_transaction_record() {
			$CI =&	get_instance();
			$CI->db->from('xin_finance_transaction');
			$CI->db->where('transaction_type','income');
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