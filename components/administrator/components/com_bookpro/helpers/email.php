<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id$
 **/
defined ( '_JEXEC' ) or die ( 'Restricted access' );
AImporter::model ( 'order', 'application' );
AImporter::helper ( 'currency', 'date','orderstatus','paystatus','bookpro' );
class EmailHelper {
	/**
	 *
	 * @param String $input        	
	 * @param CustomerTable $customer        	
	 */
	var $config;
	var $app;
	var $tempalte = 'default';
	function __construct() {
		
	}
	public function setTemplate($value) {
		$this->tempalte = $value;
	}
	public function sendMail($order_id) {
		AImporter::helper ( 'bus' );
		$orderModel = new BookProModelOrder();
		$applicationModel = new BookProModelApplication ();
		
		$config=JComponentHelper::getParams('com_bookpro');
		
		$order = $orderModel->getComplexItem( $order_id );
		
		$customer = $order->customer;
		$this->app = $applicationModel->getObjectByCode ( $order->type );
		$body_customer = $this->app->email_customer_body;
		
		$body_customer=str_replace ( '{company_name}', $config->get('company_name'), $body_customer );
		
		$body_customer=str_replace ( '{company_logo}', $config->get('company_logo'), $body_customer );
		
		$body_customer=str_replace ( '{company_address}', $config->get('company_address'), $body_customer );
		
		$body_customer = $this->fillCustomer ( $body_customer, $customer );
		$body_customer = $this->fillOrder ( $body_customer, $order );
	
		BookProHelper::sendMail ( $this->app->email_send_from, $this->app->email_send_from_name, $customer->email, $this->app->email_customer_subject, $body_customer, true );
		
		$body_admin = $this->app->email_admin_body;
		$body_admin = $this->fillCustomer ( $body_admin, $customer );
		$body_admin = $this->fillOrder ( $body_admin, $order );
		BookProHelper::sendMail ( $this->app->email_send_from, $this->app->email_send_from_name, $this->app->email_admin, $this->app->email_admin_subject, $body_admin, true );

//изменяем статус пассажира

		$dat_today = date("Y-m-d H:i:s");

		$db = JFactory::getDbo ();

		$query0 = $db->getQuery ( true );
		$query0->select('passenger_status_return');
		$query0->from('#__bookpro_passenger');
		$query0->where('order_id='.$order_id);
		$db->setQuery($query0);
		$data=$db->loadAssoc();

		$query1 = $db->getQuery ( true );
		$query1->update ( $db->quoteName ( '#__bookpro_passenger' ) );
		$confirmed="CONFIRMED";

		if($order->pay_method == "PayAnyWay")
		{
			$pay_method = "PayAnyWay";
		}
		else if($order->pay_method == "Sberbank")
		{
			$pay_method = "Sberbank";
		}
		else
		{
			$pay_method = "Api";
		}

		$query1->set ( $db->quoteName ( 'passenger_status' ) . ' = ' . $db->quote ( $confirmed ) );
		$query1->set ( $db->quoteName ( 'pay_method' ) . ' = ' . $db->quote ( $pay_method ) );
		if($data["passenger_status_return"] != "ABSENT")
		{
			$query1->set ( $db->quoteName ( 'passenger_status_return' ) . ' = ' . $db->quote ( $confirmed ) );
			$query1->set ( $db->quoteName ( 'return_pay_method' ) . ' = ' . $db->quote ( $pay_method ) );
		}
		$query1->set ( $db->quoteName ( 'payment_date' ) . ' = ' . $db->quote ( $dat_today ) );
		$query1->where ( $db->quoteName ( 'order_id' ) . ' = ' . $order_id );
		$db->setQuery ( $query1 );

		$db->execute ();

	}
	
	
	/**
	 *
	 * @param html $input        	
	 * @param Customer $customer        	
	 * @return mixed
	 */
	public function fillCustomer($input, $customer) {
		
		$input = str_replace ( '{email}', $customer->email, $input );
		$input = str_replace ( '{firstname}', $customer->firstname, $input );
		$input = str_replace ( '{lastname}', $customer->lastname, $input );
		$input = str_replace ( '{address}', $customer->address, $input );
		$input = str_replace ( '{city}', $customer->city, $input );
		$input = str_replace ( '{gender}', BookProHelper::formatGender ( $customer->gender ), $input );
		$input = str_replace ( '{telephone}', $customer->telephone, $input );
		$input = str_replace ( '{states}', $customer->states, $input );
		$input = str_replace ( '{zip}', $customer->zip ? 'N/A' : $customer->zip, $input );
		$input = str_replace ( '{country}', $customer->country_name, $input );
		return $input;
	}
	public function fillOrder($input, $order) {
		$input = str_replace ( '{order_number}', $order->order_number, $input );
		$input = str_replace ( '{total}', CurrencyHelper::formatprice ( $order->total ), $input );
		$input = str_replace ( '{tax}', CurrencyHelper::formatprice ( $order->tax ), $input );
		$input = str_replace ( '{subtotal}', CurrencyHelper::formatprice ( $order->subtotal ), $input );
		$input = str_replace ( '{payment_status}',PayStatus::format($order->pay_status), $input );
		$input = str_replace ( '{deposit}', $order->deposit, $input );
		$input = str_replace ( '{pay_method}', $order->pay_method, $input );
		$input = str_replace ( '{note}', $order->notes, $input );
		$input = str_replace ( '{created}',DateHelper::toNormalDate($order->created), $input );
		$input = str_replace ( '{order_status}', OrderStatus::format($order->order_status), $input );
		$order_link = BookProHelper::getOrderLink($order->order_number, $order->customer->email);
		$input = str_replace ( '{order_link}', $order_link, $input );
		

		
		
		if ($order->type == 'BUS') {
			// get passenger information
			
			AImporter::model ( 'passengers' );
			$model = new BookproModelpassengers ();
			
			$state = $model->getState ();
			$state->set ( 'filter.order_id', $order->id );
			$passengers = $model->getItems ();
			$data = new JObject ();
			//$route = BookProHelper::renderLayout ( 'email_route', $order );
			$route = BookProHelper::renderLayout ( 'tripinfo', $order );	
			$input = str_replace ( '{tripdetail}', $route, $input );
			
			$data->passengers = $passengers;
			$layout = new JLayoutFile('invoiceformail', $basePath = JPATH_ROOT .'/components/com_bookpro/layouts/bus');
			//$layout = new JLayoutFile('mail_passengers', $basePath = JPATH_ROOT .'/components/com_bookpro/layouts');
			//$layout = new JLayoutFile('passengers', $basePath = JPATH_ROOT .'/components/com_bookpro/layouts');
			
			$passengers_html = $layout->render($order);
			//$passengers_html = $layout->render($data);
			//$passengers_html = BookProHelper::renderLayout ( 'mail_passengers', $data );
			$input = str_replace ( '{passenger}', $passengers_html, $input );
		}
		
		return $input;
	}
	
	static public function cancelOrder($order_id) {
		$orderModel = new BookProModelOrder ();
		$applicationModel = new BookProModelApplication ();
		$customerModel = new BookProModelCustomer ();
		$order = $orderModel->getItem($order_id);
		
		$customer = $customerModel->getItem($order->user_id);
		$app = $applicationModel->getObjectByCode ( $order->type );
		$msg = 'COM_BOOKPRO_ORDER_STATUS_' . $order->order_status . '_EMAIL_BODY';
		$body_customer = JText::sprintf ( 'COM_BOOKPRO_CANCEL_ORDER_EMAIL_BODY', $order->order_number );
		
		// $body_customer=$this->fillCustomer($body_customer, $customer);
		// $body_customer=$this->fillOrder($body_customer,$order);
		$subject = JText::sprintf ( 'COM_BOOKPRO_ORDER_STATUS_CANCEL_EMAIL_SUB', $order->order_number );
		BookProHelper::sendMail ( $app->email_send_from, $app->email_send_from_name, $customer->email, $subject, $body_customer, true );
	}
	
	public function changeOrderStatus($order_id) {
		$orderModel = new BookProModelOrder ();
		$applicationModel = new BookProModelApplication ();
		$customerModel = new BookProModelCustomer ();
	
		$order = $orderModel->getItem ($order_id);
		$customerModel->setId ( $order->user_id );
		$customer = $customerModel->getComplexItem ($order->user_id);
		$this->app = $applicationModel->getObjectByCode ( $order->type );
		$msg = 'COM_BOOKPRO_ORDER_STATUS_' . $order->order_status . '_EMAIL_BODY';
		$body_customer = JText::_ ( $msg );
		$body_customer = $this->fillCustomer ( $body_customer, $customer );
		$body_customer = $this->fillOrder ( $body_customer, $order );
	
		BookProHelper::sendMail ( $this->app->email_send_from, $this->app->email_send_from_name, $customer->email, JText::_ ( 'COM_BOOKPRO_ORDER_STATUS_CHANGE_EMAIL_SUB' ), $body_customer, true );
	}
	
}
