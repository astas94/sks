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
class BookproCart {
	
	
	var $type_cart ;
	var $customer;
	var $adult;
	var $children;
	var $vat;
	var $total;
	var $subtotal;
	var $order;
	var $orderinfo;
	var $from;
	var $to;
	
	function saveToSession() {
		$session =& JFactory::getSession();
		$session->set($this->type_cart, serialize($this));
	
	}
	function setCustomer($post){
		
		$customer=array();
		if($post['firstname'])
			$customer['firstname']=$post['firstname'];
		if($post['lastname'])
			$customer['lastname']=$post['lastname'];
		if($post['city'])
			$customer['city']=$post['city'];
		if($post['states'])
			$customer['states']=$post['states'];
		if($post['address'])
			$customer['address']=$post['address'];
		if($post['country_id'])
			$customer['country_id']=$post['country_id'];
		if($post['zip'])
			$customer['zip']=$post['zip'];
		if($post['fax'])
			$customer['fax']=$post['fax'];
		if($post['email'])
			$customer['email']=$post['email'];
		if($post['telephone'])
			$customer['telephone']=$post['telephone'];
		if($post['customer_id'])
			$customer['id']=$post['customer_id'];
		$this->customer=$customer;
	}
}
