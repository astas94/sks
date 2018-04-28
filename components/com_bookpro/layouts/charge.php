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
$this->order=$displayData;
$config=JComponentHelper::getParams('com_bookpro');
$discount_site = $config->def('discount_site',0);

?>
<table class="table">
<!--
		<?php if($this->order->subtotal){?>	
		<tr>
		<td>
				<?php echo JText::_('COM_BOOKPRO_SUBTOTAL');?>
		</td>
			<td>
				<?php echo  CurrencyHelper::formatprice($this->order->subtotal); ?>
			</td>
		</tr>
			<?php }?>
			
-->		
		<?php if($discount_site>0){?>	
		<tr>
		<td>
				<?php echo JText::_('Скидка за заказ через сайт')?>
		</td>
			<td>
				<?php echo ($this->order->discount==0)?CurrencyHelper::formatprice(($this->order->subtotal)*($discount_site)/100 ):'использован купон'  ?>
			</td>
		</tr>
			<?php }?>	
			
		<?php if($this->order->tax){?>
		<tr>
		<td>
				<?php echo JText::_('COM_BOOKPRO_ORDER_TAX');?>
		</td>
			<td>
				<?php echo  CurrencyHelper::formatprice($this->order->tax); ?>
			</td>
		</tr>
			<?php }?>	
			
			
	<?php if($this->order->discount>0){?>
		<tr>
		<td>
				<?php echo JText::_('COM_BOOKPRO_TOUR_AGENTDISCOUNT');?>
			</td>
			<td>
				<?php echo $this->order->discount; ?>
			</td>
		</tr>
	<?php }?>
		
		<?php if ($this->order->discount>0){?>
		<!--tr>
		<td>
			<?php echo JText::_('COM_BOOKPRO_ORDER_TOTAL_ORIGINAL')?>
		</td>
		<td>
			<?php echo CurrencyHelper::formatprice($this->order->discount+$this->order->total) ?>
		</td>
		<td>
			<?php echo JText::_('COM_BOOKPRO_ORDER_DISCOUNT')?>
		</td>
		<td>
			<?php echo CurrencyHelper::formatprice($this->order->discount) ?>
		</td>
		</tr>
		<?php } ?>
		<tr-->
<!--
		<td>
			<?php echo JText::_('COM_BOOKPRO_ORDER_TOTAL')?>
		</td>
		<td>
			<?php echo CurrencyHelper::formatprice($this->order->total) ?>
		</td>
		
		</tr>
-->
	</table>