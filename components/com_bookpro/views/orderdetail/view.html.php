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
$user = JFactory::getUser();
$isroot = $user->authorise('core.admin');
if(!$user->id)
{
    die('Restricted access!');
}
jimport ( 'joomla.application.component.view' );
AImporter::helper('orderstatus','currency', 'date','bookpro');
AImporter::model ( 'order' );
AImporter::model ( 'customer' );
AImporter::css('common');
class BookproViewOrderDetail extends JViewLegacy {
	function display($tpl = null) {
		$input = JFactory::getApplication ()->input;
		if ($input->getInt ( 'reset', null, 'int' )) {
			JFactory::getApplication ()->setUserState ( 'filter.order_number', null );
			JFactory::getApplication ()->setUserState ( 'filter.email', null );
		}
		
		$order_number = JFactory::getApplication ()->getUserStateFromRequest ( 'filter.order_number', 'order_number', null, 'string' );
		$email = JFactory::getApplication ()->getUserStateFromRequest ( 'filter.email', 'email', null, 'string' );
		
		if ($order_number) {
				$orderModel = new BookProModelOrder ();
				$customerModel=new BookProModelCustomer();
				$order = $orderModel->getByOrderNumber ( $order_number );
				$customer=$customerModel->getComplexItem($order->user_id);
				$user = JFactory::getUser();
                $isroot = $user->authorise('core.admin');
                //var_dump ($customer);
				if($user->id!=$customer->user && !$isroot)
                {
                    die('Restricted access');
                }
				$order_id = $order->id;
				
				
				//echo "<pre>";print_r($order);die;
				
				$model = new BookProModelOrder ();
				$this->order = $model->getComplexItem ( $order_id );
					
				//echo "<pre>";print_r($this->orderComplex);die;
				
				$this->config = JComponentHelper::getParams('com_bookpro');
				//$this->order = $this->orderComplex->order;
				$this->customer = $this->order->customer;
				$this->passengers = $this->order->passengers;
				$this->setLayout ($input->get ( 'layout', 'default' ) );
		
		} else {
			$this->setLayout ( 'check' );
		}
		
		parent::display ( $tpl );
	}
	
}

?>
