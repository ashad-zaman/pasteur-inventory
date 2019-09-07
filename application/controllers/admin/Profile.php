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

class Profile extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Users_model");
		$this->load->model("Xin_model");
		$this->load->model("Roles_model");
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	  public function index() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$result = $this->Users_model->read_users_info($session['user_id']);
		$data = array(
			'breadcrumbs' => $this->lang->line('header_my_profile'),
			'path_url' => 'profile',
			'title' => $this->lang->line('header_my_profile'),
			'user_id' => $result[0]->user_id,
			'first_name' => $result[0]->first_name,
			'last_name' => $result[0]->last_name,
			'email' => $result[0]->email,
			'username' => $result[0]->username,
			'password' => $result[0]->password,
			'gender' => $result[0]->gender,
			'user_role_id' => $result[0]->user_role_id,
			'profile_photo' => $result[0]->profile_photo,
			'contact_number' => $result[0]->contact_number,
			'address_1' => $result[0]->address_1,
			'address_2' => $result[0]->address_2,
			'city' => $result[0]->city,
			'state' => $result[0]->state,
			'zipcode' => $result[0]->zipcode,
			'icountry' => $result[0]->country,
			'all_countries' => $this->Xin_model->get_countries(),
			'all_user_roles' => $this->Roles_model->all_user_roles()
		);
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/users/user_profile", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
}