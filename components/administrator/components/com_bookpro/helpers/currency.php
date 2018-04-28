<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: currency.php 16 2012-06-26 12:45:19Z quannv $
 **/
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
class CurrencyHelper{

	public static function formatprice($value,$config=null){
		$config=JComponentHelper::getParams('com_bookpro');
		$thousand=$config->get('currency_seperator');
		$newval='';
		if ($value) {
			$value = number_format($value, 2, '.',$thousand);
			$length = JString::strlen($value);
			if (JString::substr($value, $length - 2) == '00')
				$newval= JString::substr($value, 0, $length - 3);
			elseif (JString::substr($value, $length - 1) == '0')
			$newval= JString::substr($value, 0, $length - 1);
			else
				$newval=$value;
		}
		$symbol=$config->get('currency_symbol');
		switch ($config->get('currency_display')){
			case 0:
				// 0 = '00Symb'
				$newval=$newval.$symbol;
				break;
			case 2:
				// 2 = 'Symb00'
				$newval=$symbol.$newval;
				break;
			case 3:
				// 3 = 'Symb 00'
				$newval=$symbol.' '.$newval;
				break;
			case 1:
			default :
				// 1 = '00 Symb'
				$newval=$newval.' '.$symbol;
				break;
		}
		return $value?$newval:JText::_('N/A');
	}
	public static function displayPrice($value,$discount=0){
		if($discount > 0){
			return '<span class="old_price">'.CurrencyHelper::formatprice($value).'</span>'.
			'<span class="discount_price">'.CurrencyHelper::formatprice($value-($value*$discount)/100).'</span>';
		}else {
			return CurrencyHelper::formatprice($value);
		} 
	}
}