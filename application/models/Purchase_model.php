<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_purchases()
	{
	  return $this->db->get("xin_hrsale_purchases");
	}
	public function get_purchases_order_no()
	{
		$this->db->select('*');
		$this->db->from('xin_hrsale_purchases');
		$this->db->order_by('purchase_id','desc');
		$this->db->limit(1);
		$query = $this->db->get();
	  if ($query->num_rows() == 1) {
			$result=$query->result();
			return $result[0]->purchase_id;
		} else {
			return null;
		}
	}	 
	 public function read_purchase_info($id) {
	
		$condition = "purchase_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_hrsale_purchases');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_purchase_items_info($id) {
	
		$condition = "purchase_item_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_hrsale_purchase_items');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return null;
		}
	}
		
	public function get_purchase_items($id) {
	 	
		$sql = 'SELECT * FROM xin_hrsale_purchase_items WHERE purchase_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds); 
		
  	     return $query->result();
	}	
	
	// Function to add record in table
	public function add_purchase_record($data){
		$this->db->insert('xin_hrsale_purchases', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_purchase_items_record($data){
		$this->db->insert('xin_hrsale_purchase_items', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
		
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('purchase_id', $id);
		$this->db->delete('xin_hrsale_purchases');
		
	}
	
	// Function to Delete selected record from table
	public function delete_purchase_items($id){
		$this->db->where('purchase_id', $id);
		$this->db->delete('xin_hrsale_purchase_items');
		
	}
	
	// Function to Delete selected record from table
	public function delete_purchase_items_record($id){
		$this->db->where('purchase_item_id', $id);
		$this->db->delete('xin_hrsale_purchase_items');
		
	}
		
	// Function to update record in table
	public function update_purchase_record($data, $id){
		$this->db->where('purchase_id', $id);
		if( $this->db->update('xin_hrsale_purchases',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_purchase_items_record($data, $id){
		$this->db->where('purchase_item_id', $id);
		if( $this->db->update('xin_hrsale_purchase_items',$data)) {
			return true;
		} else {
			return false;
		}		
	}

	// Function to update record in table
	public function update_purchase_items_record_by_item($data, $id, $purchase_id){
		$this->db->where('item_id', $id);
		$this->db->where('purchase_id', $purchase_id);
		if( $this->db->update('xin_hrsale_purchase_items',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>