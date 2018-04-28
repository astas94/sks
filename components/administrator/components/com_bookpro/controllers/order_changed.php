<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: order.php 66 2012-07-31 23:46:01Z quannv $
 **/
defined ( '_JEXEC' ) or die ( 'Restricted access' );

// import needed JoomLIB helpers
class BookProControllerOrder extends JControllerForm {
	var $_model;
	
	function __construct($config = array())
	{
		parent::__construct($config);
		$this->_model = $this->getModel('order');
		$this->_controllerName = CONTROLLER_ORDER;
	}
	function createticket() {
		$mainframe = JFactory::getApplication ();
		$mainframe->redirect ( JUri::base () . 'index.php?option=com_bookpro&view=bussearch' );
	}


	function save($apply = false)
	{
		$db = JFactory::getDbo();
		$mainframe = &JFactory::getApplication ();
		$task = $this->getTask();
		$input 		= JFactory::getApplication ()->input;

		$passenger_status = $input->get ( 'passenger_status', array (), 'array' );
		$passenger_status_return = $input->get ( 'passenger_status_return', array (), 'array' );
		$id_passenger = $input->get ( 'id_passenger', array (), 'array' );
		$price_passenger = $input->get ( 'price_passenger', array (), 'array' );
		$price_passenger_return = $input->get ( 'price_passenger_return', array (), 'array' );
		$pay_method = $input->get ( 'pay_method_passenger', array (), 'array' );
		$pay_method_return = $input->get ( 'pay_method_passenger_return', array (), 'array' );

		$jform 		= $input->get ( 'jform', array (), 'array' );
		$order_id 	= $jform['id'];
		$order_status = $jform['order_status'];

		$amount = 0;
	`	$amount_sberbank = 0;
		$transactionId = $jform['tx_operation_id'];
		$transactionId_sberbank = $jform['tx_id'];

		$db = JFactory::getDbo();
		$query = $db->getQuery ( true );
		$query->select('order_status');
		$query->from('#__bookpro_orders');
		$query->where('id='.$order_id);
		$db->setQuery($query);
		$data=$db->loadAssoc();

		$dat_today = date("Y-m-d H:i:s");

		$check_status=1;

		if($order_status == "CONFIRMED")
		{

			if($data['order_status'] == "PENDING")
			{
				foreach($passenger_status as $sub_passenger)
				{
					if($sub_passenger != "PENDING") $check_status=0;		
				}
	
				foreach($passenger_status_return as $sub_passenger)
				{
					if( ($sub_passenger != "PENDING") && ($sub_passenger != "ABSENT") ) $check_status=0;		
				}
	
				if($check_status == 0)
				{
					JFactory::getApplication ()->enqueueMessage ( 'Error: Order status cannot be changed due to conflict statuses of passengers', 'message');
				}
	
				else if($check_status == 1)
				{
					for($kk=0;$kk<count($passenger_status);$kk++)
					{
						$passenger_status[$kk]= $order_status;
					}
	
					for($kk=0;$kk<count($passenger_status_return);$kk++)
					{
						if ($passenger_status_return[$kk] != "ABSENT") $passenger_status_return[$kk]= $order_status;
					}
				}
			}
			else if($order_status != $data['order_status'])
			{
				$check_status=0;
				JFactory::getApplication ()->enqueueMessage ( 'Error: Order status cannot be changed due to conflict statuses of passengers', 'message');
			}

		}
		else if( ($order_status == "CANCELLED") || ($order_status == "CANCELLED_L_B_D") || ($order_status == "CANCELLED_B_D") || ($order_status == "CANCELLED_A_D") )
		{
			if($data['order_status'] == "CONFIRMED")
			{
				foreach($passenger_status as $sub_passenger)
				{
					if($sub_passenger != "CONFIRMED") $check_status=0;		
				}
	
				foreach($passenger_status_return as $sub_passenger)
				{
					if( ($sub_passenger != "CONFIRMED") && ($sub_passenger != "ABSENT") ) $check_status=0;		
				}
	
				if($check_status == 0)
				{
					JFactory::getApplication ()->enqueueMessage ( 'Error: Order status cannot be changed due to conflict statuses of passengers', 'message');
				}
	
				else if($check_status == 1)
				{
					for($kk=0;$kk<count($passenger_status);$kk++)
					{
						$passenger_status[$kk]= $order_status;
					}
	
					for($kk=0;$kk<count($passenger_status_return);$kk++)
					{
						if ($passenger_status_return[$kk] != "ABSENT") $passenger_status_return[$kk]= $order_status;
					}
				}
			}
			else if($order_status != $data['order_status'])
			{
				$check_status=0;
				JFactory::getApplication ()->enqueueMessage ( 'Error: Order status cannot be changed due to conflict statuses of passengers', 'message');
			}
		}
		else if($order_status != $data['order_status'])
		{
			$check_status=0;
			JFactory::getApplication ()->enqueueMessage ( 'Error: Order status cannot be changed due to conflict statuses of passengers', 'message');
		}

		$db = JFactory::getDbo();
		$query = $db->getQuery ( true );
		$query->select('id,route_id,pay_method,return_pay_method,passenger_status,passenger_status_return');
		$query->from('#__bookpro_passenger');
		$query->where('order_id='.$order_id);
		$db->setQuery($query);
		$data1=$db->loadAssocList();

		$db = JFactory::getDbo();
		$query = $db->getQuery ( true );
		$query->select('id,parent_id,associated_parent_id,bustrip_type');
		$query->from('#__bookpro_bustrip');
		$query->where('id='.$data1[0]["route_id"]);
		$db->setQuery($query);
		$data2=$db->loadAssoc();

		if($data2["associated_parent_id"] != 0)
		{
			$db = JFactory::getDbo();
			$query = $db->getQuery ( true );
			$query->select('id,bustrip_type');
			$query->from('#__bookpro_bustrip');
			$query->where('id='.$data2["associated_parent_id"]);
			$db->setQuery($query);
			$data3=$db->loadAssoc();
			$bustrip_type=$data3["bustrip_type"];
		}
		else if($data2["parent_id"] != 0)
		{
			$db = JFactory::getDbo();
			$query = $db->getQuery ( true );
			$query->select('id,parent_id,associated_parent_id,bustrip_type');
			$query->from('#__bookpro_bustrip');
			$query->where('id='.$data2["parent_id"]);
			$db->setQuery($query);
			$data3=$db->loadAssoc();
			$bustrip_type=$data3["bustrip_type"];			
		}
		else 
		{
			$bustrip_type=$data2["bustrip_type"];
		}

		$ll=0;
				
		foreach($passenger_status as $passenger_option)
		{
			if( ($pay_method[$ll] == "PayAnyWay") && ($data1[$ll]["passenger_status"] != $passenger_option) )
			{
				if($bustrip_type == 0)
				{
					if($passenger_option == "CANCELLED_L_B_D")
					{
						$amount = $amount + ( ($price_passenger[$ll] / 100) * 95);
					}
					else if($passenger_option == "CANCELLED_B_D")
					{
						$amount = $amount + ( ($price_passenger[$ll] / 100) * 85);
					}
					else if($passenger_option == "CANCELLED_A_D")
					{
						$amount = $amount + ( ($price_passenger[$ll] / 100) * 75);
					}
					else if($passenger_option == "CANCELLED")
					{
						$amount = $amount + $price_passenger[$ll];
					}
				}
				else if($bustrip_type == 1)
				{
					if($passenger_option == "CANCELLED_L_B_D")
					{
						$amount = $amount + ( ($price_passenger[$ll] / 100) * 95);
					}
					else if($passenger_option == "CANCELLED_B_D")
					{
						$amount = $amount + ( ($price_passenger[$ll] / 100) * 50);
					}
					else if($passenger_option == "CANCELLED")
					{
						$amount = $amount + $price_passenger[$ll];
					}
				}
			}
			else if( ($pay_method[$ll] == "Sberbank") && ($data1[$ll]["passenger_status"] != $passenger_option) )
			{
				if($bustrip_type == 0)
				{
					if($passenger_option == "CANCELLED_L_B_D")
					{
						$amount_sberbank = $amount_sberbank + ( ($price_passenger[$ll] / 100) * 95);
					}
					else if($passenger_option == "CANCELLED_B_D")
					{
						$amount_sberbank = $amount_sberbank + ( ($price_passenger[$ll] / 100) * 85);
					}
					else if($passenger_option == "CANCELLED_A_D")
					{
						$amount_sberbank = $amount_sberbank + ( ($price_passenger[$ll] / 100) * 75);
					}
					else if($passenger_option == "CANCELLED")
					{
						$amount_sberbank = $amount_sberbank + $price_passenger[$ll];
					}
				}
				else if($bustrip_type == 1)
				{
					if($passenger_option == "CANCELLED_L_B_D")
					{
						$amount_sberbank = $amount_sberbank + ( ($price_passenger[$ll] / 100) * 95);
					}
					else if($passenger_option == "CANCELLED_B_D")
					{
						$amount_sberbank = $amount_sberbank + ( ($price_passenger[$ll] / 100) * 50);
					}
					else if($passenger_option == "CANCELLED")
					{
						$amount_sberbank = $amount_sberbank + $price_passenger[$ll];
					}
				}
			}

			$ll++;
		}
					
		$ll=0;
				
		foreach($passenger_status_return as $passenger_option_return)
		{
			if( ($pay_method_return[$ll] == "PayAnyWay") && ($data1[$ll]["passenger_status_return"] != $passenger_option_return) )
			{
				if($bustrip_type == 0)
				{
					if($passenger_option_return == "CANCELLED_L_B_D")
					{
						$amount = $amount + ( ($price_passenger_return[$ll] / 100) * 95);
					}
					else if($passenger_option_return == "CANCELLED_B_D")
					{
						$amount = $amount + ( ($price_passenger_return[$ll] / 100) * 85);
					}
					else if($passenger_option_return == "CANCELLED_A_D")
					{
						$amount = $amount + ( ($price_passenger_return[$ll] / 100) * 75);
					}
					else if($passenger_option_return == "CANCELLED")
					{
						$amount = $amount + $price_passenger[$ll];
					}
				}
				else if($bustrip_type == 1)
				{
					if($passenger_option_return == "CANCELLED_L_B_D")
					{
						$amount = $amount + ( ($price_passenger_return[$ll] / 100) * 95);
					}
					else if($passenger_option_return == "CANCELLED_B_D")
					{
						$amount = $amount + ( ($price_passenger_return[$ll] / 100) * 50);
					}
					else if($passenger_option_return == "CANCELLED")
					{
						$amount = $amount + $price_passenger_return[$ll];
					}
				}
			}
			else if( ($pay_method_return[$ll] == "Sberbank") && ($data1[$ll]["passenger_status_return"] != $passenger_option_return) )
			{
				if($bustrip_type == 0)
				{
					if($passenger_option_return == "CANCELLED_L_B_D")
					{
						$amount_sberbank = $amount_sberbank + ( ($price_passenger_return[$ll] / 100) * 95);
					}
					else if($passenger_option_return == "CANCELLED_B_D")
					{
						$amount_sberbank = $amount_sberbank + ( ($price_passenger_return[$ll] / 100) * 85);
					}
					else if($passenger_option_return == "CANCELLED_A_D")
					{
						$amount_sberbank = $amount_sberbank + ( ($price_passenger_return[$ll] / 100) * 75);
					}
					else if($passenger_option_return == "CANCELLED")
					{
						$amount_sberbank = $amount_sberbank + $price_passenger[$ll];
					}
				}
				else if($bustrip_type == 1)
				{
					if($passenger_option_return == "CANCELLED_L_B_D")
					{
						$amount_sberbank = $amount_sberbank + ( ($price_passenger_return[$ll] / 100) * 95);
					}
					else if($passenger_option_return == "CANCELLED_B_D")
					{
						$amount_sberbank = $amount_sberbank + ( ($price_passenger_return[$ll] / 100) * 50);
					}
					else if($passenger_option_return == "CANCELLED")
					{
						$amount_sberbank = $amount_sberbank + $price_passenger_return[$ll];
					}
				}
			}

			$ll++;
		}

		if($amount != 0)
		{

			$url = "https://demo.moneta.ru/services";
		
			$postdata = array
			(
				"Envelope" => array
				(
					"Body"	=> array
					(
						"RefundRequest" => array
						(
							"amount" => $amount,
							"transactionId" => $transactionId,
							"paymentPassword" => "123456",
						),
					),
					"Header" => array
					(
						"Security" => array
						(
							"UsernameToken" => array
							(
								"Username" => "art@sks-auto.ru",
								"Password" => "123456789",
							),
						),
					),
				),
			);

$sfile = '/home/c/chartfbt/skstest4/public_html/people.txt';
$scurrent = file_get_contents($sfile);
$scurrent = $scurrent.json_encode($postdata)."\n";
file_put_contents($sfile, $scurrent);

			$postdata = json_encode($postdata);
	
			$ch = curl_init($url);
		
			curl_setopt($ch, CURLOPT_URL,            $url );
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt($ch, CURLOPT_POST,           1 );
			curl_setopt($ch, CURLOPT_POSTFIELDS,     $postdata );
			curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json;charset=UTF-8')); 
		
			$postresult = curl_exec($ch);
		
			curl_close($ch);
		
			$postresult = json_decode($postresult);

$sfile = '/home/c/chartfbt/skstest4/public_html/people.txt';
$scurrent = file_get_contents($sfile);
$scurrent = $scurrent.json_encode($postresult)."\n"."\n";
file_put_contents($sfile, $scurrent);

			if($postresult->Envelope->Body->fault)
			{
				JFactory::getApplication ()->enqueueMessage ( 'Error: Order status cannot be changed due to conflict statuses of passengers', 'message');
				$check_status = 0;
			}
		}

		if($amount_sberbank != 0)
		{

			$url = "https://3dsec.sberbank.ru/payment/rest/refund.do";
		
			$postdata = array
			(
				'userName' => "sks-auto-api",
				'password' => "sks-auto",
				'orderId' => $transactionId_sberbank,
				'amount' => $amount_sberbank,
			);

$sfile = '/home/c/chartfbt/skstest4/public_html/people.txt';
$scurrent = file_get_contents($sfile);
$scurrent = $scurrent.json_encode($postdata)."\n";
file_put_contents($sfile, $scurrent);

			$postdata = json_encode($postdata);
	
			$ch = curl_init($url);
		
			curl_setopt($ch, CURLOPT_URL,            $url );
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt($ch, CURLOPT_POST,           1 );
			curl_setopt($ch, CURLOPT_POSTFIELDS,     $postdata );
			curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json;charset=UTF-8')); 
		
			$postresult = curl_exec($ch);
		
			curl_close($ch);
		
			$postresult = json_decode($postresult);

$sfile = '/home/c/chartfbt/skstest4/public_html/people.txt';
$scurrent = file_get_contents($sfile);
$scurrent = $scurrent.json_encode($postresult)."\n"."\n";
file_put_contents($sfile, $scurrent);

			if($postresult["errorCode"]!=0)
			{
				JFactory::getApplication ()->enqueueMessage ( 'Error: Order status cannot be changed due to conflict statuses of passengers', 'message');
				$check_status = 0;
			}
		}



		if($check_status == 1)
		{
			try {
				$db->transactionStart ();
				$this->_model->save($jform);
	
				AImporter::model('passenger');
				$model 		= new BookproModelPassenger();
				$dataall 		= $input->get ( 'person', array (), 'array' );
				$person = json_decode(json_encode($dataall),false);
			
				foreach ($person as $passenger){
	
					$Tablepassenger = JTable::getInstance('Passenger','Table');
					
					$Tablepassenger->bind ( $passenger );
					$Tablepassenger->check();	
					$Tablepassenger->store ();
				}
				
				
				$db->transactionCommit ();
	
				JFactory::getApplication ()->enqueueMessage ( 'Update successful', 'message');
			}catch (Exception $e){
				$db->transactionRollback ();
				JErrorPage::render ( $e );
				$mainframe->enqueueMessage ( $e->getMessage () );
			}
	
			if($passenger_status)
			{
				$jj=0;
				
				foreach($passenger_status as $passenger_option)
				{
					if($passenger_option == "PENDING")
					{
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);
						$query->update('#__bookpro_passenger');
						$query->set('passenger_status = "'.$passenger_option.'"');
						$query->where(' id = '.$id_passenger[$jj]);
						$db->setQuery($query);
						$querry_result =  $db->loadObjectList();
	
						$price_passengers[$jj]=$price_passenger[$jj];
					}
					else if($passenger_option == "CANCELLED")
					{
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);
						$query->update('#__bookpro_passenger');
						$query->set('passenger_status = "'.$passenger_option.'"');
						$query->set('refund_date = "'.$dat_today.'"');
						$query->where(' id = '.$id_passenger[$jj]);
						$db->setQuery($query);
						$querry_result =  $db->loadObjectList();
	
						$price_passengers[$jj]= 0;
					}
					else if($passenger_option == "CONFIRMED")
					{
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);
						$query->update('#__bookpro_passenger');
						$query->set('passenger_status = "'.$passenger_option.'"');
						if($data1[$jj]["passenger_status"] != $passenger_option)
						{
							$query->set('pay_method = "Custom"');
						}
						$query->where(' id = '.$id_passenger[$jj]);
						$db->setQuery($query);
						$querry_result =  $db->loadObjectList();
	
						$price_passengers[$jj]=$price_passenger[$jj];
					}
					else if($passenger_option == "CANCELLED_L_B_D")
					{
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);
						$query->update('#__bookpro_passenger');
						$query->set('passenger_status = "'.$passenger_option.'"');
						$query->set('refund_date = "'.$dat_today.'"');
						$query->where(' id = '.$id_passenger[$jj]);
						$db->setQuery($query);
						$querry_result =  $db->loadObjectList();
	
						$price_passengers[$jj]= 0;
					}
					else if($passenger_option == "CANCELLED_B_D")
					{
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);
						$query->update('#__bookpro_passenger');
						$query->set('passenger_status = "'.$passenger_option.'"');
						$query->set('refund_date = "'.$dat_today.'"');
						$query->where(' id = '.$id_passenger[$jj]);
						$db->setQuery($query);
						$querry_result =  $db->loadObjectList();
	
						$price_passengers[$jj]= 0;
					}
					else if($passenger_option == "CANCELLED_A_D")
					{
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);
						$query->update('#__bookpro_passenger');
						$query->set('passenger_status = "'.$passenger_option.'"');
						$query->set('refund_date = "'.$dat_today.'"');
						$query->where(' id = '.$id_passenger[$jj]);
						$db->setQuery($query);
						$querry_result =  $db->loadObjectList();
	
						$price_passengers[$jj]= 0;
					}
	
					$jj++;
				}
	
				$ii=0;
	
				foreach($passenger_status_return as $passenger_option_return)
				{
					if($passenger_option_return == "ABSENT")
					{
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);
						$query->update('#__bookpro_passenger');
						$query->set('passenger_status_return = "'.$passenger_option_return.'"');
						$query->where(' id = '.$id_passenger[$ii]);
						$db->setQuery($query);
						$querry_result =  $db->loadObjectList();
	
						$price_passengers[$jj]= 0;
					}
					else if($passenger_option_return == "PENDING")
					{
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);
						$query->update('#__bookpro_passenger');
						$query->set('passenger_status_return = "'.$passenger_option_return.'"');
						$query->where(' id = '.$id_passenger[$ii]);
						$db->setQuery($query);
						$querry_result =  $db->loadObjectList();
						$price_passengers[$jj]= $price_passenger_return[$ii];
					}
					else if($passenger_option_return == "CANCELLED")
					{
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);
						$query->update('#__bookpro_passenger');
						$query->set('passenger_status_return = "'.$passenger_option_return.'"');
						$query->set('refund_date = "'.$dat_today.'"');
						$query->where(' id = '.$id_passenger[$ii]);
						$db->setQuery($query);
						$querry_result =  $db->loadObjectList();
	
						$price_passengers[$jj]= 0;
					}
					else if($passenger_option_return == "CONFIRMED")
					{
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);
						$query->update('#__bookpro_passenger');
						$query->set('passenger_status_return = "'.$passenger_option_return.'"');
						if($data1[$ii]["passenger_status_return"] != $passenger_option_return)
						{
							$query->set('return_pay_method = "Custom"');
						}
						$query->where(' id = '.$id_passenger[$ii]);
						$db->setQuery($query);
						$querry_result =  $db->loadObjectList();
	
						$price_passengers[$jj]= $price_passenger_return[$ii];
					}
					else if($passenger_option_return == "CANCELLED_L_B_D")
					{
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);
						$query->update('#__bookpro_passenger');
						$query->set('passenger_status_return = "'.$passenger_option_return.'"');
						$query->set('refund_date = "'.$dat_today.'"');
						$query->where(' id = '.$id_passenger[$ii]);
						$db->setQuery($query);
						$querry_result =  $db->loadObjectList();
	
						$price_passengers[$jj]= 0;
					}
					else if($passenger_option_return == "CANCELLED_B_D")
					{
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);
						$query->update('#__bookpro_passenger');
						$query->set('passenger_status_return = "'.$passenger_option_return.'"');
						$query->set('refund_date = "'.$dat_today.'"');
						$query->where(' id = '.$id_passenger[$ii]);
						$db->setQuery($query);
						$querry_result =  $db->loadObjectList();
	
						$price_passengers[$jj]= 0;
					}
					else if($passenger_option_return == "CANCELLED_A_D")
					{
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);
						$query->update('#__bookpro_passenger');
						$query->set('passenger_status_return = "'.$passenger_option_return.'"');
						$query->set('refund_date = "'.$dat_today.'"');
						$query->where(' id = '.$id_passenger[$ii]);
						$db->setQuery($query);
						$querry_result =  $db->loadObjectList();
	
						$price_passengers[$jj]= 0;
					}
	
					$ii++;
	
					$jj++;
				}
	
				$price_passenger_sum = 0;
	
				foreach($price_passengers as $price_passenger_element)
				{
					$price_passenger_sum = $price_passenger_sum + $price_passenger_element;
				}
	
				$db = JFactory::getDbo();
				$query1 = $db->getQuery(true);
				$query1->update('#__bookpro_orders');
				$query1->set('total = '.$price_passenger_sum);
				$query1->where(' id = '.$jform['id']);
				$db->setQuery($query1);
				$querry_result1 =  $db->loadObjectList();
			}

		}

		if(($task=="apply")){
			$this->setRedirect ( 'index.php?option=com_bookpro&view=com_bookpro&view=order&layout=edit&id='.$order_id );
		}elseif(($task=="save")){
			$this->setRedirect('index.php?option=com_bookpro&view=orders');
		}
	
	
	}
	function changePayStatus() {
		
		$input = JFactory::getApplication ()->input;
		$id = $input->post->get ( 'paystatus_id');
 
	
		$value = $input->post->get ( 'paystatus' );
		
		if($id && $value){
			$db = JFactory::getDbo ();
			$query = $db->getQuery ( true );
			$query->update ( $db->quoteName ( '#__bookpro_orders' ) );
			$query->set ( $db->quoteName ( 'pay_status' ) . ' = ' . $db->quote ( $value ) );
			$query->where ( $db->quoteName ( 'id' ) . ' = ' . $id );
			$db->setQuery ( $query );
			
			try {
				$db->execute ();
				echo json_encode(true);
		 
			} catch ( RuntimeException $e ) {
			 	echo json_encode(false);
			}
			
		}
	 	die;
	 
	}
	/**
	 * 
	 * @return boolean
	 */
	function changeOrderstatus() {
		
		$input = JFactory::getApplication ()->input;
		$id = $input->post->get ( 'orderstatus_id' );
		$value = $input->post->get ( 'orderstatus' );

		if ($id && $value) {

			$db = JFactory::getDbo();
			$query = $db->getQuery ( true );
			$query->select('order_status');
			$query->from('#__bookpro_orders');
			$query->where('id='.$id);
			$db->setQuery($query);
			$data=$db->loadAssoc();

			$db = JFactory::getDbo();
			$query = $db->getQuery ( true );
			$query->select('id,route_id,passenger_status,passenger_status_return,price,return_price,pay_method,return_pay_method');
			$query->from('#__bookpro_passenger');
			$query->where('order_id='.$id);
			$db->setQuery($query);
			$data1=$db->loadAssocList();

			$db = JFactory::getDbo();
			$query = $db->getQuery ( true );
			$query->select('id,total,tx_operation_id,tx_id');
			$query->from('#__bookpro_orders');
			$query->where('id='.$id);
			$db->setQuery($query);
			$data2=$db->loadAssoc();

			$amount = 0;
			$amount_sberbank =0;
			$transactionId = $data2['tx_operation_id'];
			$transactionId_sberbank = $data2['tx_id'];

			$ii=0;

			foreach($data1 as $data2)
			{
				$id_passenger[$ii] = $data2['id'];
				$passenger_status[$ii] = $data2['passenger_status'];
				$passenger_status_return[$ii] = $data2['passenger_status_return'];
				$price_passenger[$ii] = $data2['price'];
				$price_passenger_return[$ii] = $data2['return_price'];
				$pay_method[$ii] = $data2['pay_method'];
				$pay_method_return[$ii] = $data2['return_pay_method'];

				$ii++;
			}

			$dat_today = date("Y-m-d H:i:s");
	
			$check_status=1;
	
			if($value == "CONFIRMED")
			{
	
				if($data['order_status'] == "PENDING")
				{
					foreach($passenger_status as $sub_passenger)
					{
						if($sub_passenger != "PENDING") $check_status=0;		
					}
		
					foreach($passenger_status_return as $sub_passenger)
					{
						if( ($sub_passenger != "PENDING") && ($sub_passenger != "ABSENT") ) $check_status=0;		
					}
		
					if($check_status == 0)
					{
						JFactory::getApplication ()->enqueueMessage ( 'Error: Order status cannot be changed due to conflict statuses of passengers', 'message');
					}
		
					else if($check_status == 1)
					{
						for($kk=0;$kk<count($passenger_status);$kk++)
						{
							$passenger_status[$kk]= $value;
						}
		
						for($kk=0;$kk<count($passenger_status_return);$kk++)
						{
							if ($passenger_status_return[$kk] != "ABSENT") $passenger_status_return[$kk]= $value;
						}
					}
				}
				else if($value != $data['order_status'])
				{
					$check_status=0;
					JFactory::getApplication ()->enqueueMessage ( 'Error: Order status cannot be changed due to conflict statuses of passengers', 'message');
				}
	
			}
			else if( ($value == "CANCELLED") || ($value == "CANCELLED_L_B_D") || ($value == "CANCELLED_B_D") || ($value == "CANCELLED_A_D") )
			{
				if($data['order_status'] == "CONFIRMED")
				{
					foreach($passenger_status as $sub_passenger)
					{
						if($sub_passenger != "CONFIRMED") $check_status=0;		
					}
		
					foreach($passenger_status_return as $sub_passenger)
					{
						if( ($sub_passenger != "CONFIRMED") && ($sub_passenger != "ABSENT") ) $check_status=0;		
					}
		
					if($check_status == 0)
					{
						JFactory::getApplication ()->enqueueMessage ( 'Error: Order status cannot be changed due to conflict statuses of passengers', 'message');
					}
		
					else if($check_status == 1)
					{
						for($kk=0;$kk<count($passenger_status);$kk++)
						{
							$passenger_status[$kk]= $value;
						}
		
						for($kk=0;$kk<count($passenger_status_return);$kk++)
						{
							if ($passenger_status_return[$kk] != "ABSENT") $passenger_status_return[$kk]= $value;
						}

					}
				}
				else if($value != $data['order_status'])
				{
					$check_status=0;
					JFactory::getApplication ()->enqueueMessage ( 'Error: Order status cannot be changed due to conflict statuses of passengers', 'message');
				}
			}
			else if($value != $data['order_status'])
			{
				$check_status=0;
				JFactory::getApplication ()->enqueueMessage ( 'Error: Order status cannot be changed due to conflict statuses of passengers', 'message');
			}

			$db = JFactory::getDbo();
			$query = $db->getQuery ( true );
			$query->select('id,route_id');
			$query->from('#__bookpro_passenger');
			$query->where('order_id='.$id);
			$db->setQuery($query);
			$data1=$db->loadAssocList();

			$db = JFactory::getDbo();
			$query = $db->getQuery ( true );
			$query->select('id,parent_id,associated_parent_id,bustrip_type');
			$query->from('#__bookpro_bustrip');
			$query->where('id='.$data1[0]["route_id"]);
			$db->setQuery($query);
			$data2=$db->loadAssoc();

			if($data2["associated_parent_id"] != 0)
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery ( true );
				$query->select('id,bustrip_type');
				$query->from('#__bookpro_bustrip');
				$query->where('id='.$data2["associated_parent_id"]);
				$db->setQuery($query);
				$data3=$db->loadAssoc();
				$bustrip_type=$data3["bustrip_type"];
			}
			else if($data2["parent_id"] != 0)
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery ( true );
				$query->select('id,parent_id,associated_parent_id,bustrip_type');
				$query->from('#__bookpro_bustrip');
				$query->where('id='.$data2["parent_id"]);
				$db->setQuery($query);
				$data3=$db->loadAssoc();
				$bustrip_type=$data3["bustrip_type"];			
			}
			else 
			{
				$bustrip_type=$data2["bustrip_type"];
			}

			$ll=0;
			
			foreach($passenger_status as $passenger_option)
			{
				if( ($pay_method[$ll] == "PayAnyWay") && ($data1[$ll]["passenger_status"] != $passenger_option) )
				{
					if($bustrip_type == 0)
					{
						if($passenger_option == "CANCELLED_L_B_D")
						{
							$amount = $amount + ( ($price_passenger[$ll] / 100) * 95);
						}
						else if($passenger_option == "CANCELLED_B_D")
						{
							$amount = $amount + ( ($price_passenger[$ll] / 100) * 85);
						}
						else if($passenger_option == "CANCELLED_A_D")
						{
							$amount = $amount + ( ($price_passenger[$ll] / 100) * 75);
						}
						else if($passenger_option == "CANCELLED")
						{
							$amount = $amount + $price_passenger[$ll];
						}

					}
					else if($bustrip_type == 1)
					{
						if($passenger_option == "CANCELLED_L_B_D")
						{
							$amount = $amount + ( ($price_passenger[$ll] / 100) * 95);
						}
						else if($passenger_option == "CANCELLED_B_D")
						{
							$amount = $amount + ( ($price_passenger[$ll] / 100) * 50);
						}
						else if($passenger_option == "CANCELLED")
						{
							$amount = $amount + $price_passenger[$ll];
						}
					}
				}
				else if( ($pay_method[$ll] == "Sberbank") && ($data1[$ll]["passenger_status"] != $passenger_option) )
				{
					if($bustrip_type == 0)
					{
						if($passenger_option == "CANCELLED_L_B_D")
						{
							$amount_sberbank = $amount_sberbank + ( ($price_passenger[$ll] / 100) * 95);
						}
						else if($passenger_option == "CANCELLED_B_D")
						{
							$amount_sberbank = $amount_sberbank + ( ($price_passenger[$ll] / 100) * 85);
						}
						else if($passenger_option == "CANCELLED_A_D")
						{
							$amount_sberbank = $amount_sberbank + ( ($price_passenger[$ll] / 100) * 75);
						}
						else if($passenger_option == "CANCELLED")
						{
							$amount_sberbank = $amount_sberbank + $price_passenger[$ll];
						}
					}
					else if($bustrip_type == 1)
					{
						if($passenger_option == "CANCELLED_L_B_D")
						{
							$amount_sberbank = $amount_sberbank + ( ($price_passenger[$ll] / 100) * 95);
						}
						else if($passenger_option == "CANCELLED_B_D")
						{
							$amount_sberbank = $amount_sberbank + ( ($price_passenger[$ll] / 100) * 50);
						}
						else if($passenger_option == "CANCELLED")
						{
							$amount_sberbank = $amount_sberbank + $price_passenger[$ll];
						}
					}
				}

				$ll++;
			}
					
			$ll=0;
					
			foreach($passenger_status_return as $passenger_option_return)
			{
				if( ($pay_method_return[$ll] == "PayAnyWay") && ($data1[$ll]["passenger_status_return"] != $passenger_option_return) )
				{
					if($bustrip_type == 0)
					{
						if($passenger_option_return == "CANCELLED_L_B_D")
						{
							$amount = $amount + ( ($price_passenger_return[$ll] / 100) * 95);
						}
						else if($passenger_option_return == "CANCELLED_B_D")
						{
							$amount = $amount + ( ($price_passenger_return[$ll] / 100) * 85);
						}
						else if($passenger_option_return == "CANCELLED_A_D")
						{
							$amount = $amount + ( ($price_passenger_return[$ll] / 100) * 75);
						}
						else if($passenger_option_return == "CANCELLED")
						{
							$amount = $amount + $price_passenger[$ll];
						}
					}
					else if($bustrip_type == 1)
					{
						if($passenger_option_return == "CANCELLED_L_B_D")
						{
							$amount = $amount + ( ($price_passenger_return[$ll] / 100) * 95);
						}
						else if($passenger_option_return == "CANCELLED_B_D")
						{
							$amount = $amount + ( ($price_passenger_return[$ll] / 100) * 50);
						}
						else if($passenger_option_return == "CANCELLED")
						{
							$amount = $amount + $price_passenger_return[$ll];
						}
					}
				}
				else if( ($pay_method_return[$ll] == "Sberbank") && ($data1[$ll]["passenger_status_return"] != $passenger_option_return) )
				{
					if($bustrip_type == 0)
					{
						if($passenger_option_return == "CANCELLED_L_B_D")
						{
							$amount_sberbank = $amount_sberbank + ( ($price_passenger_return[$ll] / 100) * 95);
						}
						else if($passenger_option_return == "CANCELLED_B_D")
						{
							$amount_sberbank = $amount_sberbank + ( ($price_passenger_return[$ll] / 100) * 85);
						}
						else if($passenger_option_return == "CANCELLED_A_D")
						{
							$amount_sberbank = $amount_sberbank + ( ($price_passenger_return[$ll] / 100) * 75);
						}
						else if($passenger_option_return == "CANCELLED")
						{
							$amount_sberbank = $amount_sberbank + $price_passenger[$ll];
						}
					}
					else if($bustrip_type == 1)
					{
						if($passenger_option_return == "CANCELLED_L_B_D")
						{
							$amount_sberbank = $amount_sberbank + ( ($price_passenger_return[$ll] / 100) * 95);
						}
						else if($passenger_option_return == "CANCELLED_B_D")
						{
							$amount_sberbank = $amount_sberbank + ( ($price_passenger_return[$ll] / 100) * 50);
						}
						else if($passenger_option_return == "CANCELLED")
						{
							$amount_sberbank = $amount_sberbank + $price_passenger_return[$ll];
						}
					}
				}

				$ll++;
			}


			if($amount != 0)
			{
	
				$url = "https://demo.moneta.ru/services";
			
				$postdata = array
				(
					"Envelope" => array
					(
						"Body"	=> array
						(
							"RefundRequest" => array
							(
								"amount" => $amount,
								"transactionId" => $transactionId,
								"paymentPassword" => "123456",
							),
						),
						"Header" => array
						(
							"Security" => array
							(
								"UsernameToken" => array
								(
									"Username" => "art@sks-auto.ru",
									"Password" => "123456789",
								),
							),
						),
					),
				);
	
$sfile = '/home/c/chartfbt/skstest4/public_html/people.txt';
$scurrent = file_get_contents($sfile);
$scurrent = $scurrent.json_encode($postdata)."\n";
file_put_contents($sfile, $scurrent);
	
				$postdata = json_encode($postdata);
		
				$ch = curl_init($url);
			
				curl_setopt($ch, CURLOPT_URL,            $url );
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
				curl_setopt($ch, CURLOPT_POST,           1 );
				curl_setopt($ch, CURLOPT_POSTFIELDS,     $postdata );
				curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json;charset=UTF-8')); 
			
				$postresult = curl_exec($ch);
			
				curl_close($ch);
			
				$postresult = json_decode($postresult);
	
$sfile = '/home/c/chartfbt/skstest4/public_html/people.txt';
$scurrent = file_get_contents($sfile);
$scurrent = $scurrent.json_encode($postresult)."\n"."\n";
file_put_contents($sfile, $scurrent);
	
				if($postresult->Envelope->Body->fault)
				{
					JFactory::getApplication ()->enqueueMessage ( 'Error: Order status cannot be changed due to conflict statuses of passengers', 'message');
					$check_status = 0;
				}
			}

			if($amount_sberbank != 0)
			{
	
				$url = "https://3dsec.sberbank.ru/payment/rest/refund.do";
			
				$postdata = array
				(
					'userName' => "sks-auto-api",
					'password' => "sks-auto",
					'orderId' => $transactionId_sberbank,
					'amount' => $amount_sberbank,
				);
	
	$sfile = '/home/c/chartfbt/skstest4/public_html/people.txt';
	$scurrent = file_get_contents($sfile);
	$scurrent = $scurrent.json_encode($postdata)."\n";
	file_put_contents($sfile, $scurrent);
	
				$postdata = json_encode($postdata);
		
				$ch = curl_init($url);
			
				curl_setopt($ch, CURLOPT_URL,            $url );
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
				curl_setopt($ch, CURLOPT_POST,           1 );
				curl_setopt($ch, CURLOPT_POSTFIELDS,     $postdata );
				curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json;charset=UTF-8')); 
			
				$postresult = curl_exec($ch);
			
				curl_close($ch);
			
				$postresult = json_decode($postresult);
	
	$sfile = '/home/c/chartfbt/skstest4/public_html/people.txt';
	$scurrent = file_get_contents($sfile);
	$scurrent = $scurrent.json_encode($postresult)."\n"."\n";
	file_put_contents($sfile, $scurrent);
	
				if($postresult["errorCode"]!=0)
				{
					JFactory::getApplication ()->enqueueMessage ( 'Error: Order status cannot be changed due to conflict statuses of passengers', 'message');
					$check_status = 0;
				}
			}
	
			if($check_status == 1)
			{
				if($passenger_status)
				{
					$jj=0;
					
					foreach($passenger_status as $passenger_option)
					{
						if($passenger_option == "PENDING")
						{
							$db = JFactory::getDbo();
							$query = $db->getQuery(true);
							$query->update('#__bookpro_passenger');
							$query->set('passenger_status = "'.$passenger_option.'"');
							$query->where(' id = '.$id_passenger[$jj]);
							$db->setQuery($query);
							$querry_result =  $db->loadObjectList();
		
							$price_passengers[$jj]=$price_passenger[$jj];
						}
						else if($passenger_option == "CANCELLED")
						{
							$db = JFactory::getDbo();
							$query = $db->getQuery(true);
							$query->update('#__bookpro_passenger');
							$query->set('passenger_status = "'.$passenger_option.'"');
							$query->set('refund_date = "'.$dat_today.'"');
							$query->where(' id = '.$id_passenger[$jj]);
							$db->setQuery($query);
							$querry_result =  $db->loadObjectList();
		
							$price_passengers[$jj]= 0;
						}
						else if($passenger_option == "CONFIRMED")
						{
							$db = JFactory::getDbo();
							$query = $db->getQuery(true);
							$query->update('#__bookpro_passenger');
							$query->set('passenger_status = "'.$passenger_option.'"');
							if($data1[$jj]["passenger_status"] != $passenger_option)
							{
								$query->set('pay_method = "Custom"');
							}
							$query->where(' id = '.$id_passenger[$jj]);
							$db->setQuery($query);
							$querry_result =  $db->loadObjectList();
		
							$price_passengers[$jj]=$price_passenger[$jj];
						}
						else if($passenger_option == "CANCELLED_L_B_D")
						{
							$db = JFactory::getDbo();
							$query = $db->getQuery(true);
							$query->update('#__bookpro_passenger');
							$query->set('passenger_status = "'.$passenger_option.'"');
							$query->set('refund_date = "'.$dat_today.'"');
							$query->where(' id = '.$id_passenger[$jj]);
							$db->setQuery($query);
							$querry_result =  $db->loadObjectList();
		
							$price_passengers[$jj]= 0;
						}
						else if($passenger_option == "CANCELLED_B_D")
						{
							$db = JFactory::getDbo();
							$query = $db->getQuery(true);
							$query->update('#__bookpro_passenger');
							$query->set('passenger_status = "'.$passenger_option.'"');
							$query->set('refund_date = "'.$dat_today.'"');
							$query->where(' id = '.$id_passenger[$jj]);
							$db->setQuery($query);
							$querry_result =  $db->loadObjectList();
		
							$price_passengers[$jj]= 0;
						}
						else if($passenger_option == "CANCELLED_A_D")
						{
							$db = JFactory::getDbo();
							$query = $db->getQuery(true);
							$query->update('#__bookpro_passenger');
							$query->set('passenger_status = "'.$passenger_option.'"');
							$query->set('refund_date = "'.$dat_today.'"');
							$query->where(' id = '.$id_passenger[$jj]);
							$db->setQuery($query);
							$querry_result =  $db->loadObjectList();
		
							$price_passengers[$jj]= 0;
						}
		
						$jj++;
					}
		
					$ii=0;
		
					foreach($passenger_status_return as $passenger_option_return)
					{
						if($passenger_option_return == "ABSENT")
						{
							$db = JFactory::getDbo();
							$query = $db->getQuery(true);
							$query->update('#__bookpro_passenger');
							$query->set('passenger_status_return = "'.$passenger_option_return.'"');
							$query->where(' id = '.$id_passenger[$ii]);
							$db->setQuery($query);
							$querry_result =  $db->loadObjectList();
		
							$price_passengers[$jj]= 0;
						}
						else if($passenger_option_return == "PENDING")
						{
							$db = JFactory::getDbo();
							$query = $db->getQuery(true);
							$query->update('#__bookpro_passenger');
							$query->set('passenger_status_return = "'.$passenger_option_return.'"');
							$query->where(' id = '.$id_passenger[$ii]);
							$db->setQuery($query);
							$querry_result =  $db->loadObjectList();
							$price_passengers[$jj]= $price_passenger_return[$ii];
						}
						else if($passenger_option_return == "CANCELLED")
						{
							$db = JFactory::getDbo();
							$query = $db->getQuery(true);
							$query->update('#__bookpro_passenger');
							$query->set('passenger_status_return = "'.$passenger_option_return.'"');
							$query->set('refund_date = "'.$dat_today.'"');
							$query->where(' id = '.$id_passenger[$ii]);
							$db->setQuery($query);
							$querry_result =  $db->loadObjectList();
		
							$price_passengers[$jj]= 0;
						}
						else if($passenger_option_return == "CONFIRMED")
						{
							$db = JFactory::getDbo();
							$query = $db->getQuery(true);
							$query->update('#__bookpro_passenger');
							$query->set('passenger_status_return = "'.$passenger_option_return.'"');
							if($data1[$ii]["passenger_status_return"] != $passenger_option_return)
							{
								$query->set('return_pay_method = "Custom"');
							}
							$query->where(' id = '.$id_passenger[$ii]);
							$db->setQuery($query);
							$querry_result =  $db->loadObjectList();
		
							$price_passengers[$jj]= $price_passenger_return[$ii];
						}
						else if($passenger_option_return == "CANCELLED_L_B_D")
						{
							$db = JFactory::getDbo();
							$query = $db->getQuery(true);
							$query->update('#__bookpro_passenger');
							$query->set('passenger_status_return = "'.$passenger_option_return.'"');
							$query->set('refund_date = "'.$dat_today.'"');
							$query->where(' id = '.$id_passenger[$ii]);
							$db->setQuery($query);
							$querry_result =  $db->loadObjectList();
		
							$price_passengers[$jj]= 0;
						}
						else if($passenger_option_return == "CANCELLED_B_D")
						{
							$db = JFactory::getDbo();
							$query = $db->getQuery(true);
							$query->update('#__bookpro_passenger');
							$query->set('passenger_status_return = "'.$passenger_option_return.'"');
							$query->set('refund_date = "'.$dat_today.'"');
							$query->where(' id = '.$id_passenger[$ii]);
							$db->setQuery($query);
							$querry_result =  $db->loadObjectList();
		
							$price_passengers[$jj]= 0;
						}
						else if($passenger_option_return == "CANCELLED_A_D")
						{
							$db = JFactory::getDbo();
							$query = $db->getQuery(true);
							$query->update('#__bookpro_passenger');
							$query->set('passenger_status_return = "'.$passenger_option_return.'"');
							$query->set('refund_date = "'.$dat_today.'"');
							$query->where(' id = '.$id_passenger[$ii]);
							$db->setQuery($query);
							$querry_result =  $db->loadObjectList();
		
							$price_passengers[$jj]= 0;
						}
		
						$ii++;
		
						$jj++;
					}
		
					$price_passenger_sum = 0;
		
					foreach($price_passengers as $price_passenger_element)
					{
						$price_passenger_sum = $price_passenger_sum + $price_passenger_element;
					}
		
					$db = JFactory::getDbo();
					$query1 = $db->getQuery(true);
					$query1->update('#__bookpro_orders');
					$query1->set('total = '.$price_passenger_sum);
					$query1->where(' id = '.$id);
					$db->setQuery($query1);
					$querry_result1 =  $db->loadObjectList();
				}

				$db = JFactory::getDbo ();
				$query = $db->getQuery ( true );
				$query->update ( $db->quoteName ( '#__bookpro_orders' ) );
				$query->set ( $db->quoteName ( 'order_status' ) . ' = ' . $db->quote ( $value ) );
				$query->where ( $db->quoteName ( 'id' ) . ' = ' . $id );
				$db->setQuery ( $query );
			
				try {
					$db->execute ();
	
					//send email						
					$this->sendEmailToCustomer($id,$value);   
					 
					echo json_encode(true);  
				} catch ( RuntimeException $e ) {
				 	echo json_encode(false);
				}

			}
			else
			{
				echo json_encode(false);
			}

		}

		die;
		
	}
	
	function sendEmailToCustomer($id,$value){
		if($id){
			$model=new BookProModelOrder();
			$model->setId($id);
			$order=$model->getObject();
		 
			$db = JFactory::getDbo();
			$query = $db->getQuery ( true );
			$query->select('a.email');
				
			$query->from('#__bookpro_customer AS a');
			$query->innerJoin('#__bookpro_orders AS b ON b.user_id=a.id');
			$query->where('b.id='.$id);
			$db->setQuery($query);
			$data=$db->loadAssoc();	
		}
		
		$link=JUri::root().('index.php?option=com_bookpro&view=ticket&layout=ticket&order_number='.$order->order_number);
		$subject=JText::_('COM_BOOKPRO_SUBJECT_MAIL_CONFIRM_PAYMENT');
		$body=JText::sprintf('COM_BOOKPRO_BODY_MAIL_CONFIRM_PAYMENT',$link);
		
		$subjectCancel=JText::_('COM_BOOKPRO_SUBJECT_MAIL_CANCEL_PAYMENT');
		$bodyCacel=JText::sprintf('COM_BOOKPRO_BODY_MAIL_CANCEL_PAYMENT');
		
		$config = JFactory::getConfig();
		
		$post['fromname'] = $config->get('fromname');
		$post['mailfrom'] = $config->get('mailfrom');
		$post['sitename'] = $config->get('sitename');
		$post['siteurl'] = JUri::root();
 		if($value=="CONFIRMED"){
		JFactory::getMailer()->sendMail($post['mailfrom'], $post['fromname'], $data['email'], $subject, $body);
 		}
 		
 		if($value=="CANCELLED"){
 			JFactory::getMailer()->sendMail($post['mailfrom'], $post['fromname'], $data['email'], $subjectCancel, $bodyCacel);
 		}
	}

}

?>