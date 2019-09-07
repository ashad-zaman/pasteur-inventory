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

class Reports extends MY_Controller
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
          $this->load->model('Company_model');
		  $this->load->model('Customers_model');
		  $this->load->model('Suppliers_model');
		  $this->load->model('Xin_model');
		  $this->load->model('Reports_model');
		  $this->load->model('Expense_model');
		  $this->load->model('Invoices_model');
		  $this->load->model('Purchase_model');
     }
	 
	 public function sales_report() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		$data['title'] = $this->lang->line('xin_acc_sales_report').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_sales_report');
		$data['path_url'] = 'xin_sales_report';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('24',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/reports/invoice_sales_report", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	// sales_report_list
	public function sales_report_list() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/reports/invoice_sales_report", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$sales_report = $this->Reports_model->get_sales_report($this->input->get('from_date'),$this->input->get('to_date'));
		
		$data = array();

        foreach($sales_report->result() as $r) {
			  
			// get amount
			$amount = $this->Xin_model->currency_sign($r->amount);			
			// sales date
			$sales_date = $this->Xin_model->set_date_format($r->transaction_date);
			// payment method 
			$payment_method = $this->Xin_model->read_payment_method($r->payment_method_id);
			if(!is_null($payment_method)){
				$method_name = $payment_method[0]->method_name;
			} else {
				$method_name = '--';	
			}
			// get customer
			$customer = $this->Customers_model->read_customer_info($r->payer_payee_id); 
			if(!is_null($customer)){
				$cname = $customer[0]->name;
			} else {
				$cname = '--';	
			}
			$invoice_info = $this->Invoices_model->read_invoice_info($r->invoice_id);
			if(!is_null($invoice_info)){
				$inv_no = '<a href="'.site_url('admin/orders/view/'.$r->invoice_id).'" target="_blank">'.$invoice_info[0]->invoice_number.'</a>';//;
			} else {
				$inv_no = '--';	
			}
		   $data[] = array(
				$sales_date,
				$inv_no,
				$cname,
				$method_name,
				$amount
		   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $sales_report->num_rows(),
			 "recordsFiltered" => $sales_report->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     } 
	 
	 // get sales footer - data
	 public function get_sales_footer() {

		$data['title'] = $this->Xin_model->site_title();
		
		$data = array(
			'from_date' => $this->input->get('from_date'),
			'to_date' => $this->input->get('to_date')
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/footer/get_sales_footer", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 } 
	 
	 public function purchases_report() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		$data['title'] = $this->lang->line('xin_acc_puchases_report').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_puchases_report');
		$data['path_url'] = 'xin_purchases_report';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('23',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/reports/invoice_purchases_report", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function all_report() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		$data['title'] = $this->lang->line('xin_acc_todays_report').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_todays_report');
		$data['path_url'] = 'log';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('22',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/reports/invoice_all_report", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	// purchases_report_list
	public function purchases_report_list() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/reports/invoice_purchases_report", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$purchases_report = $this->Reports_model->get_purchases_report($this->input->get('from_date'),$this->input->get('to_date'));
		
		$data = array();

        foreach($purchases_report->result() as $r) {
			  
			// get amount
			$amount = $this->Xin_model->currency_sign($r->amount);			
			// purchase_date
			$purchase_date = $this->Xin_model->set_date_format($r->transaction_date);
			// payment method 
			$payment_method = $this->Xin_model->read_payment_method($r->payment_method_id);
			if(!is_null($payment_method)){
				$method_name = $payment_method[0]->method_name;
			} else {
				$method_name = '--';	
			}
			// get customer
			$supplier = $this->Suppliers_model->read_supplier_information($r->payer_payee_id); 
			if(!is_null($supplier)){
				$cname = $supplier[0]->supplier_name;
			} else {
				$cname = '--';	
			}
			$purchase_info = $this->Purchase_model->read_purchase_info($r->invoice_id);
			if(!is_null($purchase_info)){
				$inv_no = '<a href="'.site_url('admin/purchases/view/'.$r->invoice_id).'" target="_blank">'.$purchase_info[0]->purchase_number.'</a>';//;
			} else {
				$inv_no = '--';	
			}
		   $data[] = array(
				$purchase_date,
				$inv_no,
				$cname,
				$method_name,
				$amount
		   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $purchases_report->num_rows(),
			 "recordsFiltered" => $purchases_report->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     } 
	 
	 // get purchases footer - data
	 public function get_purchases_footer() {

		$data['title'] = $this->Xin_model->site_title();
		
		$data = array(
			'from_date' => $this->input->get('from_date'),
			'to_date' => $this->input->get('to_date')
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/footer/get_purchases_footer", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 } 
} 
?>