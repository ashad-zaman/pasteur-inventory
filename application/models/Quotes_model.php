<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotes_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_quotes()
	{
	  return $this->db->get("xin_hrsale_quotes");
	}

	public function get_quotes_for_company($companyId)
	{
		$condition = "company_id =" . "'" . $companyId . "'";
		$this->db->select('*');
		$this->db->from('xin_hrsale_quotes');
		$this->db->where($condition);
		return $query = $this->db->get();
	 
	}

	public function get_quotes_order_no(){
		$this->db->select('*');
		$this->db->from('xin_hrsale_quotes');
		$this->db->order_by('quote_id','desc');
		$this->db->limit(1);
		$query = $this->db->get();
	  if ($query->num_rows() == 1) {
			$result=$query->result();
			return $result[0]->quote_id;
		} else {
			return null;
		}
	}	 	 
	 public function read_quotes_info($id) {
	
		$condition = "quote_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_hrsale_quotes');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_quote_items_info($id) {
	
		$condition = "quote_item_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_hrsale_quotes_items');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return null;
		}
	}
		
	public function get_quote_items($id) {
	 	
		$sql = 'SELECT * FROM xin_hrsale_quotes_items WHERE quote_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds); 
		
  	     return $query->result();
	}	
	
	// Function to add record in table
	public function add_quote_record($data){
		$this->db->insert('xin_hrsale_quotes', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_quote_items_record($data){
		$this->db->insert('xin_hrsale_quotes_items', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
		
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('quote_id', $id);
		$this->db->delete('xin_hrsale_quotes');
		
	}
	
	// Function to Delete selected record from table
	public function delete_quote_items($id){
		$this->db->where('quote_id', $id);
		$this->db->delete('xin_hrsale_quotes_items');
		
	}
	
	// Function to Delete selected record from table
	public function delete_quote_items_record($id){
		$this->db->where('quote_item_id', $id);
		$this->db->delete('xin_hrsale_quotes_items');
		
	}
		
	// Function to update record in table
	public function update_quote_record($data, $id){
		$this->db->where('quote_id', $id);
		if( $this->db->update('xin_hrsale_quotes',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_quote_items_record($data, $id){
		$this->db->where('quote_item_id', $id);
		if( $this->db->update('xin_hrsale_quotes_items',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>