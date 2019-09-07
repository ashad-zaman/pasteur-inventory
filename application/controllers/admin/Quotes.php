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

class Quotes extends MY_Controller
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
         // $this->load->model('Company_model');
		  $this->load->model('Xin_model');
		  $this->load->model("Products_model");
		  $this->load->model("Tax_model");
		  $this->load->model("Invoices_model");
		  $this->load->model('Quotes_model');
			$this->load->model("Customers_model");
			$this->load->model("company_model");
     }
	 
	// quotes page
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_quotes_title').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_quotes_title');
		$data['all_taxes'] = $this->Tax_model->get_all_taxes();
		$data['path_url'] = 'hrsale_quotes';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('17',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/quotes/quote_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	// create quote page
	public function create() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

		$data['quotes_order_no'] = $this->Quotes_model->get_quotes_order_no();
		$data['quotes_order_no']=($data['quotes_order_no']==null)?1000:(1000+$data['quotes_order_no']+1);

		//print_r($data['quotes_order_no']);exit;

		$data['title'] = $this->lang->line('xin_quote_create').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_quote_create');
		$data['all_taxes'] = $this->Tax_model->get_all_taxes();
		$data['all_items'] = $this->Xin_model->get_items();
		$data['path_url'] = 'create_hrsale_quotation';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('18',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/quotes/create_quote", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
	
	// get_quote_items
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

	public function get_quation_number()
	{
		$company_id=$this->input->get('company_id');

		$company_details = $this->company_model->read_company_information($company_id);
		$quote_query=$this->Quotes_model->get_quotes_for_company($company_id);
		$query_data=$quote_query->result();
		$count_quote=count($query_data);
		$quote_number="";
		if($count_quote>=0)
		{
      $quote_number="PPS/".$company_details[0]->short_name."/".date('Ymd')."-".($count_quote+1);
		}
		echo $quote_number;

	}
	// get_quote_items
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
	// edit quote page
	public function edit() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		
		$quote_id = $this->uri->segment(4);
		$quote_info = $this->Quotes_model->read_quotes_info($quote_id);
		if(is_null($quote_info)){
			redirect('admin/quotes');
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!in_array('17',$role_resources_ids)) { //edit
			redirect('admin/quotes');
		}
		// get project
		$customer = $this->Customers_model->read_customer_info($quote_info[0]->customer_id); 
		// get country
	//	$country = $this->Xin_model->read_country_info($supplier[0]->country_id);
		// get company info
		$company = $this->Xin_model->read_company_setting_info(1);
		// get company > country info
		$ccountry = $this->Xin_model->read_country_info($company[0]->country);
		$data = array(
			'title' => $this->lang->line('xin_acc_edit_quote').' #'.$quote_info[0]->quote_id,
			'breadcrumbs' => $this->lang->line('xin_acc_edit_quote'),
			'path_url' => 'create_hrsale_quotation',
			'quote_id' => $quote_info[0]->quote_id,
			'prefix' => $quote_info[0]->prefix,
			'quote_number' => $quote_info[0]->quote_number,
			'quote_title' => $quote_info[0]->quote_title,
			'customer_id' => $customer[0]->customer_id,
			'company_id' => $customer[0]->company_id,
			'quote_date' => $quote_info[0]->quote_date,
			'quote_due_date' => $quote_info[0]->quote_due_date,

			'your_ref' => $quote_info[0]->your_ref,
			'revision' => $quote_info[0]->revision,
			'demand_order_no' => $quote_info[0]->demand_order_no,

			'product_total_amount' =>  $quote_info[0]->product_total_amount,
			'product_total_amount_inc_vat' => $quote_info[0]->product_total_amount_inc_vat,
			'sub_total_amount' => $quote_info[0]->sub_total_amount,
			'discount_type' => $quote_info[0]->discount_type,
			'discount_figure' => $quote_info[0]->discount_figure,
			'total_tax' => $quote_info[0]->total_tax,

			'vat_type' => $quote_info[0]->vat_type,
			'vat_amount' => $quote_info[0]->vat_amount,
	
			'tax_type' => $quote_info[0]->tax_type,
			'tax_amount' => $quote_info[0]->tax_amount,

			'total_discount' => $quote_info[0]->total_discount,
			'grand_total' => $quote_info[0]->grand_total,
			'quote_note' => $quote_info[0]->quote_note,

			
			'terms_of_payment' =>$quote_info[0]->terms_of_payment,
			'delivery_condition' => $quote_info[0]->delivery_condition,
			'offer_validity' => $quote_info[0]->offer_validity,
			'delivery_time' => $quote_info[0]->delivery_time,
			'partial_shipment' => $quote_info[0]->partial_shipment,

			'all_items' => $this->Xin_model->get_items(),
			'all_taxes' => $this->Tax_model->get_all_taxes(),
		//	'product_for_purchase_invoice' => $this->Products_model->product_for_purchase_invoice(),
		//	'all_taxes' => $this->Products_model->get_taxes()
			);
			$role_resources_ids = $this->Xin_model->user_role_resource();
		//if(in_array('3',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/quotes/edit_quote", $data, TRUE);
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
		$result = $this->Quotes_model->update_quote_record($data,$id);
		redirect('admin/quotes/view/'.$id);
	}
	
	// view Quote page
	public function view() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		
		$quote_id = $this->uri->segment(4);
		$quote_info = $this->Quotes_model->read_quotes_info($quote_id);
		if(is_null($quote_info)){
			redirect('admin/quotes');
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!in_array('17',$role_resources_ids)) { //view
			redirect('admin/quotes');
		}
		// get project
		$customer = $this->Customers_model->read_customer_info($quote_info[0]->customer_id); 
		// get country
	//	$country = $this->Xin_model->read_country_info($supplier[0]->country_id);
		// get company info
		$company = $this->Xin_model->read_company_setting_info(1);
		// get company > country info
		$ccountry = $this->Xin_model->read_country_info($company[0]->country);
		
		$data = array(
			'title' => $this->lang->line('xin_acc_view_quote').' #'.$quote_info[0]->quote_id,
			'breadcrumbs' => $this->lang->line('xin_acc_view_quote'),
			'path_url' => 'create_hrsale_quotation',
			'quote_id' => $quote_info[0]->quote_id,
			'prefix' => $quote_info[0]->prefix,
			'quote_number' => $quote_info[0]->quote_number,
			'quote_title' => $quote_info[0]->quote_title,
			'customer_id' => $customer[0]->customer_id,
			'quote_date' => $quote_info[0]->quote_date,
			'quote_due_date' => $quote_info[0]->quote_due_date,

			'your_ref' =>$quote_info[0]->your_ref,
			'revision' => $quote_info[0]->revision,
			'demand_order_no' => $quote_info[0]->demand_order_no,

			'product_total_amount' => $quote_info[0]->product_total_amount,
			'product_total_amount_inc_vat' => $quote_info[0]->product_total_amount_inc_vat,

			'sub_total_amount' => $quote_info[0]->sub_total_amount,
			'discount_type' => $quote_info[0]->discount_type,
			'discount_figure' => $quote_info[0]->discount_figure,
			'total_tax' => $quote_info[0]->total_tax,
			'vat_type' => $quote_info[0]->vat_type,
			'vat_amount' => $quote_info[0]->vat_amount,
	
			'tax_type' => $quote_info[0]->tax_type,
			'tax_amount' => $quote_info[0]->tax_amount,
			'total_discount' => $quote_info[0]->total_discount,
			'grand_total' => $quote_info[0]->grand_total,
			'quote_note' => $quote_info[0]->quote_note,

			'terms_of_payment' =>$quote_info[0]->terms_of_payment,
			'delivery_condition' => $quote_info[0]->delivery_condition,
			'offer_validity' => $quote_info[0]->offer_validity,
			'delivery_time' => $quote_info[0]->delivery_time,
			'partial_shipment' => $quote_info[0]->partial_shipment,



			'status' => $quote_info[0]->status,
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
			$data['subview'] = $this->load->view("admin/quotes/quote_view", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load			
		//} else {
		//	redirect('admin/dashboard/');
		//}		  
     }
	 
	 // view Quote page
	public function preview() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		
		$quote_id = $this->uri->segment(4);
		$quote_info = $this->Quotes_model->read_quotes_info($quote_id);
		if(is_null($quote_info)){
			redirect('admin/quotes');
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!in_array('17',$role_resources_ids)) { //view
			redirect('admin/quotes');
		}
		// get project
		$customer = $this->Customers_model->read_customer_info($quote_info[0]->customer_id); 
		// get country
	//	$country = $this->Xin_model->read_country_info($supplier[0]->country_id);
		// get company info
		$company = $this->Xin_model->read_company_setting_info(1);
		// get company > country info
		$ccountry = $this->Xin_model->read_country_info($company[0]->country);
		
		$data = array(
			'title' => $this->lang->line('xin_acc_view_quote').' #'.$quote_info[0]->quote_id,
			'breadcrumbs' => $this->lang->line('xin_acc_view_quote'),
			'path_url' => 'create_hrsale_quotation',
			'quote_id' => $quote_info[0]->quote_id,
			'prefix' => $quote_info[0]->prefix,
			'quote_number' => $quote_info[0]->quote_number,
			'quote_title' => $quote_info[0]->quote_title,
			'customer_id' => $customer[0]->customer_id,
			'quote_date' => $quote_info[0]->quote_date,
			'quote_due_date' => $quote_info[0]->quote_due_date,

			'your_ref' =>$quote_info[0]->your_ref,
			'revision' => $quote_info[0]->revision,
			'demand_order_no' => $quote_info[0]->demand_order_no,

			'product_total_amount' => $quote_info[0]->product_total_amount,
			'product_total_amount_inc_vat' => $quote_info[0]->product_total_amount_inc_vat,

			'sub_total_amount' => $quote_info[0]->sub_total_amount,
			'discount_type' => $quote_info[0]->discount_type,
			'discount_figure' => $quote_info[0]->discount_figure,
			'total_tax' => $quote_info[0]->total_tax,
			'vat_type' => $quote_info[0]->vat_type,
			'vat_amount' => $quote_info[0]->vat_amount,
	
			'tax_type' => $quote_info[0]->tax_type,
			'tax_amount' => $quote_info[0]->tax_amount,
			'total_discount' => $quote_info[0]->total_discount,
			'grand_total' => $quote_info[0]->grand_total,
			'quote_note' => $quote_info[0]->quote_note,

			'terms_of_payment' =>$quote_info[0]->terms_of_payment,
			'delivery_condition' => $quote_info[0]->delivery_condition,
			'offer_validity' => $quote_info[0]->offer_validity,
			'delivery_time' => $quote_info[0]->delivery_time,
			'partial_shipment' => $quote_info[0]->partial_shipment,



			'status' => $quote_info[0]->status,
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
			$data['subview'] = $this->load->view("admin/quotes/quote_preview", $data, TRUE);
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
		$quote_id = $this->uri->segment(4);
		$quote_info = $this->Quotes_model->read_quotes_info($quote_id);
		if(is_null($quote_info)){
			redirect('admin/quotes/view/'.$quote_id);
		}
		// get customer
		$customer = $this->Customers_model->read_customer_info($quote_info[0]->customer_id); 
		// get company info
		$company = $this->Xin_model->read_company_setting_info(1);
		// get company > country info
		$ccountry = $this->Xin_model->read_country_info($company[0]->country);
		
		$data = array(
		'customer_id' => $quote_info[0]->customer_id,
		'invoice_number' => $quote_info[0]->quote_number,
		'invoice_date' => $quote_info[0]->quote_date,
		'invoice_due_date' => $quote_info[0]->quote_due_date,
		'prefix' => $quote_info[0]->prefix,
		'sub_total_amount' => $quote_info[0]->sub_total_amount,
		'vat_type' => $quote_info[0]->vat_type,
			'vat_amount' => $quote_info[0]->vat_amount,
	
			'tax_type' => $quote_info[0]->tax_type,
			'tax_amount' => $quote_info[0]->tax_amount,
		'total_tax' => $quote_info[0]->total_tax,
		'discount_type' => $quote_info[0]->discount_type,
		'discount_figure' => $quote_info[0]->discount_figure,
		'total_discount' => $quote_info[0]->total_discount,
		'grand_total' => $quote_info[0]->grand_total,
		'invoice_note' => $quote_info[0]->quote_note,
		'status' => '0',
		'created_at' => date('d-m-Y H:i:s')
		);
		$result = $this->Invoices_model->add_invoice_record($data);
		if ($result == TRUE) {	
			$quote_items = $this->Quotes_model->get_quote_items($quote_id);
			foreach($quote_items as $_item){
				
				// add values  
				$pmodel = $this->Products_model->read_product_information($_item->item_id);
				$data2 = array(
				'invoice_id' => $result,
				'customer_id' => $quote_info[0]->customer_id,
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
	 
	public function quotes_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/quotes/quote_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$quote = $this->Quotes_model->get_quotes();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

          foreach($quote->result() as $r) {
			  
			  // get grand_total
			 $grand_total = $this->Xin_model->currency_sign($r->grand_total);
			  // get customer
			  $customer = $this->Customers_model->read_customer_info($r->customer_id); 
				if(!is_null($customer)){
					$cname = $customer[0]->name;
				} else {
					$cname = '--';	
				}
			  $quote_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($r->quote_date);
			  $quote_due_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($r->quote_due_date);
			  //invoice_number
			  $quote_number = '';
			  $quote_number = '<a href="'.site_url().'admin/quotes/view/'.$r->quote_id.'/">'.$r->quote_number.'</a>';
			  $edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><a href="'.site_url().'admin/quotes/edit/'.$r->quote_id.'/"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-pencil"></span></button></a></span>';
			$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->quote_id . '"><span class="fa fa-trash"></span></button></span>';
			$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><a href="'.site_url().'admin/quotes/view/'.$r->quote_id.'/"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light""><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			if($r->status == 0){
				$_status = '<span class="label label-info">'.$this->lang->line('xin_quote_draft').'</span>';
			} else if($r->status == 1) {
				$_status = '<span class="label bg-purple">'.$this->lang->line('xin_quote_delivered').'</span>';
			} else if($r->status == 2) {
				$_status = '<span class="label label-warning">'.$this->lang->line('xin_quote_on_hold').'</span>';
			} else if($r->status == 3) {
				$_status = '<span class="label label-success">'.$this->lang->line('xin_accepted').'</span>';
			} else if($r->status == 4) {
				$_status = '<span class="label bg-maroon">'.$this->lang->line('xin_quote_lost').'</span>';
			} else {
				$_status = '<span class="label label-danger">'.$this->lang->line('xin_quote_dead').'</span>';
			}
			$combhr = $edit.$view.$delete;
               $data[] = array(
			   		$combhr,
                    $r->quote_id,
					$quote_number,
                    $cname,
					$grand_total,
                    $quote_date,
                    $quote_due_date,
                    $_status,
               );
          }
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $quote->num_rows(),
                 "recordsFiltered" => $quote->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	
	// Validate and add info in database
	public function create_new_quote() {
	
		if($this->input->post('add_type')=='invoice_create') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */	
		
		if($this->input->post('quote_number')==='') {
       		$Return['error'] = $this->lang->line('xin_acc_quote_no_field');
		} else if($this->input->post('customer_id')==='') {
       		$Return['error'] = $this->lang->line('xin_acc_order_customer_field');
		} else if($this->input->post('quote_date')==='') {
       		$Return['error'] = $this->lang->line('xin_acc_quote_date_field');
		} else if($this->input->post('quote_due_date')==='') {
			$Return['error'] = $this->lang->line('xin_acc_quote_duedate_field');
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
		'quote_number' => $this->input->post('quote_number'),
		'quote_title' => $this->input->post('quote_title'),

		'quote_date' => $this->input->post('quote_date'),
		'quote_due_date' => $this->input->post('quote_due_date'),

		'your_ref' => $this->input->post('your_ref'),
		'revision' => $this->input->post('revision'),
		'demand_order_no' => $this->input->post('demand_order_no'),




		'prefix' => $this->input->post('prefix'),
		'product_total_amount' => $this->input->post('product_total_amount'),
		'product_total_amount_inc_vat' => $this->input->post('product_total_amount_inc_vat'),
		'sub_total_amount' => $this->input->post('items_sub_total'),

		'vat_type' => $this->input->post('vat_type_total'),
		'vat_amount' => $this->input->post('vat_total'),

		'tax_type' => $this->input->post('tax_type_total'),
		'tax_amount' => $this->input->post('tax_total'),

		//'total_tax' => $this->input->post('items_tax_total'),
		'discount_type' => $this->input->post('discount_type'),
		'discount_figure' => $this->input->post('discount_figure'),
		'total_discount' => $this->input->post('discount_amount'),
		'grand_total' => $this->input->post('fgrand_total'),
		'quote_note' => $this->input->post('quote_note'),

		'terms_of_payment' => $this->input->post('terms_of_payment'),
		'delivery_condition' => $this->input->post('delivery_condition'),
		'offer_validity' => $this->input->post('offer_validity'),
		'delivery_time' => $this->input->post('delivery_time'),
		'partial_shipment' => $this->input->post('partial_shipment'),

		'status' => '0',
		'created_at' => date('d-m-Y H:i:s')
		);
		$result = $this->Quotes_model->add_quote_record($data);

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
				'quote_id' => $result,
				'customer_id' => $this->input->post('customer_id'),
				'item_id' => $iname,
				'item_name' => $pmodel[0]->product_name,

				'code' => $icode,
				'capacity' =>$icapacity,
				'remarks' => $iremarks,


				'item_qty' => $qtyhrs,
				'item_unit_price' => $price,
				// 'item_tax_type' => $tax_type,
				// 'item_tax_rate' => $tax_rate,
				'item_sub_total' => $item_sub_total,
				'sub_total_amount' => $this->input->post('items_sub_total'),
				'total_tax' => $this->input->post('items_tax_total'),
				'discount_type' => $this->input->post('discount_type'),
				'discount_figure' => $this->input->post('discount_figure'),
				'total_discount' => $this->input->post('discount_amount'),
				'grand_total' => $this->input->post('fgrand_total'),
				'created_at' => date('d-m-Y H:i:s')
				);
				//print_r($data2);exit;
				$result_item = $this->Quotes_model->add_quote_items_record($data2);
				
			$key++; }
			$Return['result'] = $this->lang->line('xin_acc_quote_created');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function update_quote() {
	
		if($this->input->post('add_type')=='invoice_create') {		
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
			$unit_price = $this->input->post('eunit_price');
			$price = $unit_price[$key_val]; 

			// // item tax_id
			// $taxt = $this->input->post('etax_type');
			// $tax_type = $taxt[$key_val]; 
			// // item tax_rate
			// $tax_rate_item = $this->input->post('etax_rate_item');
			// $tax_rate = $tax_rate_item[$key_val];

			// item sub_total
			$sub_total_item = $this->input->post('esub_total_item');
			$item_sub_total = $sub_total_item[$key_val];
			
			// update item values  
			$pmodel = $this->Products_model->read_product_information($iname);
			$data = array(
				'item_id' => $iname,
				'item_name' => $pmodel[0]->product_name,

				'code' => $icode,
				'capacity' =>$icapacity,
				'remarks' => $iremarks,


				'item_qty' => $qtyhrs,
				'item_unit_price' => $price,
				// 'item_tax_type' => $tax_type,
				// 'item_tax_rate' => $tax_rate,
				'item_sub_total' => $item_sub_total,
				'sub_total_amount' => $this->input->post('items_sub_total'),
				'total_tax' => $this->input->post('items_tax_total'),
				'discount_type' => $this->input->post('discount_type'),
				'discount_figure' => $this->input->post('discount_figure'),
				'total_discount' => $this->input->post('discount_amount'),
				'grand_total' => $this->input->post('fgrand_total'),
			);
			$result_item = $this->Quotes_model->update_quote_items_record($data,$eitem_id);
			
		}
		
		////
		$data = array(
		'company_id' => $this->input->post('company_id'),
		'customer_id' => $this->input->post('customer_id'),
		'quote_number' => $this->input->post('quote_number'),
		'quote_title' => $this->input->post('quote_title'),
		
		'quote_date' => $this->input->post('quote_date'),
		'quote_due_date' => $this->input->post('quote_due_date'),

		'your_ref' => $this->input->post('your_ref'),
		'revision' => $this->input->post('revision'),
		'demand_order_no' => $this->input->post('demand_order_no'),

		'product_total_amount' => $this->input->post('product_total_amount'),
		'product_total_amount_inc_vat' => $this->input->post('product_total_amount_inc_vat'),
		'sub_total_amount' => $this->input->post('items_sub_total'),


		'vat_type' => $this->input->post('vat_type_total'),
		'vat_amount' => $this->input->post('vat_total'),

		'tax_type' => $this->input->post('tax_type_total'),
		'tax_amount' => $this->input->post('tax_total'),
	//	'total_tax' => $this->input->post('items_tax_total'),
		'discount_type' => $this->input->post('discount_type'),
		'discount_figure' => $this->input->post('discount_figure'),
		'total_discount' => $this->input->post('discount_amount'),
		'grand_total' => $this->input->post('fgrand_total'),
		'quote_note' => $this->input->post('quote_note'),

		'terms_of_payment' => $this->input->post('terms_of_payment'),
		'delivery_condition' => $this->input->post('delivery_condition'),
		'offer_validity' => $this->input->post('offer_validity'),
		'delivery_time' => $this->input->post('delivery_time'),
		'partial_shipment' => $this->input->post('partial_shipment'),
		);
		$result = $this->Quotes_model->update_quote_record($data,$id);
	

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
				'quote_id' => $id,
				'customer_id' => $this->input->post('customer_id'),
				'item_id' => $iname,
				'item_name' => $pmodel[0]->product_name,

				'code' => $icode,
				'capacity' =>$icapacity,
				'remarks' => $iremarks,


				'item_qty' => $qtyhrs,
				'item_unit_price' => $price,
				// 'item_tax_type' => $tax_type,
				// 'item_tax_rate' => $tax_rate,
				'item_sub_total' => $item_sub_total,
				'sub_total_amount' => $this->input->post('items_sub_total'),
				'total_tax' => $this->input->post('items_tax_total'),
				'discount_type' => $this->input->post('discount_type'),
				'discount_figure' => $this->input->post('discount_figure'),
				'total_discount' => $this->input->post('discount_amount'),
				'grand_total' => $this->input->post('fgrand_total'),
				'created_at' => date('d-m-Y H:i:s')
				);
				$result_item = $this->Quotes_model->add_quote_items_record($data2);
				
			$key++; }
			$Return['result'] = $this->lang->line('xin_acc_quote_updated');
		} else {
			//$Return['error'] = 'Bug. Something went wrong, please try again.';
		}
		$Return['result'] = $this->lang->line('xin_acc_quote_updated');
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
			
			$result = $this->Quotes_model->delete_quote_items_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_acc_quote_item_deleted');
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
			
			$result = $this->Quotes_model->delete_record($id);
			if(isset($id)) {
				$result_item = $this->Quotes_model->delete_quote_items($id);
				$Return['result'] = $this->lang->line('xin_acc_quote_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
} 
?>