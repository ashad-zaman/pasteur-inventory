<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	// sales > report	
	public function get_sales_report($start_date,$end_date){
			$sql = "SELECT transaction_date,dr_cr,invoice_id,amount,payment_method_id,payer_payee_id,reference,transaction_type,description,IF(dr_cr='dr',amount,NULL) as debit,IF(dr_cr='cr',amount,NULL) as credit FROM xin_finance_transaction where transaction_type = 'income' and invoice_id>0 and DATE(transaction_date) BETWEEN ? AND ?";
			$binds = array($start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
	}
	// purchases > report	
	public function get_purchases_report($start_date,$end_date){
			$sql = "SELECT transaction_date,dr_cr,invoice_id,amount,payment_method_id,payer_payee_id,reference,transaction_type,description,IF(dr_cr='dr',amount,NULL) as debit,IF(dr_cr='cr',amount,NULL) as credit FROM xin_finance_transaction where transaction_type = 'purchases' and invoice_id>0 and DATE(transaction_date) BETWEEN ? AND ?";
			$binds = array($start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
	}
	
	// today purchases > report	
	public function get_today_purchases_report(){
			$sql = "SELECT transaction_date,dr_cr,invoice_id,amount,payment_method_id,payer_payee_id,reference,transaction_type,description,IF(dr_cr='dr',amount,NULL) as debit,IF(dr_cr='cr',amount,NULL) as credit FROM xin_finance_transaction where transaction_type = 'purchases' and invoice_id>0 and DATE(transaction_date) = CURDATE()";
			$query = $this->db->query($sql);
			return $query;
	}
	// today sales > report	
	public function get_today_sales_report(){
			$sql = "SELECT transaction_date,dr_cr,invoice_id,amount,payment_method_id,payer_payee_id,reference,transaction_type,description,IF(dr_cr='dr',amount,NULL) as debit,IF(dr_cr='cr',amount,NULL) as credit FROM xin_finance_transaction where transaction_type = 'income' and invoice_id>0 and DATE(transaction_date) = CURDATE()";
			$query = $this->db->query($sql);
			return $query;
	}
}
?>