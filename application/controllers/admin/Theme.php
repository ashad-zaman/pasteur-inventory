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

class Theme extends MY_Controller
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
		  $this->load->model('Xin_model');
     }
	 
	// theme settings page
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_theme_settings').' | '.$this->Xin_model->site_title();
		$setting = $this->Xin_model->read_setting_info(1);
		$company_info = $this->Xin_model->read_company_setting_info(1);
		$theme_info = $this->Xin_model->read_theme_info(1);
		$data = array(
			'title' => $this->lang->line('xin_theme_settings').' | '.$this->Xin_model->site_title(),
			'company_info_id' => $company_info[0]->company_info_id,
			'logo' => $company_info[0]->logo,
			'logo_second' => $company_info[0]->logo_second,
			'favicon' => $company_info[0]->favicon,
			'sign_in_logo' => $company_info[0]->sign_in_logo,
			'signature' => $company_info[0]->signature,
			'notification_position' => $setting[0]->notification_position,
			'notification_close_btn' => $setting[0]->notification_close_btn,
			'notification_bar' => $setting[0]->notification_bar,
			'statistics_cards' => $theme_info[0]->statistics_cards,
			'all_countries' => $this->Xin_model->get_countries()
			);
		$data['breadcrumbs'] = $this->lang->line('xin_theme_settings');
		$data['path_url'] = 'theme_settings';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('29',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/theme/theme_settings", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	// Validate and update info in database>page layouts
	public function page_layouts() {
	
		if($this->input->post('type')=='page_layouts_info') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		if($this->input->post('statistics_cards')==='') {
        	$Return['error'] = $this->lang->line('xin_error_thm_statistics_cards');
		}
		
		if($Return['error']!=''){
			$this->output($Return);
		}
		$id = 1;
			
		$data = array(
		//'fixed_layout' => $this->input->post('fixed_layout'),
		'statistics_cards' => $this->input->post('statistics_cards'),
		);
		
		$result = $this->Xin_model->update_theme_info_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_thm_page_layouts_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database> Navigation Menu
	public function nav_menu() {
	
		if($this->input->post('type')=='nav_menu_info') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$id = 1;
			
		$data = array(
		'compact_menu' => $this->input->post('compact_menu'),
		'flipped_menu' => $this->input->post('flipped_menu'),
		'right_side_icons' => $this->input->post('right_side_icons'),
		'bordered_menu' => $this->input->post('bordered_menu')
		);
		
		$result = $this->Xin_model->update_theme_info_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_thm_nav_menu_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database> Form Design
	public function form_design() {
	
		if($this->input->post('type')=='form_design_info') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('form_design')==='') {
        	$Return['error'] = $this->lang->line('xin_error_thm_form_design');
		}
		
		if($Return['error']!=''){
			$this->output($Return);
		}
		
		$id = 1;
			
		$data = array(
		'form_design' => $this->input->post('form_design')
		);
		
		$result = $this->Xin_model->update_theme_info_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_thm_form_design_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and update info in database> System color
	public function color_system() {
	
		if($this->input->post('type')=='color_system_info') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		if($this->input->post('nav_sdark_color')==='') {
        	$Return['error'] = $this->lang->line('xin_error_thm_select_semi_dark_clr');
		} else if($this->input->post('nav_dark_color')==='') {
        	$Return['error'] = $this->lang->line('xin_error_thm_select_dark_clr');
		} else if($this->input->post('menu_color_option')==='') {
        	$Return['error'] = $this->lang->line('xin_error_thm_select_menu_clr_opt');
		}
		
		if($Return['error']!=''){
			$this->output($Return);
		}
		
		$id = 1;
			
		$data = array(
		'semi_dark_color' => $this->input->post('nav_sdark_color'),
		'top_nav_dark_color' => $this->input->post('nav_dark_color'),
		'menu_color_option' => $this->input->post('menu_color_option'),
		'is_semi_dark' => $this->input->post('is_semi_dark')
		);
		
		$result = $this->Xin_model->update_theme_info_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_thm_system_color_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function notification_position_info() {
	
		if($this->input->post('type')=='notification_position_info') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		if($this->input->post('notification_position')==='') {
        	$Return['error'] = $this->lang->line('xin_error_notify_position');
		}
		
		if($Return['error']!=''){
			$hrm_f->output($Return);
		}
		$id = 1;
			
		$data = array(
		'notification_position' => $this->input->post('notification_position'),
		'notification_close_btn' => $this->input->post('notification_close_btn'),
		'notification_bar' => $this->input->post('notification_bar')
		);
		
		$result = $this->Xin_model->update_setting_info_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_notify_position_config_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and update info in database
	public function logo_info() {
	
		if($this->input->post('type')=='logo_info') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;
		
		if($_FILES['p_file']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_error_select_first_logo');
		} 
		else if($_FILES['favicon']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_error_select_favicon');
		}
		if($Return['error']!=''){
				$this->output($Return);
			}
							
		if(is_uploaded_file($_FILES['p_file']['tmp_name'])) {
		//checking image type
		$allowed =  array('png','jpg','jpeg','pdf','gif');
		$filename = $_FILES['p_file']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		
		if(in_array($ext,$allowed)){
			$tmp_name = $_FILES["p_file"]["tmp_name"];
			$profile = "uploads/logo/";
			$set_img = base_url()."uploads/logo/";
			// basename() may prevent filesystem traversal attacks;
			// further validation/sanitation of the filename may be appropriate
			$name = basename($_FILES["p_file"]["name"]);
			$newfilename = 'logo_'.round(microtime(true)).'.'.$ext;
			move_uploaded_file($tmp_name, $profile.$newfilename);
			$fname = $newfilename;			
			
			} else {
				$Return['error'] = $this->lang->line('xin_error_logo_first_attachment');
			}
		}	
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		if(is_uploaded_file($_FILES['favicon']['tmp_name'])) {
		//checking image type
		$allowed3 =  array('png','jpg','gif','ico');
		$filename3 = $_FILES['favicon']['name'];
		$ext3 = pathinfo($filename3, PATHINFO_EXTENSION);
		
		if(in_array($ext3,$allowed3)){
			$tmp_name3 = $_FILES["favicon"]["tmp_name"];
			$profile3 = "uploads/logo/favicon/";
			$set_img3 = base_url()."uploads/logo/favicon/";
			// basename() may prevent filesystem traversal attacks;
			// further validation/sanitation of the filename may be appropriate
			$name = basename($_FILES["favicon"]["name"]);
			$newfilename3 = 'favicon_'.round(microtime(true)).'.'.$ext3;
			move_uploaded_file($tmp_name3, $profile3.$newfilename3);
			$fname3 = $newfilename3;			
			
			} else {
				$Return['error'] = $this->lang->line('xin_error_logo_favicon_attachment');
			}
		}

	
		$data = array(
		'logo' => $fname,
		'favicon' => $fname3
		);
		$result = $this->Xin_model->update_company_info_record($data,$id);	
		if ($result == TRUE) {
			$Return['img'] = $set_img.$fname;
			$Return['img3'] = $set_img3.$fname3;
			$Return['result'] = $this->lang->line('xin_success_system_logo_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;

		}
	}
	// Validate and update info in database
	public function sign_in_logo() {
	
		if($this->input->post('type')=='singin_logo') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;
		
		if($_FILES['p_file3']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_error_select_signin_page_logo');
		} else {
		if(is_uploaded_file($_FILES['p_file3']['tmp_name'])) {
			//checking image type
			$allowed =  array('png','jpg','jpeg','pdf','gif');
			$filename = $_FILES['p_file3']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			if(in_array($ext,$allowed)){
				$tmp_name = $_FILES["p_file3"]["tmp_name"];
				$profile = "uploads/logo/signin/";
				$set_img = base_url()."uploads/logo/signin/";
				// basename() may prevent filesystem traversal attacks;
				// further validation/sanitation of the filename may be appropriate
				$name = basename($_FILES["p_file3"]["name"]);
				$newfilename = 'signin_logo_'.round(microtime(true)).'.'.$ext;
				move_uploaded_file($tmp_name, $profile.$newfilename);
				$fname = $newfilename;			
				
				$data = array(
				'sign_in_logo' => $fname
				);
				$result = $this->Xin_model->update_company_info_record($data,$id);	
				if ($result == TRUE) {
					$Return['img'] = $set_img.$fname;
					$Return['result'] = $this->lang->line('xin_success_signin_page_logo_updated');
				} else {
					$Return['error'] = $this->lang->line('xin_error_msg');
				}
				$this->output($Return);
				exit;	
		
			} else {
				$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
				
		if($Return['error']!=''){
		$this->output($Return);
		}
		}
	}	

	// Validate and update info in database
	public function signature() {
	
		if($this->input->post('type')=='signature_photo') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;
		
		if($_FILES['p_file4']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_error_select_signin_page_logo');
		} else {
		if(is_uploaded_file($_FILES['p_file4']['tmp_name'])) {
			//checking image type
			$allowed =  array('png','jpg','jpeg','pdf','gif');
			$filename = $_FILES['p_file4']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			if(in_array($ext,$allowed)){
				$tmp_name = $_FILES["p_file4"]["tmp_name"];
				$profile = "uploads/logo/signature/";
				$set_img = base_url()."uploads/logo/signature/";
				// basename() may prevent filesystem traversal attacks;
				// further validation/sanitation of the filename may be appropriate
				$name = basename($_FILES["p_file4"]["name"]);
				$newfilename = 'signature_'.round(microtime(true)).'.'.$ext;
				move_uploaded_file($tmp_name, $profile.$newfilename);
				$fname = $newfilename;			
				
				$data = array(
				'signature' => $fname
				);
				$result = $this->Xin_model->update_company_info_record($data,$id);	
				if ($result == TRUE) {
					$Return['img'] = $set_img.$fname;
					$Return['result'] = $this->lang->line('xin_success_signature_page_logo_updated');
				} else {
					$Return['error'] = $this->lang->line('xin_error_msg');
				}
				$this->output($Return);
				exit;	
		
			} else {
				$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
				
		if($Return['error']!=''){
		$this->output($Return);
		}
		}
	}
} 
?>