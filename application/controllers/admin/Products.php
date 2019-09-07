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

class Products extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the login model
		$this->load->model("Products_model");
		$this->load->model("Xin_model");
		$this->load->model("Warehouses_model");
		$this->load->model("Tax_model");
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
		$data['title'] = $this->lang->line('xin_acc_products').' | '.$this->Xin_model->site_title();
		$data['all_warehouses'] = $this->Warehouses_model->get_warehouses();
		$data['all_product_categories'] = $this->Products_model->get_categories();
		$data['all_taxes'] = $this->Tax_model->get_all_taxes();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_products');
		$data['path_url'] = 'products';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('1',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/products/product_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard/');
		}
     }
	  
    public function product_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/products/product_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$product = $this->Products_model->get_products();
		
		$data = array();

    foreach($product->result() as $r) {
			  
			if($r->product_qty > $r->reorder_stock) {
				// get user
			
				$user = $this->Xin_model->read_user_info($r->added_by);
				// user full name
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
				// get category name
				$category = $this->Products_model->read_category_info($r->category_id);
				// get warehouse
				$warehouse = $this->Warehouses_model->read_warehouse_info($r->warehouse_id);
				
				$pr_amount = $this->Xin_model->currency_sign($r->retail_price);
				$pp_amount = $this->Xin_model->currency_sign($r->purchase_price);
				$exp_date =  $this->Xin_model->set_date_format($r->expiration_date);
				
				// image
				$image = '<img src="'.base_url().'uploads/products/'.($r->product_image!='no file'?$r->product_image:'no_image.png').'" width="30" height="30">';
	
				   $data[] = array(
						'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-default btn-xs m-b-0-0 waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-product_id="'. $r->product_id . '"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_acc_view_product').'"><button type="button" class="btn btn-default btn-xs m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-product_id="'. $r->product_id . '"><i class="fa fa-eye"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-xs m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->product_id . '"><i class="fa fa-trash-o"></i></button></span>',
						$image,
						$r->product_serial_number,
						$r->product_name,
						$r->capacity,
						// $warehouse[0]->warehouse_name,
						$r->product_qty,
						// $r->barcode,
						$pp_amount,
						$pr_amount,
						isset($category[0]->name)?$category[0]->name:''
				   );
			  }
		  } // in stock

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $product->num_rows(),
                 "recordsFiltered" => $product->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	// expired stock > products
	 public function expired_stock()
     {
		$data['title'] = $this->lang->line('xin_acc_expired_stock').' | '.$this->Xin_model->site_title();
		$data['all_warehouses'] = $this->Warehouses_model->get_warehouses();
		$data['all_product_categories'] = $this->Products_model->get_categories();
		$data['all_taxes'] = $this->Tax_model->get_all_taxes();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_expired_stock');
		$data['path_url'] = 'expired_products';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('4',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/products/expired_stock_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard/');
		}
     }
	 
	  // out of stock > products
	 public function out_of_stock()
     {
		$data['title'] = $this->lang->line('xin_acc_outofstock_products').' | '.$this->Xin_model->site_title();
		$data['all_warehouses'] = $this->Warehouses_model->get_warehouses();
		$data['all_product_categories'] = $this->Products_model->get_categories();
		$data['all_taxes'] = $this->Tax_model->get_all_taxes();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_outofstock_products');
		$data['path_url'] = 'out_of_stock_products';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('3',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/products/out_of_stock_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard/');
		}
     }
 
    // out of stock list
	public function out_of_stock_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/products/out_of_stock_list", $data);
		} else {
			redirect('');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$product = $this->Products_model->out_of_stock_products();
		
		$data = array();

          foreach($product->result() as $r) {
			  			
			$user = $this->Xin_model->read_user_info($r->added_by);
			// user full name
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			// get category name
			$category = $this->Products_model->read_category_info($r->category_id);
			// get warehouse
			$warehouse = $this->Warehouses_model->read_warehouse_info($r->warehouse_id);
			
			$pr_amount = $this->Xin_model->currency_sign($r->retail_price);
			$pp_amount = $this->Xin_model->currency_sign($r->purchase_price);
			$exp_date =  $this->Xin_model->set_date_format($r->expiration_date);
			
			// image
			$image = '<img src="'.base_url().'uploads/products/'.($r->product_image!='no file'?$r->product_image:'no_image.png').'" width="30" height="30">';

			   $data[] = array(
					'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-default btn-xs m-b-0-0 waves-effect waves-light"  data-toggle="modal" data-target=".add-modal-data"  data-product_id="'. $r->product_id . '"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn btn-default btn-xs m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-product_id="'. $r->product_id . '"><i class="fa fa-eye"></i></button></span>',
					$image,
					$r->product_serial_number,
					$r->product_name,
					$warehouse[0]->warehouse_name,
					$r->product_qty,
					// $r->barcode,
					$pp_amount,
					$pr_amount,
					$category[0]->name
			   );
		  } // in stock

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $product->num_rows(),
                 "recordsFiltered" => $product->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 // expired_stock_list
	 public function expired_stock_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/products/expired_stock_list", $data);
		} else {
			redirect('');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$product = $this->Products_model->expired_products();
		
		$data = array();

          foreach($product->result() as $r) {
			
			$user = $this->Xin_model->read_user_info($r->added_by);
			// user full name
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			// get category name
			$category = $this->Products_model->read_category_info($r->category_id);
			// get warehouse
			$warehouse = $this->Warehouses_model->read_warehouse_info($r->warehouse_id);
			
			$pr_amount = $this->Xin_model->currency_sign($r->retail_price);
			$pp_amount = $this->Xin_model->currency_sign($r->purchase_price);
			$exp_date =  $this->Xin_model->set_date_format($r->expiration_date);
			
			// image
			$image = '<img src="'.base_url().'uploads/products/'.($r->product_image!='no file'?$r->product_image:'no_image.png').'" width="30" height="30">';
		   $data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-default btn-xs m-b-0-0 waves-effect waves-light"  data-toggle="modal" data-target=".add-modal-data"  data-product_id="'. $r->product_id . '"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn btn-default btn-xs m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-product_id="'. $r->product_id . '"><i class="fa fa-eye"></i></button></span>',
				$image,
				$r->product_serial_number,
				$r->product_name,
				$warehouse[0]->warehouse_name,
				$r->product_qty,
				// $r->barcode,
				$pp_amount,
				$pr_amount,
				$category[0]->name
		   );
		  } // in stock

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $product->num_rows(),
                 "recordsFiltered" => $product->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
		 
	 public function categories()
     {
			$data['title'] = $this->lang->line('xin_acc_product_categories').' | '.$this->Xin_model->site_title();
			$data['breadcrumbs'] = $this->lang->line('xin_acc_product_categories');
			$data['path_url'] = 'product_categories';
			$session = $this->session->userdata('username');
			$role_resources_ids = $this->Xin_model->user_role_resource();
			if(in_array('6',$role_resources_ids)) {
				if(!empty($session)){ 
					$data['subview'] = $this->load->view("admin/products/product_categories", $data, TRUE);
					$this->load->view('admin/layout/layout_main', $data); //page load
				} else {
					redirect('admin/');
				}
			} else {
				redirect('admin/dashboard/');
			}
     }
	 	 
	 public function category_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/products/product_categories", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$product_category = $this->Products_model->get_product_categories();
		
		$data = array();

          foreach($product_category->result() as $r) {
			
				$user = $this->Xin_model->read_user_info($r->added_by);
				// user full name
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
				// date
				$created_at = $this->Xin_model->set_date_format($r->created_at);
					
				$data[] = array(
						'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-default btn-xs m-b-0-0 waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-category_id="'. $r->category_id . '"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn btn-default btn-xs m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-category_id="'. $r->category_id . '"><i class="fa fa-eye"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-xs m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->category_id . '"><i class="fa fa-trash-o"></i></button></span>',
						$r->name,
						$r->code,
						$created_at,
						$full_name
				   );
			  }
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $product_category->num_rows(),
                 "recordsFiltered" => $product_category->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	public function read()
	{		
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('product_id');
		$result = $this->Products_model->read_product_information($id);		
		$data = array(
			'product_id' => $result[0]->product_id,
			'product_name' => $result[0]->product_name,
			'product_qty' => $result[0]->product_qty,
			'reorder_stock' => $result[0]->reorder_stock,
			'barcode' => $result[0]->barcode,
			'barcode_type' => $result[0]->barcode_type,
			'warehouse_id' => $result[0]->warehouse_id,
			'category_id' => $result[0]->category_id,
			'product_sku' => $result[0]->product_sku,
			'expiration_date' => $result[0]->expiration_date,
			'product_serial_number' => $result[0]->product_serial_number,
			'purchase_price' => $result[0]->purchase_price,
			'retail_price' => $result[0]->retail_price,
			'product_image' => $result[0]->product_image,
			'barcodes_img' => '',
			'capacity' =>$result[0]->capacity,
			'remarks' => $result[0]->remarks,
			'product_description' => $result[0]->product_description,
			'all_warehouses' => $this->Warehouses_model->get_warehouses(),
			'all_product_categories' => $this->Products_model->get_categories(),
			'all_taxes' => $this->Tax_model->get_all_taxes()
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/products/dialog_product', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function finished_read()
	{
		
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('product_id');
		$result = $this->Products_model->read_product_information($id);		
		$data = array(
			'product_id' => $result[0]->product_id,
			'product_name' => $result[0]->product_name,
			'product_qty' => $result[0]->product_qty,
			'reorder_stock' => $result[0]->reorder_stock,
			'barcode' => $result[0]->barcode,
			'barcode_type' => $result[0]->barcode_type,
			'warehouse_id' => $result[0]->warehouse_id,
			'category_id' => $result[0]->category_id,
			'product_sku' => $result[0]->product_sku,
			'expiration_date' => $result[0]->expiration_date,
			'product_serial_number' => $result[0]->product_serial_number,
			'purchase_price' => $result[0]->purchase_price,
			'retail_price' => $result[0]->retail_price,
			'product_image' => $result[0]->product_image,
			'barcodes_img' => '',
			'capacity' =>$result[0]->capacity,
			'remarks' => $result[0]->remarks,
			'product_description' => $result[0]->product_description,
			'all_warehouses' => $this->Warehouses_model->get_warehouses(),
			'all_product_categories' => $this->Products_model->get_categories(),
			'all_taxes' => $this->Tax_model->get_all_taxes()
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/products/dialog_out_of_stock', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// categories data
	public function category_read()
	{
		
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('category_id');
		$result = $this->Products_model->read_category_info($id);
		$data = array(
				'category_id' => $result[0]->category_id,
				'name' => $result[0]->name,
				'code' => $result[0]->code,
				'description' => $result[0]->description
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/products/dialog_category', $data);
		} else {
			redirect('');
		}
	}
	
	// Validate and add info in database
	public function add_product() {
	
		if($this->input->post('add_type')=='product') {
		// Check validation for user input
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($this->input->post('product_name')==='') {
			$Return['error'] = $this->lang->line('xin_acc_product_name_field_error');
		} 
		// else if($this->input->post('barcode_type')==='') {
		// //	$Return['error'] = $this->lang->line('xin_acc_barcode_type_field_error');
		// } else if($this->input->post('barcode')==='') {
		// //	$Return['error'] = $this->lang->line('xin_acc_barcode_field_error');
		// } 
		else if($this->input->post('warehouse')==='') {
			$Return['error'] = $this->lang->line('xin_acc_warehouse_field_error');
		} else if($this->input->post('category')==='') {
			$Return['error'] = $this->lang->line('xin_acc_category_feild_error');
		} else if($this->input->post('sku')==='') {
			$Return['error'] = $this->lang->line('xin_acc_product_sku_error');
		} else if($this->input->post('purchase_price')==='') {
			$Return['error'] = $this->lang->line('xin_acc_purchase_field_field_error');
		} else if($this->input->post('retail_price')==='') {
			$Return['error'] = $this->lang->line('xin_acc_retail_price_field_error');
		} else if($this->input->post('product_qty')==='') {
			$Return['error'] = $this->lang->line('xin_acc_product_qty_field_error');
		} 
		// else if($this->input->post('expiration_date')==='') {
		// 	$Return['error'] = $this->lang->line('xin_acc_expiration_date_field_error');
		// }	
		/* Check if file uploaded..*/
		else if($_FILES['apimage']['size'] == 0) {
			$fname = 'no file';
			 //$Return['error'] = $this->lang->line('xin_acc_product_image_field_error');
		} else {
			if(is_uploaded_file($_FILES['apimage']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['apimage']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["apimage"]["tmp_name"];
					$img_path = "uploads/products/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["apimage"]["name"]);
					$newfilename = 'image_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $img_path.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'product_name' => $this->input->post('product_name'),
		// 'barcode_type' => $this->input->post('barcode_type'),
		// 'barcode' => $this->input->post('barcode'),
		'warehouse_id' => $this->input->post('warehouse'),
		'category_id' => $this->input->post('category'),
		'product_description' => $qt_description,
		'product_sku' => $this->input->post('sku'),
		'product_serial_number' => $this->input->post('serial_number'),
		'purchase_price' => $this->input->post('purchase_price'),
		'retail_price' => $this->input->post('retail_price'),
		'product_qty' => $this->input->post('product_qty'),

		'capacity' => $this->input->post('capacity'),
		'remarks' => $this->input->post('remarks'),
		//'reorder_stock' => $this->input->post('reorder_stock'),
		// 'expiration_date' => $this->input->post('expiration_date'),
		'added_by' => $this->input->post('user_id'),
		'product_image' => $fname,
		'created_at' => date('d-m-Y h:i:s'),
		'status' => '1'
		);
		$result = $this->Products_model->add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_product_added_msg');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function add_category() {
	
		if($this->input->post('add_type')=='category') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('name')==='') {
       		$Return['error'] = $this->lang->line('xin_error_name_field');
		} else if($this->input->post('code')==='') {
			$Return['error'] = $this->lang->line('xin_acc_code_field_error');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'name' => $this->input->post('name'),
		'code' => $this->input->post('code'),
		'description' => $qt_description,
		'added_by' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Products_model->add_category_record($data);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_product_cat_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_category() {
	
		if($this->input->post('edit_type')=='category') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		$id = $this->uri->segment(4);
		
		if($this->input->post('name')==='') {
       		$Return['error'] = $this->lang->line('xin_error_name_field');
		} else if($this->input->post('code')==='') {
			$Return['error'] = $this->lang->line('xin_acc_code_field_error');
		}				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'name' => $this->input->post('name'),
		'code' => $this->input->post('code'),
		'description' => $qt_description
		);
		$result = $this->Products_model->update_category_record($data,$id);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_product_cat_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
		
	// Validate and update info in database
	public function update_product() {
	
		if($this->input->post('edit_type')=='product') {
		
		$id = $this->uri->segment(4);
		
		// Check validation for user input
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($this->input->post('product_name')==='') {
			$Return['error'] = $this->lang->line('xin_acc_product_name_field_error');
		} 
		// else if($this->input->post('barcode_type')==='') {
		// 	$Return['error'] = $this->lang->line('xin_acc_barcode_type_field_error');
		// }
		//  else if($this->input->post('barcode')==='') {
		// 	$Return['error'] = $this->lang->line('xin_acc_barcode_field_error');
		// }
		//  else if($this->input->post('warehouse')==='') {
		// 	$Return['error'] = $this->lang->line('xin_acc_warehouse_field_error');
		// } 
		else if($this->input->post('category')==='') {
			$Return['error'] = $this->lang->line('xin_acc_category_feild_error');
		} else if($this->input->post('sku')==='') {
			$Return['error'] = $this->lang->line('xin_acc_product_sku_error');
		} else if($this->input->post('purchase_price')==='') {
			$Return['error'] = $this->lang->line('xin_acc_purchase_field_field_error');
		} else if($this->input->post('retail_price')==='') {
			$Return['error'] = $this->lang->line('xin_acc_retail_price_field_error');
		} else if($this->input->post('product_qty')==='') {
			$Return['error'] = $this->lang->line('xin_acc_product_qty_field_error');
		} else if($this->input->post('expiration_date')==='') {
			$Return['error'] = $this->lang->line('xin_acc_expiration_date_field_error');
		} else if($_FILES['pimage']['size'] == 0) {
			$no_logo_data = array(
			'product_name' => $this->input->post('product_name'),
			'barcode_type' => $this->input->post('barcode_type'),
			'barcode' => $this->input->post('barcode'),
			'warehouse_id' => $this->input->post('warehouse'),
			'category_id' => $this->input->post('category'),
			'product_description' => $qt_description,
			'product_sku' => $this->input->post('sku'),
			'product_serial_number' => $this->input->post('serial_number'),
			'purchase_price' => $this->input->post('purchase_price'),
			'expiration_date' => $this->input->post('expiration_date'),
			'product_qty' => $this->input->post('product_qty'),
			'retail_price' => $this->input->post('retail_price'),
			'reorder_stock' => $this->input->post('reorder_stock'),
			'capacity' => $this->input->post('capacity'),
			'remarks' => $this->input->post('remarks')
			);
			$result = $this->Products_model->update_record($no_logo_data,$id);
		} else {
			if(is_uploaded_file($_FILES['pimage']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['pimage']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["pimage"]["tmp_name"];
					$img_path = "uploads/products/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["pimage"]["name"]);
					$newfilename = 'image_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $img_path.$newfilename);
					$fname = $newfilename;
					
					$data = array(
					'product_name' => $this->input->post('product_name'),
					'barcode_type' => $this->input->post('barcode_type'),
					'barcode' => $this->input->post('barcode'),
					'warehouse_id' => $this->input->post('warehouse'),
					'category_id' => $this->input->post('category'),
					'product_description' => $qt_description,
					'product_sku' => $this->input->post('sku'),
					'product_serial_number' => $this->input->post('serial_number'),
					'purchase_price' => $this->input->post('purchase_price'),
					'retail_price' => $this->input->post('retail_price'),
					'reorder_stock' => $this->input->post('reorder_stock'),
					'expiration_date' => $this->input->post('expiration_date'),
					'product_qty' => $this->input->post('product_qty'),
					'capacity' => $this->input->post('capacity'),
					'remarks' => $this->input->post('remarks'),
					'product_image' => $fname
					);
					// update record > model
					$result = $this->Products_model->update_record($data,$id);
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}	
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_product_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database > add stock
	public function update_stock() {
	
		if($this->input->post('edit_type')=='product') {
		
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($this->input->post('product_qty')==='') {
			$Return['error'] = $this->lang->line('xin_acc_product_qty_field_error');
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$data = array(
		'product_qty' => $this->input->post('product_qty')
		// 'reorder_stock' => $this->input->post('reorder_stock'),
		);
		// update record > model
		$result = $this->Products_model->update_record($data,$id);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_stock_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database > add stock
	public function update_expiry_date() {
	
		if($this->input->post('edit_type')=='product') {
		
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($this->input->post('expiration_date')==='') {
			$Return['error'] = $this->lang->line('xin_acc_expiration_date_field_error');
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$data = array(
		'expiration_date' => $this->input->post('expiration_date'),
		);
		// update record > model
		$result = $this->Products_model->update_record($data,$id);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_exxp_date_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// delete a product
	public function delete() {
		if($this->input->post('is_ajax')==='2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Products_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_acc_product_del_msg');
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
			$result = $this->Products_model->delete_tax_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_product_tax_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete a product category
	public function category_delete() {
		if($this->input->post('is_ajax')==='2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Products_model->delete_category_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_ac_product_cat_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
}
