<?php $sales = $this->Reports_model->get_sales_report($from_date,$to_date);?>
<?php
$total_amount = 0;
foreach($sales->result() as $r) {
	// amount
	$total_amount += $r->amount;
}
?>

<tr>
  <th colspan="5">&nbsp;</th>
  <th><?php echo $this->lang->line('xin_acc_total');?>: <?php echo $this->Xin_model->currency_sign($total_amount);?></th>
</tr>
