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
class OrderStatus {

	static $FINISHED = null;
	static $CONFIRMED = null;
	static $PENDING = null;
	static $CANCELLED = null;
	static $NEW = null;
	static $CANCELLED_L_B_D = null;
	static $CANCELLED_B_D = null;
	static $CANCELLED_A_D = null;

	public $value = null;

	public static $map;
	private $key=null;
	public $text=null;

	public function __construct($value) {
		$this->value = $value;
		
		$this->text= JText::_('COM_BOOKPRO_ORDER_STATUS_'.strtoupper($this->value));
	}

	public static function init () {
		self::$FINISHED  = new OrderStatus("FINISHED");
		self::$PENDING  = new OrderStatus("PENDING");
		self::$CANCELLED = new OrderStatus("CANCELLED");
		self::$NEW = new OrderStatus("NEW");
		self::$CONFIRMED = new OrderStatus("CONFIRMED");
		self::$CANCELLED_L_B_D = new OrderStatus("CANCELLED_L_B_D");
		self::$CANCELLED_B_D = new OrderStatus("CANCELLED_B_D");
		self::$CANCELLED_A_D = new OrderStatus("CANCELLED_A_D");
		
		//static map to get object by name - example Enum::get("INIT") - returns Enum::$INIT object;
		self::$map = array (self::$PENDING,self::$CANCELLED,self::$CONFIRMED,self::$CANCELLED_L_B_D,self::$CANCELLED_B_D,self::$CANCELLED_A_D);
	}
	static function format($status){
		return JText::_('COM_BOOKPRO_ORDER_STATUS_'.strtoupper($status));
	}
	public function getText() {
		return JText::_('COM_BOOKPRO_ORDER_STATUS_'.strtoupper($this->value));
	}

	public static function get($element) {
		if($element == null)
			return null;
		return self::$map[$element];
	}

	public function getValue() {
		return $this->value;
	}
	
	public function __getKey() {
		return $this->value;
	}

	public function __setKey($key){
		$this->key=$key;
	}
	
	public function equals(OrderStatus $element) {
		return $element->getValue() == $this->getValue();
	}

	public function __toString () {
		return $this->value;
	}
}