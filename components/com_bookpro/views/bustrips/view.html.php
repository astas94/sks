<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: view.html.php  23-06-2012 23:33:14
 **/
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
AImporter::helper ( 'bus', 'date' );
class BookProViewBusTrips extends JViewLegacy {
	function display($tpl = null) {
		JSession::checkToken () or jexit ( 'Invalid Token' );
		
		JFactory::getApplication ()->setUserState ( 'test', 'yahooo' );
		
		$config = JComponentHelper::getParams ( 'com_bookpro' );
		$app = JFactory::getApplication ();
		$this->resetCart();
		$from = JFactory::getApplication ()->getUserStateFromRequest ( 'filter.from', 'filter_from' );
		$to = JFactory::getApplication ()->getUserStateFromRequest ( 'filter.to', 'filter_to', null );
		$this->roundtrip = JFactory::getApplication ()->getUserStateFromRequest ('filter.roundtrip', 'filter_roundtrip', false,'boolean' );
		$this->start = JFactory::getApplication ()->getUserStateFromRequest ( 'filter.start', 'filter_start' );
		
		$this->adult = JFactory::getApplication()->getUserStateFromRequest ( 'filter.adult', 'filter_adult', 1 );
		$this->child = JFactory::getApplication()->getUserStateFromRequest ( 'filter.child', 'filter_child', 0 );
		$this->senior = JFactory::getApplication()->getUserStateFromRequest ( 'filter.senior', 'filter_senior',0 );
		$this->start = DateHelper::createFromFormat ($this->start )->format ( 'Y-m-d' );
		
		$this->end = JFactory::getApplication ()->getUserStateFromRequest ( 'filter.end', 'filter_end' );
		
		if (!$this->roundtrip) {
			$this->end = null;
		} else {
			$this->end = DateHelper::createFromFormat ( $this->end )->format ( 'Y-m-d' );
		}
		$timestamp = strtotime ( $this->start );
		$state = $this->get('State' );
		$state->set ( 'filter.depart_date', $this->start );
		$state->set ( 'filter.from', $from );
		$state->set ( 'filter.to', $to );
		
		if (JFactory::getDate ()->format ( 'Y-m-d' ) == JFactory::getDate ( $this->start )->format ( 'Y-m-d' )) {
			
			$state->set ( 'filter.cutofftime', $config->get ( 'cutofftime' ) );
		}
		$going_trip = $this->get('Items');
	    //var_dump ($this);die;
		//var_dump ($going_trip);die;
		$this->going_trips = $going_trip;
		
		if ($this->roundtrip) {
			
			
			$model=new BookProModelBustrips();
			$state = $model->getState();
			$state->set ( 'filter.depart_date', $this->end );
			$state->set ( 'filter.from', $to );
			$state->set ( 'filter.to', $from );
			if (JFactory::getDate ()->format ( 'Y-m-d' ) == JFactory::getDate ( $this->start )->format ( 'Y-m-d' )) {
				$state->set ( 'filter.cutofftime', $config->get ( 'cutofftime' ) );
			}
			$return_trips = $model->getItems();
			$this->return_trips = $return_trips;
		}
		$this->from_to = BusHelper::getRoutePair ( $from, $to );
		$this->_prepare ();
		parent::display ( $tpl );
	}
	protected function _prepare() {
		$document = JFactory::getDocument ();
		$document->setTitle ( JText::_ ( 'COM_BOOKPRO_SELECT_TRIP' ) );
	}
	private function resetCart(){
	
		JFactory::getApplication()->setUserState('filter.end', '');
		JFactory::getApplication()->setUserState('filter.start', '');
		JFactory::getApplication()->setUserState('filter.roundtrip', '');
		JFactory::getApplication()->setUserState('filter.boarding_id', '');
		JFactory::getApplication()->setUserState('filter.dropping_id', '');
		JFactory::getApplication()->setUserState('filter.return_boarding_id', '');
		JFactory::getApplication()->setUserState('filter.return_dropping_id', '');
		JFactory::getApplication()->setUserState('filter.seat', '');
		JFactory::getApplication()->setUserState('filter.return_seat', '');
	
		JFactory::getApplication()->setUserState('filter.adult', '');
		JFactory::getApplication()->setUserState('filter.child', '');
		JFactory::getApplication()->setUserState('filter.senior', '');
	
	}
}
