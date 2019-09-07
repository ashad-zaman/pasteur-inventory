<?php $session = $this->session->userdata('username'); ?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $theme = $this->Xin_model->read_theme_info(1);?>
<?php $this->load->view('admin/components/vendors/del_dialog');?>

<!-- jQuery 3 -->
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/jquery/jquery-3.2.1.min.js"></script> 
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/bootstrap-select/bootstrap-select.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/jquery-ui/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/Trumbowyg/dist/trumbowyg.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/clockpicker/dist/jquery-clockpicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/toastr/toastr.min.js"></script>

<!--<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>-->
<!-- jQuery Knob Chart -->
<!--<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>-->
<!-- daterangepicker -->
<!--<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>-->
<!-- datepicker -->
<!--<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>-->
<!-- Bootstrap WYSIHTML5 -->
<!--<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>-->
<!-- Slimscroll -->
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/dist/js/pages/dashboard.js"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/dist/js/demo.js"></script>

<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">var user_role = '<?php //echo $user[0]->user_role_id;?>';</script>
<script type="text/javascript">var user_session_id = '<?php echo $session['user_id'];?>';</script>
<script type="text/javascript">var js_date_format = '<?php echo $this->Xin_model->set_date_format_js();?>';</script>
<script type="text/javascript">var site_url = '<?php echo site_url(); ?>admin/';</script>
<script type="text/javascript">var base_url = '<?php echo site_url().'admin/'.$this->router->fetch_class(); ?>';</script>
<script type="text/javascript">
$(document).ready(function(){
	toastr.options.closeButton = <?php echo $system[0]->notification_close_btn;?>;
	toastr.options.progressBar = <?php echo $system[0]->notification_bar;?>;
	toastr.options.timeOut = 3000;
	toastr.options.showMethod = 'slideDown';
	toastr.options.hideMethod = 'slideUp';
	toastr.options.preventDuplicates = true;
	toastr.options.positionClass = "<?php echo $system[0]->notification_position;?>";
   // setTimeout(refreshChatMsgs, 5000);
   $('[data-toggle="popover"]').popover();
});
function escapeHtmlSecure(str)
{
	var map =
	{
		'alert': '&lt;',
		'313': '&lt;',
		'bzps': '&lt;',
		'<': '&lt;',
		'>': '&gt;',
		'script': '&lt;',
		'html': '&lt;',
		'php': '&lt;',
	};
	return str.replace(/[<>]/g, function(m) {return map[m];});
}	
</script>
<script type="text/javascript">
$(document).ready(function(){
	/*  Toggle Starts   */
	//iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    });
	//$('.js-switch:checkbox').checkboxpicker();
	$('.date').datepicker({
	changeMonth: true,
	changeYear: true,
	dateFormat:'yy-mm-dd',
	yearRange: '1900:' + (new Date().getFullYear() + 15),
	beforeShow: function(input) {
		$(input).datepicker("widget").show();
	}
	});
});
</script>
<script type="text/javascript" src="<?php echo base_url().'skin/hrsale_assets/hrsale_scripts/'.$path_url.'.js'; ?>"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/hrsale_scripts/custom.js"></script>
<?php if($this->router->fetch_class() =='roles') { ?>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/kendo/kendo.all.min.js"></script>
<?php $this->load->view('admin/roles/role_values');?>
<?php } ?>
<?php if($this->router->fetch_class() =='organization'){?>
<?php $this->load->view('admin/components/vendors/organization_chart');?>
<?php } ?>
<?php if($this->router->fetch_class() =='goal_tracking' || $this->router->fetch_method() =='task_details' || $this->router->fetch_class() =='project' || $this->router->fetch_method() =='project_details'){?>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/ion.rangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
<?php }?>
<?php if($this->router->fetch_method() =='task_details' || $this->router->fetch_method() =='project_details' || $this->router->fetch_class() =='project'){?>
<script type="text/javascript">
$(document).ready(function(){	
	$("#range_grid").ionRangeSlider({
		type: "single",
		min: 0,
		max: 100,
		from: '<?php echo $progress;?>',
		grid: true,
		force_edges: true,
		onChange: function (data) {
			$('#progres_val').val(data.from);
		}
	});
});
</script>
<?php } ?>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<?php if(($this->router->fetch_class() =='invoices' || $this->router->fetch_class() =='quotes' || $this->router->fetch_class() =='samples' || $this->router->fetch_class() =='orders') && ($this->router->fetch_method() =='create' || $this->router->fetch_method() =='edit')) { ?>

<script type="text/javascript">
$(document).ready(function(){
	$('#add-invoice-item').click(function () {
        jQuery.get(base_url+"/get_invoice_items/", function(data, status){
			$('#item-list').append(data).fadeIn(500);
		});		
	});	

});
</script>


<?php } ?>

<?php if(($this->router->fetch_class() =='purchase' && $this->router->fetch_method() =='create') || ($this->router->fetch_class() =='purchase' && $this->router->fetch_method() =='edit')|| ($this->router->fetch_class() =='purchase' && $this->router->fetch_method() =='convert_quote_purchase')) { ?>

<script type="text/javascript">
$(document).ready(function(){
	$('#add-invoice-item').click(function () {
        jQuery.get(base_url+"/get_purchase_items/", function(data, status){
			$('#item-list').append(data).fadeIn(500);
		});		
	});	
});
</script>
<?php } ?>

<?php if(($this->router->fetch_class() =='challan' && $this->router->fetch_method() =='create') || ($this->router->fetch_class() =='challan' && $this->router->fetch_method() =='edit')|| ($this->router->fetch_class() =='challan' && $this->router->fetch_method() =='convert_quote_challan')) { ?>

<script type="text/javascript">
$(document).ready(function(){
	$('#add-challan-item').click(function () {
        jQuery.get(base_url+"/get_challan_items/", function(data, status){
			$('#item-list').append(data).fadeIn(500);
		});		
	});	
});
</script>
<?php } ?>


<?php if(($this->router->fetch_class() =='invoices' || $this->router->fetch_class() =='quotes' || $this->router->fetch_class() =='orders') && $this->router->fetch_method() =='view' || $this->router->fetch_method() =='preview') { ?>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/printThis.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.print-invoice').click(function () {
		$("#print_invoice_hr").printThis();
	});	
});
</script>
<?php } ?>
<?php if($this->router->fetch_class() =='calendar' || $this->router->fetch_class() =='dashboard'){?>
	<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/moment/moment.js"></script>
	<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
	<?php $this->load->view('admin/components/vendors/full_calendar');?>
    <script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/gauge.min.js"></script>
    <script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/jquery-knob/js/jquery.knob.js"></script>
    <script type="text/javascript">
	$(function () {
	/* jQueryKnob */

    $(".knob").knob({
      draw: function () {

        // "tron" case
        if (this.$.data('skin') == 'tron') {

          var a = this.angle(this.cv)  // Angle
              , sa = this.startAngle          // Previous start angle
              , sat = this.startAngle         // Start angle
              , ea                            // Previous end angle
              , eat = sat + a                 // End angle
              , r = true;

          this.g.lineWidth = this.lineWidth;

          this.o.cursor
          && (sat = eat - 0.3)
          && (eat = eat + 0.3);

          if (this.o.displayPrevious) {
            ea = this.startAngle + this.angle(this.value);
            this.o.cursor
            && (sa = ea - 0.3)
            && (ea = ea + 0.3);
            this.g.beginPath();
            this.g.strokeStyle = this.previousColor;
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
            this.g.stroke();
          }

          this.g.beginPath();
          this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
          this.g.stroke();

          this.g.lineWidth = 2;
          this.g.beginPath();
          this.g.strokeStyle = this.o.fgColor;
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
          this.g.stroke();

          return false;
        }
      }
    });
    /* END JQUERY KNOB */
});
	</script>
    
<?php }?>