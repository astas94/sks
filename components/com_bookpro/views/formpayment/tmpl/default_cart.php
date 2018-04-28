<?php 

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: currency.php 16 2012-06-26 12:45:19Z quannv $
 **/
defined('_JEXEC') or die('Restricted access');
AImporter::helper('currency');
$config=JComponentHelper::getParams('com_bookpro');
$discount_site = $config->def('discount_site',0);
//echo($discount_site);
?>
<div class="bpcart">
	<h2 class='block_head'>
		<span><?php echo JText::_("COM_BOOKPRO_CART_SUMMARY")?> </span>
	</h2>

	<dl id="summary">
		
		<?php if ($this->order->discount){?>
		<dt>
			<?php echo JText::_('COM_BOOKPRO_ORDER_TOTAL_ORIGINAL')?>
		</dt>
		<dd>
			<?php echo CurrencyHelper::formatprice($this->order->subtotal ) ?>
		</dd>
		<?php } ?>
		
		<?php if($discount_site>0 ){?>	
		<dt>
			<?php echo JText::_('Скидка за заказ через сайт')?>
		</dt>
		<dd>
			<?php echo ($this->order->discount==0)?CurrencyHelper::formatprice(($this->order->subtotal)*($discount_site)/100 ):'использован купон' ?>
		</dd>
		<?php } ?>
		
		<?php if($this->order->discount){?>	
		<dt>
			<?php echo JText::_('Скидка по купону')?>
		</dt>
		<dd>
			<?php echo CurrencyHelper::formatprice($this->order->discount) ?>
		</dd>
		<?php } ?>
		
		<?php if($this->order->tax){?>	
		<dt>
				<?php echo JText::_('COM_BOOKPRO_ORDER_TAX');?>
		</dt>
			<dd>
				<?php echo  CurrencyHelper::formatprice($this->order->tax); ?>
			</dd>
		
		<?php }?>
		
		<dt>
			<?php echo JText::_('COM_BOOKPRO_ORDER_TOTAL')?>
		</dt>
		<dd>
			<?php echo CurrencyHelper::formatprice($this->order->total) ?>
		</dd>
		<dt>
			<?php echo JText::_('COM_BOOKPRO_COUPON_CODE')?>
		</dt>
		<dd><div class="form-inline">
			<input type="text" value="" class="input-small" name="coupon"> <input type="submit" class="btn"
				value="<?php echo JText::_('COM_BOOKPRO_SUBMIT') ?>" id="couponbt">
				</div>
		</dd>

	</dl>
</div>
