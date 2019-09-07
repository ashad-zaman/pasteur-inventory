<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_products() {
	  return $this->db->get("xin_catalog_products");
	}
	 	 
	public function get_taxes() {
	  return $this->db->get("xin_product_taxes");
	}
	
	public function get_product_categories() {
	  return $this->db->get("xin_product_categories");
	}
	
	// get product info by id
	public function read_product_information($id) {
	
		$condition = "product_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_catalog_products');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	// get product > out of stock
	public function out_of_stock_products() {
	
		$this->db->select('*');
		$this->db->from('xin_catalog_products');
		$this->db->where('product_qty',0);
		$query = $this->db->get();
		return $query;
	}
	
	// get expired products
	public function expired_products() {
	
		$query = $this->db->query("SELECT * from xin_catalog_products where expiration_date <=CURDATE()");
		return $query;
	}
	
	// get product info by sku
	public function read_product_sku_info($id) {
	
		$condition = "product_sku =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_catalog_products');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query;
	}
	
	public function read_tax_information($id) {
	
		$condition = "tax_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_product_taxes');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	// get all product categories
	public function get_categories() {
	  $query = $this->db->query("SELECT * from xin_product_categories");
  	  return $query->result();
	}
	 
	 // get single category
	 public function read_category_info($id) {
	
		$condition = "category_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_product_categories');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_catalog_products', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_tax_record($data){
		$this->db->insert('xin_product_taxes', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_category_record($data){
		$this->db->insert('xin_product_categories', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// get all product taxes
	public function get_all_taxes() {
	  $query = $this->db->query("SELECT * from xin_product_taxes");
  	  return $query->result();
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('product_id', $id);
		$this->db->delete('xin_catalog_products');
		
	}
	
	// Function to Delete selected record from table
	public function delete_tax_record($id){
		$this->db->where('tax_id', $id);
		$this->db->delete('xin_product_taxes');
		
	}
	
	// Function to Delete selected record from table
	public function delete_category_record($id){
		$this->db->where('category_id', $id);
		$this->db->delete('xin_product_categories');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('product_id', $id);
		if( $this->db->update('xin_catalog_products',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_tax_record($data, $id){
		$this->db->where('tax_id', $id);
		if( $this->db->update('xin_product_taxes',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table > by sku
	public function update_by_sku($data, $sku){
		$this->db->where('product_sku', $sku);
		if( $this->db->update('xin_catalog_products',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_category_record($data, $id){
		$this->db->where('category_id', $id);
		if( $this->db->update('xin_product_categories',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record without logo > in table
	public function update_record_no_logo($data, $id){
		$this->db->where('product_id', $id);
		if( $this->db->update('xin_catalog_products',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// get all product  > qty>0
	public function product_for_purchase_invoice(){
	  $query = $this->db->query("SELECT * from xin_catalog_products where product_qty > 0");
  	  return $query->result();
	}
}
?>