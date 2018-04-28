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

$from = 111111; $to = 111111;

		$state = $this->get('State' );
		$state->set ( 'filter.depart_date', $this->start );
		$state->set ( 'filter.from', $from );
		$state->set ( 'filter.to', $to );
		
		if (JFactory::getDate ()->format ( 'Y-m-d' ) == JFactory::getDate ( $this->start )->format ( 'Y-m-d' )) {
			
			$state->set ( 'filter.cutofftime', $config->get ( 'cutofftime' ) );
		}

		$going_trip = $this->get('Items');

//echo "<pre>";print_r($going_trip);echo "</pre>";

		$ii=0;

		if($going_trip)
		{
			foreach($going_trip as $key => $going_trip_element)
			{
				$weekdays = $going_trip_element->weekdays;

				$weekdays = explode(",",$weekdays);

				$start_weekday = JFactory::getDate ( $this->start )->format ( 'N' );

				$bustrip = $going_trip_element->parent_id;

				$db = JFactory::getDbo();
				$query =$db->getQuery(true);
				$query->select('start_time')->from('#__bookpro_bustrip')->where('id='.$db->quote($bustrip));
				$db->setQuery( $query );
				$start_bustrip = $db->loadResult();

				$start_depart = $going_trip_element->start_time;

				$start_bustrip = explode(":",$start_bustrip);
				$start_bustrip = $start_bustrip[0]*3600 + $start_bustrip[1]*60 + $start_bustrip[2];
				$start_depart = explode(":",$start_depart);
				$start_depart = $start_depart[0]*3600 + $start_depart[1]*60 + $start_depart[2];

				if($start_bustrip > $start_depart)
				{
					if($start_weekday == 1) $start_weekday = 7;
					else $start_weekday--;
				}

				if(in_array($start_weekday,$weekdays))
				{
					$new_going_trip[$ii] = $going_trip_element;
					$ii++;
				}

//echo "<pre>";print_r($weekdays);echo "</pre>";
//echo "<pre>";print_r($start_weekday);echo "</pre>";
//echo "<pre>";print_r($bustrip);echo "</pre>";
//echo "<pre>";print_r($start_bustrip);echo "</pre>";
//echo "<pre>";print_r($start_depart);echo "</pre>";

			}

			$going_trip = $new_going_trip;

		}


//echo "<pre>";print_r($going_trip);echo "</pre>";

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

//echo "<pre>";print_r($return_trips);echo "</pre>";

			$ii=0;

			if($return_trips)
			{
				foreach($return_trips as $key => $return_trips_element)
				{
					$weekdays = $return_trips_element->weekdays;
					$weekdays = explode(",",$weekdays);
	
					$start_weekday = JFactory::getDate ( $this->end )->format ( 'N' );
	
					$bustrip = $return_trips_element->parent_id;
	
					$db = JFactory::getDbo();
					$query =$db->getQuery(true);
					$query->select('start_time')->from('#__bookpro_bustrip')->where('id='.$db->quote($bustrip));
					$db->setQuery( $query );
					$start_bustrip = $db->loadResult();
	
					$start_depart = $return_trips_element->start_time;
	
					$start_bustrip = explode(":",$start_bustrip);
					$start_bustrip = $start_bustrip[0]*3600 + $start_bustrip[1]*60 + $start_bustrip[2];
					$start_depart = explode(":",$start_depart);
					$start_depart = $start_depart[0]*3600 + $start_depart[1]*60 + $start_depart[2];
	
					if($start_bustrip > $start_depart)
					{
						if($start_weekday == 1) $start_weekday = 7;
						else $start_weekday--;
					}
	
					if(in_array($start_weekday,$weekdays))
					{
						$new_return_trips[$ii] = $return_trips_element;
						$ii++;

					}
	
//echo "<pre>";print_r($weekdays);echo "</pre>";
//echo "<pre>";print_r($start_weekday);echo "</pre>";
//echo "<pre>";print_r($bustrip);echo "</pre>";
//echo "<pre>";print_r($start_bustrip);echo "</pre>";
//echo "<pre>";print_r($start_depart);echo "</pre>";
	
				}

				$return_trips = $new_return_trips;

			}

//echo "<pre>";print_r($return_trips);echo "</pre>";

			$this->return_trips = $return_trips;
		}

if( ($_POST["filter_from"] >= 100000) && ($_POST["filter_to"] >= 100000) )
{
	$this->from_to = BusHelper::getRoutePair ( 417, 415 );
	$this->from_to[0]->title = "Санкт-Петербург";
	$this->from_to[1]->title = "Санкт-Петербург";
}
else if($_POST["filter_from"] >= 100000)
{
	$this->from_to = BusHelper::getRoutePair ( 415, $to );

	$this->from_to[0]->title = "Санкт-Петербург";
}
else if($_POST["filter_to"] >= 100000)
{
	$this->from_to = BusHelper::getRoutePair ( $from, 415 );

	$this->from_to[1]->title = "Санкт-Петербург";
}
else
{
		$this->from_to = BusHelper::getRoutePair ( $from, $to );
}

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
?>
