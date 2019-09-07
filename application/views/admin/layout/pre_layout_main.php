<?php
$session = $this->session->userdata('username');
$system = $this->Xin_model->read_setting_info(1);
$company_info = $this->Xin_model->read_company_setting_info(1);
$layout = $this->Xin_model->system_layout();
$user_info = $this->Xin_model->read_user_info($session['user_id']);
//material-design
$theme = $this->Xin_model->read_theme_info(1);
// set layout / fixed or static
if($user_info[0]->fixed_header=='fixed_layout_hrsale') {
	$fixed_header = 'fixed';
} else {
	$fixed_header = '';
}
if($user_info[0]->boxed_wrapper=='boxed_layout_hrsale') {
	$boxed_wrapper = 'layout-boxed';
} else {
	$boxed_wrapper = '';
}
if($user_info[0]->compact_sidebar=='sidebar_layout_hrsale') {
	$compact_sidebar = 'sidebar-collapse';
} else {
	$compact_sidebar = '';
}
/*
if($this->router->fetch_class() =='chat'){
	$chat_app = 'chat-application';
} else {
	$chat_app = '';
}*/
?>
<?php $this->load->view('admin/components/htmlheader');?>
<?php echo $subview;?>
<!-- ./wrapper -->

<!-- Layout footer -->
<?php $this->load->view('admin/components/htmlfooter');?>
<!-- / Layout footer -->
          
</body>
</html>