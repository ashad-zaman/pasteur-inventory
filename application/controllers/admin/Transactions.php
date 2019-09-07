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

class Transactions extends MY_Controller
{

   /*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	public function __construct() {
          parent::__construct();
          //load the models
          $this->load->model('Xin_model');
		  $this->load->model('Customers_model');
		  $this->load->model('Expense_model');
		  $this->load->model('Invoices_model');
		  $this->load->model('Transactions_model');
		  $this->load->model('Purchase_model');
     }
		
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_acc_view_transactions').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_view_transactions_log');
		$data['path_url'] = 'stock_transactions';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('34',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/transactions/transaction_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	 
	// transactions list
	public function transaction_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/transactions/transaction_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$transaction = $this->Transactions_model->get_transaction();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();
		$balance2 = 0;
          foreach($transaction->result() as $r) {
			  
			// transaction date
			$transaction_date = $this->Xin_model->set_date_format($r->transaction_date);
			// get currency
			$total_amount = $this->Xin_model->currency_sign($r->amount);
			// credit
			if($r->dr_cr == 'cr') {
				$xin_acc = $this->lang->line('xin_acc_credit');
			} else {
				$xin_acc = $this->lang->line('xin_acc_debit');
			}
			if($r->transaction_type == 'purchases'){
				$purchase_info = $this->Purchase_model->read_purchase_info($r->invoice_id);
				if(!is_null($purchase_info)){
					$purchase_number = $purchase_info[0]->purchase_number;
				} else {
					$purchase_number = '--';	
				}
				$info = '<a href="'.site_url('admin/purchase/view/').$r->invoice_id.'" target="_blank">'.$purchase_number.'</a>';
			} else if($r->transaction_type == 'income'){
				$result = $this->Invoices_model->read_invoice_info($r->invoice_id);
				if(!is_null($result)){
					$invoice_number = $result[0]->invoice_number;
				} else {
					$invoice_number = '--';	
				}
				$info = '<a href="'.site_url('admin/orders/view/').$r->invoice_id.'" target="_blank">'.$invoice_number.'</a>';
			} else {
				$info = '<a  data-toggle="modal" data-target=".view-modal-data" data-expense_id="'. $r->invoice_id . '" style="cursor:pointer;">'.$this->lang->line('xin_view').'</a>';
			}
			//			
			$data[] = array(
				$transaction_date,
				$info,
				$xin_acc,
				$r->transaction_type,
				$total_amount,
				$r->reference
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
} 
?>