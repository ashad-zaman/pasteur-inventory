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

class Suppliers extends MY_Controller {
	
	 public function __construct() {
        Parent::__construct();
		//load the models
		$this->load->model("Suppliers_model");
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
		$data['title'] = $this->lang->line('xin_suppliers').' | '.$this->Xin_model->site_title();
		$data['all_countries'] = $this->Xin_model->get_countries();
		$data['breadcrumbs'] = $this->lang->line('xin_suppliers');
		$data['path_url'] = 'supplier';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('8',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/supplier/supplier_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard/');
		}
     }
 
    public function supplier_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/supplier/supplier_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$supplier = $this->Suppliers_model->get_suppliers();
		
		$data = array();

          foreach($supplier->result() as $r) {
			  
			  // get country
			  $country = $this->Xin_model->read_country_info($r->country);
			  // get user
			  $user = $this->Xin_model->read_user_info($r->added_by);
			  // user full name
			  $full_name = $user[0]->first_name.' '.$user[0]->last_name;

               $data[] = array(
			   		'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-default btn-xs m-b-0-0 waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-supplier_id="'. $r->supplier_id . '"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn btn-default btn-xs m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-supplier_id="'. $r->supplier_id . '"><i class="fa fa-eye"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-xs m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->supplier_id . '"><i class="fa fa-trash-o"></i></button></span>',
                    $r->supplier_name,
                    $r->email,
                    $r->contact_number,
                    $r->city,
                    isset($country[0]->country_name)?$country[0]->country_name:'',
					$full_name
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $supplier->num_rows(),
                 "recordsFiltered" => $supplier->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 public function read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('supplier_id');
		$result = $this->Suppliers_model->read_supplier_information($id);
		$data = array(
				'supplier_id' => $result[0]->supplier_id,
				'supplier_name' => $result[0]->supplier_name,
				'registration_no' => $result[0]->registration_no,
				'email' => $result[0]->email,
				'contact_number' => $result[0]->contact_number,
				'website_url' => $result[0]->website_url,
				'address_1' => $result[0]->address_1,
				'address_2' => $result[0]->address_2,
				'city' => $result[0]->city,
				'state' => $result[0]->state,
				'zipcode' => $result[0]->zipcode,
				'countryid' => $result[0]->country,
				'all_countries' => $this->Xin_model->get_countries(),
				'all_companies' => $this->Xin_model->get_companies()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/supplier/dialog_supplier', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function add_supplier() {
	
		if($this->input->post('add_type')=='supplier') {

		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('xin_acc_supplier_name_field');
		} 
		
		// else if($this->input->post('email')==='') {
		// 	$Return['error'] = $this->lang->line('xin_employee_error_email');
		// } else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
		// 	$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		// } else if($this->input->post('contact_number')==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_contact_field');
		// } else if($this->input->post('address_1')==='') {
		// 	$Return['error'] = $this->lang->line('xin_acc_address1_field');
		// } else if($this->input->post('city')==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_city_field');
		// } else if($this->input->post('zipcode')==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_zipcode_field');
		// } else if($this->input->post('country')==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_country_field');
		// }
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'supplier_name' => $this->input->post('name'),
		'registration_no' => $this->input->post('registration_no'),
		'email' => $this->input->post('email'),
		'website_url' => $this->input->post('website'),
		'contact_number' => $this->input->post('contact_number'),
		'address_1' => $this->input->post('address_1'),
		'address_2' => $this->input->post('address_2'),
		'city' => $this->input->post('city'),
		'state' => $this->input->post('state'),
		'zipcode' => $this->input->post('zipcode'),
		'country' => $this->input->post('country'),
		'added_by' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y h:i:s'),
		
		);
		$result = $this->Suppliers_model->add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_supplier_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='supplier') {
		$id = $this->uri->segment(4);
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('xin_acc_supplier_name_field');
		} 
		// else if($this->input->post('email')==='') {
		// 	$Return['error'] = $this->lang->line('xin_employee_error_email');
		// } else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
		// 	$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		// } else if($this->input->post('contact_number')==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_contact_field');
		// } else if($this->input->post('address_1')==='') {
		// 	$Return['error'] = $this->lang->line('xin_acc_address1_field');
		// } else if($this->input->post('city')==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_city_field');
		// } else if($this->input->post('zipcode')==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_zipcode_field');
		// } else if($this->input->post('country')==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_country_field');
		// }
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'supplier_name' => $this->input->post('name'),
		'registration_no' => $this->input->post('registration_no'),
		'email' => $this->input->post('email'),
		'website_url' => $this->input->post('website'),
		'contact_number' => $this->input->post('contact_number'),
		'address_1' => $this->input->post('address_1'),
		'address_2' => $this->input->post('address_2'),
		'city' => $this->input->post('city'),
		'state' => $this->input->post('state'),
		'zipcode' => $this->input->post('zipcode'),
		'country' => $this->input->post('country')		
		);
		$result = $this->Suppliers_model->update_record($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_supplier_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function delete() {
		if($this->input->post('is_ajax')=='2') {
			
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Suppliers_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_acc_supplier_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
}
