<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: orders.php 56 2012-07-21 07:53:28Z quannv $
 **/

defined('_JEXEC') or die('Restricted access');

class TableOrders extends JTable
{

	var $id;
	var $order_number;
	var $user_id;
	var $type;
	/**
	 *  Total amount
	 * @var unknown_type
	 */
	var $total;
	var $total_bag;
	var $state;
	var $subtotal;
	/**
	 * Discounted amount
	 * @var unknown_type
	 */
	var $discount;
	var $notes;
	/**
	 * Payment method
	 * @var unknown_type
	 */
	var $pay_method;
	/**
	 * Payment status
	 * @var unknown_type
	 */
	var $pay_status;
	/**
	 * client IP address
	 * @var unknown_type
	 */
	var $ip_address;
	var $tax;
	var $service_fee;
	var $created;
	/**
	 * Deposit amount
	 */
	var $deposit;
	/**
	 * Transaction id from payment gateway
	 * @var string
	 */
	var $tx_id;
	/**
	 * Status of order
	 * @var Constant: CONFIRMED, CANCELED, NEW, NEGOTIATING, FINISHED
	 */
	var $order_status;
	/**
	 * 
	 * @var unknown_type
	 */
	var $coupon_id;
	var $currency_id;


	/**
	 * Construct object.
	 *
	 * @param JDatabaseMySQL $db database connector
	 */
	function __construct(& $db)
	{
		parent::__construct('#__bookpro_orders', 'id', $db);
	}

	/**
	 * Init empty object.
	 */
	function init()
	{
		$this->user_id=0;
		$this->order_number='';
		$this->notes='';
		$this->total = '';
		$this->subtotal = '';
		$this->total_bag = 0;
		$this->state = 1;
		$this->discount=0;
		$this->pay_method='';
		$this->pay_status='';
		$this->ip_address='';
		$this->tax=0;
		$this->service_fee=0;
		$this->tx_id='';
		$this->coupon_id=0;
	}

	function check(){
		if(!$this->id) {
			$date = JFactory::getDate('now');
			$this->created=$date->toSql(true);
			$this->refund_date = JFactory::getDate($this->refund_date)->toSql(true);
			$this->order_number=$this->create_unique_order_id();
			$this->ip_address=$_SERVER[REMOTE_ADDR];
		}
		return true;
	}
	function create_unique_order_id(){
		$params=JcomponentHelper::getParams('com_bookpro');
		
		if ($params->get('orderno_type')) {
			$order = $this->create_sort_order_number();
		}else{
			$order = $this->create_random_order_number();
		}
		
		return $order;	
		
	}
	function create_random_order_number(){
		$order = '';
		$chars = "0123456789";
		srand((double)microtime()*1000000);
		$i = 0;
		while ($i <= 5) {
			$num = rand() % 10;
			$tmp = substr($chars, $num, 1);
			$order = $order . $tmp;
			$i++;
		}
		return $order;
	}
	function create_sort_order_number(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('orders.*');
		$query->from('#__bookpro_orders AS orders');
		$query->order('orders.order_number DESC');
		
		$db->setQuery($query,0,1);
		$orders = $db->loadObjectList();
		
		
		$order_number = '';
		if (count($orders) == 0) {
			$order_number = '000001';
		}else{
			$onumber = $orders[0]->order_number;
			$number = (int) $onumber + 1;
			$length = strlen($number);
			$n = 6 - $length;
			if ($n > 1) {
				$prefix = array();
				for ($i = 1;$i <= $n;$i++){
					$prefix[] = '0';
				}
				$order_number = implode("", $prefix).$number;
			}else{
				$order_number = $number;
			}
			
		}
		return $order_number;
		
	}
}

?>