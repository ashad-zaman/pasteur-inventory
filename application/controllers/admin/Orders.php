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
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends MY_Controller
{

   /*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	public function __construct()
     {
          parent::__construct();
          //load the login model
         // $this->load->model('Finance_model');
		  $this->load->model('Xin_model');
		  $this->load->model("Products_model");
		  $this->load->model("Tax_model");
		  $this->load->model("Invoices_model");
		  $this->load->model("Customers_model");
		  $this->load->model("Transactions_model");
     }
	 
	// invoices page
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_acc_inv_orders').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_inv_orders');
		$data['all_taxes'] = $this->Tax_model->get_all_taxes();
		$data['path_url'] = 'hrsale_invoices';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('15',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/invoices/invoices_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	// create invoice page
	public function create() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

		$data['invoice_order_no'] = $this->Invoices_model->get_invoice_order_no();
		$data['invoice_order_no']=($data['invoice_order_no']==null)?1000:(1000+$data['invoice_order_no']+1);

		//print_r($data['invoice_order_no']);exit;

		$data['title'] = $this->lang->line('xin_invoice_create').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_invoice_create');
		$data['all_taxes'] = $this->Tax_model->get_all_taxes();
		$data['all_items'] = $this->Xin_model->get_items();
		$data['path_url'] = 'create_hrsale_invoice';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('16',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/invoices/create_invoice", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
	
	// get_invoice_items
	 public function get_invoice_items() {

		$data['title'] = $this->Xin_model->site_title();
		
		$data = array(
			'all_taxes' => $this->Tax_model->get_all_taxes(),
			'all_items' => $this->Xin_model->get_items()
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/invoices/get_items", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	
	public function taxes()
     {
		$data['title'] = $this->lang->line('xin_invoice_tax_types').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_invoice_tax_types');
		$data['path_url'] = 'invoice_taxes';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('5',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/invoices/invoice_taxes", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
	 
	 public function taxes_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/invoices/invoice_taxes", $data);
		} else {
			redirect('admin/dashboard');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$taxes = $this->Invoices_model->get_taxes();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

          foreach($taxes->result() as $r) {
			
			// get type
			if($r->type == 'fixed'): $type = 'Fixed'; else: $type = 'Percentage'; endif;
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-tax_id="'. $r->tax_id . '"><span class="fa fa-pencil"></span></button></span>';
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->tax_id . '"><span class="fa fa-trash"></span></button></span>';					
				$combhr = $edit.$delete;
				$data[] = array(
					$combhr,
					$r->name,
					$r->rate,
					$type
			   );
		  }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $taxes->num_rows(),
                 "recordsFiltered" => $taxes->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	public function payments() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		$data['title'] = $this->lang->line('xin_invoice_title').' | '.$this->lang->line('xin_acc_inv_payments').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_invoice_title');
		$data['path_url'] = 'xin_invoice_payment';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('13',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/invoices/invoice_payment_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	} 
	 
	 // invoice payment list
	public function invoice_payment_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/invoices/invoice_payment_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$transaction = $this->Finance_model->get_invoice_payments();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();
		$balance2 = 0;
          foreach($transaction->result() as $r) {
			  
			// transaction date
			$transaction_date = $this->Xin_model->set_date_format($r->transaction_date);
			// get currency
			$total_amount = $this->Xin_model->currency_sign($r->amount);
			// credit
			$cr_dr = $r->dr_cr=="dr" ? $this->lang->line('xin_acc_debit') : $this->lang->line('xin_acc_credit');
			
			// account type
			$acc_type = $this->Finance_model->read_bankcash_information($r->account_id);
			if(!is_null($acc_type)){
				$account = $acc_type[0]->account_name;
			} else {
				$account = '--';	
			}
			$invoice_info = $this->Invoices_model->read_invoice_info($r->invoice_id);
			if(!is_null($invoice_info)){
				$inv_no = $invoice_info[0]->invoice_number;
			} else {
				$inv_no = '--';	
			}
			// payment method 
			$payment_method = $this->Xin_model->read_payment_method($r->payment_method_id);
			if(!is_null($payment_method)){
				$method_name = $payment_method[0]->method_name;
			} else {
				$method_name = '--';	
			}
			
			$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"  data-toggle="modal" data-target=".view-modal-data-bg"  data-deposit_id="'. $r->transaction_id . '"><span class="fa fa-pencil"></span></button></span>';
						
			$data[] = array(
				$edit,
				$inv_no,
				$transaction_date,
				$account,
				$total_amount,
				$method_name,
				$r->description
			);
		  }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $transaction->num_rows(),
                 "recordsFiltered" => $transaction->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 // tax data
	public function tax_read()
	{
		
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('tax_id');
		$result = $this->Invoices_model->read_tax_information($id);
		$data = array(
				'tax_id' => $result[0]->tax_id,
				'name' => $result[0]->name,
				'rate' => $result[0]->rate,
				'type' => $result[0]->type,
				'description' => $result[0]->description
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/invoices/dialog_tax', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function add_tax() {
	
		if($this->input->post('add_type')=='tax') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('tax_name')==='') {
       		$Return['error'] = $this->lang->line('xin_acc_tax_name_field');
		} else if($this->input->post('tax_rate')==='') {
			$Return['error'] = $this->lang->line('xin_acc_tax_rate_field');
		} else if($this->input->post('tax_type')==='') {
			$Return['error'] = $this->lang->line('xin_acc_tax_type_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'name' => $this->input->post('tax_name'),
		'rate' => $this->input->post('tax_rate'),
		'type' => $this->input->post('tax_type'),
		'description' => $qt_description,
		'created_at' => date('d-m-Y h:i:s'),
		
		);
		$result = $this->Invoices_model->add_tax_record($data);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_product_tax_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_tax() {
	
		if($this->input->post('edit_type')=='tax') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$id = $this->uri->segment(4);
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('tax_name')==='') {
       		$Return['error'] = $this->lang->line('xin_acc_tax_name_field');
		} else if($this->input->post('tax_rate')==='') {
			$Return['error'] = $this->lang->line('xin_acc_tax_rate_field');
		} else if($this->input->post('tax_type')==='') {
			$Return['error'] = $this->lang->line('xin_acc_tax_type_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'name' => $this->input->post('tax_name'),
		'rate' => $this->input->post('tax_rate'),
		'type' => $this->input->post('tax_type'),
		'description' => $qt_description		
		);
		$result = $this->Invoices_model->update_tax_record($data,$id);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_product_tax_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// edit invoice page
	public function edit() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		
		$invoice_id = $this->uri->segment(4);
		$invoice_info = $this->Invoices_model->read_invoice_info($invoice_id);
		if(is_null($invoice_info)){
			redirect('admin/invoices');
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!in_array('15',$role_resources_ids)) { //edit
			redirect('admin/invoices');
		}
		// get project
		$customer = $this->Customers_model->read_customer_info($invoice_info[0]->customer_id); 
		// get country
	//	$country = $this->Xin_model->read_country_info($supplier[0]->country_id);
		// get company info
		$company = $this->Xin_model->read_company_setting_info(1);
		// get company > country info
		$ccountry = $this->Xin_model->read_country_info($company[0]->country);
		$data = array(
			'title' => $this->lang->line('xin_acc_edit_order').' #'.$invoice_info[0]->invoice_id,
			'breadcrumbs' => $this->lang->line('xin_acc_edit_order'),
			'path_url' => 'create_hrsale_invoice',
			'invoice_id' => $invoice_info[0]->invoice_id,
			'prefix' => $invoice_info[0]->prefix,
			'invoice_number' => $invoice_info[0]->invoice_number,
			'customer_id' => $customer[0]->customer_id,
			'invoice_date' => $invoice_info[0]->invoice_date,
			'invoice_due_date' => $invoice_info[0]->invoice_due_date,
			'sub_total_amount' => $invoice_info[0]->sub_total_amount,
			'discount_type' => $invoice_info[0]->discount_type,
			'discount_figure' => $invoice_info[0]->discount_figure,
			'total_tax' => $invoice_info[0]->total_tax,
			'total_discount' => $invoice_info[0]->total_discount,
			'grand_total' => $invoice_info[0]->grand_total,
			'invoice_note' => $invoice_info[0]->invoice_note,
			'all_items' => $this->Xin_model->get_items(),
			'all_taxes' => $this->Tax_model->get_all_taxes(),
		//	'product_for_purchase_invoice' => $this->Products_model->product_for_purchase_invoice(),
		//	'all_taxes' => $this->Products_model->get_taxes()
			);
		$role_resources_ids = $this->Xin_model->user_role_resource();
		//if(in_array('3',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/invoices/edit_invoice", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load			
		//} else {
		//	redirect('admin/dashboard/');
		//}		  
     }
	
	// preview invoice page
	public function preview() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		
		$invoice_id = $this->uri->segment(4);
		$invoice_info = $this->Invoices_model->read_invoice_info($invoice_id);
		if(is_null($invoice_info)){
			redirect('admin/invoices');
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!in_array('15',$role_resources_ids)) { //view
			redirect('admin/invoices');
		}
		// get project
		$customer = $this->Customers_model->read_customer_info($invoice_info[0]->customer_id); 
		// get country
	//	$country = $this->Xin_model->read_country_info($supplier[0]->country_id);
		// get company info
		$company = $this->Xin_model->read_company_setting_info(1);
		// get company > country info
		$ccountry = $this->Xin_model->read_country_info($company[0]->country);
		
		$data = array(
			'title' => $this->lang->line('xin_acc_view_order').' #'.$invoice_info[0]->invoice_id,
			'breadcrumbs' => $this->lang->line('xin_acc_view_order'),
			'path_url' => 'invoice_preview',
			'invoice_id' => $invoice_info[0]->invoice_id,
			'prefix' => $invoice_info[0]->prefix,
			'invoice_number' => $invoice_info[0]->invoice_number,
			'customer_id' => $customer[0]->customer_id,
			'invoice_date' => $invoice_info[0]->invoice_date,
			'invoice_due_date' => $invoice_info[0]->invoice_due_date,
			'sub_total_amount' => $invoice_info[0]->sub_total_amount,
			'discount_type' => $invoice_info[0]->discount_type,
			'discount_figure' => $invoice_info[0]->discount_figure,
			'total_tax' => $invoice_info[0]->total_tax,
			'total_discount' => $invoice_info[0]->total_discount,
			'grand_total' => $invoice_info[0]->grand_total,
			'invoice_note' => $invoice_info[0]->invoice_note,
			'status' => $invoice_info[0]->status,
			'company_name' => $company[0]->company_name,
			'company_email' => $company[0]->company_email,
			'company_address' => $company[0]->address_1,
			'company_zipcode' => $company[0]->zipcode,
			'company_city' => $company[0]->city,
			'company_phone' => $company[0]->phone,
			'company_country' => $ccountry[0]->country_name,
			'all_items' => $this->Xin_model->get_items(),
			'all_taxes' => $this->Tax_model->get_all_taxes(),
		//	'product_for_purchase_invoice' => $this->Products_model->product_for_purchase_invoice(),
		//	'all_taxes' => $this->Products_model->get_taxes()
			);
			$role_resources_ids = $this->Xin_model->user_role_resource();
			//if(in_array('3',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/invoices/invoice_preview", $data, TRUE);
			$this->load->view('admin/layout/pre_layout_main', $data); //page load			
		//} else {
		//	redirect('admin/dashboard/');
		//}		  
     }
	 // view invoice page
	public function view() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		
		$invoice_id = $this->uri->segment(4);
		$invoice_info = $this->Invoices_model->read_invoice_info($invoice_id);
		if(is_null($invoice_info)){
			redirect('admin/invoices');
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!in_array('15',$role_resources_ids)) { //view
			redirect('admin/invoices');
		}
		// get project
		$customer = $this->Customers_model->read_customer_info($invoice_info[0]->customer_id); 
		// get country
	//	$country = $this->Xin_model->read_country_info($supplier[0]->country_id);
		// get company info
		$company = $this->Xin_model->read_company_setting_info(1);
		// get company > country info
		$ccountry = $this->Xin_model->read_country_info($company[0]->country);
		
		$data = array(
			'title' => $this->lang->line('xin_acc_view_order').' #'.$invoice_info[0]->invoice_id,
			'breadcrumbs' => $this->lang->line('xin_acc_view_order'),
			'path_url' => 'create_hrsale_invoice',
			'invoice_id' => $invoice_info[0]->invoice_id,
			'prefix' => $invoice_info[0]->prefix,
			'invoice_number' => $invoice_info[0]->invoice_number,
			'customer_id' => $customer[0]->customer_id,
			'invoice_date' => $invoice_info[0]->invoice_date,
			'invoice_due_date' => $invoice_info[0]->invoice_due_date,
			'sub_total_amount' => $invoice_info[0]->sub_total_amount,
			'discount_type' => $invoice_info[0]->discount_type,
			'discount_figure' => $invoice_info[0]->discount_figure,
			'total_tax' => $invoice_info[0]->total_tax,
			'total_discount' => $invoice_info[0]->total_discount,
			'grand_total' => $invoice_info[0]->grand_total,
			'invoice_note' => $invoice_info[0]->invoice_note,
			'status' => $invoice_info[0]->status,
			'company_name' => $company[0]->company_name,
			'company_address' => $company[0]->address_1,
			'company_zipcode' => $company[0]->zipcode,
			'company_city' => $company[0]->city,
			'company_phone' => $company[0]->phone,
			'company_email' => $company[0]->company_email,
			'company_country' => $ccountry[0]->country_name,
			'all_items' => $this->Xin_model->get_items(),
			'all_taxes' => $this->Tax_model->get_all_taxes(),
		//	'product_for_purchase_invoice' => $this->Products_model->product_for_purchase_invoice(),
		//	'all_taxes' => $this->Products_model->get_taxes()
			);
			$role_resources_ids = $this->Xin_model->user_role_resource();
			//if(in_array('3',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/invoices/invoice_view", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load			
		//} else {
		//	redirect('admin/dashboard/');
		//}		  
     }
	 
	public function invoices_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/invoices/invoices_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$invoice = $this->Invoices_model->get_invoices();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

          foreach($invoice->result() as $r) {
			  
			  // get grand_total
			 $grand_total = $this->Xin_model->currency_sign($r->grand_total);
			  // get customer
			  $customer = $this->Customers_model->read_customer_info($r->customer_id); 
				if(!is_null($customer)){
					$cname = $customer[0]->name;
				} else {
					$cname = '--';	
				}
			  $invoice_date = '<i class="fa fa-calendar position-left"></i> '.$this->Xin_model->set_date_format($r->invoice_date);
			  $invoice_due_date = '<i class="fa fa-calendar position-left"></i> '.$this->Xin_model->set_date_format($r->invoice_due_date);
			  //invoice_number
			$invoice_number = '';
			$invoice_number = '<a href="'.site_url().'admin/orders/view/'.$r->invoice_id.'/">'.$r->invoice_number.'</a>';
			$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><a href="'.site_url().'admin/orders/edit/'.$r->invoice_id.'/"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-pencil"></span></button></a></span>';
			$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->invoice_id . '"><span class="fa fa-trash"></span></button></span>';
			$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><a href="'.site_url().'admin/orders/view/'.$r->invoice_id.'/"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light""><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			if($r->status == 0){
				$status = '<span class="label label-danger">'.$this->lang->line('xin_payroll_unpaid').'</span>';
			} else if($r->status == 1) {
				$status = '<span class="label label-success">'.$this->lang->line('xin_payment_paid').'</span>';
			} else {
				$status = '<span class="label label-info">'.$this->lang->line('xin_acc_inv_cancelled').'</span>';
			}
			$combhr = $edit.$view.$delete;
               $data[] = array(
			   		$combhr,
					$invoice_number,
                    $cname,
					$grand_total,
                    $invoice_date,
                    $invoice_due_date,
                    $status,
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $invoice->num_rows(),
                 "recordsFiltered" => $invoice->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 public function read_invoice()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$invoice_id = $this->input->get('invoice_id');
		$result = $this->Invoices_model->read_invoice_info($invoice_id);
		$data = array(
				'invoice_id' => $result[0]->invoice_id,
				'invoice_number' => $result[0]->invoice_number,
				'grand_total' => $result[0]->grand_total,
				'all_payers' => $this->Customers_model->get_all_customers(),
				'all_income_categories_list' => $this->Xin_model->all_income_categories_list(),
				'get_all_payment_method' => $this->Xin_model->get_payment_method()
				);
		if(!empty($session)){ 
			$this->load->view('admin/invoices/dialog_invoice_add_payment', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function mark_as_paid() {
	
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$invoice_id = $this->uri->segment(4);
		$invoice_info = $this->Invoices_model->read_invoice_info($invoice_id);
		$data = array(
		'amount' => $invoice_info[0]->grand_total,
		'transaction_type' => 'income',
		'dr_cr' => 'dr',
		'transaction_date' => date('Y-m-d'),
		'payer_payee_id' => $invoice_info[0]->customer_id,
		'payment_method_id' => 3,
		'description' => 'Invoice Payments',
		'reference' => 'Invoice Payments',
		'invoice_id' => $invoice_id,
		'created_at' => date('Y-m-d H:i:s')
		);
		$result = $this->Transactions_model->add_transactions($data);			
		if ($result == TRUE) {		
			$data = array(
				'status' => 1,
			);
			$result = $this->Invoices_model->update_invoice_record($data,$invoice_id);
		} else {
			$Return['error'] = $this->lang->line('xin_error');
		}
		redirect('admin/orders/view/'.$invoice_id);
	}
	// Validate and add info in database
	public function add_invoice_payment() {
	
		if($this->input->post('add_type')=='invoice_payment') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		$invoice_tr = $this->Xin_model->read_invoice_transaction($this->input->post('invoice_id'));
		if ($invoice_tr->num_rows() > 0) {
			$Return['error'] = $this->lang->line('xin_acc_inv_paid_already');
		} 
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		} else if($this->input->post('add_invoice_date')==='') {
			$Return['error'] = $this->lang->line('xin_acc_error_deposit_date');
		} else if($this->input->post('payment_method')==='') {
			$Return['error'] = $this->lang->line('xin_error_makepayment_payment_method');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$invoice_id = $this->input->post('invoice_id');
		$invoice_info = $this->Invoices_model->read_invoice_info($invoice_id);
		$data = array(
		'amount' => $this->input->post('amount'),
		'transaction_type' => 'income',
		'dr_cr' => 'dr',
		'transaction_date' => $this->input->post('add_invoice_date'),
		'payer_payee_id' => $invoice_info[0]->customer_id,
		'payment_method_id' => $this->input->post('payment_method'),
		'description' => $qt_description,
		'reference' => 'Invoice Payments',
		'invoice_id' => $invoice_id,
		'created_at' => date('Y-m-d H:i:s')
		);
		$result = $this->Transactions_model->add_transactions($data);			
		if ($result == TRUE) {		
			$data = array(
				'status' => 1,
			);
			$result = $this->Invoices_model->update_invoice_record($data,$invoice_id);
			$Return['result'] = $this->lang->line('xin_acc_added_payment_invoice');
		} else {
			$Return['error'] = $this->lang->line('xin_error');
		}
		$this->output($Return);
		exit;
	
		
		}
	}
	
	// Validate and add info in database
	public function create_new_invoice() {
	
		if($this->input->post('add_type')=='invoice_create') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */	
		
		if($this->input->post('invoice_number')==='') {
       		$Return['error'] = $this->lang->line('xin_acc_order_no_field');
		} else if($this->input->post('customer_id')==='') {
       		$Return['error'] = $this->lang->line('xin_acc_order_customer_field');
		} else if($this->input->post('invoice_date')==='') {
       		$Return['error'] = $this->lang->line('xin_acc_order_date_field');
		} else if($this->input->post('invoice_due_date')==='') {
			$Return['error'] = $this->lang->line('xin_acc_order_duedate_field');
		} else if($this->input->post('unit_price')==='') {
			$Return['error'] = $this->lang->line('xin_acc_unitp_field');
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$j=0; foreach($this->input->post('item_name') as $items){
				$item_name = $this->input->post('item_name');
				$iname = $item_name[$j];
				// item qty
				$qty = $this->input->post('qty_hrs');
				$qtyhrs = $qty[$j];
				// item price
				$unit_price = $this->input->post('unit_price');
				$price = $unit_price[$j];
				
				if($iname==='') {
					$Return['error'] = $this->lang->line('xin_acc_itemp_field');
				} else if($qty==='') {
					$Return['error'] = $this->lang->line('xin_acc_qtyhrs_field');
				} else if($price==='' || $price===0) {
					$Return['error'] = $j. " ".$this->lang->line('xin_acc_p_price_field');
				}
				$j++;
		}
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'customer_id' => $this->input->post('customer_id'),
		'invoice_number' => $this->input->post('invoice_number'),
		'invoice_date' => $this->input->post('invoice_date'),
		'invoice_due_date' => $this->input->post('invoice_due_date'),
		'prefix' => $this->input->post('prefix'),
		'sub_total_amount' => $this->input->post('items_sub_total'),
		'total_tax' => $this->input->post('items_tax_total'),
		'discount_type' => $this->input->post('discount_type'),
		'discount_figure' => $this->input->post('discount_figure'),
		'total_discount' => $this->input->post('discount_amount'),
		'grand_total' => $this->input->post('fgrand_total'),
		'invoice_note' => $this->input->post('invoice_note'),
		'status' => '0',
		'created_at' => date('d-m-Y H:i:s')
		);
		$result = $this->Invoices_model->add_invoice_record($data);

		if ($result) {
			$key=0;
			foreach($this->input->post('item_name') as $items){

				/* get items info */
				// item name
				//$iname = $items['item_name']; 
				$item_name = $this->input->post('item_name');
				$iname = $item_name[$key]; 
				// item qty
				$qty = $this->input->post('qty_hrs');
				$qtyhrs = $qty[$key]; 
				// item price
				$unit_price = $this->input->post('unit_price');
				$price = $unit_price[$key]; 
				// item tax_id
				$taxt = $this->input->post('tax_type');
				$tax_type = $taxt[$key]; 
				// item tax_rate
				$tax_rate_item = $this->input->post('tax_rate_item');
				$tax_rate = $tax_rate_item[$key];
				// item sub_total
				$sub_total_item = $this->input->post('sub_total_item');
				$item_sub_total = $sub_total_item[$key];
				// add values  
				$pmodel = $this->Products_model->read_product_information($iname);
				$data2 = array(
				'invoice_id' => $result,
				'customer_id' => $this->input->post('customer_id'),
				'item_id' => $iname,
				'item_name' => $pmodel[0]->product_name,
				'item_qty' => $qtyhrs,
				'item_unit_price' => $price,
				'item_tax_type' => $tax_type,
				'item_tax_rate' => $tax_rate,
				'item_sub_total' => $item_sub_total,
				'sub_total_amount' => $this->input->post('items_sub_total'),
				'total_tax' => $this->input->post('items_tax_total'),
				'discount_type' => $this->input->post('discount_type'),
				'discount_figure' => $this->input->post('discount_figure'),
				'total_discount' => $this->input->post('discount_amount'),
				'grand_total' => $this->input->post('fgrand_total'),
				'created_at' => date('d-m-Y H:i:s')
				);
				$result_item = $this->Invoices_model->add_invoice_items_record($data2);
				// add products > 
				$add_product_qty = $pmodel[0]->product_qty - $qtyhrs;
				$idata = array(
					'product_qty' => $add_product_qty,
				);
				$iresult = $this->Products_model->update_record($idata,$iname);
			$key++; }
			$Return['result'] = $this->lang->line('xin_acc_order_created');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function mark_as(){
		
		$id = $this->uri->segment(4);
		$txt = $this->uri->segment(5);
		////
		$data = array(
			'status' => $txt,
		);
		$result = $this->Invoices_model->update_invoice_record($data,$id);
		redirect('admin/invoices/view/'.$id);
	}
	
	// Validate and add info in database
	public function update_invoice() {
	
		if($this->input->post('add_type')=='invoice_create') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = $this->uri->segment(4);
	
		// add purchase items
		foreach($this->input->post('item') as $eitem_id=>$key_val){
			
			/* get items info */
			// item qty
			$item_name = $this->input->post('eitem_name');
			$iname = $item_name[$key_val]; 
			// item qty
			$qty = $this->input->post('eqty_hrs');
			$qtyhrs = $qty[$key_val]; 
			// item price
			$unit_price = $this->input->post('eunit_price');
			$price = $unit_price[$key_val]; 
			// item tax_id
			$taxt = $this->input->post('etax_type');
			$tax_type = $taxt[$key_val]; 
			// item tax_rate
			$tax_rate_item = $this->input->post('etax_rate_item');
			$tax_rate = $tax_rate_item[$key_val];
			// item sub_total
			$sub_total_item = $this->input->post('esub_total_item');
			$item_sub_total = $sub_total_item[$key_val];
			$pmodel = $this->Products_model->read_product_information($iname);
			// update item values  
			$data = array(
				'item_id' => $iname,
				'item_name' => $pmodel[0]->product_name,
				'item_qty' => $qtyhrs,
				'item_unit_price' => $price,
				'item_tax_type' => $tax_type,
				'item_tax_rate' => $tax_rate,
				'item_sub_total' => $item_sub_total,
				'sub_total_amount' => $this->input->post('items_sub_total'),
				'total_tax' => $this->input->post('items_tax_total'),
				'discount_type' => $this->input->post('discount_type'),
				'discount_figure' => $this->input->post('discount_figure'),
				'total_discount' => $this->input->post('discount_amount'),
				'grand_total' => $this->input->post('fgrand_total'),
			);
			$result_item = $this->Invoices_model->update_invoice_items_record($data,$eitem_id);
			
		}
		
		////
		$data = array(
		'sub_total_amount' => $this->input->post('items_sub_total'),
		'total_tax' => $this->input->post('items_tax_total'),
		'discount_type' => $this->input->post('discount_type'),
		'discount_figure' => $this->input->post('discount_figure'),
		'total_discount' => $this->input->post('discount_amount'),
		'grand_total' => $this->input->post('fgrand_total'),
		'invoice_note' => $this->input->post('invoice_note'),
		);
		$result = $this->Invoices_model->update_invoice_record($data,$id);
	

		if($this->input->post('item_name')) {
			$key=0;
			foreach($this->input->post('item_name') as $items){

				/* get items info */
				// item name
				$item_name = $this->input->post('item_name');
				$iname = $item_name[$key]; 
				// item qty
				$qty = $this->input->post('qty_hrs');
				$qtyhrs = $qty[$key]; 
				// item price
				$unit_price = $this->input->post('unit_price');
				$price = $unit_price[$key]; 
				// item tax_id
				$taxt = $this->input->post('tax_type');
				$tax_type = $taxt[$key]; 
				// item tax_rate
				$tax_rate_item = $this->input->post('tax_rate_item');
				$tax_rate = $tax_rate_item[$key];
				// item sub_total
				$sub_total_item = $this->input->post('sub_total_item');
				$item_sub_total = $sub_total_item[$key];
				// add values  
				$data2 = array(
				'invoice_id' => $id,
				'customer_id' => $this->input->post('customer_id'),
				'item_name' => $iname,
				'item_qty' => $qtyhrs,
				'item_unit_price' => $price,
				'item_tax_type' => $tax_type,
				'item_tax_rate' => $tax_rate,
				'item_sub_total' => $item_sub_total,
				'sub_total_amount' => $this->input->post('items_sub_total'),
				'total_tax' => $this->input->post('items_tax_total'),
				'discount_type' => $this->input->post('discount_type'),
				'discount_figure' => $this->input->post('discount_figure'),
				'total_discount' => $this->input->post('discount_amount'),
				'grand_total' => $this->input->post('fgrand_total'),
				'created_at' => date('d-m-Y H:i:s')
				);
				$result_item = $this->Invoices_model->add_invoice_items_record($data2);
				
			$key++; }
			$Return['result'] = $this->lang->line('xin_acc_order_updated');
		} else {
			//$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$Return['result'] = $this->lang->line('xin_acc_order_updated');
		$this->output($Return);
		exit;
		}
	}
	
	// delete a purchase record
	public function delete_item() {
		
		if($this->uri->segment(5) == 'isajax') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			
			$result = $this->Invoices_model->delete_invoice_items_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_acc_order_item_del');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete a purchase record
	public function delete() {
		
		if($this->input->post('is_ajax') == '2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			
			$result = $this->Invoices_model->delete_record($id);
			$del_data = delete_sales_transaction_data($id);
			if(isset($id)) {
				$invoice_info = $this->Invoices_model->get_invoice_items($id);
				foreach($invoice_info as $invinfo){
					$product_info = $this->Products_model->read_product_information($invinfo->item_id);
					// current qty
					$product_qty = $product_info[0]->product_qty;
					// purchased qty
					$item_qty = $invinfo->item_qty;
					// new qty
					$new_qty = $product_qty + $item_qty;
					$new_product_data = array(
						'product_qty' => $new_qty,
					);
					$this->Products_model->update_record($new_product_data,$invinfo->item_id);
				}
				$result_item = $this->Invoices_model->delete_invoice_items($id);
				$Return['result'] = $this->lang->line('xin_acc_order_del');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete a tax record
	public function tax_delete() {
		if($this->input->post('is_ajax')==='2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Invoices_model->delete_tax_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_product_tax_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
} 
?>