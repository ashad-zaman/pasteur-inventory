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

class Services extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Products_model");
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
		$data['title'] = $this->lang->line('xin_services').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_services');
		$data['path_url'] = 'xin_services';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('8',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/products/services_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load		
		} else {
			redirect('admin/dashboard');
		}
     }
 
    public function services_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/products/services_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$product = $this->Products_model->get_services();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

        foreach($product->result() as $r) {
			// get date
			$pdate = $this->Xin_model->set_date_format($r->created_at);
			
			$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-product_id="'. $r->product_id . '"><span class="fa fa-pencil"></span></button></span>';
			$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->product_id . '"><span class="fa fa-trash"></span></button></span>';
			$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-product_id="'. $r->product_id . '"><span class="fa fa-eye"></span></button></span>';
			$combhr = $edit.$view.$delete;
			$data[] = array(
				$combhr,
				$r->name,
				$r->item_number,
				$r->sales_price,
				$r->description,
			);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $product->num_rows(),
			 "recordsFiltered" => $product->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }

	 public function read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('product_id');
		$result = $this->Products_model->read_service_info($id);
		$data = array(
				'product_id' => $result[0]->product_id,
				'name' => $result[0]->name,
				'item_number' => $result[0]->item_number,
				'sales_price' => $result[0]->sales_price,
				'description' => $result[0]->description
				);
		if(!empty($session)){ 
			$this->load->view('admin/products/dialog_service', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function add() {
	
		if($this->input->post('add_type')=='add_item') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
       		$Return['error'] = $this->lang->line('xin_error_name_field');
		} else if($this->input->post('item_number')==='') {
			$Return['error'] = $this->lang->line('xin_error_item_number_field');
		} else if($this->input->post('sales_price')==='') {
			$Return['error'] = $this->lang->line('xin_error_sales_price_field');
		} else if($this->input->post('description')==='') {
			$Return['error'] = $this->lang->line('xin_error_task_file_description');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'name' => $this->input->post('name'),
		'item_number' => $this->input->post('item_number'),
		'sales_price' => $this->input->post('sales_price'),
		'description' => $this->input->post('description'),
		'type' => 'service',
		'created_at' => date('d-m-Y h:i:s'),
		
		);
		$result = $this->Products_model->add_service($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_service_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='edit_item') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('name')==='') {
       		$Return['error'] = $this->lang->line('xin_error_name_field');
		} else if($this->input->post('item_number')==='') {
			$Return['error'] = $this->lang->line('xin_error_item_number_field');
		} else if($this->input->post('sales_price')==='') {
			$Return['error'] = $this->lang->line('xin_error_sales_price_field');
		} else if($this->input->post('description')==='') {
			$Return['error'] = $this->lang->line('xin_error_task_file_description');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'name' => $this->input->post('name'),
		'item_number' => $this->input->post('item_number'),
		'sales_price' => $this->input->post('sales_price'),
		'description' => $this->input->post('description'),		
		);
		
		$result = $this->Products_model->update_service_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_service_updated');
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
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Products_model->delete_service_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_service_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
}
