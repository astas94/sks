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
class PayStatus {

	static $PENDING = null;
	static $SUCCESS = null;
	static $DEPOSIT = null;
	static $REFUND = null;

	public $value = null;

	public static $map;
	private $key=null;
	public $text=null;

	public function __construct($value) {
		$this->value = $value;
		$this->text= JText::_('COM_BOOKPRO_PAYMENT_STATUS_'.strtoupper($this->value));
	}
	static function format($status){
		return JText::_('COM_BOOKPRO_PAYMENT_STATUS_'.strtoupper($status));
	}
	public function getText() {
		return JText::_('COM_BOOKPRO_PAYMENT_STATUS_'.strtoupper($this->value));
	}

	public static function init () {
		self::$PENDING  = new PayStatus("PENDING");
		self::$SUCCESS = new PayStatus("SUCCESS");
		self::$REFUND = new PayStatus('REFUND');
		self::$map = array (self::$PENDING,self::$SUCCESS,self::$REFUND);
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
	public function __getText() {
		return $this->value;
	}
	public function __setKey($key){
		$this->key=$key;
	}
	
	public function equals(PayStatus $element) {
		return $element->getValue() == $this->getValue();
	}

	public function __toString () {
		return $this->value;
	}
}