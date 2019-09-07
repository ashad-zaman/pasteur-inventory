<?php
 /**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the HRSALE License
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.hrsale.com/license.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to hrsalesoft@gmail.com so we can send you a copy immediately.
 *
 * @author   HRSALE
 * @author-email  hrsalesoft@gmail.com
 * @copyright  Copyright © hrsale.com. All Rights Reserved
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the models
		$this->load->model("Customers_model");
		$this->load->model("Xin_model");
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	 public function index()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		$data['title'] = $this->lang->line('xin_customers').' | '.$this->Xin_model->site_title();
		$data['all_countries'] = $this->Xin_model->get_countries();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('xin_customers');
		$data['path_url'] = 'xin_customers';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('12',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/customers/customers_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
     }
	 
	 public function detail()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_customers_detail').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_customers_detail');
		$data['path_url'] = 'xin_customers_last_login';
		$id = $this->uri->segment(4);
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$result = $this->Customers_model->read_customer_info($id);
		$data = array(
			'title' => $this->lang->line('xin_customers_detail'),
			'breadcrumbs' => $this->lang->line('xin_customers_detail'),
			'path_url' => 'xin_customers_detail',
			'customer_id' => $result[0]->customer_id,
			'name' => $result[0]->name,
			'company_id' => $result[0]->company_id,
			'profile_picture' => $result[0]->profile_picture,
			'email' => $result[0]->email,
			'contact_number' => $result[0]->contact_number,
			'website_url' => $result[0]->website_url,
			'address_1' => $result[0]->address_1,
			'address_2' => $result[0]->address_2,
			'city' => $result[0]->city,
			'state' => $result[0]->state,
			'zipcode' => $result[0]->zipcode,
			'countryid' => $result[0]->country,
			'is_active' => $result[0]->is_active,
			'all_companies' => $this->Xin_model->get_companies(),
			'all_countries' => $this->Xin_model->get_countries(),
		);
		
		if(!empty($session)){ 
			if(in_array('12',$role_resources_ids)) {
				$data['subview'] = $this->load->view("admin/customers/customers_detail", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/dashboard');
			}	
		} else {
			redirect('admin/');
		}		  
     }
 
    public function customers_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/customers/customers_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$customer = $this->Customers_model->get_customers();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

          foreach($customer->result() as $r) {
			  
			  // get country
			  $country = $this->Xin_model->read_country_info($r->country);
			  if(!is_null($country)){
			  	$c_name = $country[0]->country_name;
			  } else {
				  $c_name = '--';	
			  }	  
				// get company
				$company = $this->Xin_model->read_company_info($r->company_id);
				if(!is_null($company)){
					$comp_name = $company[0]->name;
				} else {
					$comp_name = '--';	
				}
			  
			 $edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-customer_id="'. $r->customer_id . '"><span class="fa fa-pencil"></span></button></span>';
			$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete-customer" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->customer_id . '"><span class="fa fa-trash"></span></button></span>';
			$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><a href="'.site_url().'admin/customers/detail/'. $r->customer_id . '"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			$combhr = $view.$edit.$delete;
		
               $data[] = array(
			   		$combhr,
                    $r->name,
					$comp_name,
					$r->email,
                    $r->website_url,
                    $r->city,
                    $c_name,
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $customer->num_rows(),
                 "recordsFiltered" => $customer->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 public function customer_read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('customer_id');
		$result = $this->Customers_model->read_customer_info($id);
		$data = array(
				'customer_id' => $result[0]->customer_id,
				'name' => $result[0]->name,
				'company_id' => $result[0]->company_id,
				'profile_picture' => $result[0]->profile_picture,
				'email' => $result[0]->email,
				'contact_number' => $result[0]->contact_number,
				'website_url' => $result[0]->website_url,
				'address_1' => $result[0]->address_1,
				'address_2' => $result[0]->address_2,
				'city' => $result[0]->city,
				'state' => $result[0]->state,
				'zipcode' => $result[0]->zipcode,
				'countryid' => $result[0]->country,
				'is_active' => $result[0]->is_active,
				'all_companies' => $this->Xin_model->get_companies(),
				'all_countries' => $this->Xin_model->get_countries(),
				);
		$this->load->view('admin/customers/dialog_customers', $data);
	}
	
	// Validate and add info in database
	public function add_customer() {
	
		if($this->input->post('add_type')=='customer') {
		// Check validation for user input
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('website', 'Website', 'trim|required|xss_clean');
		$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
		
		$name = $this->input->post('name');
		//$customer_id = $this->input->post('customer_id');
		$email = $this->input->post('email');
		$contact_number = $this->input->post('contact_number');
		$website = $this->input->post('website');
		$address_1 = $this->input->post('address_1');
		$address_2 = $this->input->post('address_2');
		$city = $this->input->post('city');
		$state = $this->input->post('state');
		$zipcode = $this->input->post('zipcode');
		$country = $this->input->post('country');
		$user_id = $this->input->post('user_id');
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($name==='') {
			$Return['error'] = $this->lang->line('xin_error_name_field');
		} 
		// else if($this->input->post('company_id')==='') {
		// 	$Return['error'] = $this->lang->line('error_company_field');
		// } 
		
		/*else if($email==='') {
			$Return['error'] = $this->lang->line('xin_error_cemail_field');
		} else if($this->Xin_model->check_customer_email($email) > 0) {
			$Return['error'] = $this->lang->line('xin_acc_customer_already_exist');
		} else if($country==='') {
			$Return['error'] = $this->lang->line('xin_error_country_field');
		} else if($this->input->post('password')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_password');
		}*/
		
		/* Check if file uploaded..*/
		else if($_FILES['profile_picture']['size'] == 0) {
			if($this->input->post('password')==='') {
				$ipassword = 'mypassword';
			} else {
				$ipassword = $this->input->post('password');
			}
			$fname = 'no file';
			$options = array('cost' => 12);
			$password_hash = password_hash($ipassword, PASSWORD_BCRYPT, $options);
		
			$data = array(
			'name' => $this->input->post('name'),
			'company_id' => $this->input->post('company_id'),
			'email' => $this->input->post('email'),
			'password' => $password_hash,
			'profile_picture' => '',
			'contact_number' => $this->input->post('contact_number'),
			'website_url' => $this->input->post('website'),
			'address_1' => $this->input->post('address_1'),
			'address_2' => $this->input->post('address_2'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'zipcode' => $this->input->post('zipcode'),
			'country' => $this->input->post('country'),
			'is_active' => 1,
			'created_at' => date('Y-m-d H:i:s'),
			
			);
			$result = $this->Customers_model->add($data);
		} else {
			if(is_uploaded_file($_FILES['profile_picture']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['profile_picture']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["profile_picture"]["tmp_name"];
					$bill_copy = "uploads/customers/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["profile_picture"]["name"]);
					$newfilename = 'customer_photo_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
			if($this->input->post('password')==='') {
				$ipassword = 'mypassword';
			} else {
				$ipassword = $this->input->post('password');
			}
			$options = array('cost' => 12);
			$password_hash = password_hash($ipassword, PASSWORD_BCRYPT, $options);
		
			$data = array(
			'name' => $this->input->post('name'),
			'company_id' => $this->input->post('company_id'),
			'email' => $this->input->post('email'),
			'password' => $password_hash,
			'profile_picture' => $fname,
			'contact_number' => $this->input->post('contact_number'),
			'website_url' => $this->input->post('website'),
			'address_1' => $this->input->post('address_1'),
			'address_2' => $this->input->post('address_2'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'zipcode' => $this->input->post('zipcode'),
			'country' => $this->input->post('country'),
			'is_active' => 1,
			'created_at' => date('Y-m-d H:i:s'),
			
			);
			$result = $this->Customers_model->add($data);
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_project_client_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='customer') {
		$id = $this->uri->segment(4);
		// Check validation for user input
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('website', 'Website', 'trim|required|xss_clean');
		$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
		
		$name = $this->input->post('name');
		$company_id = $this->input->post('company_id');
		$email = $this->input->post('email');
		$contact_number = $this->input->post('contact_number');
		$website = $this->input->post('website');
		$address_1 = $this->input->post('address_1');
		$address_2 = $this->input->post('address_2');
		$city = $this->input->post('city');
		$state = $this->input->post('state');
		$zipcode = $this->input->post('zipcode');
		$country = $this->input->post('country');
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($name==='') {
			$Return['error'] = $this->lang->line('xin_error_name_field');
		}
		
		// else if($this->input->post('company_id')==='') {
		// 	$Return['error'] = $this->lang->line('error_company_field');
		// } else if($email==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_cemail_field');
		// } else if($country==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_country_field');
		// }				
		/* Check if file uploaded..*/
		else if($_FILES['profile_picture']['size'] == 0) {
			 //$fname = 'no file';
			 $no_logo_data = array(
			'name' => $this->input->post('name'),
			'company_id' => $this->input->post('company_id'),
			'email' => $this->input->post('email'),
			'contact_number' => $this->input->post('contact_number'),
			'website_url' => $this->input->post('website'),
			'address_1' => $this->input->post('address_1'),
			'address_2' => $this->input->post('address_2'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'zipcode' => $this->input->post('zipcode'),
			'country' => $this->input->post('country'),
			'is_active' => $this->input->post('status'),
			);
			 $result = $this->Customers_model->update_record($no_logo_data,$id);
		} else {
			if(is_uploaded_file($_FILES['profile_picture']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['client_photo']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["profile_picture"]["tmp_name"];
					$bill_copy = "uploads/customers/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["profile_picture"]["name"]);
					$newfilename = 'customer_photo_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
					$data = array(
					'name' => $this->input->post('name'),
					'company_id' => $this->input->post('company_id'),
					'email' => $this->input->post('email'),
					'profile_picture' => $fname,
					'contact_number' => $this->input->post('contact_number'),
					'website_url' => $this->input->post('website'),
					'address_1' => $this->input->post('address_1'),
					'address_2' => $this->input->post('address_2'),
					'city' => $this->input->post('city'),
					'state' => $this->input->post('state'),
					'zipcode' => $this->input->post('zipcode'),
					'country' => $this->input->post('country'),		
					'is_active' => $this->input->post('status'),
					);
					// update record > model
					$result = $this->Customers_model->update_record($data,$id);
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
	
		if($Return['error']!=''){
       		$this->output($Return);
    	}		
			
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_customers_updated');
		} else {
			$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database // change password
	public function change_password() {
	
		if($this->input->post('type')=='change_password') {		
		/* Define return | here result is used to return user data and error for error message */
		$session = $this->session->userdata('username');
		
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */						
		if(trim($this->input->post('new_password'))==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_newpassword');
		} else if(strlen($this->input->post('new_password')) < 6) {
			$Return['error'] = $this->lang->line('xin_employee_error_password_least');
		} else if(trim($this->input->post('new_password_confirm'))==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_new_cpassword');
		} else if($this->input->post('new_password')!=$this->input->post('new_password_confirm')) {
			 $Return['error'] = $this->lang->line('xin_employee_error_old_new_cpassword');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$options = array('cost' => 12);
		$password_hash = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT, $options);
	
		$data = array(
		'password' => $password_hash
		);
		$id = $this->input->post('customer_id');
		$result = $this->Customers_model->update_record($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_client_password_update');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function delete() {
		
		if($this->input->post('is_ajax')==2) {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('admin/');
			}
			/* Define return | here result is used to return user data and error for error message */
			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Customers_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_project_client_deleted');
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
}
