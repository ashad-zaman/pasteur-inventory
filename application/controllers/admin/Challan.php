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

class Challan extends MY_Controller
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
      $this->load->model('Challan_model');
		  $this->load->model('Xin_model');
		  $this->load->model("Products_model");
		  $this->load->model("Tax_model");
		  $this->load->model("Invoices_model");
		  $this->load->model('Quotes_model');
		  $this->load->model("Customers_model");
		  $this->load->model("Suppliers_model");
			$this->load->model("Transactions_model");
			$this->load->model("company_model");
     }
	 
	// challans page
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_acc_challanes').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_challanes');
		$data['all_taxes'] = $this->Tax_model->get_all_taxes();
		$data['path_url'] = 'hrsale_challanes';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('11',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/challan/challan_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	// create challan page
	public function create() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

		$data['purchases_order_no'] = $this->Challan_model->get_challan_order_no();
		$data['purchases_order_no']=($data['purchases_order_no']==null)?1000:(1000+$data['purchases_order_no']+1);

		//print_r($data['purchases_order_no']);exit;

		$data['title'] = $this->lang->line('xin_acc_challanes').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_challanes');
		$data['all_taxes'] = $this->Tax_model->get_all_taxes();
		$data['all_suppliers'] = $this->Suppliers_model->get_suppliers();
		$data['all_items'] = $this->Xin_model->get_items();
		$data['all_payment_methods'] = $this->Xin_model->get_payment_method();
		$data['path_url'] = 'create_hrsale_challan';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('10',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/challan/create_challan", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
	
	// get_challan_items
	 public function get_challan_items() {

		$data['title'] = $this->Xin_model->site_title();
		
		$data = array(
			'all_taxes' => $this->Tax_model->get_all_taxes(),
			'all_items' => $this->Xin_model->get_items()
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/challan/get_challan_items", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	
	 public function get_quation_number()
	 {
		 $company_id=$this->input->get('company_id');
 
		 $company_details = $this->company_model->read_company_information($company_id);
		 $challan_query=$this->Challan_model->get_challans_for_company($company_id);
		 $query_data=$challan_query->result();
		 $count_challan=count($query_data);
		 $challan_number="";
		 if($count_challan>=0)
		 {
			 $challan_number="PPS/".$company_details[0]->short_name."/".date('Ymd')."-".($count_challan+1);
		 }
		 echo $challan_number;
 
	 }
	 
	 // get_challan_items
	 public function get_company_address() {
		 $company_id=$this->input->get('company_id');
 
		 $data['title'] = $this->Xin_model->site_title();
		 
		 
		 $session = $this->session->userdata('username');
		 if(!empty($session)&&$company_id>0){ 
 
			 $all_addresses= $this->Customers_model->get_all_customers_bycompany($company_id);
			 $options='<option value=""></option>';
			 foreach($all_addresses as $address)
			 {
				 $options.='<option value="'.$address->customer_id.'">'. $address->name.'-'.$address->address_1.'</option>';
			 }
			 //	print_r($data);
			 //$this->load->view("admin/quo/get_items", $data);
		 } else {
			 redirect('admin/');
		 }
 
		 echo $options;
		 // Datatables Variables
		 $draw = intval($this->input->get("draw"));
		 $start = intval($this->input->get("start"));
		 $length = intval($this->input->get("length"));
		}
	 // edit challan page
	 public function edit() {
	 
		 $session = $this->session->userdata('username');
		 if(empty($session)){ 
			 redirect('admin/');
		 }
		 
		 $data['title'] = $this->Xin_model->site_title();
		 $session = $this->session->userdata('username');
		 
		 $challan_id = $this->uri->segment(4);
		 $challan_info = $this->Challan_model->read_challan_info($challan_id);
		 if(is_null($challan_info)){
			 redirect('admin/challan');
		 }
		 $role_resources_ids = $this->Xin_model->user_role_resource();
		 if(!in_array('17',$role_resources_ids)) { //edit
			 redirect('admin/challan');
		 }
		 // get project
		 $customer = $this->Customers_model->read_customer_info($challan_info[0]->customer_id); 
		 // get country
	 //	$country = $this->Xin_model->read_country_info($supplier[0]->country_id);
		 // get company info
		 $company = $this->Xin_model->read_company_setting_info(1);
		 // get company > country info
		 $ccountry = $this->Xin_model->read_country_info($company[0]->country);
		 $data = array(
			 'title' => $this->lang->line('xin_acc_edit_challan').' #'.$challan_info[0]->challan_id,
			 'breadcrumbs' => $this->lang->line('xin_acc_edit_challan'),
			 'path_url' => 'create_hrsale_challan',
			 'challan_id' => $challan_info[0]->challan_id,
			 'prefix' => $challan_info[0]->prefix,
			 'challan_number' => $challan_info[0]->challan_number,
			 'challan_title' => $challan_info[0]->challan_title,
			 'customer_id' => $customer[0]->customer_id,
			 'company_id' => $customer[0]->company_id,
			 'challan_date' => $challan_info[0]->challan_date,
			 'challan_due_date' => $challan_info[0]->challan_due_date,
 
			 
			 'product_total_amount' =>  $challan_info[0]->product_total_amount,
			 'product_total_amount_inc_vat' => $challan_info[0]->product_total_amount_inc_vat,
			 'sub_total_amount' => $challan_info[0]->sub_total_amount,
			 'discount_type' => $challan_info[0]->discount_type,
			 'discount_figure' => $challan_info[0]->discount_figure,
			 'total_tax' => $challan_info[0]->total_tax,
 
 
			 'total_discount' => $challan_info[0]->total_discount,
			 'grand_total' => $challan_info[0]->grand_total,
			 'challan_note' => $challan_info[0]->challan_note,
 
			 
			 
 
			 'all_items' => $this->Xin_model->get_items(),
			 'all_taxes' => $this->Tax_model->get_all_taxes(),
		 //	'product_for_purchase_invoice' => $this->Products_model->product_for_purchase_invoice(),
		 //	'all_taxes' => $this->Products_model->get_taxes()
			 );
			 $role_resources_ids = $this->Xin_model->user_role_resource();
		 //if(in_array('3',$role_resources_ids)) {
			 $data['subview'] = $this->load->view("admin/challan/edit_challan", $data, TRUE);
			 $this->load->view('admin/layout/layout_main', $data); //page load			
		 //} else {
		 //	redirect('admin/dashboard/');
		 //}			  
			}
	// edit challan page
	public function generate_new_challane() {
	 echo  $pid=$this->input->get('pid');
	echo $pid=base64_decode($pid);
	echo $qArray=$this->input->get('qArray');
	echo $qArray=base64_decode($qArray);
	exit;
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		
		$challan_id = $this->uri->segment(4);
		$challan_info = $this->Challan_model->read_challan_info($challan_id);
		if(is_null($challan_info)){
			redirect('admin/challan');
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!in_array('17',$role_resources_ids)) { //edit
			redirect('admin/challan');
		}
		// get project
		$customer = $this->Customers_model->read_customer_info($challan_info[0]->customer_id); 
		// get country
	//	$country = $this->Xin_model->read_country_info($supplier[0]->country_id);
		// get company info
		$company = $this->Xin_model->read_company_setting_info(1);
		// get company > country info
		$ccountry = $this->Xin_model->read_country_info($company[0]->country);
		$data = array(
			'title' => $this->lang->line('xin_acc_edit_challan').' #'.$challan_info[0]->challan_id,
			'breadcrumbs' => $this->lang->line('xin_acc_edit_challan'),
			'path_url' => 'create_hrsale_challan',
			'challan_id' => $challan_info[0]->challan_id,
			'prefix' => $challan_info[0]->prefix,
			'challan_number' => $challan_info[0]->challan_number,
			'challan_title' => $challan_info[0]->challan_title,
			'customer_id' => $customer[0]->customer_id,
			'company_id' => $customer[0]->company_id,
			'challan_date' => $challan_info[0]->challan_date,
			'challan_due_date' => $challan_info[0]->challan_due_date,

			
			'product_total_amount' =>  $challan_info[0]->product_total_amount,
			'product_total_amount_inc_vat' => $challan_info[0]->product_total_amount_inc_vat,
			'sub_total_amount' => $challan_info[0]->sub_total_amount,
			'discount_type' => $challan_info[0]->discount_type,
			'discount_figure' => $challan_info[0]->discount_figure,
			'total_tax' => $challan_info[0]->total_tax,


			'total_discount' => $challan_info[0]->total_discount,
			'grand_total' => $challan_info[0]->grand_total,
			'challan_note' => $challan_info[0]->challan_note,

			
			

			'all_items' => $this->Xin_model->get_items(),
			'all_taxes' => $this->Tax_model->get_all_taxes(),
		//	'product_for_purchase_invoice' => $this->Products_model->product_for_purchase_invoice(),
		//	'all_taxes' => $this->Products_model->get_taxes()
			);
			$role_resources_ids = $this->Xin_model->user_role_resource();
		//if(in_array('3',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/challan/edit_challan", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load			
		//} else {
		//	redirect('admin/dashboard/');
		//}			  
		   }	
		public function mark_as(){
		 
		 $id = $this->uri->segment(4);
		 $txt = $this->uri->segment(5);
		 ////
		 $data = array(
			 'status' => $txt,
		 );
		 $result = $this->Challan_model->update_challan_record($data,$id);
		 redirect('admin/challans/view/'.$id);
	 }
	 
	 // view challan page
	 public function view() {
	 
		 $session = $this->session->userdata('username');
		 if(empty($session)){ 
			 redirect('admin/');
		 }
		 
		 $data['title'] = $this->Xin_model->site_title();
		 $session = $this->session->userdata('username');
		 
		 $challan_id = $this->uri->segment(4);
		 $challan_info = $this->Challan_model->read_challan_info($challan_id);
		 if(is_null($challan_info)){
			 redirect('admin/challan');
		 }
		 $role_resources_ids = $this->Xin_model->user_role_resource();
		 if(!in_array('17',$role_resources_ids)) { //view
			 redirect('admin/challan');
		 }
		 // get project
		 $customer = $this->Customers_model->read_customer_info($challan_info[0]->customer_id); 
		 // get country
	 //	$country = $this->Xin_model->read_country_info($supplier[0]->country_id);
		 // get company info
		 $company = $this->Xin_model->read_company_setting_info(1);
		 // get company > country info
		 $ccountry = $this->Xin_model->read_country_info($company[0]->country);
		 
		 $data = array(
			 'title' => $this->lang->line('xin_acc_view_challan').' #'.$challan_info[0]->challan_id,
			 'breadcrumbs' => $this->lang->line('xin_acc_view_challan'),
			 'path_url' => 'create_hrsale_quotation',
			 'challan_id' => $challan_info[0]->challan_id,
			 'prefix' => $challan_info[0]->prefix,
			 'challan_number' => $challan_info[0]->challan_number,
			 'challan_title' => $challan_info[0]->challan_title,
			 'customer_id' => $customer[0]->customer_id,
			 'challan_date' => $challan_info[0]->challan_date,
			 'challan_due_date' => $challan_info[0]->challan_due_date,
 
			//  'your_ref' =>$challan_info[0]->your_ref,
			//  'revision' => $challan_info[0]->revision,
			//  'demand_order_no' => $challan_info[0]->demand_order_no,
 
			//  'product_total_amount' => $challan_info[0]->product_total_amount,
			//  'product_total_amount_inc_vat' => $challan_info[0]->product_total_amount_inc_vat,
 
			//  'sub_total_amount' => $challan_info[0]->sub_total_amount,
			//  'discount_type' => $challan_info[0]->discount_type,
			//  'discount_figure' => $challan_info[0]->discount_figure,
			//  'total_tax' => $challan_info[0]->total_tax,
			//  'vat_type' => $challan_info[0]->vat_type,
			//  'vat_amount' => $challan_info[0]->vat_amount,
	 
			//  'tax_type' => $challan_info[0]->tax_type,
			//  'tax_amount' => $challan_info[0]->tax_amount,
			//  'total_discount' => $challan_info[0]->total_discount,
			//  'grand_total' => $challan_info[0]->grand_total,
			 'challan_note' => $challan_info[0]->challan_note,
 
			//  'terms_of_payment' =>$challan_info[0]->terms_of_payment,
			//  'delivery_condition' => $challan_info[0]->delivery_condition,
			//  'offer_validity' => $challan_info[0]->offer_validity,
			//  'delivery_time' => $challan_info[0]->delivery_time,
			//  'partial_shipment' => $challan_info[0]->partial_shipment,
 
 
 
			 'status' => $challan_info[0]->status,
			 'company_name' => $company[0]->company_name,
			 'company_address' => $company[0]->address_1,
			 'company_reg_address1' => $company[0]->reg_address_1,
			 'company_reg_address2' => $company[0]->reg_address_2,
			 'company_zipcode' => $company[0]->zipcode,
			 'company_city' => $company[0]->city,
			 'company_state' => $company[0]->state,
			 'company_phone' => $company[0]->phone,
			 'company_email' => $company[0]->company_email,
			 'company_fax' => $company[0]->fax,
			 'company_country' => $ccountry[0]->country_name,
			 'all_items' => $this->Xin_model->get_items(),
			 'all_taxes' => $this->Tax_model->get_all_taxes(),
		 //	'product_for_purchase_invoice' => $this->Products_model->product_for_purchase_invoice(),
		 //	'all_taxes' => $this->Products_model->get_taxes()
			 );
			 $role_resources_ids = $this->Xin_model->user_role_resource();
			 //if(in_array('3',$role_resources_ids)) {
			 $data['subview'] = $this->load->view("admin/challan/challan_view", $data, TRUE);
			 $this->load->view('admin/layout/layout_main', $data); //page load			
		 //} else {
		 //	redirect('admin/dashboard/');
		 //}		  
			}
		
		// view challan page
	 public function preview() {
	 
		 $session = $this->session->userdata('username');
		 if(empty($session)){ 
			 redirect('admin/');
		 }
		 
		 $data['title'] = $this->Xin_model->site_title();
		 $session = $this->session->userdata('username');
		 
		 $challan_id = $this->uri->segment(4);
		 $challan_info = $this->Challan_model->read_challan_info($challan_id);
		 if(is_null($challan_info)){
			 redirect('admin/challan');
		 }
		 $role_resources_ids = $this->Xin_model->user_role_resource();
		 if(!in_array('17',$role_resources_ids)) { //view
			 redirect('admin/challan');
		 }
		 // get project
		 $customer = $this->Customers_model->read_customer_info($challan_info[0]->customer_id); 
		 // get country
	 //	$country = $this->Xin_model->read_country_info($supplier[0]->country_id);
		 // get company info
		 $company = $this->Xin_model->read_company_setting_info(1);
		 // get company > country info
		 $ccountry = $this->Xin_model->read_country_info($company[0]->country);
		 
		 $data = array(
			 'title' => $this->lang->line('xin_acc_view_challan').' #'.$challan_info[0]->challan_id,
			 'breadcrumbs' => $this->lang->line('xin_acc_view_challan'),
			 'path_url' => 'create_hrsale_quotation',
			 'challan_id' => $challan_info[0]->challan_id,
			 'prefix' => $challan_info[0]->prefix,
			 'challan_number' => $challan_info[0]->challan_number,
			 'challan_title' => $challan_info[0]->challan_title,
			 'customer_id' => $customer[0]->customer_id,
			 'challan_date' => $challan_info[0]->challan_date,
			//  'challan_due_date' => $challan_info[0]->challan_due_date,
 
			//  'your_ref' =>$challan_info[0]->your_ref,
			//  'revision' => $challan_info[0]->revision,
			//  'demand_order_no' => $challan_info[0]->demand_order_no,
 
			//  'product_total_amount' => $challan_info[0]->product_total_amount,
			//  'product_total_amount_inc_vat' => $challan_info[0]->product_total_amount_inc_vat,
 
			//  'sub_total_amount' => $challan_info[0]->sub_total_amount,
			//  'discount_type' => $challan_info[0]->discount_type,
			//  'discount_figure' => $challan_info[0]->discount_figure,
			//  'total_tax' => $challan_info[0]->total_tax,
			//  'vat_type' => $challan_info[0]->vat_type,
			//  'vat_amount' => $challan_info[0]->vat_amount,
	 
			//  'tax_type' => $challan_info[0]->tax_type,
			//  'tax_amount' => $challan_info[0]->tax_amount,
			//  'total_discount' => $challan_info[0]->total_discount,
			//  'grand_total' => $challan_info[0]->grand_total,
			 'challan_note' => $challan_info[0]->challan_note,
 
			//  'terms_of_payment' =>$challan_info[0]->terms_of_payment,
			//  'delivery_condition' => $challan_info[0]->delivery_condition,
			//  'offer_validity' => $challan_info[0]->offer_validity,
			//  'delivery_time' => $challan_info[0]->delivery_time,
			//  'partial_shipment' => $challan_info[0]->partial_shipment,
 
 
 
			 'status' => $challan_info[0]->status,
			 'company_name' => $company[0]->company_name,
			 'company_address' => $company[0]->address_1,
			 'company_reg_address1' => $company[0]->reg_address_1,
			 'company_reg_address2' => $company[0]->reg_address_2,
			 'company_zipcode' => $company[0]->zipcode,
			 'company_city' => $company[0]->city,
			 'company_state' => $company[0]->state,
			 'company_phone' => $company[0]->phone,
			 'company_email' => $company[0]->company_email,
			 'company_fax' => $company[0]->fax,
			 'company_country' => $ccountry[0]->country_name,
			 'all_items' => $this->Xin_model->get_items(),
			 'all_taxes' => $this->Tax_model->get_all_taxes(),
		 //	'product_for_purchase_invoice' => $this->Products_model->product_for_purchase_invoice(),
		 //	'all_taxes' => $this->Products_model->get_taxes()
			 );
			 $role_resources_ids = $this->Xin_model->user_role_resource();
			 //if(in_array('3',$role_resources_ids)) {
			 $data['subview'] = $this->load->view("admin/challan/preview_challan", $data, TRUE);
			 $this->load->view('admin/layout/pre_layout_main', $data); //page load			
		 //} else {
		 //	redirect('admin/dashboard/');
		 //}		  
			}
		
		public function convert_to_invoice() {
		 $data['title'] = $this->Xin_model->site_title();
		 $session = $this->session->userdata('username');
		 if(empty($session)){ 
			 redirect('admin/');
		 }
		 $challan_id = $this->uri->segment(4);
		 $challan_info = $this->Challan_model->read_challan_info($challan_id);
		 if(is_null($challan_info)){
			 redirect('admin/challan/view/'.$challan_id);
		 }
		 // get customer
		 $customer = $this->Customers_model->read_customer_info($challan_info[0]->customer_id); 
		 // get company info
		 $company = $this->Xin_model->read_company_setting_info(1);
		 // get company > country info
		 $ccountry = $this->Xin_model->read_country_info($company[0]->country);
		 
		 $data = array(
		 'customer_id' => $challan_info[0]->customer_id,
		 'invoice_number' => $challan_info[0]->challan_number,
		 'invoice_date' => $challan_info[0]->challan_date,
		 'invoice_due_date' => $challan_info[0]->challan_due_date,
		 'prefix' => $challan_info[0]->prefix,
		 'sub_total_amount' => $challan_info[0]->sub_total_amount,
		 'vat_type' => $challan_info[0]->vat_type,
			 'vat_amount' => $challan_info[0]->vat_amount,
	 
			 'tax_type' => $challan_info[0]->tax_type,
			 'tax_amount' => $challan_info[0]->tax_amount,
		 'total_tax' => $challan_info[0]->total_tax,
		 'discount_type' => $challan_info[0]->discount_type,
		 'discount_figure' => $challan_info[0]->discount_figure,
		 'total_discount' => $challan_info[0]->total_discount,
		 'grand_total' => $challan_info[0]->grand_total,
		 'invoice_note' => $challan_info[0]->challan_note,
		 'status' => '0',
		 'created_at' => date('d-m-Y H:i:s')
		 );
		 $result = $this->Invoices_model->add_invoice_record($data);
		 if ($result == TRUE) {	
			 $challan_items = $this->Challan_model->get_challan_items($challan_id);
			 foreach($challan_items as $_item){
				 
				 // add values  
				 $pmodel = $this->Products_model->read_product_information($_item->item_id);
				 $data2 = array(
				 'invoice_id' => $result,
				 'customer_id' => $challan_info[0]->customer_id,
				 'item_id' => $_item->item_id,
				 'item_name' => $pmodel[0]->product_name,
				 'item_qty' => $_item->item_qty,
				 'item_unit_price' => $_item->item_unit_price,
				 'item_tax_type' => $_item->item_tax_type,
				 'item_tax_rate' => $_item->item_tax_rate,
				 'item_sub_total' => $_item->item_sub_total,
				 'sub_total_amount' => $_item->sub_total_amount,
				 'total_tax' => $_item->total_tax,
				 'discount_type' => $_item->discount_type,
				 'discount_figure' => $_item->discount_figure,
				 'total_discount' => $_item->total_discount,
				 'grand_total' => $_item->grand_total,
				 'created_at' => date('d-m-Y H:i:s')
				 );
				 $pmodel2 = $this->Products_model->read_product_information($_item->item_id);
				 // add products > 
				 $add_product_qty = $pmodel2[0]->product_qty - $_item->item_qty;
				 $idata = array(
					 'product_qty' => $add_product_qty,
				 );
				 $iresult = $this->Products_model->update_record($idata,$_item->item_id);
				 
				 $result_item = $this->Invoices_model->add_invoice_items_record($data2);
			 }
		 }
		 //$Return['result'] = 'Converted to invoice successfully.';
		 redirect('admin/orders/view/'.$result);
		}
		
	 public function challan_list() {
 
		 $data['title'] = $this->Xin_model->site_title();
		 $session = $this->session->userdata('username');
		 if(!empty($session)){ 
			 $this->load->view("admin/challan/challan_list", $data);
		 } else {
			 redirect('admin/');
		 }
		 // Datatables Variables
		 $draw = intval($this->input->get("draw"));
		 $start = intval($this->input->get("start"));
		 $length = intval($this->input->get("length"));
		 
		 
		 $challan = $this->Challan_model->get_challanes();
		 $role_resources_ids = $this->Xin_model->user_role_resource();
		 $data = array();
 
					 foreach($challan->result() as $r) {
				 
				 // get grand_total
				$grand_total = $this->Xin_model->currency_sign($r->grand_total);
				 // get customer
				 $customer = $this->Customers_model->read_customer_info($r->customer_id); 
				 if(!is_null($customer)){
					 $cname = $customer[0]->name;
				 } else {
					 $cname = '--';	
				 }
				 $challan_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($r->challan_date);
				 $challan_due_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($r->challan_due_date);
				 //invoice_number
				 $challan_number = '';
				 $challan_number = '<a href="'.site_url().'admin/challan/view/'.$r->challan_id.'/">'.$r->challan_number.'</a>';
				 $edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><a href="'.site_url().'admin/challan/edit/'.$r->challan_id.'/"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-pencil"></span></button></a></span>';
			 $delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->challan_id . '"><span class="fa fa-trash"></span></button></span>';
			 $view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><a href="'.site_url().'admin/challan/view/'.$r->challan_id.'/"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light""><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			 if($r->status == 0){
				 $_status = '<span class="label label-info">'.$this->lang->line('xin_challan_draft').'</span>';
			 } else if($r->status == 1) {
				 $_status = '<span class="label bg-purple">'.$this->lang->line('xin_challan_delivered').'</span>';
			 } else if($r->status == 2) {
				 $_status = '<span class="label label-warning">'.$this->lang->line('xin_challan_on_hold').'</span>';
			 } else if($r->status == 3) {
				 $_status = '<span class="label label-success">'.$this->lang->line('xin_accepted').'</span>';
			 } else if($r->status == 4) {
				 $_status = '<span class="label bg-maroon">'.$this->lang->line('xin_challan_lost').'</span>';
			 } else {
				 $_status = '<span class="label label-danger">'.$this->lang->line('xin_challan_dead').'</span>';
			 }
			 $combhr = $edit.$view.$delete;
								$data[] = array(
							$combhr,
										 $r->challan_id,
					 $challan_number,
										 $cname,
					 $grand_total,
										 $challan_date,
										 $_status,
								);
					 }
					 $output = array(
								"draw" => $draw,
									"recordsTotal" => $challan->num_rows(),
									"recordsFiltered" => $challan->num_rows(),
									"data" => $data
						 );
					 echo json_encode($output);
					 exit();
			}
	 
	 // Validate and add info in database
	 public function create_new_challan() {
	 
		 if($this->input->post('add_type')=='challan_create') {		
		 /* Define return | here result is used to return user data and error for error message */
		 $Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		 $Return['csrf_hash'] = $this->security->get_csrf_hash();
			 
		 /* Server side PHP input validation */	
		 
		 if($this->input->post('challan_number')==='') {
						$Return['error'] = $this->lang->line('xin_acc_challan_no_field');
		 } else if($this->input->post('customer_id')==='') {
						$Return['error'] = $this->lang->line('xin_acc_order_customer_field');
		 } else if($this->input->post('challan_date')==='') {
						$Return['error'] = $this->lang->line('xin_acc_challan_date_field');
		 } else if($this->input->post('challan_due_date')==='') {
			 $Return['error'] = $this->lang->line('xin_acc_challan_duedate_field');
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
		 'company_id' => $this->input->post('company_id'),
		 'customer_id' => $this->input->post('customer_id'),
		 'challan_number' => $this->input->post('challan_number'),
		 'challan_title' => $this->input->post('challan_title'),
 
		 'challan_date' => $this->input->post('challan_date'),
		//  'challan_due_date' => $this->input->post('challan_due_date'),
 
		//  'your_ref' => $this->input->post('your_ref'),
		//  'revision' => $this->input->post('revision'),
		//  'demand_order_no' => $this->input->post('demand_order_no'),
 
 
 
 
		//  'prefix' => $this->input->post('prefix'),
		//  'product_total_amount' => $this->input->post('product_total_amount'),
		//  'product_total_amount_inc_vat' => $this->input->post('product_total_amount_inc_vat'),
		//  'sub_total_amount' => $this->input->post('items_sub_total'),
 
		//  'vat_type' => $this->input->post('vat_type_total'),
		//  'vat_amount' => $this->input->post('vat_total'),
 
		//  'tax_type' => $this->input->post('tax_type_total'),
		//  'tax_amount' => $this->input->post('tax_total'),
 
		 //'total_tax' => $this->input->post('items_tax_total'),
		//  'discount_type' => $this->input->post('discount_type'),
		//  'discount_figure' => $this->input->post('discount_figure'),
		//  'total_discount' => $this->input->post('discount_amount'),
		//  'grand_total' => $this->input->post('fgrand_total'),
		 'challan_note' => $this->input->post('challan_note'),
 
		//  'terms_of_payment' => $this->input->post('terms_of_payment'),
		//  'delivery_condition' => $this->input->post('delivery_condition'),
		//  'offer_validity' => $this->input->post('offer_validity'),
		//  'delivery_time' => $this->input->post('delivery_time'),
		//  'partial_shipment' => $this->input->post('partial_shipment'),
 
		 'status' => '0',
		 'created_at' => date('d-m-Y H:i:s')
		 );
		 $result = $this->Challan_model->add_challan_record($data);
 
		 if ($result) {
			 $key=0;
			 foreach($this->input->post('item_name') as $items){
 
				 /* get items info */
 
				 $item_code = $this->input->post('code');
				 $icode = $item_code[$key]; 
 
				 $item_capacity = $this->input->post('capacity');
				 $icapacity = $item_capacity[$key]; 
 
				 $item_remarks = $this->input->post('remarks');
				 $iremarks = $item_remarks[$key]; 
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
				 // $taxt = $this->input->post('tax_type');
				 // $tax_type = $taxt[$key]; 
				 // // item tax_rate
				 // $tax_rate_item = $this->input->post('tax_rate_item');
				 // $tax_rate = $tax_rate_item[$key];
				 // item sub_total
				 $sub_total_item = $this->input->post('sub_total_item');
				 $item_sub_total = $sub_total_item[$key];
				 // add values  
				 $pmodel = $this->Products_model->read_product_information($iname);
				 $data2 = array(
				 'challan_id' => $result,
				 'customer_id' => $this->input->post('customer_id'),
				 'item_id' => $iname,
				 'item_name' => $pmodel[0]->product_name,
 
				 'code' => $icode,
				 'capacity' =>$icapacity,
				 'remarks' => $iremarks,
 
 
				 'item_qty' => $qtyhrs,
				//  'item_unit_price' => $price,
				//  // 'item_tax_type' => $tax_type,
				//  // 'item_tax_rate' => $tax_rate,
				//  'item_sub_total' => $item_sub_total,
				//  'sub_total_amount' => $this->input->post('items_sub_total'),
				//  'total_tax' => $this->input->post('items_tax_total'),
				//  'discount_type' => $this->input->post('discount_type'),
				//  'discount_figure' => $this->input->post('discount_figure'),
				//  'total_discount' => $this->input->post('discount_amount'),
				//  'grand_total' => $this->input->post('fgrand_total'),
				 'created_at' => date('d-m-Y H:i:s')
				 );
				 //print_r($data2);exit;
				 $result_item = $this->Challan_model->add_challan_items_record($data2);
				 
			 $key++; }
			 $Return['result'] = $this->lang->line('xin_acc_challan_created');
		 } else {
			 $Return['error'] = $this->lang->line('xin_error_msg');
		 }
		 $this->output($Return);
		 exit;
		 }
	 }
	 
	 // Validate and add info in database
	 public function update_challan() {
		
		 if($this->input->post('add_type')=='challan_create') {	
			 
			
		 /* Define return | here result is used to return user data and error for error message */
		 $Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		 $Return['csrf_hash'] = $this->security->get_csrf_hash();
		 $id = $this->uri->segment(4);
	 
		 // add purchase items
		 foreach($this->input->post('item') as $eitem_id=>$key_val){
			 
			 /* get items info */
 
				 $item_code = $this->input->post('ecode');
					$icode = $item_code[$key_val]; 
 
				 $item_capacity = $this->input->post('ecapacity');
				 $icapacity = $item_capacity[$key_val]; 
 
				 $item_remarks = $this->input->post('eremarks');
				 $iremarks = $item_remarks[$key_val]; 
 
 
			 // item qty
			 $item_name = $this->input->post('eitem_name');
			 $iname = $item_name[$key_val]; 
			 // item qty
			 $qty = $this->input->post('eqty_hrs');
			 $qtyhrs = $qty[$key_val]; 
			 // item price
			//  $unit_price = $this->input->post('eunit_price');
			//  $price = $unit_price[$key_val]; 
 
			 // // item tax_id
			 // $taxt = $this->input->post('etax_type');
			 // $tax_type = $taxt[$key_val]; 
			 // // item tax_rate
			 // $tax_rate_item = $this->input->post('etax_rate_item');
			 // $tax_rate = $tax_rate_item[$key_val];
 
			 // item sub_total
			//  $sub_total_item = $this->input->post('esub_total_item');
			//  $item_sub_total = $sub_total_item[$key_val];
			 
			 // update item values  
			 $pmodel = $this->Products_model->read_product_information($iname);
			 $data = array(
				 'item_id' => $iname,
				 'item_name' => $pmodel[0]->product_name,
 
				 'code' => $icode,
				 'capacity' =>$icapacity,
				 'remarks' => $iremarks,
 
 
				 'item_qty' => $qtyhrs,
				//  'item_unit_price' => $price,
				//  // 'item_tax_type' => $tax_type,
				//  // 'item_tax_rate' => $tax_rate,
				//  'item_sub_total' => $item_sub_total,
				//  'sub_total_amount' => $this->input->post('items_sub_total'),
				//  'total_tax' => $this->input->post('items_tax_total'),
				//  'discount_type' => $this->input->post('discount_type'),
				//  'discount_figure' => $this->input->post('discount_figure'),
				//  'total_discount' => $this->input->post('discount_amount'),
				//  'grand_total' => $this->input->post('fgrand_total'),
			 );
			 $result_item = $this->Challan_model->update_challan_items_record($data,$eitem_id);
			 
		 }
		 
		 ////
		 $data = array(
		 'company_id' => $this->input->post('company_id'),
		 'customer_id' => $this->input->post('customer_id'),
		 'challan_number' => $this->input->post('challan_number'),
		 'challan_title' => $this->input->post('challan_title'),
		 
		 'challan_date' => $this->input->post('challan_date'),
		//  'challan_due_date' => $this->input->post('challan_due_date'),
 
		//  'your_ref' => $this->input->post('your_ref'),
		//  'revision' => $this->input->post('revision'),
		//  'demand_order_no' => $this->input->post('demand_order_no'),
 
		//  'product_total_amount' => $this->input->post('product_total_amount'),
		//  'product_total_amount_inc_vat' => $this->input->post('product_total_amount_inc_vat'),
		//  'sub_total_amount' => $this->input->post('items_sub_total'),
 
 
		//  'vat_type' => $this->input->post('vat_type_total'),
		//  'vat_amount' => $this->input->post('vat_total'),
 
		//  'tax_type' => $this->input->post('tax_type_total'),
		//  'tax_amount' => $this->input->post('tax_total'),
	 //	'total_tax' => $this->input->post('items_tax_total'),
		//  'discount_type' => $this->input->post('discount_type'),
		//  'discount_figure' => $this->input->post('discount_figure'),
		//  'total_discount' => $this->input->post('discount_amount'),
		//  'grand_total' => $this->input->post('fgrand_total'),
		 'challan_note' => $this->input->post('challan_note'),
 
		//  'terms_of_payment' => $this->input->post('terms_of_payment'),
		//  'delivery_condition' => $this->input->post('delivery_condition'),
		//  'offer_validity' => $this->input->post('offer_validity'),
		//  'delivery_time' => $this->input->post('delivery_time'),
		//  'partial_shipment' => $this->input->post('partial_shipment'),
		 );
		 $result = $this->Challan_model->update_challan_record($data,$id);
	 
 
		 if($this->input->post('item_name')) {
			 $key=0;
			 foreach($this->input->post('item_name') as $items){
 
				 /* get items info */
				 $item_code = $this->input->post('code');
				 $icode = $item_code[$key]; 
 
				 $item_capacity = $this->input->post('capacity');
				 $icapacity = $item_capacity[$key]; 
 
				 $item_remarks = $this->input->post('remarks');
				 $iremarks = $item_remarks[$key]; 
 
				 // item name
				 $item_name = $this->input->post('item_name');
				 $iname = $item_name[$key]; 
				 // item qty
				 $qty = $this->input->post('qty_hrs');
				 $qtyhrs = $qty[$key]; 
				 // item price
				//  $unit_price = $this->input->post('unit_price');
				//  $price = $unit_price[$key]; 
				 // item tax_id
				 // $taxt = $this->input->post('tax_type');
				 // $tax_type = $taxt[$key]; 
				 // // item tax_rate
				 // $tax_rate_item = $this->input->post('tax_rate_item');
				 // $tax_rate = $tax_rate_item[$key];
				 // item sub_total
				//  $sub_total_item = $this->input->post('sub_total_item');
				//  $item_sub_total = $sub_total_item[$key];
				 // add values  
				 $pmodel = $this->Products_model->read_product_information($iname);
				 $data2 = array(
				 'challan_id' => $id,
				 'customer_id' => $this->input->post('customer_id'),
				 'item_id' => $iname,
				 'item_name' => $pmodel[0]->product_name,
 
				 'code' => $icode,
				 'capacity' =>$icapacity,
				 'remarks' => $iremarks,
 
 
				 'item_qty' => $qtyhrs,
				 //'item_unit_price' => $price,
				 // 'item_tax_type' => $tax_type,
				 // 'item_tax_rate' => $tax_rate,
				//  'item_sub_total' => $item_sub_total,
				//  'sub_total_amount' => $this->input->post('items_sub_total'),
				//  'total_tax' => $this->input->post('items_tax_total'),
				//  'discount_type' => $this->input->post('discount_type'),
				//  'discount_figure' => $this->input->post('discount_figure'),
				//  'total_discount' => $this->input->post('discount_amount'),
				//  'grand_total' => $this->input->post('fgrand_total'),
				 'created_at' => date('d-m-Y H:i:s')
				 );
				 $result_item = $this->Challan_model->add_challan_items_record($data2);
				 
			 $key++; }
			 $Return['result'] = $this->lang->line('xin_acc_challan_updated');
		 } else {
			 //$Return['error'] = 'Bug. Something went wrong, please try again.';
		 }
		 $Return['result'] = $this->lang->line('xin_acc_challan_updated');
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
			 
			 $result = $this->Challan_model->delete_challan_items_record($id);
			 if(isset($id)) {
				 $Return['result'] = $this->lang->line('xin_acc_challan_item_deleted');
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
			 
			 $result = $this->Challan_model->delete_record($id);
			 if(isset($id)) {
				 $result_item = $this->Challan_model->delete_challan_items($id);
				 $Return['result'] = $this->lang->line('xin_acc_challan_deleted');
			 } else {
				 $Return['error'] = $this->lang->line('xin_error_msg');
			 }
			 $this->output($Return);
		 }
	 }
 } 
 ?>