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
class BookProModelBusTrips extends JModelList {
	function __construct() {
		if (empty ( $config ['filter_fields'] )) {
			$config ['filter_fields'] = array (
					'id',
					'l.id',
					'state',
					'l.state' 
			);
		}
		parent::__construct ( $config );
	}
	protected function populateState($ordering = null, $direction = null) {
		$from = $this->getUserStateFromRequest ( $this->context . '.filter.from', 'filter_from' );
		$this->setState ( 'filter.from', $from );
		
		$to = $this->getUserStateFromRequest ( $this->context . '.filter.to', 'filter_to' );
		$this->setState ( 'filter.to', $to );
		
		$bus_id = $this->getUserStateFromRequest ( $this->context . '.filter.bus_id', 'filter_bus_id' );
		$this->setState ( 'filter.bus_id', $bus_id );
		
		$agent_id = $this->getUserStateFromRequest ( $this->context . '.filter.agent_id', 'filter_agent_id' );
		$this->setState ( 'filter.agent_id', $agent_id );
		
		$depart_date = $this->getUserStateFromRequest ( $this->context . '.filter.depart_date', 'filter_depart_date' );
		$this->setState ( 'filter.depart_date', $depart_date );
		
		parent::populateState ( 'bustrip.lft', 'ASC' );
	}
	function getListQuery() {
	    //var_dump($this->getState('test'));die;
		$query = null;
		
		$db = $this->getDbo ();
		
		$subQuery = $db->getQuery ( true );
		$subQuery->select ( 'p.adult' );
		$subQuery->from ( '#__bookpro_roomrate AS p' );
		$subQuery->where ( 'p.date >= ' . $db->quote ( JFactory::getDate ()->toSql () ) );
		$subQuery->where ( 'p.room_id=bustrip.id' );
		$subQuery->order ( 'p.adult asc limit 0,1' );
		
		$query = $db->getQuery ( true );
		
		// get table name
		$airportTable = $db->quoteName ( '#__bookpro_dest' );
		
		$query->select ( array (
				'bustrip.*,agent.brandname,agent.company,seattemplate.id AS seattemplate_id,seattemplate.block_layout AS block_layout',
				'bus.title AS bus_name',
				'seattemplate.title AS seattemplate_title',
				'dest1.code AS from_code',
				'dest2.code AS to_code',
				'dest1.title AS fromName',
				'dest2.title AS toName',
				'agent.image AS agent_logo',
				'CONCAT(dest1.title,' . $db->quote ( '-' ) . ',dest2.title) AS title' 
		) );
		
		$query->from ( '#__bookpro_bustrip AS bustrip' );
		$query->join ( 'left', $airportTable . ' AS dest1' . ' ON bustrip.from = dest1.id ' );
		$query->join ( 'left', $airportTable . ' AS dest2' . ' ON bustrip.to = dest2.id ' );
		$query->join ( 'left', '#__bookpro_agent AS agent ON agent.id = bustrip.agent_id ' );
		$query->join ( 'left', '#__bookpro_bus AS bus ON bus.id = bustrip.bus_id ' );
		$query->join ( 'left', '#__bookpro_bus_seattemplate AS seattemplate ON bus.seattemplate_id = seattemplate.id ' );
		
		// $query->where('1=1')->append('EXISTS ('.$subQuery.')');
		$depart_date = $this->getState ( 'filter.depart_date' );
		if (! empty ( $depart_date )) {
			$query->innerJoin ( '#__bookpro_roomrate AS r ON r.room_id=bustrip.id' );
			$query->where ( '(r.date = ' . $db->quote ( JFactory::getDate ( $depart_date )->toSql () ) . ')' );
		}
		
		$from = $this->getState ( 'filter.from' );
		if (! empty ( $from )) {
			$query->where ( '(bustrip.from = ' . ( int ) $from . ')' );
		}
		$to = $this->getState ( 'filter.to' );
		if (! empty ( $to )) {
			$query->where ( '(bustrip.to = ' . ( int ) $to . ')' );
		}
		$bus_id = $this->getState ( 'filter.bus_id' );
		if (! empty ( $bus_id )) {
			$query->where ( '(bustrip.bus_id = ' . ( int ) $bus_id . ')' );
		}
		
		$agent_id = $this->getState ( 'filter.agent_id' );
		if (! empty ( $agent_id )) {
			$query->where ( '(bustrip.agent_id = ' . ( int ) $agent_id . ')' );
		}
		
		$query->where ( '(bustrip.parent_id = ' . 0 . ')' );
		
		if ($this->getState('test')==1){
		    $query->where ( '(bustrip.associated_parent_id = ' . 0 . ')' );
		}
		$orderCol = $this->state->get ( 'list.ordering' );
		$orderDirn = $this->state->get ( 'list.direction' );
		if (empty ( $orderCol ) || empty ( $orderDirn )) {
			$orderCol = 'bustrip.start';
			$orderCol = 'bustrip.code';
			$orderDirn = 'ASC';
		}
		$query->order ( $db->escape ( $orderCol . ' ' . $orderDirn ) );
		$query->group ( 'bustrip.id' );
		//var_dump($query);
		return $query;
	}
	function getItems() {
	    //die;
		$items = parent::getItems ();
		//var_dump (parent);die;
		if ($this->getState ( 'filter.price' )) {
			
			foreach ( $items as $item ) {
				
				$db = $this->getDbo ();
				
				$subQuery = $db->getQuery ( true );
				$subQuery->select ( 'min(p.adult)' );
				$subQuery->from ( '#__bookpro_roomrate AS p' );
				$subQuery->where ( 'p.date >= ' . $db->quote ( JFactory::getDate ()->toSql () ) );
				$subQuery->where ( 'p.room_id=' . $item->id );
				// $subQuery->order ( 'p.adult asc limit 0,1' );
				$db->setQuery ( $subQuery );
				$item->price = $db->loadResult ();
			}
		}
		return $items;
	}
	function getFullData() {
		$bustrips = $this->getData ();
		for($i = 0; $i < count ( $bustrips ); $i ++) {
			
			$query = $this->_db->getQuery ( true );
			$query->select ( 'b.*,d.title AS title' )->from ( '#__bookpro_busstation AS b' );
			$query->leftJoin ( '#__bookpro_dest AS d ON d.id=b.dest_id' );
			$query->where ( 'b.bustrip_id=' . $bustrips [$i]->id )->order ( 'ordering ASC' );
			$this->_db->setQuery ( $query );
			$stations = $this->_db->loadObjectList ();
			$bustrips [$i]->stations = $stations;
		}
		return $bustrips;
	}
}

?>