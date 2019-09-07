<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
class Warehouses_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_warehouses_list() {
	  return $this->db->get("xin_warehouses");
	}
	
	// get all warehouse
	public function get_warehouses(){
	  $query = $this->db->query("SELECT * from xin_warehouses");
  	  return $query->result();
	}
	 
	 // get single warehouse record
	 public function read_warehouse_info($id) {
	
		$condition = "warehouse_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_warehouses');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		return $query->result();
	}	
	
	 // get warehouse products qty
	 public function get_warehouse_products($id) {
	
		$condition = "warehouse_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_catalog_products');
		$this->db->where($condition);
		$query = $this->db->get();
		$rowTotal = $query->num_rows();
		
		return $rowTotal;
	}
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_warehouses', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('warehouse_id', $id);
		$this->db->delete('xin_warehouses');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('warehouse_id', $id);
		if( $this->db->update('xin_warehouses',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>