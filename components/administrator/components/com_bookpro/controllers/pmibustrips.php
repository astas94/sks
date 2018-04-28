<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bustrip.php 66 2012-07-31 23:46:01Z quannv $
 **/
defined ( '_JEXEC' ) or die ( 'Restricted access' );
class BookProControllerPmiBustrips extends JControllerAdmin {
	function exportpdf() {
		$input = JFactory::getApplication ()->input;
		AImporter::helper ( 'pdf' );
		$model = $this->getModel ( 'PmiBustrips' );
		
		$depart_date = JFactory::getApplication ()->input->get ( 'depart_date', 0 );
		$router_id = JFactory::getApplication ()->input->get ( 'router_id', 0 );
		$agent_id = JFactory::getApplication ()->input->get ( 'agent_id', 0 );
		$children = JFactory::getApplication ()->input->get ( 'children', 0 );
		$pay_status = JFactory::getApplication ()->input->get ( 'pay_status', 0 );
		
		$state = $model->getState ();
		$model->setState ( 'filter.route_id', $router_id );
		$model->setState ( 'filter.depart_date', $depart_date );
		$model->setState ( 'filter.agent_id', $agent_id );
		$model->setState ( 'filter.children', $children );
		$model->setState ( 'filter.pay_status', $paystatus );
		$state->set ( 'list.limit', NULL );
		
		$ticket_view = $this->getView ( 'pmibustrips', 'html', 'BookProView' );
		$ticket_view->setModel ( $model, true );
		$ticket_view->setLayout ( 'report' );
		
		ob_start ();
		$ticket_view->display ();
		$pdf = ob_get_contents ();
		ob_end_clean ();
		PrintPdfHelper::printTicket ( $pdf, $order_number, 'L' );
		return;
	}
	function printpmi(){
		
		
	}
	function printticket(){
		AImporter::model('passengers');
		AImporter::helper('passenger');
		$cid = JFactory::getApplication()->input->get('cid', array(), 'array');
		$route_id=JFactory::getApplication()->input->get('filter_route_id');
		JArrayHelper::toInteger($cid);
		$model=new BookproModelpassengers();
		$passengers=$model->getItemsByIds($cid,$route_id);
		$view=$this->getView('printticket','html','BookProView');
		$view->passengers=PassengertHelper::formatPassenger($passengers);
		$view->display();
	}

	function CancelOrder(){

		$input = JFactory::getApplication ()->input;
//		$order_id = $input->post->get ( 'order_id' );
		$status_value = $input->post->get ( 'status_value' );
		$cancel_array_passenger = $input->post->get ( 'passenger' );
		$cancel_array_route = $input->post->get ( 'route' );

$sfile = '/home/c/chartfbt/skstest4/public_html/people.txt';
$scurrent = file_get_contents($sfile);
$scurrent = $scurrent."\n".$cancel_array_passenger."\n".$cancel_array_route."\n".$status_value."\n";
file_put_contents($sfile, $scurrent);

		$cancel_array_passenger = explode("_", $cancel_array_passenger);
		$cancel_array_route = explode("_", $cancel_array_route);
		$passengers_number=count($cancel_array_passenger);

/*
		if($status_value == "active")
		{
			$new_status = "ROUTE_CANCELLED";

			$db = JFactory::getDbo ();
			$query_1 = $db->getQuery(true);
			$query_1->update($db->quoteName('#__bookpro_passenger' ));
			$query_1->set($db->quoteName('passenger_status').' = '.$db->quote($new_status));
			$query_1->where($db->quoteName('id').' = '.$order_id);
			$db->setQuery($query_1);
			$db->execute();

			$new_status = "1";

			$db = JFactory::getDbo ();
			$query_1 = $db->getQuery(true);
			$query_1->update($db->quoteName('#__bookpro_passenger' ));
			$query_1->set($db->quoteName('route_cancelled').' = '.$new_status);
			$query_1->where($db->quoteName('id').' = '.$order_id);
			$db->setQuery($query_1);
			$db->execute();
		}
		else if($status_value == "cancelled")
		{
			$new_status = "CONFIRMED";

			$db = JFactory::getDbo ();
			$query_1 = $db->getQuery(true);
			$query_1->update($db->quoteName('#__bookpro_passenger' ));
			$query_1->set($db->quoteName('passenger_status').' = '.$db->quote($new_status));
			$query_1->where($db->quoteName('id').' = '.$order_id);
			$db->setQuery($query_1);
			$db->execute();

			$new_status = "0";

			$db = JFactory::getDbo ();
			$query_1 = $db->getQuery(true);
			$query_1->update($db->quoteName('#__bookpro_passenger' ));
			$query_1->set($db->quoteName('route_cancelled').' = '.$new_status);
			$query_1->where($db->quoteName('id').' = '.$order_id);
			$db->setQuery($query_1);
			$db->execute();
		}
*/

		for($i=0;$i<$passengers_number;$i++)
		{
			if($status_value == "active")
			{
				$new_status = "1";
			}
			else if($status_value == "cancelled")
			{
				$new_status = "0";
			}

			$db = JFactory::getDbo ();
			$query_1 = $db->getQuery(true);
			$query_1->update($db->quoteName('#__bookpro_passenger' ));

			if($cancel_array_route[$i] == "onward")
			{
				$query_1->set($db->quoteName('route_cancelled').' = '.$new_status);
			}
			else if($cancel_array_route[$i] == "return")
			{
				$query_1->set($db->quoteName('return_route_cancelled').' = '.$new_status);
			}

			$query_1->where($db->quoteName('id').' = '.$cancel_array_passenger[$i]);
			$db->setQuery($query_1);
			$db->execute();
		}

		die;
	}
}

?>