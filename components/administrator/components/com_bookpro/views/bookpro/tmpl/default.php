<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: default.php 66 2012-07-31 23:46:01Z quannv $
 **/
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
BookProHelper::setSubmenu(1);
//JToolBarHelper::title('JB BUS','dashboard');
JToolBarHelper::title('Управление автобусами','dashboard');
JToolBarHelper::preferences('com_bookpro');
$itemsCount = count($this->items);
$pagination = $this->pagination;

?>
<div class="span10">


<div class="row-fuild"> 



<div class="span9">
<fieldset>
<legend>
	<?php echo JText::_('COM_BOOKPRO_BOOKING_TODAY'); ?>
</legend>

<form action="index.php" method="post" name="adminForm" id="adminForm">
  


<table class="table-striped table">
	<thead>
		<tr>
			<th width="1%">#</th>
			<!-- 	
			<th><?php echo JText::_("COM_BOOKPRO_CUSTOMER"); ?>
			
			</th>
			 -->	
			<th><?php echo JText::_("COM_BOOKPRO_ORDER_NUMBER"); ?></th>
			<th><?php echo JText::_("COM_BOOKPRO_ORDER_TOTAL") ?></th>
			<th><?php echo JText::_("COM_BOOKPRO_ORDER_STATUS") ?></th>
			<th><?php echo JText::_("COM_BOOKPRO_ORDER_PAY_STATUS") ?></th>
			<th><?php echo JText::_("COM_BOOKPRO_ORDER_CREATED") ?></th>

		</tr>
	</thead>
	
	<tbody>
	<?php if ($itemsCount == 0) { ?>
		<tr>
			<td colspan="13" class="emptyListInfo"><?php echo JText::_('No booking today.'); ?></td>
		</tr>
		<?php } ?>
		<?php for ($i = 0; $i < $itemsCount; $i++) { ?>
		<?php $subject = &$this->items[$i];

		$orderlink= BookProHelper::getOrderLink($subject->order_number, $subject->email);
		?>
		<tr class="row<?php echo $i % 2; ?>">
			<td style="text-align: right; white-space: nowrap;"><?php echo number_format($pagination->getRowOffset($i), 0, '', ' '); ?></td>
			
			<!-- 
			<td><a href="<?php echo JRoute::_(ARoute::edit(CONTROLLER_CUSTOMER, $subject->user_id)); ?>"><?php echo $subject->firstname.' '.$subject->lastname; ?></a></td>
			 -->
			<td><a href="<?php echo 'index.php?option=com_bookpro&view=order&layout=edit&id='.$subject->id; ?>"><?php echo $subject->order_number; ?></a>
			<span> <a href="<?php echo $orderlink ?>" target="_blank"><icon class="icon-print"></icon></a>
			</span>
			</td>
			<td><?php echo CurrencyHelper::formatprice($subject->total)?></td>
			<td><?php echo  OrderStatus::format($subject->order_status);	?></td>
			<td><?php echo  PayStatus::format($subject->pay_status);	?></td>
			<td><?php echo  DateHelper::toNormalDate($subject->created)	?></td>
		
		</tr>
		<?php } ?>
	</tbody>
</table>
<div style="float:right;">
	<a href='index.php?option=com_bookpro&view=orders'>
		Дополнительно >>
	</a>
</div>
	
</form>
</fieldset>

<div>
<?php 
	AImporter::helper('chart');


	$chart = new ChartHelper(1,'LineChart','height:300,backgroundColor:"#F7F7F7",vAxis: {title: "Итого '.JComponentHelper::getParams('com_bookpro')->get('currency_symbol').'"}');
	
	echo $chart->getRevenueChart('lastmonth');
?>
</div>

</div>



<div class="span3">
<fieldset>
<legend>
	<?php echo JText::_('COM_BOOKPRO_GENERAL_STATISTIC'); ?>
</legend>
	<?php echo $this->loadTemplate('general')?>
	<?php 
	$manifest=new SimpleXMLElement(JPATH_COMPONENT_ADMINISTRATOR.'/manifest.xml',null,true);

?>
<hr>
<h4>Версия: <?php echo $manifest->version ?></h4>
</fieldset>
</div>


</div>
</div>