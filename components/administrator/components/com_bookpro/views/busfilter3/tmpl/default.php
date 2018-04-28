<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: default.php 81 2012-08-11 01:16:36Z quannv $
 **/

defined('_JEXEC') or die('Restricted access');

/* @var $this BookingViewSubjects */
JHtml::_('behavior.modal');
JHTML::_('behavior.tooltip');
AImporter::helper('currency','bookpro','date');
AImporter::model ( 'order' );
//BookProHelper::setSubmenu(1);
JToolbarHelper::title(JText::_('COM_BOOKPRO_BUSFILTER3'), 'user');
//JToolBarHelper::custom('pmibustrips.printpmi', 'print', 'icon over', 'Print', false, false);
//JToolBarHelper::preview(JUri::base().'index.php?option=com_bookpro&view=pmibustrips&tmpl=component&layout=report','_blank');
//JToolBarHelper::custom('pmibustrips.printticket', 'tags', 'icon over', 'Печать билета', true);

$toolbar = JToolbar::getInstance('toolbar');
//$toolbar->appendButton( 'Popup', 'print', JText::_('COM_BOOKPRO_PASSENGER_PRINT'), JUri::base().'index.php?option=com_bookpro&view=busfilter3&tmpl=component&layout=report','600px', '800px' );
JToolBarHelper::back();

$itemsCount = count($this->items);
$pagination = &$this->pagination;
$date = $this->state->get('filter.date');
 
$params=JComponentHelper::getParams('com_bookpro');


$state = $this->get('State');
$route_id=$state->get('filter.route_id');
$segment=$this->state->get('filter.children') ;

?>

<script type="text/javascript">
Joomla.submitbutton = function(pressbutton) { 
    
	var depart_date	=jQuery('#depart_date').val();
	var router_id	=jQuery('#filter_route_id').val();
	var agent_id	=jQuery('#filter_agent_id').val();
	var children	=jQuery('#filter_children').val();
	var pay_status	=jQuery('#filter_pay_status').val();

////////S

	var depart_todate =jQuery('#depart_todate').val();

////////E
	
	//if(pressbutton=='pmibustrips.print'){
		//$link="index.php?option=com_bookpro&controller=pmibustrips&task=exportpdf&depart_date="+depart_date+"&router_id="+router_id+"&agent_id="+agent_id+"&children="+children+"&tmpl=component";
		//window.open($link);
	//}

	if(pressbutton=='busfilter3.printticket'){

		if (document.adminForm.boxchecked.value==0){
			alert('Пожалуйста отметьте билеты галочками');
			}
		else{ 
			Joomla.submitform('busfilter3.printticket')
			return true;
			
			}

	}

		

	
}


 jQuery(document).ready(function($) {

$("#limit").val(0);
	 
	 $("a#ok").click(function(){
			var depart_date	=jQuery('#depart_date').val();
			var router_id	=jQuery('#filter_route_id').val();
			var agent_id	=jQuery('#filter_agent_id').val();
			var children	=jQuery('#filter_children').val();
			var pay_status	=jQuery('#filter_pay_status').val();

////////S

	var depart_todate =jQuery('#depart_todate').val();

////////E
			
		if(depart_date=="" &&router_id==0&&agent_id==0){
				alert ('Please enter a agent id and router id and depart date');	 
		}
		
		if(depart_date=="" &&router_id!=0&&agent_id!=0 ){
			alert('Please enter a depart date'); 
		}

		if(depart_date != "" && router_id !="0" && agent_id != "0"){
			 
			$link="index.php?option=com_bookpro&view=seatallocations&depart_date="+depart_date+"&route_id="+router_id+"&agent_id="+agent_id+"&children="+children+"&tmpl=component";
			
			SqueezeBox.fromElement(this, {handler:'iframe', size: {x: 800, y: 350}, url: $link});
		}
			 
		  
		});

	 

		if($("#filter_agent_id").val()>0){

			$.ajax({
				type:"GET",
				url: "<?php echo JUri::base()?>index.php?option=com_bookpro&controller=bustrips&task=getBustrip&id=<?php echo $route_id; ?>&format=raw",
				data:"agent_id="+$("#filter_agent_id").val(),
				beforeSend : function() {
					$("#filter_route_id")
							.html('<option>Loading route</option>');
				},
				success:function(result){
						$("#filter_route_id").html(result + '<option value="0" selected><?php echo JText::_("COM_BOOKPRO_FILTER_ALL_BUSTRIPS"); ?></option>');
					}
				});
			
			}

		$("#filter_agent_id").change(function(){
			$.ajax({
				type:"GET",
				url: "<?php echo JUri::base()?>index.php?option=com_bookpro&controller=bustrips&task=getBustrip&id=<?php echo $route_id; ?>&format=raw",
				data:"agent_id="+jQuery(this).val(),
				beforeSend : function() {
					$("#filter_route_id")
							.html('<option>Loading route</option>');
				},
				success:function(result){
						$("#filter_route_id").html(result + '<option value="0" selected><?php echo JText::_("COM_BOOKPRO_FILTER_ALL_BUSTRIPS"); ?></option>');
					}
				});
		});

	
	
});

</script>

<?php

$post_for_agent=$_POST;
$ssum=0;
$rsum=0;
$isum=0;
$ncount = $itemsCount;
$ncount_s = 0;
$ncount_r = 0;
$nnumber=1;

?> 
<!--
<head>
<meta charset="utf-8">
</head>
<pre>
-->
<?php
// print_r($order);
// die;
?>
<!--
</pre>
-->
<?php

?>

<div class="container">
<form action="index.php?option=com_bookpro&view=busfilter3" method="post" name="adminForm" id="adminForm">
	
	<div class="well well-small">
				<div class="row-fluid">
				<div class="form-inline">
				<label><?php echo JText::_('COM_BOOKPRO_BUSFILTER3_AGENT_NAME')?></label>
				<select name="filter_sks_agent_id" id="filter_sks_agent_id" class="input-medium">
				<option value="0"><?php echo JText::_('COM_BOOKPRO_SELECT_SKS_AGENT') ?></option>
				<option value="1" selected><?php echo JText::_('COM_BOOKPRO_AGENT1') ?></option>
				</select>
				<label><?php echo JText::_('COM_BOOKPRO_BUSFILTER3_COMPANY_NAME')?></label>
				<?php echo $this->agentbox;?>

<!--
				<select name="filter_route_id" id="filter_route_id" class="input-xlarge">
				<option value="0"><?php echo JText::_('COM_BOOKPRO_SELECT_ROUTE') ?></option>
				</select>
-->


				<label><?php echo JText::_('COM_BOOKPRO_BUSFILTER3_OPERATION_DATE_FROM')?></label>
				<?php
				if ($this->state->get('filter.depart_date')){
					$date = DateHelper::createFromFormat($this->state->get('filter.depart_date'))->format('d-m-Y');
				}
				else{
					$date = $this->state->get('filter.depart_date');
				}
				echo JHtml::calendar($date, 'filter_depart_date', 'depart_date',DateHelper::getConvertDateFormat('M'),'style="width:80px;"') ?>

				<label><?php echo JText::_('COM_BOOKPRO_BUSFILTER3_OPERATION_DATE_TO')?></label>
				<?php
				if ($this->state->get('filter.depart_todate')){
					$todate = DateHelper::createFromFormat($this->state->get('filter.depart_todate'))->format('d-m-Y');
				}
				else{
					$todate = $this->state->get('filter.depart_todate');
				}
				echo JHtml::calendar($todate, 'filter_depart_todate', 'depart_todate',DateHelper::getConvertDateFormat('M'),'style="width:80px;"');

				//$todate = date('d-m-Y', strtotime($todate . ' +1 day'));

				?>

				<label><?php echo JText::_('COM_BOOKPRO_BUSFILTER3_OPERATION_TYPE')?></label>
				<select name="filter_sum_or_refund" id="filter_sum_or_refund" class="input-medium">
				<option value="0" selected><?php echo JText::_('COM_BOOKPRO_AGENT_SUM_AND_REFUND_NAME') ?></option>
				<option value="1"><?php echo JText::_('COM_BOOKPRO_AGENT_SUM_NAME') ?></option>
				<option value="2"><?php echo JText::_('COM_BOOKPRO_AGENT_REFUND_NAME') ?></option>
				</select>
				
					<?php 
										
					$item[]=JHtmlSelect::option('1',JText::_('COM_BOOKPRO_ALL_SEGMENT'));
					$item[]=JHtmlSelect::option('0',JText::_('COM_BOOKPRO_SINGLE_SEGMENT'));
					echo JHtmlSelect::genericlist($item, 'filter_children',$attribs = 'class="input-medium" style="display:none;"', $optKey = 'value', $optText = 'text', $selected = $segment);
					 
					?>
					<button onclick="this.form.submit();" class="btn btn-success"><?php echo JText::_('COM_BOOKPRO_SEARCH'); ?></button>
<!--					<a id="ok" class="btn btn-info" >
						Схема мест
					</a> -->
				</div>
		 	
				
					
	
				</div>
	</div>
	<div class="row-fluid">
	<!--<a onClick ="jQuery('#printtable').tableExport({type:'xls'});" href="#">Экспорт в Excel</a>-->
	
		<table id="printtable" class="table table-striped" >
			<thead>
				
				
				<tr>
					<th width="3%">#</th>
					<th><?php echo JText::_("COM_BOOKPRO_AGENT"); ?></th>
					<th><?php echo JText::_("COM_BOOKPRO_COMPANY"); ?></th>
					<th><?php echo JText::_("COM_BOOKPRO_BUSFILTER3_OPERATION_DATE"); ?></th>
					<th><?php echo JText::_("COM_BOOKPRO_BUSFILTER3_OPERATION_TYPE"); ?></th>
					<th><?php echo JText::_("COM_BOOKPRO_BUSFILTER3_OPERATION_SUM"); ?></th>
					<th><?php echo JText::_("COM_BOOKPRO_BUSFILTER3_ORDER_NUMBER"); ?></th>
				</tr>
			</thead>
		
			<tbody>
				<?php 
				//var_dump ($this->items);
				//echo("----------------");
				//return (0);
				
				if (! is_array($this->items)) { ?>
					<tr><td colspan="10" class="emptyListInfo"><?php echo JText::_('No items found.'); ?></td></tr>
				<?php 
				
					} else {
						 for ($i = 0; $i < $itemsCount; $i++) { 
				    	 	$subject = &$this->items[$i]; 
					    
							//	var_dump($subject->order_id);
							//	return 0;
							
							$orderModel = new BookProModelOrder ();
        				    $order = $orderModel->getComplexItem ( $subject->order_id);
        					//var_dump($order);

				if($order->bustrips != 0)
				{

	        					for($jj = 0; $jj < count($order->bustrips); $jj++) {
	        					    if ($order->bustrips[$jj]->code==$subject->tripcode){
	        					        $bustripfrom=$order->bustrips[$jj]->from_name;
	        					        $bustripto=$order->bustrips[$jj]->to_name;
	        					    }
	        					}
									
						?>
	
					<?php

	$topost1=$post_for_agent["filter_sks_agent_id"];
	$topost2=$post_for_agent["filter_agent_id"];
	$topost3=$post_for_agent["filter_sum_or_refund"];
	JFactory::getApplication ()->setUserState ("topost_1", $topost1);
	JFactory::getApplication ()->setUserState ("topost_2", $topost2);
	JFactory::getApplication ()->setUserState ("topost_3", $topost3);
					
					if( ($order->bustrips[0]->id) && ($post_for_agent["filter_sks_agent_id"]!=0) && ($subject->passenger_status != "PENDING") && ( (($order->bustrips[0]->agent_id)==($post_for_agent["filter_agent_id"])) || (($post_for_agent["filter_agent_id"])==0) ) && ( ($post_for_agent["filter_sum_or_refund"]==0) || (($post_for_agent["filter_sum_or_refund"]==1) && ($subject->passenger_status == "CONFIRMED")) || (($post_for_agent["filter_sum_or_refund"]==2) && ( ($subject->passenger_status == "CANCELLED_L_B_D") || ($subject->passenger_status == "CANCELLED_B_D") || ($subject->passenger_status == "CANCELLED_A_D") )) ) )
					{
	
						$result_massiv[$nnumber]["agent"]=JText::_('COM_BOOKPRO_AGENT1');
						$result_massiv[$nnumber]["company"]=$order->bustrips[0]->company;
						if($subject->passenger_status == "CONFIRMED")
						{
							$result_massiv[$nnumber]["date"]=$order->created;
						}
						else if( ($subject->passenger_status == "CANCELLED_L_B_D") || ($subject->passenger_status == "CANCELLED_B_D") || ($subject->passenger_status == "CANCELLED_A_D") )
						{
							$result_massiv[$nnumber]["date"]=$order->refund_date;
						}
						$result_massiv[$nnumber]["operation"]=$subject->passenger_status;
	
						if($subject->passenger_status == "CONFIRMED")
						{
							$result_massiv[$nnumber]["sum"]=$order->subtotal;
						}
						else if( ($subject->passenger_status == "CANCELLED_L_B_D") || ($subject->passenger_status == "CANCELLED_B_D") || ($subject->passenger_status == "CANCELLED_A_D") )
						{
	
							$expired_data1= $order->bustrips[0]->depart_date;
							$expired_data2=date( "Y-m-d H:i:s", strtotime($expired_data1." -120 minutes" ));
							$expired_data3=date( "Y-m-d H:i:s", strtotime($expired_data1." +180 minutes" ));
							$expired_data4=date( "Y-m-d H:i:s", strtotime($expired_data1." -1440 minutes" ));

							if($order->bustrips[0]->associated_parent_id != 0)
							{
								$db = JFactory::getDbo();
								$query = $db->getQuery(true);
								$query->select('*');
								$query->from('#__bookpro_bustrip');
								$query->where(' id = '.$order->bustrips[0]->associated_parent_id);
								$db->setQuery($query);
								$querry_result =  $db->loadObjectList();
								$bustrip_type=$querry_result[0]->bustrip_type;
							}
							else if($order->bustrips[0]->parent_id != 0)
							{
								$db = JFactory::getDbo();
								$query = $db->getQuery(true);
								$query->select('*');
								$query->from('#__bookpro_bustrip');
								$query->where(' id = '.$order->bustrips[0]->parent_id);
								$db->setQuery($query);
								$querry_result =  $db->loadObjectList();
								$bustrip_type=$querry_result[0]->bustrip_type;
							}
							else 
							{
								$db = JFactory::getDbo();
								$query = $db->getQuery(true);
								$query->select('*');
								$query->from('#__bookpro_bustrip');
								$query->where(' id = '.$order->bustrips[0]->id);
								$db->setQuery($query);
								$querry_result =  $db->loadObjectList();
								$bustrip_type=$querry_result[0]->bustrip_type;
							}

		
							if($bustrip_type == 0)
							{
								if($order->refund_date < $expired_data2)
								{
									$result_massiv[$nnumber]["sum"]= ($order->subtotal / 100) * 95;
								}
								else if(($expired_data2 < $order->refund_date)&&($order->refund_date < $expired_data1))
								{
									$result_massiv[$nnumber]["sum"]=($order->subtotal / 100) * 85;
								}
								else if(($expired_data1 < $order->refund_date)&&($order->refund_date < $expired_data3))
								{
									$result_massiv[$nnumber]["sum"]=($order->subtotal / 100) * 75;
								}
								else if($expired_data3 < $order->refund_date)
								{
									$result_massiv[$nnumber]["sum"]=0;
								}
							}
							else if($bustrip_type == 1)
							{
								if($order->refund_date < $expired_data4)
								{
									$result_massiv[$nnumber]["sum"]= ($order->subtotal / 100) * 95;
								}
								else if(($expired_data4 < $order->refund_date)&&($order->refund_date < $expired_data1))
								{
									$result_massiv[$nnumber]["sum"]=($order->subtotal / 100) * 50;
								}
								else if($expired_data1 < $order->refund_date)
								{
									$result_massiv[$nnumber]["sum"]=0;
								}
							}
	
						}
	
						$result_massiv[$nnumber]["order"]=$order->order_number;	
	
						$nnumber++;		
	   
					}
				}

			}

			$result_massiv = array_map("unserialize", array_unique( array_map("serialize", $result_massiv) ));

				
			$oz=1;
			for($zz=1;$zz<$nnumber+1;$zz++)
			{

				if($result_massiv[$zz])
				{

					?>

						<tr>
				    		<td style="text-align: left; white-space: nowrap;">
						<?php echo $oz; ?>
						</td>
						<td>
						<?php echo $result_massiv[$zz]["agent"]; ?>
						</td>
						<td>
						<?php echo $result_massiv[$zz]["company"]; ?>
						</td>
				    		<td>
				    		<?php echo $result_massiv[$zz]["date"]; ?>
				    		</td>
				    		<td>
				    		<?php if($result_massiv[$zz]["operation"] == "CONFIRMED") {$ssum= $ssum + $result_massiv[$zz]["sum"]; echo JText::_('COM_BOOKPRO_REPORT_TOUR');} else if( ($result_massiv[$zz]["operation"] == "CANCELLED_L_B_D" ) || ($result_massiv[$zz]["operation"] == "CANCELLED_B_D" ) || ($result_massiv[$zz]["operation"] == "CANCELLED_A_D" ) ) {$rsum= $rsum + $result_massiv[$zz]["sum"]; echo JText::_('COM_BOOKPRO_PAYMENT_STATUS_REFUND');} ?>
				    		</td>
				    		<td>
				    		<?php echo $result_massiv[$zz]["sum"]; ?>
				    		</td>
				    		<td>
				    		<?php echo $result_massiv[$zz]["order"]; ?>
				    		</td>
				    		</tr>

					<?php

					$oz++;

				}
			}
			
		}
		?>
			</tbody>
		</table>
<?php
echo $date." - ".$todate."<br>";
echo JText::sprintf('COM_BOOKPRO_AGENT_NSUM',$ssum).'<br>';
echo JText::sprintf('COM_BOOKPRO_AGENT_NREFUND',$rsum).'<br>';
//$isum= $ssum - $rsum;
//echo JText::sprintf('COM_BOOKPRO_TOTAL_TXT',$isum).'<br>';
?>
		</div>
<div style="display:none;">
	<?php echo $this->pagination->getLimitBox(); ?>
</div>
	<?php echo $this->pagination->getListFooter(); ?>	

	<input type="hidden" name="option" value="com_bookpro"/>
	<input type="hidden" name="task"	value="" />
	<input type="hidden" name="boxchecked" value="0"> 
	<?php echo JHTML::_('form.token'); ?>
</form>	
<div>

</div>
</div>


