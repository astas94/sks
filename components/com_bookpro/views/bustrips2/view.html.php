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
class BookProViewBusTrips2 extends JViewLegacy {
	function display($tpl = null) {
		//JSession::checkToken () or jexit ( 'Invalid Token' );
		$config = JComponentHelper::getParams ( 'com_bookpro' );
		$app = JFactory::getApplication ();
		$this->resetCart();
		//15//19
		$query_arr = $_GET;
		//echo($query_arr["filter_from"]);
		$query_arr["filter_from"]=BusHelper::getIdFromYandexId($query_arr["filter_from"]);
		$query_arr["filter_to"]=BusHelper::getIdFromYandexId($query_arr["filter_to"]);
		$jinput = JFactory::getApplication()->input;
		$jinput->set('filter_from', $query_arr["filter_from"]);
		$jinput->set('filter_to', $query_arr["filter_to"]);
	//	echo($query_arr["filter_from"]);
		//$from = BusHelper::getIdFromYandexId(JFactory::getApplication ()->getUserStateFromRequest ( 'filter.from', 'filter_from' ));
		//$to = BusHelper::getIdFromYandexId(JFactory::getApplication ()->getUserStateFromRequest ( 'filter.to', 'filter_to', null ));
		JFactory::getApplication ()->setUserState ( 'filter.from', '0' );
		JFactory::getApplication ()->setUserState ( 'filter.to', '0' );
		JFactory::getApplication ()->setUserState ('filter.roundtrip', '0' );
		JFactory::getApplication ()->setUserState ( 'filter.start', null );
		JFactory::getApplication ()->setUserState ( 'filter.adult', 1 );
		JFactory::getApplication ()->setUserState ( 'filter.child',  0 );
		JFactory::getApplication()->setUserState ( 'filter.senior', 0 );
		
		//$test=BusHelper::getIdFromYandexId(50);
		//var_dump($test);
		$from =(JFactory::getApplication ()->getUserStateFromRequest ( 'filter.from', 'filter_from' ));
		$to = (JFactory::getApplication ()->getUserStateFromRequest ( 'filter.to', 'filter_to', null ));

		$this->roundtrip = JFactory::getApplication ()->getUserStateFromRequest ('filter.roundtrip', 'filter_roundtrip', false,'boolean' );
		$this->start = JFactory::getApplication ()->getUserStateFromRequest ( 'filter.start', 'filter_start' );
		//echo($to);
		//echo($from);
		$this->adult = JFactory::getApplication()->getUserStateFromRequest ( 'filter.adult', 'filter_adult', 1 );
		$this->child =  JFactory::getApplication()->getUserStateFromRequest ( 'filter.child', 'filter_child', 0 );
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
			
			
			$model=new BookProModelBustrips2();
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
		//$this->prepareDocument();
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
	
	protected function prepareDocument()
	{
		$app   = JFactory::getApplication();
		$menus = $app->getMenu();
		$title = null;
		$this->state	= $this->get('State');
		$this->params	= $this->state->get('params');

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
/*
		if ($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		else
		{
			$this->params->def('page_heading', JText::_('COM_USERS_REGISTRATION'));
		}*/

		$title = $this->params->get('page_title', '');

		if (empty($title))
		{
			$title = $app->get('sitename');
		}
		elseif ($app->get('sitename_pagetitles', 0) == 1)
		{
			$title = JText::sprintf('JPAGETITLE', $app->get('sitename'), $title);
		}
		elseif ($app->get('sitename_pagetitles', 0) == 2)
		{
			$title = JText::sprintf('JPAGETITLE', $title, $app->get('sitename'));
		}

		$this->document->setTitle($title);

		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}
}
