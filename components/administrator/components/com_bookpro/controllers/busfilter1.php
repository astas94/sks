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
class BookProControllerBusFilter1 extends JControllerAdmin {
    
	function exportpdf() {

		$input = JFactory::getApplication ()->input;
		AImporter::helper ( 'pdf' );
		$model = $this->getModel ( 'BusFilter1' );
		
		$depart_date = JFactory::getApplication ()->input->get ( 'depart_date', 0 );
		$router_id = JFactory::getApplication ()->input->get ( 'router_id', 0 );
		$agent_id = JFactory::getApplication ()->input->get ( 'agent_id', 0 );
		$children = JFactory::getApplication ()->input->get ( 'children', 0 );
		$pay_status = JFactory::getApplication ()->input->get ( 'pay_status', 0 );

////////S

		$depart_todate = JFactory::getApplication ()->input->get ( 'depart_todate', 0 );

////////E

		$state = $model->getState ();
		$model->setState ( 'filter.route_id', $router_id );
		$model->setState ( 'filter.depart_date', $depart_date );
////////S
		$model->setState ( 'filter.depart_todate', $depart_todate );
////////S
		$model->setState ( 'filter.agent_id', $agent_id );
		$model->setState ( 'filter.children', $children );
		$model->setState ( 'filter.pay_status', $paystatus );
		$state->set ( 'list.limit', NULL );
		
		$ticket_view = $this->getView ( 'busfilter1', 'html', 'BookProView' );
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
}

?>