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

class Warehouse extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Warehouses_model");
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
		$data['title'] = $this->lang->line('xin_acc_warehouses').' | '.$this->Xin_model->site_title();
		$data['all_countries'] = $this->Xin_model->get_countries();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_warehouses');
		$data['path_url'] = 'warehouse';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('7',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/warehouse/warehouse_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard/');
		}		  
     }
 
    public function warehouse_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/warehouse/warehouse_list", $data);
		} else {
			redirect('');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$warehouse = $this->Warehouses_model->get_warehouses_list();
		
		$data = array();

          foreach($warehouse->result() as $r) {
			  // pickup location
			  if($r->pickup_location == 0){
				  $ploc = $this->lang->line('xin_no');
			  } else {
				  $ploc = $this->lang->line('xin_yes');
			  }
			  $pro_qty = $this->Warehouses_model->get_warehouse_products($r->warehouse_id);

               $data[] = array(
			   		'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-default btn-xs m-b-0-0 waves-effect waves-light"  data-toggle="modal" data-target="#edit-modal-data"  data-warehouse_id="'. $r->warehouse_id . '"><i class="fa fa-pencil-square-o"></i></button></span></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn btn-default btn-xs m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-warehouse_id="'. $r->warehouse_id . '"><i class="fa fa-eye"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-xs m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->warehouse_id . '"><i class="fa fa-trash-o"></i></button></span>',
                    $r->warehouse_name,
					$r->contact_number,
					$pro_qty,
					$ploc,
                    $r->city
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $warehouse->num_rows(),
                 "recordsFiltered" => $warehouse->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 public function read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('warehouse_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		$result = $this->Warehouses_model->read_warehouse_info($id);
		$data = array(
				'warehouse_id' => $result[0]->warehouse_id,
				'warehouse_name' => $result[0]->warehouse_name,
				'contact_number' => $result[0]->contact_number,
				'pickup_location' => $result[0]->pickup_location,
				'address_1' => $result[0]->address_1,
				'address_2' => $result[0]->address_2,
				'city' => $result[0]->city,
				'state' => $result[0]->state,
				'zipcode' => $result[0]->zipcode,
				'countryid' => $result[0]->country,
				'all_countries' => $this->Xin_model->get_countries()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/warehouse/dialog_warehouse', $data);
		} else {
			redirect('');
		}
	}
	
	// Validate and add info in database
	public function add_warehouse() {
	
		if($this->input->post('add_type')=='warehouse') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('xin_error_name_field');
		} 
		// else if($this->input->post('contact_number')==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_contact_field');
		// } else if($this->input->post('address_1')==='') {
		// 	$Return['error'] = $this->lang->line('xin_acc_address1_field');
		// } else if($this->input->post('city')==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_city_field');
		// } else if($this->input->post('country')==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_country_field');
		// }
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'warehouse_name' => $this->input->post('name'),
		'contact_number' => $this->input->post('contact_number'),
		'pickup_location' => $this->input->post('pickup_location'),
		'address_1' => $this->input->post('address_1'),
		'address_2' => $this->input->post('address_2'),
		'city' => $this->input->post('city'),
		'state' => $this->input->post('state'),
		'zipcode' => $this->input->post('zipcode'),
		'country' => $this->input->post('country'),
		'added_by' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y h:i:s'),
		
		);
		$result = $this->Warehouses_model->add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_warehouse_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='warehouse') {
			
		$id = $this->uri->segment(4);
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('xin_error_name_field');
		} 
		// else if($this->input->post('contact_number')==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_contact_field');
		// } else if($this->input->post('address_1')==='') {
		// 	$Return['error'] = $this->lang->line('xin_acc_address1_field');
		// } else if($this->input->post('city')==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_city_field');
		// } else if($this->input->post('country')==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_country_field');
		// }
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'warehouse_name' => $this->input->post('name'),
		'contact_number' => $this->input->post('contact_number'),
		'pickup_location' => $this->input->post('pickup_location'),
		'address_1' => $this->input->post('address_1'),
		'address_2' => $this->input->post('address_2'),
		'city' => $this->input->post('city'),
		'state' => $this->input->post('state'),
		'zipcode' => $this->input->post('zipcode'),
		'country' => $this->input->post('country')	
		);
		
		$result = $this->Warehouses_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_warehouse_updated');
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
			$result = $this->Warehouses_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_acc_warehouse_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
}
