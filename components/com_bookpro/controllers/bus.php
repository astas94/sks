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
use Joomla\Registry\Registry;

AImporter::helper('bookpro','orderstatus');
class BookProControllerBus extends JControllerLegacy{

	public function BookProControllerBus(){
		parent::__construct();
		
	}
	public function display($cachable = false, $urlparams = false){
		
		parent::display();

	}
	
	
	function ticket(){
	
	
		AImporter::model('bustrips','bustrip','passengers','order');
		$order_number = JRequest::getVar('order_number','');
		$order = new BookProModelOrder();
		$this->order = $order->getByOrderNumber($order_number);	
		if ($this->order->id) {
			$link = 'index.php?option=com_bookpro&view=ticket&layout=ticket&order_number='.$order_number.'&Itemid='.JRequest::getVar('Itemid');
			$this->setRedirect($link,false);
		}else {
			$link = 'index.php?option=com_bookpro&view=ticket&Itemid='.JRequest::getVar('Itemid');
			$msg = JText::_('COM_BOOKPRO_TICKET_INVALID');
			$this->setRedirect($link,$msg);
		}
	
	}
	function smscron(){
		$log=JLog::getInstance('cron.txt');
		$log->addEntry(array('comment'=>'SMS cron start'));
	}
	
	function listdestination()
	{
		$from=JRequest::getVar('from',0);
		$db = JFactory::getDBO();
		$query =$db->getQuery(true);
		$query->select('f.to AS `key` ,`d2`.`title` AS `title`,`d2`.`ordering` AS `t_order`');
		$query->from('#__bookpro_bustrip AS f');
		$query->leftJoin('#__bookpro_dest AS d2 ON f.to =d2.id');
		$query->where(array('f.from='.$from,'f.state=1'));
		$query->group('f.to');
		$query->order('t_order');
		$sql = (string)$query;
		$db->setQuery($sql);
		$dests = $db->loadObjectList();
			
		$return = "<?xml version=\"1.0\" encoding=\"utf8\" ?>";
		$return .= "<options>";
		$return .= "<option id='0'>".JText::_( 'TO' )."</option>";
		if(is_array($dests)) {
			foreach ($dests as $dest) {
				$return .="<option id='".$dest->key."'>".JText::_($dest->title)."</option>";
			}
		}
		$return .= "</options>";
		echo $return;
	}

	/**
	 * Find destination for ajax call
	 */
	function findDestination()
	{
		$from=JFactory::getApplication()->input->getInt('desfrom');
		$db = JFactory::getDBO();
		$query =$db->getQuery(true);
		$query->select('d2.id AS code ,d2.title AS title');
		$query->from('#__bookpro_bustrip AS f');
		$query->leftJoin('#__bookpro_dest AS d2 ON f.to =d2.id');
		$query->where(array('f.from='.$from,'f.state=1'));
		$query->group('f.to');
		$query->order('title');
		$sql = (string)$query;
		$db->setQuery($sql);
		$dests = $db->loadObjectList();
			
		$return = '<option value="">'.JText::_('COM_BOOKPRO_BUSTRIP_TO').'</option>';
		if(is_array($dests)) {
			foreach ($dests as $dest) {
				$return .="<option value='".$dest->code."'>".$dest->title."</option>";
			}
		}
		echo trim($return);
		die();

	}


	function confirm()
	{
		
		
		AImporter::helper('bus','log','date');
		$config=JComponentHelper::getParams('com_bookpro');
		$app = JFactory::getApplication();
		$this->start = JFactory::getApplication ()->getUserStateFromRequest ( 'filter.start', 'filter_start' );
		$roundtrip = JFactory::getApplication ()->getUserStateFromRequest ('filter.roundtrip', 'filter_roundtrip', false,'boolean' );
		//var_dump ($this);die;
		
		$input = $app->input;
		$cart = JModelLegacy::getInstance('BusCart', 'bookpro');
		$cart->load();
		$chargeInfo=$cart->chargeInfo;
		//var_dump($chargeInfo);die;
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.'/tables');
		$person=$input->get('person',array(),'array');
		$total_pax=count($person);
		$person = json_decode ( json_encode ( $person ), false );
		$a_key_persons = array (
				'adult' 	=> 'adult',
				'children' 	=> 'children',
				'infant' 	=> 'infant'
		);
		foreach ($person as $key_persons=>$listpersons){
			if (in_array ( $key_persons, $a_key_persons ))
				switch ($key_persons) {
					case 'adult' : 		$group_id = 1; break;
					case 'children' : 	$group_id = 2; break;
					case 'infant' : 	$group_id = 3; break;
			}
		
			for ($i = 0;$i < count($listpersons);$i++){
				$listperson = $listpersons[$i];
				$listperson->route_id = $chargeInfo['onward']['id'];
				$listperson->group_id = $group_id;
				//$listperson->start = JFactory::getDate($this->start)->format(DateHelper::getConvertDateFormat('P'));
				//$listperson->start =$chargeInfo["onward"]["date"];
				$listperson->start = JFactory::getDate($chargeInfo["onward"]["date"])->format("Y-m-d H:i:s");
				//var_dump($listperson);die;
			}
				
		}
		if($roundtrip==1){
			$this->end = JFactory::getApplication ()->getUserStateFromRequest ( 'filter.end', 'filter_end' );
			foreach ($person as $key_persons=>$listpersons){
				for ($i = 0;$i < count($listpersons);$i++){
					$listperson = $listpersons[$i];
					$listperson->return_route_id = $chargeInfo['return']['id'];
					//$listperson->return_start = JFactory::getDate($this->end)->format(DateHelper::getConvertDateFormat('P'));
					//$listperson->return_start = $chargeInfo["return"]["date"];
					$listperson->return_start = JFactory::getDate($chargeInfo["return"]["date"])->format("Y-m-d H:i:s");
					//var_dump($listperson);die;
				}
		
			}
				
		}
		
		AImporter::table ( 'customer','orders' );
		$db = JFactory::getDbo ();
		$user = JFactory::getUser ();
		try {
			
			$db->transactionStart ();
			$user = JFactory::getUser();
			$post= $input->getArray($_POST);
			//var_dump($post);die;
			if ($user->id) {
				$account=JBFactory::getAccount();
				if($account->id){
					$cid = $account->id;
                    $db1 = JFactory::getDbo();
                     
                    $query = $db1->getQuery(true);
                     
                    // Fields to update.
                    $fields = array(
                        $db1->quoteName('lastname') . ' = ' . $db1->quote($post["lastname"]),
                        $db1->quoteName('firstname') . ' = ' . $db1->quote($post["firstname"]),
                        $db1->quoteName('midlename') . ' = ' . $db1->quote($post["midlename"]),
                        $db1->quoteName('mobile') . ' = ' . $db1->quote($post["mobile"]),
                        $db1->quoteName('email') . ' = ' . $db1->quote($post["email"]),
                        $db1->quoteName('country_id') . ' = ' . $db1->quote($post["country_id"])
                    );
                     
                    // Conditions for which records should be updated.
                    $conditions = array(
                        $db1->quoteName('id') . ' = '.$cid
                    );
                     
                    $query->update($db1->quoteName('#__bookpro_customer'))->set($fields)->where($conditions);
                     
                    $db1->setQuery($query);
                     
                    $result = $db1->execute();
				}
				else
				{
					
					$post['id']=0;
					$post['state'] = 1;
					$post['user']=$user->id;
					$post['created'] = JFactory::getDate()->toSql();
					$customerTable=new TableCustomer($db);
					$customerTable->save($post);
					$cid = $customerTable->id;
				}
				
				
			}else{
					
				$post['id']=0;
				$post['state'] = 1;
				$post['created'] = JFactory::getDate()->toSql();
				$customerTable=new TableCustomer($db);
				$customerTable->save($post);
				$cid = $customerTable->id;	
			}
			$params = new JObject();
			$params->chargeInfo=$chargeInfo;
			$config=JComponentHelper::getParams('com_bookpro');
            $discount_site = $config->def('discount_site',0);
		    //echo ($discount_site);
		    if ($discount_site>0){
		        $chargeInfo['sum']['total']=($chargeInfo['sum']['subtotal'])*(100-$discount_site)/100;
		    }
		        //echo ( $chargeInfo['sum']['total']);die;
			OrderStatus::init();
			if(isset($chargeInfo['return'])){
				$return_seat=$chargeInfo['return']['seat'];
				
			}
			$order=array(
					'id'=>0,
					'type'=>'BUS',
					'user_id'=>$cid,
					'total'=>$chargeInfo['sum']['total'],
					'subtotal'=>$chargeInfo['sum']['subtotal'],
					'pay_method'=>'',
					'pay_status'=>'PENDING',
					'order_status'=>OrderStatus::$PENDING->getValue(),
					'notes'=>$notes,
					'seat'=>$chargeInfo['onward']['seat'],
					'return_seat'=>$return_seat,
					'tax'=>$chargeInfo['sum']['fee'],
					'service_fee'=>$chargeInfo['sum']['fee'],
					'params'=>json_encode($params)
						
			);
			$orderTable=new TableOrders($db);
			$orderTable->save ($order);
		
			$orderid=$orderTable->id;
			
			//save passenger
			AImporter::model('roomrate');
			$rateModel = new BookProModelRoomRate();
			$rate = $rateModel->getItem($chargeInfo['onward']['rate_id']);
			$complexRate = new JObject();
			$complexRate->rate = $rate;
			if ($roundtrip == 1){
				$return_rate = $rateModel->getItem($chargeInfo['return']['rate_id']);
				$complexRate->return_rate = $return_rate;
			}
			$rateJson = json_encode($complexRate);

$ii=0;

			foreach ($person as $key_person=>$listpersons){
				for ($i = 0;$i < count($listpersons);$i++){
					$listperson = $listpersons[$i];
					$stop_price=($chargeInfo['onward']['boarding']+$chargeInfo['onward']['dropping']);
					if($listperson->group_id==1){
						$listperson->price = $rate->adult;
						if ($roundtrip == 1){
							$listperson->return_price = $return_rate->adult;
						}
					}
					if($listperson->group_id==2){
						$listperson->price = $rate->child;
						if ($roundtrip == 1){
							$listperson->return_price = $return_rate->child;
						}
					}
					
					if($listperson->group_id==3){
						$listperson->price = $rate->infant;
						if ($roundtrip == 1){
							$listperson->return_price = $return_rate->infant;
						}
					}
					$listperson->price +=$stop_price;
					$listperson->order_id = $orderid;
					$listperson->params = $rateJson;

$passenger_seat= explode(",", $chargeInfo['onward']['seat']);
$listperson->seat = $passenger_seat[$ii];
$listperson->passenger_status = "PENDING";
$listperson->passenger_status_return = "ABSENT";
					
if(isset($chargeInfo['return']))
{
	$passenger_return_seat= explode(",", $chargeInfo['return']['seat']);
	$listperson->return_seat = $passenger_return_seat[$ii];
	$listperson->passenger_status_return = "PENDING";
}

					AImporter::table ( 'passenger' );
					$Tablepassenger = new TablePassenger($db);
					$Tablepassenger->save (JArrayHelper::fromObject($listperson));

$ii++;

				}
			}
			$db->transactionCommit();
			$this->setRedirect(JURI::base().'index.php?option=com_bookpro&view=formpayment&order_id='.$orderid.'&'.JSession::getFormToken().'=1');
			return;
		}catch (Exception $e){
			
			JBLog::addException($e);
			$db->transactionRollback();
			$this->setRedirect(JURI::base(),$e->getMessage());
		}
			
	
	}
	

	function ajaxsearch(){
		$config = JComponentHelper::getParams('com_bookpro');
		$app=JFactory::getApplication();
		$input=$app->input;
		if (! class_exists('BookProModelBustrips')) {
			AImporter::model('bustrips');
		}
		
		AImporter::helper('bus');
		
		$view=&$this->getView('ajaxbustrip','html','BookProView');
		$cart = &JModelLegacy::getInstance('BusCart', 'bookpro');
		$cart->load();

		if(!$cart->from){
			$app->enqueueMessage(JText::_('COM_BOOKPRO_SESSION_EXPIRED'));
			$app->redirect(JUri::root());
		}else {
			$start=JRequest::getVar('start',null);
			if($start)
				$cart->start=$start;
            $agent=JRequest::getVar('agent',null);
            if($agent)
                $cart->agent=$agent;
			$lists=array();
			$lists['from']= $cart->from;
			$lists['to']= $cart->to;
			$timestamp = strtotime($cart->start);
			$lists['depart_date']=$cart->start;
			if(JFactory::getDate()->format('Y-m-d')==JFactory::getDate($cart->start)->format('Y-m-d')){
				$lists['cutofftime']=$config->get('cutofftime');
			}
			$going_trip = BusHelper::getBustripSearch($lists,(int) $cart->roundtrip);
			$view->going_trips=$going_trip;

			if($cart->roundtrip=='1'){

				$end=JRequest::getVar('end',null);
				if($end)
					$cart->end=$end;
				
				$lists=array();
				$lists['from']= $cart->to;
				$lists['to']= $cart->from;
				
				$end=$cart->end;
				if(is_null($end)){
					$end=JFactory::getDate()->format('Y-m-d');
				}
				$timestamp = strtotime($cart->end);
				$lists['depart_date']=$cart->end;
				$return_trips=BusHelper::getBustripSearch($lists,(int) $cart->roundtrip,true);
				$view->return_trips=$return_trips;
			}

			$cart->saveToSession();
			$view->assign('cart',$cart);
			$view->display();

		}
	}


}