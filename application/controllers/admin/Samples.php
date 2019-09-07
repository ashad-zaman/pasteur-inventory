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
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Samples extends MY_Controller
{

    /*Function to set JSON output*/
    public function output($Return = array())
    {
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
        $this->load->model('Samples_model');
        $this->load->model("Customers_model");
    }

    // samples page
    public function index()
    {

        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
        $data['title'] = $this->lang->line('xin_samples_title') . ' | ' . $this->Xin_model->site_title();
        $data['breadcrumbs'] = $this->lang->line('xin_samples_title');
        $data['all_taxes'] = $this->Tax_model->get_all_taxes();
        $data['path_url'] = 'hrsale_samples';
        $role_resources_ids = $this->Xin_model->user_role_resource();
        if (in_array('17', $role_resources_ids)) {
            $data['subview'] = $this->load->view("admin/samples/sample_list", $data, true);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/dashboard');
        }
    }
    // create sample page
    public function create()
    {

        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        $data['samples_order_no'] = $this->Samples_model->get_samples_order_no();
        $data['samples_order_no'] = ($data['samples_order_no'] == null) ? 1000 : (1000 + $data['samples_order_no'] + 1);

        //print_r($data['samples_order_no']);exit;

        $data['title'] = $this->lang->line('xin_sample_create') . ' | ' . $this->Xin_model->site_title();
        $data['breadcrumbs'] = $this->lang->line('xin_sample_create');
        $data['all_taxes'] = $this->Tax_model->get_all_taxes();
        $data['all_items'] = $this->Xin_model->get_items();
        $data['path_url'] = 'create_hrsale_sample';
        $role_resources_ids = $this->Xin_model->user_role_resource();
        if (in_array('18', $role_resources_ids)) {
            $data['subview'] = $this->load->view("admin/samples/create_sample", $data, true);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/dashboard');
        }
    }

    // get_sample_items
    public function get_invoice_items()
    {

        $data['title'] = $this->Xin_model->site_title();

        $data = array(
            'all_taxes' => $this->Tax_model->get_all_taxes(),
            'all_items' => $this->Xin_model->get_items(),
        );
        $session = $this->session->userdata('username');
        if (!empty($session)) {
            $this->load->view("admin/invoices/get_items", $data);
        } else {
            redirect('admin/');
        }
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
    }

    // edit sample page
    public function edit()
    {

        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        $data['title'] = $this->Xin_model->site_title();
        $session = $this->session->userdata('username');

        $sample_id = $this->uri->segment(4);
        $sample_info = $this->Samples_model->read_samples_info($sample_id);
        if (is_null($sample_info)) {
            redirect('admin/samples');
        }
        $role_resources_ids = $this->Xin_model->user_role_resource();
        if (!in_array('17', $role_resources_ids)) { //edit
            redirect('admin/samples');
        }
        // get project
        $customer = $this->Customers_model->read_customer_info($sample_info[0]->customer_id);
        // get country
        //    $country = $this->Xin_model->read_country_info($supplier[0]->country_id);
        // get company info
        $company = $this->Xin_model->read_company_setting_info(1);
        // get company > country info
        $ccountry = $this->Xin_model->read_country_info($company[0]->country);
        $data = array(
            'title' => $this->lang->line('xin_acc_edit_sample') . ' #' . $sample_info[0]->sample_id,
            'breadcrumbs' => $this->lang->line('xin_acc_edit_sample'),
            'path_url' => 'create_hrsale_sample',
            'sample_id' => $sample_info[0]->sample_id,
            'prefix' => $sample_info[0]->prefix,
            'sample_number' => $sample_info[0]->sample_number,
            'customer_id' => $customer[0]->customer_id,
            'sample_date' => $sample_info[0]->sample_date,
            'sample_due_date' => $sample_info[0]->sample_due_date,
            'sub_total_amount' => $sample_info[0]->sub_total_amount,
            'discount_type' => $sample_info[0]->discount_type,
            'discount_figure' => $sample_info[0]->discount_figure,
            'total_tax' => $sample_info[0]->total_tax,
            'total_discount' => $sample_info[0]->total_discount,
            'grand_total' => $sample_info[0]->grand_total,
            'sample_note' => $sample_info[0]->sample_note,
            'all_items' => $this->Xin_model->get_items(),
            'all_taxes' => $this->Tax_model->get_all_taxes(),
            //    'product_for_purchase_invoice' => $this->Products_model->product_for_purchase_invoice(),
            //    'all_taxes' => $this->Products_model->get_taxes()
        );
        $role_resources_ids = $this->Xin_model->user_role_resource();
        //if(in_array('3',$role_resources_ids)) {
        $data['subview'] = $this->load->view("admin/samples/edit_sample", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
        //} else {
        //    redirect('admin/dashboard/');
        //}
    }

    public function mark_as()
    {

        $id = $this->uri->segment(4);
        $txt = $this->uri->segment(5);
        ////
        $data = array(
            'status' => $txt,
        );
        $result = $this->Samples_model->update_sample_record($data, $id);
        redirect('admin/samples/view/' . $id);
    }

    // view sample page
    public function view()
    {

        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        $data['title'] = $this->Xin_model->site_title();
        $session = $this->session->userdata('username');

        $sample_id = $this->uri->segment(4);
        $sample_info = $this->Samples_model->read_samples_info($sample_id);
        if (is_null($sample_info)) {
            redirect('admin/samples');
        }
        $role_resources_ids = $this->Xin_model->user_role_resource();
        if (!in_array('17', $role_resources_ids)) { //view
            redirect('admin/samples');
        }
        // get project
        $customer = $this->Customers_model->read_customer_info($sample_info[0]->customer_id);
        // get country
        //    $country = $this->Xin_model->read_country_info($supplier[0]->country_id);
        // get company info
        $company = $this->Xin_model->read_company_setting_info(1);
        // get company > country info
        $ccountry = $this->Xin_model->read_country_info($company[0]->country);

        $data = array(
            'title' => $this->lang->line('xin_acc_view_sample') . ' #' . $sample_info[0]->sample_id,
            'breadcrumbs' => $this->lang->line('xin_acc_view_sample'),
            'path_url' => 'create_hrsale_quotation',
            'sample_id' => $sample_info[0]->sample_id,
            'prefix' => $sample_info[0]->prefix,
            'sample_number' => $sample_info[0]->sample_number,
            'customer_id' => $customer[0]->customer_id,
            'sample_date' => $sample_info[0]->sample_date,
            'sample_due_date' => $sample_info[0]->sample_due_date,
            'sub_total_amount' => $sample_info[0]->sub_total_amount,
            'discount_type' => $sample_info[0]->discount_type,
            'discount_figure' => $sample_info[0]->discount_figure,
            'total_tax' => $sample_info[0]->total_tax,
            'total_discount' => $sample_info[0]->total_discount,
            'grand_total' => $sample_info[0]->grand_total,
            'sample_note' => $sample_info[0]->sample_note,
            'status' => $sample_info[0]->status,
            'company_name' => $company[0]->company_name,
            'company_address' => $company[0]->address_1,
            'company_zipcode' => $company[0]->zipcode,
            'company_city' => $company[0]->city,
            'company_phone' => $company[0]->phone,
            'company_email' => $company[0]->company_email,
            'company_country' => $ccountry[0]->country_name,
            'all_items' => $this->Xin_model->get_items(),
            'all_taxes' => $this->Tax_model->get_all_taxes(),
            //    'product_for_purchase_invoice' => $this->Products_model->product_for_purchase_invoice(),
            //    'all_taxes' => $this->Products_model->get_taxes()
        );
        $role_resources_ids = $this->Xin_model->user_role_resource();
        //if(in_array('3',$role_resources_ids)) {
        $data['subview'] = $this->load->view("admin/samples/sample_view", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
        //} else {
        //    redirect('admin/dashboard/');
        //}
    }

    // view sample page
    public function preview()
    {

        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        $data['title'] = $this->Xin_model->site_title();
        $session = $this->session->userdata('username');

        $sample_id = $this->uri->segment(4);
        $sample_info = $this->Samples_model->read_samples_info($sample_id);
        if (is_null($sample_info)) {
            redirect('admin/samples');
        }
        $role_resources_ids = $this->Xin_model->user_role_resource();
        if (!in_array('17', $role_resources_ids)) { //view
            redirect('admin/samples');
        }
        // get project
        $customer = $this->Customers_model->read_customer_info($sample_info[0]->customer_id);
        // get country
        //    $country = $this->Xin_model->read_country_info($supplier[0]->country_id);
        // get company info
        $company = $this->Xin_model->read_company_setting_info(1);
        // get company > country info
        $ccountry = $this->Xin_model->read_country_info($company[0]->country);

        $data = array(
            'title' => $this->lang->line('xin_acc_view_sample') . ' #' . $sample_info[0]->sample_id,
            'breadcrumbs' => $this->lang->line('xin_acc_view_sample'),
            'path_url' => 'create_hrsale_quotation',
            'sample_id' => $sample_info[0]->sample_id,
            'prefix' => $sample_info[0]->prefix,
            'sample_number' => $sample_info[0]->sample_number,
            'customer_id' => $customer[0]->customer_id,
            'sample_date' => $sample_info[0]->sample_date,
            'status' => $sample_info[0]->status,
            'sample_due_date' => $sample_info[0]->sample_due_date,
            'sub_total_amount' => $sample_info[0]->sub_total_amount,
            'discount_type' => $sample_info[0]->discount_type,
            'discount_figure' => $sample_info[0]->discount_figure,
            'total_tax' => $sample_info[0]->total_tax,
            'total_discount' => $sample_info[0]->total_discount,
            'grand_total' => $sample_info[0]->grand_total,
            'sample_note' => $sample_info[0]->sample_note,
            'company_name' => $company[0]->company_name,
            'company_address' => $company[0]->address_1,
            'company_email' => $company[0]->company_email,
            'company_zipcode' => $company[0]->zipcode,
            'company_city' => $company[0]->city,
            'company_phone' => $company[0]->phone,
            'company_country' => $ccountry[0]->country_name,
            'all_items' => $this->Xin_model->get_items(),
            'all_taxes' => $this->Tax_model->get_all_taxes(),
            //    'product_for_purchase_invoice' => $this->Products_model->product_for_purchase_invoice(),
            //    'all_taxes' => $this->Products_model->get_taxes()
        );
        $role_resources_ids = $this->Xin_model->user_role_resource();
        //if(in_array('3',$role_resources_ids)) {
        $data['subview'] = $this->load->view("admin/samples/sample_preview", $data, true);
        $this->load->view('admin/layout/pre_layout_main', $data); //page load
        //} else {
        //    redirect('admin/dashboard/');
        //}
    }

    public function convert_to_invoice()
    {
        $data['title'] = $this->Xin_model->site_title();
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
        $sample_id = $this->uri->segment(4);
        $sample_info = $this->Samples_model->read_samples_info($sample_id);
        if (is_null($sample_info)) {
            redirect('admin/samples/view/' . $sample_id);
        }
        // get customer
        $customer = $this->Customers_model->read_customer_info($sample_info[0]->customer_id);
        // get company info
        $company = $this->Xin_model->read_company_setting_info(1);
        // get company > country info
        $ccountry = $this->Xin_model->read_country_info($company[0]->country);

        $data = array(
            'customer_id' => $sample_info[0]->customer_id,
            'invoice_number' => $sample_info[0]->sample_number,
            'invoice_date' => $sample_info[0]->sample_date,
            'invoice_due_date' => $sample_info[0]->sample_due_date,
            'prefix' => $sample_info[0]->prefix,
            'sub_total_amount' => $sample_info[0]->sub_total_amount,
            'total_tax' => $sample_info[0]->total_tax,
            'discount_type' => $sample_info[0]->discount_type,
            'discount_figure' => $sample_info[0]->discount_figure,
            'total_discount' => $sample_info[0]->total_discount,
            'grand_total' => $sample_info[0]->grand_total,
            'invoice_note' => $sample_info[0]->sample_note,
            'status' => '0',
            'created_at' => date('d-m-Y H:i:s'),
        );
        $result = $this->Invoices_model->add_invoice_record($data);
        if ($result == true) {
            $sample_items = $this->Samples_model->get_sample_items($sample_id);
            foreach ($sample_items as $_item) {

                // add values
                $pmodel = $this->Products_model->read_product_information($_item->item_id);
                $data2 = array(
                    'invoice_id' => $result,
                    'customer_id' => $sample_info[0]->customer_id,
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
                    'created_at' => date('d-m-Y H:i:s'),
                );
                $pmodel2 = $this->Products_model->read_product_information($_item->item_id);
                // add products >
                $add_product_qty = $pmodel2[0]->product_qty - $_item->item_qty;
                $idata = array(
                    'product_qty' => $add_product_qty,
                );
                $iresult = $this->Products_model->update_record($idata, $_item->item_id);

                $result_item = $this->Invoices_model->add_invoice_items_record($data2);
            }
        }
        //$Return['result'] = 'Converted to invoice successfully.';
        redirect('admin/orders/view/' . $result);
    }

    public function samples_list()
    {

        $data['title'] = $this->Xin_model->site_title();
        $session = $this->session->userdata('username');
        if (!empty($session)) {
            $this->load->view("admin/samples/sample_list", $data);
        } else {
            redirect('admin/');
        }
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $sample = $this->Samples_model->get_samples();
       
        $role_resources_ids = $this->Xin_model->user_role_resource();
        $data = array();

        foreach ($sample->result() as $r) {

            // get grand_total
            $grand_total = $this->Xin_model->currency_sign($r->grand_total);
            // get customer
            $customer = $this->Customers_model->read_customer_info($r->customer_id);
            if (!is_null($customer)) {
                $cname = $customer[0]->name;
            } else {
                $cname = '--';
            }
            $sample_date = '<i class="far fa-calendar-alt position-left"></i> ' . $this->Xin_model->set_date_format($r->sample_date);
            $sample_due_date = '<i class="far fa-calendar-alt position-left"></i> ' . $this->Xin_model->set_date_format($r->sample_due_date);
            //invoice_number
            $sample_number = '';
            $sample_number = '<a href="' . site_url() . 'admin/samples/view/' . $r->sample_id . '/">' . $r->sample_number . '</a>';
            $edit = '<span data-toggle="tooltip" data-placement="top" title="' . $this->lang->line('xin_edit') . '"><a href="' . site_url() . 'admin/samples/edit/' . $r->sample_id . '/"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-pencil"></span></button></a></span>';
            $delete = '<span data-toggle="tooltip" data-placement="top" title="' . $this->lang->line('xin_delete') . '"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="' . $r->sample_id . '"><span class="fa fa-trash"></span></button></span>';
            $view = '<span data-toggle="tooltip" data-placement="top" title="' . $this->lang->line('xin_view') . '"><a href="' . site_url() . 'admin/samples/view/' . $r->sample_id . '/"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light""><span class="fa fa-arrow-circle-right"></span></button></a></span>';
            if ($r->status == 0) {
                $_status = '<span class="label label-info">' . $this->lang->line('xin_sample_draft') . '</span>';
            } else if ($r->status == 1) {
                $_status = '<span class="label bg-purple">' . $this->lang->line('xin_sample_delivered') . '</span>';
            } else if ($r->status == 2) {
                $_status = '<span class="label label-warning">' . $this->lang->line('xin_sample_on_hold') . '</span>';
            } else if ($r->status == 3) {
                $_status = '<span class="label label-success">' . $this->lang->line('xin_accepted') . '</span>';
            } else if ($r->status == 4) {
                $_status = '<span class="label bg-maroon">' . $this->lang->line('xin_sample_lost') . '</span>';
            } else {
                $_status = '<span class="label label-danger">' . $this->lang->line('xin_sample_dead') . '</span>';
            }
            $combhr = $edit . $view . $delete;
            $data[] = array(
                $combhr,
                $r->sample_id,
                $sample_number,
                $cname,
                $grand_total,
                $sample_date,
                $_status,
            );
        }
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $sample->num_rows(),
            "recordsFiltered" => $sample->num_rows(),
            "data" => $data,
        );
        echo json_encode($output);
        exit();
    }

    // Validate and add info in database
    public function create_new_sample()
    {

        if ($this->input->post('add_type') == 'invoice_create') {
            /* Define return | here result is used to return user data and error for error message */
            $Return = array('result' => '', 'error' => '', 'csrf_hash' => '');
            $Return['csrf_hash'] = $this->security->get_csrf_hash();

            /* Server side PHP input validation */

            if ($this->input->post('sample_number') === '') {
                $Return['error'] = $this->lang->line('xin_acc_sample_no_field');
            } else if ($this->input->post('customer_id') === '') {
                $Return['error'] = $this->lang->line('xin_acc_order_customer_field');
            } else if ($this->input->post('sample_date') === '') {
                $Return['error'] = $this->lang->line('xin_acc_sample_date_field');
            } else if ($this->input->post('sample_due_date') === '') {
                $Return['error'] = $this->lang->line('xin_acc_sample_duedate_field');
            } else if ($this->input->post('unit_price') === '') {
                $Return['error'] = $this->lang->line('xin_acc_unitp_field');
            }

            if ($Return['error'] != '') {
                $this->output($Return);
            }

            $j = 0;foreach ($this->input->post('item_name') as $items) {
                $item_name = $this->input->post('item_name');
                $iname = $item_name[$j];
                // item qty
                $qty = $this->input->post('qty_hrs');
                $qtyhrs = $qty[$j];
                // item price
                $unit_price = $this->input->post('unit_price');
                $price = $unit_price[$j];

                if ($iname === '') {
                    $Return['error'] = $this->lang->line('xin_acc_itemp_field');
                } else if ($qty === '') {
                    $Return['error'] = $this->lang->line('xin_acc_qtyhrs_field');
                } else if ($price === '' || $price === 0) {
                    $Return['error'] = $j . " " . $this->lang->line('xin_acc_p_price_field');
                }
                $j++;
            }
            if ($Return['error'] != '') {
                $this->output($Return);
            }

            $data = array(
                'customer_id' => $this->input->post('customer_id'),
                'sample_number' => $this->input->post('sample_number'),
                'sample_date' => $this->input->post('sample_date'),
                'sample_due_date' => $this->input->post('sample_due_date'),
                'prefix' => $this->input->post('prefix'),
                'sub_total_amount' => $this->input->post('items_sub_total'),
                'total_tax' => $this->input->post('items_tax_total'),
                'discount_type' => $this->input->post('discount_type'),
                'discount_figure' => $this->input->post('discount_figure'),
                'total_discount' => $this->input->post('discount_amount'),
                'grand_total' => $this->input->post('fgrand_total'),
                'sample_note' => $this->input->post('sample_note'),
                'status' => '1',
                'created_at' => date('d-m-Y H:i:s'),
            );
           
            $result = $this->Samples_model->add_sample_record($data);

            if ($result) {
                $key = 0;
                foreach ($this->input->post('item_name') as $items) {

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
                        'sample_id' => $result,
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
                        'created_at' => date('d-m-Y H:i:s'),
                    );
                    $result_item = $this->Samples_model->add_sample_items_record($data2);

                    $key++;}
                $Return['result'] = $this->lang->line('xin_acc_sample_created');
            } else {
                $Return['error'] = $this->lang->line('xin_error_msg');
            }
            $this->output($Return);
            exit;
        }
    }

    // Validate and add info in database
    public function update_sample()
    {

        if ($this->input->post('add_type') == 'invoice_create') {
            /* Define return | here result is used to return user data and error for error message */
            $Return = array('result' => '', 'error' => '', 'csrf_hash' => '');
            $Return['csrf_hash'] = $this->security->get_csrf_hash();
            $id = $this->uri->segment(4);

            // add purchase items
            foreach ($this->input->post('item') as $eitem_id => $key_val) {

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

                // update item values
                $pmodel = $this->Products_model->read_product_information($iname);
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
                $result_item = $this->Samples_model->update_sample_items_record($data, $eitem_id);

            }

            ////
            $data = array(
                'sub_total_amount' => $this->input->post('items_sub_total'),
                'total_tax' => $this->input->post('items_tax_total'),
                'discount_type' => $this->input->post('discount_type'),
                'discount_figure' => $this->input->post('discount_figure'),
                'total_discount' => $this->input->post('discount_amount'),
                'grand_total' => $this->input->post('fgrand_total'),
                'sample_note' => $this->input->post('sample_note'),
            );
            $result = $this->Samples_model->update_sample_record($data, $id);

            if ($this->input->post('item_name')) {
                $key = 0;
                foreach ($this->input->post('item_name') as $items) {

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
                    $pmodel = $this->Products_model->read_product_information($iname);
                    $data2 = array(
                        'sample_id' => $id,
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
                        'created_at' => date('d-m-Y H:i:s'),
                    );
                    $result_item = $this->Samples_model->add_sample_items_record($data2);

                    $key++;}
                $Return['result'] = $this->lang->line('xin_acc_sample_updated');
            } else {
                //$Return['error'] = 'Bug. Something went wrong, please try again.';
            }
            $Return['result'] = $this->lang->line('xin_acc_sample_updated');
            $this->output($Return);
            exit;
        }
    }

    // delete a purchase record
    public function delete_item()
    {

        if ($this->uri->segment(5) == 'isajax') {
            /* Define return | here result is used to return user data and error for error message */
            $Return = array('result' => '', 'error' => '', 'csrf_hash' => '');
            $Return['csrf_hash'] = $this->security->get_csrf_hash();
            $id = $this->uri->segment(4);

            $result = $this->Samples_model->delete_sample_items_record($id);
            if (isset($id)) {
                $Return['result'] = $this->lang->line('xin_acc_sample_item_deleted');
            } else {
                $Return['error'] = $this->lang->line('xin_error_msg');
            }
            $this->output($Return);
        }
    }

    // delete a purchase record
    public function delete()
    {

        if ($this->input->post('is_ajax') == '2') {
            /* Define return | here result is used to return user data and error for error message */
            $Return = array('result' => '', 'error' => '', 'csrf_hash' => '');
            $Return['csrf_hash'] = $this->security->get_csrf_hash();
            $id = $this->uri->segment(4);

            $result = $this->Samples_model->delete_record($id);
            if (isset($id)) {
                $result_item = $this->Samples_model->delete_sample_items($id);
                $Return['result'] = $this->lang->line('xin_acc_sample_deleted');
            } else {
                $Return['error'] = $this->lang->line('xin_error_msg');
            }
            $this->output($Return);
        }
    }
}
