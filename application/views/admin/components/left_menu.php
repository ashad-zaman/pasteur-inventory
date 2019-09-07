<?php
$session = $this->session->userdata('username');
$theme = $this->Xin_model->read_theme_info(1);
// set layout / fixed or static
/*if($theme[0]->right_side_icons=='true') {
	$icons_right = 'expanded menu-icon-right';
} else {
	$icons_right = '';
}
if($theme[0]->bordered_menu=='true') {
	$menu_bordered = 'menu-bordered';
} else {
	$menu_bordered = '';
}*/
$user_info = $this->Xin_model->read_user_info($session['user_id']);
if($user_info[0]->is_active!=1) {
	redirect('admin/');
}

$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);

if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $arr_mod = $this->Xin_model->select_module_class($this->router->fetch_class(),$this->router->fetch_method()); ?>
<?php $submenuicon = 'fa-circle-o';//'fa-angle-double-right';?>
<?php  if($user_info[0]->profile_photo!='' && $user_info[0]->profile_photo!='no file') {?>
	<?php $cpimg = base_url().'uploads/users/'.$user_info[0]->profile_photo;?>
<?php } else {?>
<?php  if($user_info[0]->gender=='Male') { ?>
<?php 	$de_file = base_url().'uploads/users/default_male.jpg';?>
<?php } else { ?>
<?php 	$de_file = base_url().'uploads/users/default_female.jpg';?>
<?php } ?>
    <?php $cpimg = $de_file;?>
<?php  } ?>
<section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo $cpimg;?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $user_info[0]->first_name. ' '.$user_info[0]->last_name;?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="<?php if(!empty($arr_mod['active']))echo $arr_mod['active'];?>">
          <a href="<?php echo site_url('admin/dashboard');?>">
            <i class="fa fa-dashboard"></i> <span><?php echo $this->lang->line('dashboard_title');?></span>
          </a>
        </li>
       <?php if(in_array('1',$role_resources_ids) || in_array('2',$role_resources_ids) || in_array('3',$role_resources_ids) || in_array('4',$role_resources_ids) || in_array('5',$role_resources_ids) || in_array('6',$role_resources_ids)){?>
        <li class="<?php if(!empty($arr_mod['products_open']))echo $arr_mod['products_open'];?> treeview">
          <a href="#">
            <i class="glyphicon glyphicon-th-large"></i> <span><?php echo $this->lang->line('xin_acc_products');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <?php if(in_array('2',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['products_active']))echo $arr_mod['products_active'];?>">
            <a href="<?php echo site_url('admin/products/');?>">
              <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_acc_products');?>
            </a>
          </li>
          <?php } ?>
          <?php if(in_array('3',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['out_of_stock_active']))echo $arr_mod['out_of_stock_active'];?>">
            <a href="<?php echo site_url('admin/products/out_of_stock/');?>">
              <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_acc_out_of_stock_products');?>
            </a>
          </li>
          <?php } ?>

          <!-- <?php if(in_array('4',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['expired_stock_active']))echo $arr_mod['expired_stock_active'];?>">
            <a href="<?php echo site_url('admin/products/expired_stock/');?>">
              <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_acc_low_stock_products');?>
            </a>
          </li>
          <?php } ?> -->

          <?php if(in_array('5',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['taxes_active']))echo $arr_mod['taxes_active'];?>">
            <a href="<?php echo site_url('admin/orders/taxes');?>">
              <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_acc_product_tax');?>
            </a>
          </li>
          <?php } ?>
          <?php if(in_array('6',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['categories_product_active']))echo $arr_mod['categories_product_active'];?>">
            <a href="<?php echo site_url('admin/products/categories');?>">
              <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_acc_product_categories');?>
            </a>
          </li>
          <?php } ?>
         </ul>
        </li>
        <?php } ?>
        <?php if(in_array('7',$role_resources_ids)) { ?>
        <li class="<?php if(!empty($arr_mod['warehouse_active']))echo $arr_mod['warehouse_active'];?>">
          <a href="<?php echo site_url('admin/warehouse');?>">
            <i class="fa fa-building"></i> <span><?php echo $this->lang->line('xin_acc_warehouses');?></span>
          </a>
        </li>
        <?php } ?>    
        <?php if(in_array('8',$role_resources_ids)) { ?>
        <li class="<?php if(!empty($arr_mod['suppliers_active']))echo $arr_mod['suppliers_active'];?>">
          <a href="<?php echo site_url('admin/suppliers');?>">
            <i class="glyphicon glyphicon-user"></i> <span><?php echo $this->lang->line('xin_suppliers');?></span>
          </a>
        </li>
        <?php } ?>



        <?php if(in_array('13',$role_resources_ids)) { ?>
        <li class="<?php if(!empty($arr_mod['company_active']))echo $arr_mod['company_active'];?>">
          <a href="<?php echo site_url('admin/company');?>">
            <i class="fa fa-building-o"></i> <span><?php echo $this->lang->line('xin_companies');?></span>
          </a>
        </li>
        <?php } ?>

        
        <?php if(in_array('12',$role_resources_ids)) { ?>
        <li class="<?php if(!empty($arr_mod['customers_active']))echo $arr_mod['customers_active'];?>">
          <a href="<?php echo site_url('admin/customers');?>">
            <i class="fa fa-handshake-o"></i> <span><?php echo $this->lang->line('xin_customers');?></span>
          </a>
        </li>
        <?php } ?>
          

<?php if(in_array('14',$role_resources_ids) || in_array('17',$role_resources_ids) || in_array('18',$role_resources_ids) ){?>
        <li class="<?php if(!empty($arr_mod['hr_sales_open']))echo $arr_mod['hr_sales_open'];?> treeview">
          <a href="#">
            <i class="glyphicon glyphicon-shopping-cart"></i> <span><?php echo $this->lang->line('xin_acc_quote_order');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
         
          <?php if(in_array('17',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['hr_quotes_active']))echo $arr_mod['hr_quotes_active'];?>">
            <a href="<?php echo site_url('admin/quotes/');?>">
              <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_acc_quotes_order');?>
            </a>
          </li>
          <?php } ?>
          <?php if(in_array('18',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['hr_quotes_create']))echo $arr_mod['hr_quotes_create'];?>">
            <a href="<?php echo site_url('admin/quotes/create');?>">
              <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_acc_add_order_quote');?>
            </a>
          </li>
          <?php } ?>
          
           
         </ul>
        </li>

        <?php } ?> 




        <?php if(in_array('9',$role_resources_ids) || in_array('10',$role_resources_ids) || in_array('11',$role_resources_ids)){?>
        <li class="<?php if(!empty($arr_mod['hr_purchase_open']))echo $arr_mod['hr_purchase_open'];?> treeview">
          <a href="#">
            <i class="fa fa-truck"></i> <span><?php echo $this->lang->line('xin_acc_purchases');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          

          <?php if(in_array('11',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['hr_purchases']))echo $arr_mod['hr_purchases'];?>">
            <a href="<?php echo site_url('admin/purchase/');?>">
              <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_acc_purchase_list');?>
            </a>
          </li>
          <?php } ?>

          <?php if(in_array('10',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['hr_purchase_new']))echo $arr_mod['hr_purchase_new'];?>">
            <a href="<?php echo site_url('admin/purchase/create/');?>">
              <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_acc_new_purchase');?>
            </a>
          </li>
          <?php } ?>
          
         </ul>
        </li>
        <?php } ?>

        
        <?php if(in_array('9',$role_resources_ids) || in_array('10',$role_resources_ids) || in_array('11',$role_resources_ids)){?>
        <li class="<?php if(!empty($arr_mod['hr_purchase_open']))echo $arr_mod['hr_purchase_open'];?> treeview">
          <a href="#">
            <i class="fa fa-truck"></i> <span><?php echo $this->lang->line('xin_acc_challanes');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          

          <?php if(in_array('11',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['hr_purchases']))echo $arr_mod['hr_purchases'];?>">
            <a href="<?php echo site_url('admin/challan/');?>">
              <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_acc_challane_list');?>
            </a>
          </li>
          <?php } ?>

          <?php if(in_array('10',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['hr_purchase_new']))echo $arr_mod['hr_purchase_new'];?>">
            <a href="<?php echo site_url('admin/challan/create/');?>">
              <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_acc_new_challanes');?>
            </a>
          </li>
          <?php } ?>
          
         </ul>
        </li>
        <?php } ?>

        

<!--          

        <?php if(in_array('35',$role_resources_ids) || in_array('36',$role_resources_ids) || in_array('37',$role_resources_ids) ){?>
        <li class="<?php if(!empty($arr_mod['hr_sales_open']))echo $arr_mod['hr_sales_open'];?> treeview">
          <a href="#">
            <i class="glyphicon glyphicon-shopping-cart"></i> <span><?php echo $this->lang->line('xin_acc_sample_order');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <?php if(in_array('36',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['hr_invoices_active']))echo $arr_mod['hr_invoices_active'];?>">
            <a href="<?php echo site_url('admin/samples/');?>">
              <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_acc_manage_sample_order');?>
            </a>
          </li>
          <?php } ?>

          <?php if(in_array('37',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['hr_invoices_create']))echo $arr_mod['hr_invoices_create'];?>">
            <a href="<?php echo site_url('admin/samples/create/');?>">
              <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_acc_add_sample_order');?>
            </a>
          </li>
          <?php } ?>
          
           
         </ul>
        </li>

        <?php } ?> -->






        <?php if(in_array('14',$role_resources_ids) || in_array('15',$role_resources_ids) || in_array('16',$role_resources_ids) ){?>
        <li class="<?php if(!empty($arr_mod['hr_sales_open']))echo $arr_mod['hr_sales_open'];?> treeview">
          <a href="#">
            <i class="glyphicon glyphicon-shopping-cart"></i> <span><?php echo $this->lang->line('xin_acc_sales_order');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <?php if(in_array('15',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['hr_invoices_active']))echo $arr_mod['hr_invoices_active'];?>">
            <a href="<?php echo site_url('admin/orders/');?>">
              <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_acc_manage_order');?>
            </a>
          </li>
          <?php } ?>
          <?php if(in_array('16',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['hr_invoices_create']))echo $arr_mod['hr_invoices_create'];?>">
            <a href="<?php echo site_url('admin/orders/create/');?>">
              <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_acc_add_order');?>
            </a>
          </li>
          <?php } ?>




         </ul>
        </li>
        <?php } ?>
        <?php if(in_array('19',$role_resources_ids)) { ?>
        <li class="<?php if(!empty($arr_mod['calendar_active']))echo $arr_mod['calendar_active'];?>">
          <a href="<?php echo site_url('admin/calendar');?>">
            <i class="fa fa-calendar-check-o"></i> <span><?php echo $this->lang->line('xin_acc_calendar');?></span>
          </a>
        </li>
        <?php } ?>
        <!-- <?php if(in_array('20',$role_resources_ids)) { ?>
        <li class="<?php if(!empty($arr_mod['expense_active']))echo $arr_mod['expense_active'];?>">
          <a href="<?php echo site_url('admin/expense');?>">
            <i class="fa fa-dollar"></i> <span><?php echo $this->lang->line('xin_acc_expenditure');?></span>
          </a>
        </li>
        <?php } ?> -->
        <?php if(in_array('21',$role_resources_ids) || in_array('22',$role_resources_ids) || in_array('23',$role_resources_ids) || in_array('24',$role_resources_ids)){?>
        <li class="<?php if(!empty($arr_mod['hr_acc_reports_open']))echo $arr_mod['hr_acc_reports_open'];?> treeview">
          <a href="#">
            <i class="fa fa-bar-chart-o"></i> <span><?php echo $this->lang->line('xin_acc_reports');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <?php if(in_array('22',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['hr_all_report_report']))echo $arr_mod['hr_all_report_report'];?>">
                <a href="<?php echo site_url('admin/reports/all_report');?>">
                  <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_acc_todays_report');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('23',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['hr_purchases_report']))echo $arr_mod['hr_purchases_report'];?>">
                <a href="<?php echo site_url('admin/reports/purchases_report');?>">
                  <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_acc_puchases_report');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('24',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['hr_invoices_report_sales']))echo $arr_mod['hr_invoices_report_sales'];?>">
                <a href="<?php echo site_url('admin/reports/sales_report');?>">
                  <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_acc_sales_report');?>
                </a>
              </li>
              <?php } ?>
             </ul>
        </li>
        <?php } ?>
        
        <!-- <?php if(in_array('25',$role_resources_ids) || in_array('26',$role_resources_ids) || in_array('27',$role_resources_ids) || in_array('28',$role_resources_ids) || in_array('29',$role_resources_ids) || in_array('30',$role_resources_ids) || in_array('31',$role_resources_ids) || in_array('32',$role_resources_ids) || in_array('33',$role_resources_ids) || in_array('34',$role_resources_ids) || $user_info[0]->user_role_id==1){?>
        <li class="<?php if(!empty($arr_mod['system_open']))echo $arr_mod['system_open'];?> treeview">
          <a href="#">
            <i class="fa fa-cog"></i> <span><?php echo $this->lang->line('xin_system');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <?php if(in_array('26',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['languages_active']))echo $arr_mod['languages_active'];?>">
                <a href="<?php echo site_url('admin/languages');?>">
                  <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_multi_language');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('27',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['settings_active']))echo $arr_mod['settings_active'];?>">
                <a href="<?php echo site_url('admin/settings');?>">
                  <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_settings');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('28',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['payment_gateway_active']))echo $arr_mod['payment_gateway_active'];?>">
                <a href="<?php echo site_url('admin/settings/payment_gateway');?>">
                  <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_acc_payment_gateway');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('29',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['theme_active']))echo $arr_mod['theme_active'];?>">
                <a href="<?php echo site_url('admin/theme');?>">
                  <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_theme_settings');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('30',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['constants_active']))echo $arr_mod['constants_active'];?>">
                <a href="<?php echo site_url('admin/settings/constants');?>">
                  <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_constants');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('31',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['db_active']))echo $arr_mod['db_active'];?>">
                <a href="<?php echo site_url('admin/settings/database_backup');?>">
                  <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_db_backup');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('32',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['email_template_active']))echo $arr_mod['email_template_active'];?>">
                <a href="<?php echo site_url('admin/settings/email_template');?>">
                  <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_email_templates');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('33',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['users_active']))echo $arr_mod['users_active'];?>">
                <a href="<?php echo site_url('admin/users');?>">
                  <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('let_staff');?>
                </a>
              </li>
              <?php } ?>
              <?php if($user_info[0]->user_role_id==1) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['roles_active']))echo $arr_mod['roles_active'];?>">
                <a href="<?php echo site_url('admin/roles');?>">
                  <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('xin_crm_user_roles');?>
                </a>
              </li>
              <?php } ?>
             <?php if(in_array('34',$role_resources_ids)) { ?>
            <li class="sidenav-link <?php if(!empty($arr_mod['hr_account_transactions_active']))echo $arr_mod['hr_account_transactions_active'];?>">
              <a href="<?php echo site_url('admin/transactions');?>">
                <i class="fa fa-money"></i> <span><?php echo $this->lang->line('xin_acc_view_transactions_log');?></span>
              </a>
            </li>
            <?php } ?>
             </ul>
        </li>
        <?php } ?> -->
        <li>
          <a href="<?php echo site_url('admin/logout');?>">
            <i class="fa fa-sign-out"></i> <span><?php echo $this->lang->line('left_logout');?></span>
          </a>
        </li>
      </ul>
    </section>
   