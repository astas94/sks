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
$price = $displayData;

$roundtrip=JFactory::getApplication()->getUserState('filter.roundtrip');
if($roundtrip == 0){
	$adult=$price->adult;
	
	$discount = $price->discount;
	$prices[] = '<span>'.JText::sprintf('COM_BOOKPRO_PRICE_ADULT',CurrencyHelper::displayPrice($adult,$discount)).'</span>';
	if ($price->child) {
		$prices[] = '<span>'.JText::sprintf('COM_BOOKPRO_PRICE_CHILD',CurrencyHelper::formatprice($price->child)).'</span>';
	}
	/*if ($price->infant) {
		$prices[] = '<span>'.JText::sprintf('COM_BOOKPRO_PRICE_INFANT',CurrencyHelper::formatprice($price->infant)).'</span>';
	}*/
}else{
	$adult=$price->adult;
	
	$discount = $price->discount;
	$prices[] = '<span>'.JText::sprintf('COM_BOOKPRO_PRICE_ADULT',CurrencyHelper::displayPrice($adult,$discount)).'</span>';
	if ($price->child) {
		$prices[] = '<span>'.JText::sprintf('COM_BOOKPRO_PRICE_CHILD',CurrencyHelper::formatprice($price->child)).'</span>';
	}
	
	
	//$discount = $price->discount;
	//$prices[] = '<span>'.JText::sprintf('COM_BOOKPRO_PRICE_ADULT',CurrencyHelper::formatprice($price->adult_roundtrip)).'</span>';
	//if ($price->child_roundtrip) {
	//	$prices[] ='<span>'.JText::sprintf('COM_BOOKPRO_PRICE_CHILD',CurrencyHelper::formatprice($price->child_roundtrip)).'</span>';
	//}
	/*if ($price->infant_roundtrip) {
		$prices[] = '<span>'.JText::sprintf('COM_BOOKPRO_PRICE_INFANT',CurrencyHelper::formatprice($price->infant_roundtrip)).'</span>';
	}*/
}
?>
<div class="list_price">
<?php 
echo implode($prices, ",");
?>
</div>
