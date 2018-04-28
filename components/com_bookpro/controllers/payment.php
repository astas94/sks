<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id$
 **/
defined('_JEXEC') or die('Restricted access');
AImporter::helper('paystatus','orderstatus');
class BookProControllerPayment extends JControllerLegacy{


	function BookProControllerPayment(){

		parent::__construct();
		
	}
	
	function process(){
		
		JSession::checkToken() or jexit('Invalid Token');
		AImporter::helper('bus');
		$input=JFactory::getApplication()->input;
		$payment_plugin = $input->getString('payment_plugin','', 'bookpro');
		$element=explode('_', $payment_plugin);
		$order_id=$input->getInt('order_id');
		
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.'/tables');
		$order = JTable::getInstance('orders', 'table');
		$customer = JTable::getInstance('customer', 'table');
		$customer->load($order->user_id);
		$order->load($order_id);
		//$order->pay_method=$element[1];
//$order->pay_method="PayAnyWay";
		if($element[1] == 'paypal')
			$order->pay_method="PayAnyWay";
		elseif($element[1] == 'sberbank')
			$order->pay_method="Sberbank";
		$order->store();
		//Prepare value to complete payment
		$values=array();
		$values['payment_plugin'] =$payment_plugin;
		$values['total']=$order->total;
		$values['order_number']=$order->order_number;
		$values['title']=BusHelper::getRouteFromParams(json_decode($order->params,true));
		$values['city']=$customer->city;
		$values['firstname']=$customer->firstname;
		$values['lastname']=$customer->lastname;
		$values['address']=$customer->address;
		$values['mobile']=$customer->mobile;
		$values['email']=$customer->email;
		$values['desc']=$order->order_number;
		if($input->getString('failUrl') && $element[1] == 'sberbank') $values['failUrl']=$input->getString('failUrl');
		
		//cal payment plugin
		
		$dispatcher    = JDispatcher::getInstance();
		JPluginHelper::importPlugin ('bookpro');
		$results = $dispatcher->trigger( "onBookproPrePayment", array($payment_plugin,$values ));
		
		//echo $results;
		//echo utf8_encode('SUCCESS');die;
		exit;
			
	}
	function getPaymentForm($element='')
	{
		$app = JFactory::getApplication();
		$values = JRequest::get('post');
		$html = '';
		$text = "";
		$user = JFactory::getUser();
		if (empty($element)) {
			$element = JRequest::getVar( 'payment_element' );
		}
		$results = array();
		$dispatcher    = JDispatcher::getInstance();
		JPluginHelper::importPlugin ('bookpro');
	
		$results = $dispatcher->trigger( "onBookproGetPaymentForm", array( $element, $values ) );
		for ($i=0; $i<count($results); $i++)
		{
		$result = $results[$i];
		$text .= $result;
		}
		$html = $text;
		// set response array
		$response = array();
		$response['msg'] = $html;
		// encode and echo (need to echo to send back to browser)
		echo json_encode($response);
		//$app->close();
		return;
	}

	function postpayment()
	{
		
		$app =JFactory::getApplication();
		$plugin = $app->input->getString('method');
		$pluginsms = $app->input->get('methodsms','product_sms','string');
		$dispatcher = JDispatcher::getInstance();
		JPluginHelper::importPlugin ('bookpro');
		$values=array();
		$results = $dispatcher->trigger( "onBookproPostPayment", array($plugin, $values ));
		
		/// Send email
		
		
		if($results){
			$smsresult=$dispatcher->trigger('onBookproSendSms',array($results[0]));
			
			if (count($results)){
				if(!$results[0]->sendemail){
					AImporter::helper('email');
					$mail=new EmailHelper();
				
					$mail->sendMail($results[0]->id);
					
				}	
			}
			
		}
		die;
		AImporter::model('order');
		$orderModel=new BookProModelOrder();
		$view = $this->getView('postpayment','html','Bookproview');
		$view->assign('order',$orderModel->getComplexItem($results[0]->id));
		$view->display();
	}


	

}
