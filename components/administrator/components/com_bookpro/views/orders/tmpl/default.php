 <?php
 /**
  * @package 	Bookpro
  * @author 		Ngo Van Quan
  * @link 		http://joombooking.com
  * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
  * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
  * @version 	$Id: bookpro.php 27 2012-07-08 17:15:11Z quannv $
  **/
 defined('_JEXEC') or die('Restricted access');
AImporter::helper('currency','paystatus','bus');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');

JHTML::_('behavior.framework');
JHtml::_('behavior.modal');

BookProHelper::setSubmenu(1);

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));

$itemsCount = count($this->items);
$pagination = &$this->pagination;
AImporter::helper('date');

	?>
<style>
	.PAY_REFUND{color: purple !important;}
	.PAY_SUCCESS{color:green !important;}
	.PAY_PENDING{color: red !important;}
	
	.ORDER_CONFIRMED{color: green !important;}
	.ORDER_CANCELLED{color: red !important;}
	.ORDER_PENDING{color: purple !important;}
	
 
	 
</style>
<script type="text/javascript">
	jQuery(document).ready(function($) {

		 var olddata;
	    $(".td_paystatus").on('focus', function () {
	       olddata = $(this).val();
	      oldID=jQuery(this).attr('id');
	      /// alert(olddata+'aaaaaaaa');
	      
	    }).change(function(){		
			var value=$(this).val();
			var classValuechange= $(this).find('option:selected').attr('class');
			//get name or id of a control		
			var id= $(this).attr('id').substring(9);
			var id_all= $(this).attr('id');
			
			//Ask user for continue
			var result1 = window.confirm('<?php echo JText::_('ARE_YOU_SURE');?>');
			
			if ( result1 == true ){
				jQuery.ajax({
					type: 'POST',
					url: "index.php?option=com_bookpro&controller=order&task=changePayStatus",
					data: 'paystatus='+value+'&paystatus_id='+id,
					dataType: 'json',
					success : function(result) {

						if(result){		
						 	oldID='#'+oldID;
							  $(oldID).removeClass($(oldID).attr('class'))
					           .addClass("td_paystatus input-small "+classValuechange); 
							 
							
						}else {
							
														
							   $('#'+id_all+' option').each(function()
									{
									 if($(this).val() == olddata )
									 {
									  $(this).attr("selected","selected");
									  }
									});
								}
						
							      
					  },
 
					 
					 
				});
			}
			else{
				this.form.submit();
			}
		});
	});
</script>


<script type="text/javascript">
	jQuery(document).ready(function($) {

		 var olddata;
		    $(".td_orderstatus").on('focus', function () {
		       olddata = $(this).val();
		       oldID=jQuery(this).attr('id');
		     
		   
		     
		      
		    }).change(function(){		
			var value=$(this).val();
			var classValuechange= $(this).find('option:selected').attr('class');
			 
			//get name or id of a control		
			var id= $(this).attr('id').substring(6);
			var id_all= $(this).attr('id');
			
			
			//Ask user for continue
			var result1 = window.confirm('<?php echo JText::_('ARE_YOU_SURE');?>');
			
			if ( result1 == true ){
				jQuery.ajax({
					type: 'POST',
					url: "index.php?option=com_bookpro&controller=order&task=changeOrderstatus",
					
					data: 'orderstatus='+value+'&orderstatus_id='+id,
				 
					dataType: 'json',
					success : function(result) {
						if(result){
							oldID='#'+oldID;
							  $(oldID).removeClass($(oldID).attr('class'))
					           .addClass("td_paystatus input-small "+classValuechange); 
								 
							
							 
						}else {
						 
														
							   $('#'+id_all+' option').each(function()
									{
									 if($(this).val() == olddata )
									 {
									  $(this).attr("selected","selected");
									  }
									});
								}	      
					  },
					 
					 
				});
			}
			else{
				this.form.submit();
			}
		});
	});
</script>

<script type="text/javascript">
	jQuery(document).ready(function($) {
	$("select.td_paystatus option[value='REFUND']").addClass('PAY_REFUND');
	$("select.td_paystatus option[value='SUCCESS']").addClass('PAY_SUCCESS');
	$("select.td_paystatus option[value='PENDING']").addClass('PAY_PENDING');
	$("select.td_paystatus").each(function(){
 		//classOption=$(this+ "option").each(function(){
 		id = $(this).attr('id')
 		$("#"+id+' option').each(function(){
 			if($(this).is(':selected')){
 				classOption = $(this).attr('class');
 				jQuery("#"+id).addClass(classOption);			
 					return false;		
	 			}  
	  });
}); 
});
 

</script>	

<script type="text/javascript">
	jQuery(document).ready(function($) {
	$("select.td_orderstatus option[value='CONFIRMED']").addClass('ORDER_CONFIRMED');
	$("select.td_orderstatus option[value='CANCELLED']").addClass('ORDER_CANCELLED');
	$("select.td_orderstatus option[value='PENDING']").addClass('ORDER_PENDING');
	$("select.td_orderstatus").each(function(){
		 		//classOption=$(this+ "option").each(function(){
		 		id = $(this).attr('id')
		 		$("#"+id+' option').each(function(){
		 			if($(this).is(':selected')){
		 				classOption = $(this).attr('class');
		 				jQuery("#"+id).addClass(classOption);			
		 					return false;		
			 			}  
			  });
		}); 
	});

</script>	


<div class="span10">
	<form action="<?php echo JRoute::_('index.php?option=com_bookpro&view=orders');?>" method="post" name="adminForm" id="adminForm">
		<div class="j-main-container" style="border: 1px solid #ccc;">
				<div class="well well-small">
		<div class="form-inline">
			<?php echo JHtmlSelect::booleanlist('filter_date_type','class="btn-group"',$this->state->get('filter.date_type'),'Дата бронирования','Дата отправления')?>
			<!--?php echo $this->ranges ?-->
			<?php
			if ($this->state->get('filter.from_date')){
				$from_date = DateHelper::createFromFormat($this->state->get('filter.from_date'))->format('d-m-Y');
			}else{
				$from_date = $this->state->get('filter.from_date');
			}
			if ($this->state->get('filter.to_date')){
				$to_date = DateHelper::createFromFormat($this->state->get('filter.to_date'))->format('d-m-Y');
			}else{
				$to_date = $this->state->get('filter.to_date');
			}
			
			echo JHtml::calendar($from_date, 'filter_from_date','filter_from_date',DateHelper::getConvertDateFormat('M'),'placeholder="От" style="width: 100px;"') ?>
			<?php echo JHtml::calendar($to_date, 'filter_to_date','filter_to_date',DateHelper::getConvertDateFormat('M'),'placeholder="До" style="width: 100px;"') ?>
			
			
			
			<span>
				<?php echo $this->agents ?>
			</span>
			<span id="filter_user_id_return">
			
			</span>
			<span>
				<?php echo $this->orderstatus ?>
			</span>
			<span>
				<?php echo $this->paystatus ?>
			</span>
					<button onclick="this.form.submit();" class="btn btn-success">
						<?php echo JText::_('COM_BOOKPRO_SEARCH'); ?>
					</button>
				
			</div>
		
	</fieldset>			
</div>
<div class="clearfix"></div>

		<table class="table-striped table">
			<thead>
		<tr>
			
			<th width="2%"><input type="checkbox" class="inputCheckbox"
				name="toggle" value=""
				onclick="Joomla.checkAll(this);" /></th>
			<th><?php echo JText::_("COM_BOOKPRO_ORDER_NUMBER"); ?></th>
			<th><?php echo JHTML::_('grid.sort',JText::_("COM_BOOKPRO_BUSTRIP"), 'total', $listDirn, $listOrder); ?></th>
			<th><?php echo JHTML::_('grid.sort',JText::_("COM_BOOKPRO_DEPART_DATE"), 'depart', $listDirn, $listOrder); ?></th>
			<th><?php echo JHTML::_('grid.sort',JText::_("COM_BOOKPRO_CUSTOMER"), 'firstname', $listDirn, $listOrder); ?></th>
			<th><?php echo JHTML::_('grid.sort',JText::_("COM_BOOKPRO_ORDER_TOTAL"), 'total', $listDirn, $listOrder); ?></th>
			<th><?php echo JHTML::_('grid.sort',JText::_("COM_BOOKPRO_ORDER_PAY_STATUS"), 'pay_status', $listDirn, $listOrder); ?></th>
			<th>
				<?php echo JHTML::_('grid.sort',JText::_("COM_BOOKPRO_ORDER_STATUS"), 'order_status', $listDirn, $listOrder); ?>
			</th>
			<th><?php echo JHTML::_('grid.sort',JText::_("COM_BOOKPRO_ORDER_CREATED"), 'created', $listDirn, $listOrder); ?>
			</th>
		</tr>
	</thead>
			<tfoot>
				<tr>
					<td colspan="13"><?php echo $pagination->getListFooter(); ?></td>
				</tr>
			</tfoot>
			<tbody>
	<?php if ($itemsCount == 0) { ?>
		<tr>
					<td colspan="13" class="emptyListInfo"><?php echo JText::_('Нет бронирований.'); ?></td>
				</tr>
		<?php } ?>
		<?php for ($i = 0; $i < $itemsCount; $i++)		{ 
//echo ("itemcount=".$itemsCount);
		$subject = &$this->items[$i]; 		
		$orderlink= BookProHelper::getOrderLink($subject->order_number, $subject->email);
		
		?>

		<tr class="row<?php echo $i % 2; ?>">
			<td class="checkboxCell"><?php echo JHTML::_('grid.checkedout', $subject, $i); ?></td>
			
			<td>
				<a href="<?php echo JUri::base().'index.php?option=com_bookpro&view=order&layout=edit&id='.$subject->id; ?>"><?php echo $subject->order_number; ?></a>
				<span>
			     <a href="<?php echo $orderlink ?>" target="_blank"><icon class="icon-print"></icon></a>
					</span>
			</td>
					<td>
					
					<?php 	
					
					//echo "<pre>";print_r(json_decode($subject->params,true));die;
					echo BusHelper::getRouteFromParams((json_decode($subject->params,true)));
					
					
					?>
					</td>
					<td><?php echo DateHelper::toShortDate($subject->depart); /*var_dump($subject);*/ ?></td>
					<td><a
						href="<?php echo JRoute::_('index.php?option=com_bookpro&task=customer.edit&id='.(int) $subject->user_id); ?>"><?php echo $subject->firstname; ?></a></td>
					
					<td><?php echo CurrencyHelper::formatprice($subject->total)?>
					<br/>
					<?php echo $subject->pay_method; ?></td>
					<td>
			 	<?php  echo $this->td_getPayStatusSelect($subject->pay_status,'tdpayment'.$subject->id);?>
			</td>
					<td>
				<?php  echo $this->td_getOrderStatusSelect($subject->order_status,'status'.$subject->id);?>
			</td>

			<td><?php echo DateHelper::toShortDate($subject->created) ?></td>



				</tr>
		<?php } ?>
	</tbody>
		</table>

		 <input	type="hidden" name="task" value="" /> 
	  
	<input type="hidden" name="boxchecked" value="0" /> 
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	 <?php echo JHTML::_('form.token'); ?>
</form>

</div>
