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
AImporter::helper('bookpro');
$order = $displayData;
?>

				
<h2>
	<?php echo JText::_('COM_BOOKPRO_ORDER_SUMARY'); ?>
</h2>
<table class="table table-bordered">
		<tr>
				<th align="left"><?php echo JText::_('COM_BOOKPRO_ORDER_NUMBER'); ?>:
			</th>
			<td><label class="label label-info"><?php echo $order->order_number; ?></label></td>
		</tr>
		<tr>
			<th align="left"><?php echo JText::_('COM_BOOKPRO_CUSTOMER_NAME'); ?>:
			</th>
			<td><?php echo $order->firstname; ?></td>
		</tr>
		<tr>
			<th align="left"><?php echo JText::_('COM_BOOKPRO_CUSTOMER_EMAIL'); ?>:
			</th>
			<td><?php echo $order->email	?></td>
		</tr>
		<tr>
			<th align="left"><?php echo JText::_('COM_BOOKPRO_CUSTOMER_PHONE'); ?>:
			</th>
			<td><?php   echo $order->mobile;
						?></td>
		</tr>
		<tr>
			<th align="left"><?php echo JText::_('COM_BOOKPRO_ORDER_NOTE'); ?>:
			</th>
			<td><?php   echo $order->notes;
						?></td>
		</tr>
		<tr>
			<th align="left"><?php echo JText::_('COM_BOOKPRO_ORDER_PAYMENT_STATUS'); ?>:
			</th>
			<td>
			
			<?php 
			echo BookProHelper::displayPaymentStatus($order->pay_status);
			?>
			
			</td>
		</tr>
		<tr>
			<th align="left"><?php echo JText::_('COM_BOOKPRO_ORDER_TOTAL'); ?>:
			</th>
			<td><?php echo CurrencyHelper::formatPrice($order->total); ?></td>
		</tr>
		<tr>
			<th align="left"><?php echo JText::_('COM_BOOKPRO_ORDER_ORDER_TIME'); ?>:
			</th>
			<td><?php echo  JHtml::_('date',$order->created,'d-m-Y H:i:s'); ?></td>
		</tr>
	</table>
	
