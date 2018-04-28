<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: flightcart.php  23-06-2012 23:33:14
 **/
defined('_JEXEC') or die('Restricted access');
include_once 'cart.php';
class BookProBusCart extends BookproCart{

	var $type_cart = "buscart"; //cart,wishlist
	var $count_product = 0;
	var $sum = 0;
	var $total=0;
	var $service_fee=0;
	var $tax=0;
	var $orderinfos;
	var $passengers=array();
	var $person = null;
	var $customer;
	var $seat;
	var $return_seat;
	var $boarding;
	var $dropping;
	var $return_boarding;
	var $return_dropping;
	var $stop;
	var $stopdrop;
	var $return_stop;
	var $return_stopdrop;
	var $from;
	var $infant;
	var $to;
	var $start;
	var $end;
	var $roundtrip;
	var $bustrip_id;
	var $return_bustrip_id;
	var $listseat;
	var $returnlistseat;
	var $price;
	var $return_price;
	var $notes;
	var $chargeInfo;
	

	function saveToSession() {
		$session = JFactory::getSession();
		$session->set($this->type_cart, serialize($this));
	}
 
	function load($type_cart = "buscart"){
		$this->type_cart = $type_cart;
		$session = JFactory::getSession();
		$objcart = $session->get($this->type_cart);

		if (isset($objcart) && $objcart!='') {
			$temp_cart = unserialize($objcart);
			$this->sum=$temp_cart->sum;
			$this->service_fee=$temp_cart->service_fee;
			$this->tax=$temp_cart->tax;
			$this->total=$temp_cart->total;
			$this->chargeInfo=$temp_cart->chargeInfo;
			$this->roundtrip=$temp_cart->roundtrip;
			$this->notes=$temp_cart->notes;
			$this->customer=$temp_cart->customer;
			$this->orderinfos=$temp_cart->orderinfos;
			$this->adult=$temp_cart->adult;
			$this->children=$temp_cart->children;
			$this->infant=$temp_cart->infant;
			$this->passengers=$temp_cart->passengers;
			$this->chargeInfo=$temp_cart->chargeInfo;
			$this->person = $temp_cart->person;
			$this->from=$temp_cart->from;
			$this->to=$temp_cart->to;
			$this->start=$temp_cart->start;
			$this->end=$temp_cart->end;
			$this->bustrip_id=$temp_cart->bustrip_id;
			$this->return_bustrip_id=$temp_cart->return_bustrip_id;
			$this->price=$temp_cart->price;
			$this->return_price=$temp_cart->return_price;
			$this->seat = $temp_cart->seat;
			$this->return_seat = $temp_cart->return_seat;
			$this->boarding = $temp_cart->boarding;
			$this->return_boarding = $temp_cart->return_boarding;
			
			$this->dropping = $temp_cart->dropping;
			$this->return_dropping = $temp_cart->return_dropping;
			$this->stop = $temp_cart->stop;
			$this->stopdrop = $temp_cart->stopdrop;
			$this->return_stopdrop = $temp_cart->return_stopdrop;
			$this->listseat=$temp_cart->listseat;
			$this->returnlistseat=$temp_cart->returnlistseat;
			
		}


	}
	function clear(){
		$session = JFactory::getSession();
        $this->products = null;
        $this->passengers = null;
        $this->person = new JObject();
        $this->orderinfo = null;
        $this->customer=null;
        $this->sum = 0;
        $this->no_room = 0;
        $this->notes = "";        
        $this->total = 0; 
        $this->chargeInfo = '';
        $this->adult=0;
        $this->children=0;
        $this->enfant=0;
        $this->seat = '';
        $this->return_seat = '';
	}

}