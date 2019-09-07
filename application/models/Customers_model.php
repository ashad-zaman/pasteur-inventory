<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Customers_model extends CI_Model
	{
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_customers() {
	  return $this->db->get("xin_customers");
	}
		
	public function get_customers_byCompany($company_id) {
		$this->db->where('company_id', $company_id);
	  return $this->db->get("xin_customers");
	}
		


	public function get_all_customers() {
	  $query = $this->db->get("xin_customers");
	  return $query->result();
	}

	public function get_all_customers_bycompany($companyID) {
		
		$this->db->where('company_id', $companyID);
	  $query = $this->db->get("xin_customers");
	  return $query->result();
	}
	 
	public function read_customer_info($id) {
	
		$sql = 'SELECT * FROM xin_customers WHERE customer_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	// Read data using username and password
	public function login($data) {
	
		$sql = 'SELECT * FROM xin_customers WHERE email = ? AND is_active = ?';
		$binds = array($data['username'],1);
		$query = $this->db->query($sql, $binds);		
		
	    $options = array('cost' => 12);
		$password_hash = password_hash($data['password'], PASSWORD_BCRYPT, $options);
		if ($query->num_rows() > 0) {
			$rw_password = $query->result();
			if(password_verify($data['password'],$rw_password[0]->client_password)){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	// get single user > by email
	public function read_client_info_byemail($email) {
	
		$sql = 'SELECT * FROM xin_customers WHERE email = ?';
		$binds = array($email);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	// Read data from database to show data in admin page
	public function read_client_information($username) {
	
		$sql = 'SELECT * FROM xin_customers WHERE email = ?';
		$binds = array($username);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_customers', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('customer_id', $id);
		$this->db->delete('xin_customers');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('customer_id', $id);
		if( $this->db->update('xin_customers',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>