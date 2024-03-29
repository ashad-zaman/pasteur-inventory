<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_invoices()
	{
	  return $this->db->get("xin_hrsale_invoices");
	}
	
	public function get_taxes() {
	  return $this->db->get("xin_tax_types");
	}
	public function get_invoice_order_no(){
		$this->db->select('*');
		$this->db->from('xin_hrsale_invoices');
		$this->db->order_by('invoice_id','desc');
		$this->db->limit(1);
		$query = $this->db->get();
	  if ($query->num_rows() == 1) {
			$result=$query->result();
			return $result[0]->invoice_id;
		} else {
			return null;
		}
	}	 
	 public function read_invoice_info($id) {
	
		$condition = "invoice_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_hrsale_invoices');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function client_email_for_invoice($invoice_id){
	   //$CI= & get_instance();
	   $query = $this->db->query("SELECT email FROM xin_hrsale_invoices,xin_customers WHERE xin_hrsale_invoices.customer_id=xin_customers.customer_id AND xin_hrsale_invoices.invoice_id='$invoice_id'")->row()->email;
	   return $query;
 }
	
	public function read_invoice_items_info($id) {
	
		$condition = "invoice_item_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_hrsale_invoices_items');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_tax_information($id) {
	
		$condition = "tax_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_tax_types');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function get_invoice_items($id) {
	 	
		$sql = 'SELECT * FROM xin_hrsale_invoices_items WHERE invoice_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds); 
		
  	     return $query->result();
	}	
	
	// Function to add record in table
	public function add_invoice_record($data){
		$this->db->insert('xin_hrsale_invoices', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_invoice_items_record($data){
		$this->db->insert('xin_hrsale_invoices_items', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_tax_record($data){
		$this->db->insert('xin_tax_types', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to update record in table
	public function update_tax_record($data, $id){
		$this->db->where('tax_id', $id);
		if( $this->db->update('xin_tax_types',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('invoice_id', $id);
		$this->db->delete('xin_hrsale_invoices');
		
	}
	
	// Function to Delete selected record from table
	public function delete_invoice_items($id){
		$this->db->where('invoice_id', $id);
		$this->db->delete('xin_hrsale_invoices_items');
		
	}
	
	// Function to Delete selected record from table
	public function delete_invoice_items_record($id){
		$this->db->where('invoice_item_id', $id);
		$this->db->delete('xin_hrsale_invoices_items');
		
	}
	
	// Function to Delete selected record from table
	public function delete_tax_record($id){
		$this->db->where('tax_id', $id);
		$this->db->delete('xin_tax_types');
		
	}
	
	// Function to update record in table
	public function update_invoice_record($data, $id){
		$this->db->where('invoice_id', $id);
		if( $this->db->update('xin_hrsale_invoices',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_invoice_items_record($data, $id){
		$this->db->where('invoice_item_id', $id);
		if( $this->db->update('xin_hrsale_invoices_items',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>