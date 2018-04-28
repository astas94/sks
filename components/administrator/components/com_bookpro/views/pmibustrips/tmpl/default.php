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
JToolbarHelper::title(JText::_('Информация о маршрутах'), 'user');
//JToolBarHelper::custom('pmibustrips.printpmi', 'print', 'icon over', 'Print', false, false);
//JToolBarHelper::preview(JUri::base().'index.php?option=com_bookpro&view=pmibustrips&tmpl=component&layout=report','_blank');
//JToolBarHelper::custom('pmibustrips.printticket', 'tags', 'icon over', 'Печать билета', true);

$toolbar = JToolbar::getInstance('toolbar');
$toolbar->appendButton( 'Popup', 'print', 'Печать', JUri::base().'index.php?option=com_bookpro&view=pmibustrips&tmpl=component&layout=report','600px', '800px' );
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
	
	//if(pressbutton=='pmibustrips.print'){
		//$link="index.php?option=com_bookpro&controller=pmibustrips&task=exportpdf&depart_date="+depart_date+"&router_id="+router_id+"&agent_id="+agent_id+"&children="+children+"&tmpl=component";
		//window.open($link);
	//}
	if(pressbutton=='pmibustrips.printticket'){

		if (document.adminForm.boxchecked.value==0){
			alert('Пожалуйста отметьте билеты галочками');
			}
		else{ 
			Joomla.submitform('pmibustrips.printticket')
			return true;
			
			}

	}

		

	
}


 jQuery(document).ready(function($) {
	 
	 $("a#ok").click(function(){
			var depart_date	=jQuery('#depart_date').val();
			var router_id	=jQuery('#filter_route_id').val();
			var agent_id	=jQuery('#filter_agent_id').val();
			var children	=jQuery('#filter_children').val();
			var pay_status	=jQuery('#filter_pay_status').val();

	
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

						$("#filter_route_id").html(result);

						var router_id	=jQuery('#filter_route_id').val();

						$("#filter_route_id").html($("#filter_route_id option").sort(function (a, b) {
							return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
						}))

						$("#filter_route_id").val(router_id);
						//$('#filter_route_id option[value="1280"]').prop('selected', true);
						//$('#filter_route_id option[value="1280"]').attr("selected","selected");

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

						$("#filter_route_id").html(result);

						var router_id	=jQuery('#filter_route_id').val();

						$("#filter_route_id").html($("#filter_route_id option").sort(function (a, b) {
							return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
						}))

						$("#filter_route_id").val(router_id);
						//$('#filter_route_id option[value="1280"]').prop('selected', true);
						//$('#filter_route_id option[value="1280"]').attr("selected","selected");

					}
				});
		});



	
	
});

</script>

<!--

<script type="text/javascript">

jQuery(document).ready(function($) {

$('.cancel_order').change(function () {
	alert('changed');
	var id = $(this).attr('order_id');
	var value = 'active';
	if($(this).prop("checked") == true){
	   value = 'cancelled';
	}
	$.ajax({
		url: "index.php?option=com_bookpro&controller=pmibustrips&task=CancelOrder",
		type: 'POST',
		data: 'status_value='+value+'&order_id='+id,
	});
 });

});

</script>

<script type="text/javascript">

jQuery(document).ready(function($) {

	var old_value;

	$(".cancel_order").on("click", function() {

		var id = $(this).attr('order_id');
		var value = 'active';
		if($(this).prop("checked") == true){
		   value = 'cancelled';
		}

		old_value = $(this).val();
		
		var confirmation = window.confirm('<?php echo JText::_('ARE_YOU_SURE');?>');
		if( confirmation == true ){

			$.ajax({
				url: "index.php?option=com_bookpro&controller=pmibustrips&task=CancelOrder",
				type: 'POST',
				data: 'status_value='+value+'&order_id='+id,
			});
		}
		else{
		        $(this).val(old_value);
			return false;
		}
	});

});

</script>

-->

<script type="text/javascript">

jQuery(document).ready(function($) {

	var old_value;

	$(".cancel_order").on("click", function() {

		var passenger = $(this).attr('cancel_array_passenger');
		var route = $(this).attr('cancel_array_route');
		var value = 'active';
		if($(this).prop("checked") == true){
		   value = 'cancelled';
		}

		old_value = $(this).val();
		
		var confirmation = window.confirm('<?php echo JText::_('ARE_YOU_SURE');?>');
		if( confirmation == true ){

			$.ajax({
				url: "index.php?option=com_bookpro&controller=pmibustrips&task=CancelOrder",
				type: 'POST',
				data: 'status_value='+value+'&passenger='+passenger+'&route='+route,
			});
		}
		else{
		        $(this).val(old_value);
			return false;
		}
	});

});

</script>

<style>

	.cancel_switch {
	position: relative;
	display: inline-block;
	width: 60px;
	height: 34px;
	}
	
	.cancel_switch input{
	display:none;
	}
	
	.cancel_slider{
	position: absolute;
	cursor: pointer;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background-color: #ccc;
	-webkit-transition: .4s;
	transition: .4s;
	}
	
	.cancel_slider:before{
	position: absolute;
	content: "";
	height: 26px;
	width: 26px;
	left: 4px;
	bottom: 4px;
	background-color: white;
	-webkit-transition: .4s;
	transition: .4s;
	}
	
	input:checked + .cancel_slider{
	background-color: #2196F3;
	}
	
	input:focus + .cancel_slider{
	box-shadow: 0 0 1px #2196F3;
	}
	
	input:checked + .cancel_slider:before{
	-webkit-transform: translateX(26px);
	-ms-transform: translateX(26px);
	transform: translateX(26px);
	}
	
	.cancel_slider.round{
	border-radius: 34px;
	}
	
	.cancel_slider.round:before{
	border-radius: 50%;
	}

</style>

<div class="container">
<form action="index.php?option=com_bookpro&view=pmibustrips" method="post" name="adminForm" id="adminForm">
	
	<div class="well well-small">
				<div class="row-fluid">
				<div class="form-inline">
				<?php echo $this->agentbox;?>
				<select name="filter_route_id" id="filter_route_id" class="input-xlarge">
				<option value="0"><?php echo JText::_('COM_BOOKPRO_SELECT_ROUTE') ?></option>
				</select>
				<label><?php echo JText::_('COM_BOOKPRO_DEPART_DATE')?></label>
				<?php
				if ($this->state->get('filter.depart_date')){
					$date = DateHelper::createFromFormat($this->state->get('filter.depart_date'))->format('d-m-Y');
				}
				else{
					$date = $this->state->get('filter.depart_date');
				}
				echo JHtml::calendar($date, 'filter_depart_date', 'depart_date',DateHelper::getConvertDateFormat('M'),'style="width:80px;"') ?>
				
					<?php 
										
					$item[]=JHtmlSelect::option('1',JText::_('COM_BOOKPRO_ALL_SEGMENT'));
					$item[]=JHtmlSelect::option('0',JText::_('COM_BOOKPRO_SINGLE_SEGMENT'));
					echo JHtmlSelect::genericlist($item, 'filter_children',$attribs = 'class="input-medium"', $optKey = 'value', $optText = 'text', $selected = $segment);
					
					?>
					<button onclick="this.form.submit();" class="btn btn-success"><?php echo JText::_('COM_BOOKPRO_SEARCH'); ?></button>
					<a id="ok" class="btn btn-info" >
						Схема мест
					</a>
				</div>
		 	
				
					
	
				</div>
	</div>
		
	<br/>
		<div> 
			<?php echo JText::sprintf('COM_BOOKPRO_TOTAL_PASSENGERS_TXT',count($this->items));?>
		</div>	
	<br/>
	<div class="row-fluid">
		
		<table class="table table-striped" >
			<thead>
				
				
				<tr>
					<th width="3%">#</th>
					<th width="1%"><input type="checkbox" name="checkall-toggle"
						value="" title="(<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>"
						onclick="Joomla.checkAll(this)" />
					</th>
					<th class="title">
				        <?php echo JText::_('COM_BOOKPRO_PASSENGER_FIRSTNAME'); ?>
					</th>
					<th width="10%">
				        <?php echo JText::_('COM_BOOKPRO_PASSENGER_LASTNAME'); ?>
					</th>
					
					<?php if($params->get('ps_gender')){?>
					<th class="title">
				        <?php echo JText::_('COM_BOOKPRO_PASSENGER_GENDER') ?>
					</th>
					<?php } ?>
					<?php if($params->get('ps_birthday')){?>
					<th width="10%">
				        <?php echo JText::_('COM_BOOKPRO_PASSENGER_BIRTHDAY'); ?>
					</th>
					<?php } ?>
					
					<?php if($params->get('ps_passport')){?>
					<th width="10%">
				        <?php echo JText::_('COM_BOOKPRO_PASSENGER_PASSPORT'); ?>
					</th>
					<?php } ?>
					
					
					<th width="10%">
				        <?php echo JText::_('COM_BOOKPRO_PASSENGER_GROUP'); ?>
					</th>
					
					<!-- 
					<th><?php echo JText::_('COM_BOOKPRO_PASSENGER_PRICE')?>
					</th>
					 -->
					<th><?php echo JText::_('COM_BOOKPRO_DEPART_DATE')?>
					</th>
					<td>
						<?php echo JText::_('COM_BOOKPRO_ORDER_NUMBER')?>
					</td>
					<td>
						<?php echo JText::_('COM_BOOKPRO_SEAT')?>
					</td>
					<td>
						<?php echo JText::_('COM_BOOKPRO_BOARDING')?>
					</td>
					<td>
						<?php echo JText::_('COM_BOOKPRO_DROPPING')?>
					</td>
				</tr>
			</thead>
		
			<tbody>
				<?php if (! is_array($this->items)) { ?>
					<tr><td colspan="10" class="emptyListInfo"><?php echo JText::_('No items found.'); ?></td></tr>
				<?php 
				
					} else {
												
						 for ($i = 0; $i < $itemsCount; $i++) { 
				    	 	$subject = &$this->items[$i]; 
				    	 	$checked = JHTML::_('grid.id', $i, $subject->id);
				    	 	$edit = 'index.php?option=com_bookpro&view=passenger&task=passenger.edit&id='.$subject->id;
							
							$orderModel = new BookProModelOrder ();
        				    $order = $orderModel->getComplexItem ( $subject->order_id);
        					//var_dump($subject);
        					for($jj = 0; $jj < count($order->bustrips); $jj++) {
        					    if ($order->bustrips[$jj]->code==$subject->tripcode){
        					        $bustripfrom=$order->bustrips[$jj]->from_name;
        					        $bustripto=$order->bustrips[$jj]->to_name;
        					    }
        					}
							//var_dump($subject);

echo "<pre>";print_r($subject);echo "</pre>";

					?>
				    	<tr>
				    		<td  style="text-align: left; white-space: nowrap;"><?php echo number_format($this->pagination->getRowOffset($i), 0, '', ' '); ?></td>
				    		<td><?php echo $checked;  ?></td>
				    		
				    		<td>
				    			<a href="<?php echo $edit; ?>">
				    			<?php echo $subject->firstname; ?>
				    			</a>
							</td>
							<td>
					    		<?php  echo $subject->lastname.'</br>'.$subject->mobile;?>
				    		</td>
				    			<?php if($params->get('ps_gender')){?>
				    		<td><?php echo BookProHelper::formatGender($subject->gender) ?></td>
							<?php }?>
							<?php if($params->get('ps_birthday')){?>
				    		<td>
					    		<?php 	echo DateHelper::toShortDate($subject->birthday);?>
					    		
				    		</td>
				    		<?php } ?>
				    		
				    		<?php if($params->get('ps_passport')){?>
				    		<td>
					    		<?php 
								echo $subject->passport; ?>
					    		
				    		</td>
				    		<?php } ?>
				    		
				    		<td>
				    			<?php echo $subject->group_title;?>
				    		</td>
				    		
				    
				    		<td>
				    			<?php echo DateHelper::toShortDate($subject->start_date); ?>
				    		</td>
				    		<td>
								<a href="<?php echo JUri::base()?>index.php?option=com_bookpro&view=order&id=<?php echo $subject->order_id ?>">
									<?php echo $subject->order_number; ?>
								</a>
							</td>
							
							<td>
				    			<?php echo $subject->pseat ?>
				    		</td>
							
						<td>
							<?php 
							    echo $bustripfrom;
								if (isset($subject->boarding)){

									echo JText::sprintf('COM_BOOKPRO_BOARDING_TXT',$subject->boarding->location,$subject->boarding->depart);
								}
							?>
						</td>

						<td>
							<?php 
							    echo $bustripto;
							if (isset($subject->dropping)){

									echo JText::sprintf('COM_BOOKPRO_DROPPING_TXT',$subject->dropping->location,$subject->dropping->depart);
								}
							?>
						</td>

<?php

$cancel_array_passenger[$i]=$subject->id;

$db = JFactory::getDbo ();
$query0 = $db->getQuery(true);
$query0->select('id,parent_id');
$query0->from('#__bookpro_bustrip');
$query0->where('id = '.$subject->route_id);
$db->setQuery($query0);
$parent_route = $db->loadObject();

if($route_id == $parent_route->parent_id)
{
	$cancel_array_route[$i]="onward";

	if( ($i==0) && ($subject->route_cancelled == 0) ) $check_value = 1;
	else if( ($i==0) && ($subject->route_cancelled == 1) ) $check_value = 0;
}
else
{
	$cancel_array_route[$i]="return";

	if( ($i==0) && ($subject->return_route_cancelled == 0) ) $check_value = 1;
	else if( ($i==0) && ($subject->return_route_cancelled == 1) ) $check_value = 0;
}

?>

<!--
							<label class="cancel_switch">
								<input order_id=<?php echo $subject->id; ?> class="cancel_order" name="cancel_order" type="checkbox" <?php if($subject->route_cancelled == 0) echo "checked" ; ?>>
								<span class="cancel_slider round"></span>
							</label>
-->
				    	</tr>
				    <?php 
				    	}
					} 
					?>
			</tbody>
		</table>

		<?php

		$cancel_array_passenger = implode("_",$cancel_array_passenger);
		$cancel_array_route = implode("_",$cancel_array_route);

echo "<pre>";print_r($cancel_array_passenger);echo "</pre>";

		?>

		<span>Активность рейса</span>
		<label class="cancel_switch">
			<input cancel_array_passenger=<?php echo $cancel_array_passenger; ?> cancel_array_route=<?php echo $cancel_array_route; ?> class="cancel_order" name="cancel_order" type="checkbox" <?php if($check_value == 1) echo "checked" ; ?>>
			<span class="cancel_slider round"></span>
		</label>

		</div>
	<?php echo $this->pagination->getLimitBox(); ?>
	<?php echo $this->pagination->getListFooter(); ?>	
	<input type="hidden" name="option" value="com_bookpro"/>
	<input type="hidden" name="task"	value="" />
	<input type="hidden" name="boxchecked" value="0"> 
	<?php echo JHTML::_('form.token'); ?>
</form>	
<div>

</div>
</div>


