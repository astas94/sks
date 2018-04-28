<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: passenger.php 26 2012-07-08 16:07:54Z quannv $
 **/
defined('_JEXEC') or die('Restricted access');

class RefundHelper{
	

	static function refundPrice($orderinfo, $order) {
	
		$now = new JDate ( JHtml::date ( 'now', 'd-m-Y H:i:s' ) );
		$start = new JDate ( $orderinfo->depart_date );
	
		$days = $start->diff ( $now );
		$hour = $days->days * 24 + $days->h;
		if (RefundHelper::getCheckRefund ( $hour )) {
			$refund = RefundHelper::getRefundHour ( $hour );
				
			$price = $order->total - $order->total * $refund->amount / 100;
		} else {
			$price = 0;
		}
		
		return $price;
	}
	static function refundAmount($orderinfo,$order){
		$now = new JDate ( JHtml::date ( 'now', 'd-m-Y H:i:s' ) );
		$start = new JDate ( $orderinfo->depart_date );
		
		$days = $start->diff ( $now );
		$hour = $days->days * 24 + $days->h;
		
		if (RefundHelper::getCheckRefund ( $hour )) {
			$refund = RefundHelper::getRefundHour ( $hour );
			$amount = $refund->amount."%";
			
			
		} else {
			$amount = "";
		}
		
		return $amount;
	}
	static function getMinRefund($hour = 0) {
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select ( 'MIN(refund.number_hour)' );
		$query->from ( '#__bookpro_refund AS refund' );
		$query->state ( 'refund.state = 1' );
		if ($hour) {
			$query->where ( 'refund.number_hour >' . $hour );
		}
		$db->setQuery ( $query );
		$min = $db->loadResult ();
		if ($min) {
			return $min;
		} else {
			return 0;
		}
	}
	
	static function getMaxRefund($hour = 0) {
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select ( 'MAX(refund.number_hour)' );
		$query->from ( '#__bookpro_refund AS refund' );
		$query->where ( 'refund.state = 1' );
		if ($hour) {
			$query->where ( 'refund.number_hour <=' . $hour );
		}
		$db->setQuery ( $query );
		$max = $db->loadResult ();
		if ($max) {
			return $max;
		} else {
			return 0;
		}
	}
	static function getRangeRefund($hour) {
		$max = RefundHelper::getMaxRefund ();
		$min = RefundHelper::getMinRefund ();
	
		if ($hour >= $max) {
			return $max;
		} elseif ($hour <= $min) {
			return $min;
		} else {
			$preRange = RefundHelper::getMaxRefund ( $hour );
			return $preRange;
		}
	}
	
	static function getRefundHour($hour) {
		$number_hour = RefundHelper::getRangeRefund ( $hour );
	
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select ( 'refund.*' );
		$query->from ( '#__bookpro_refund AS refund' );
		$query->where ( 'refund.number_hour =' . $number_hour );
	
		$db->setQuery ( $query );
		$refund = $db->loadObject ();
		if (!$refund){
			$refund = new JObject();
			$refund->amount = 0;
		}
		return $refund;
	}
	static function getCheckCancel($order_id){
		AImporter::model('order');
		AImporter::helper('orderstatus');
		OrderStatus::init();
		$now = JFactory::getDate('now')->format('Y-m-d');
		$model = new BookProModelOrder();
		$order = $model->getItem($order_id);
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('count(pass.id)');
		$query->from('#__bookpro_passenger AS pass');
		$query->join('LEFT', '#__bookpro_orders AS `order` ON pass.order_id = `order`.id');
		
		$query->where('DATE_FORMAT(pass.start,"%Y-%m-%d") > '.$db->quote($now));
		$query->where('`order`.`order_status`= '.$db->quote(OrderStatus::$CONFIRMED->getValue()));
		$query->where('pass.order_id='.$order_id);
		$db->setQuery($query);
		$result = $db->loadResult();
		return $result;
	}
	static function getCheckRefund($hour) {
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select ( 'refund.*' );
		$query->from ( '#__bookpro_refund AS refund' );
		// $query->where('refund.number_hour <'.$hour);
		$query->order ( 'refund.number_hour ASC' );
		$db->setQuery ( $query );
		$refund = $db->loadObject ();
		if (!$refund){
			$refund = new JObject();
			$refund->number_hour = 0;
		}
	
		if ($hour <= $refund->number_hour) {
			return false;
		} else {
			return true;
		}
	}
}