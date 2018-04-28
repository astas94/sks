<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: rooms.php 48 2012-07-13 14:13:31Z quannv $
 **/
defined ( '_JEXEC' ) or die ( 'Restricted access' );
class BookProModelRoomRateLogs extends JModelList {
	function getListQuery() {
		$db = $this->getDbo ();
		
		$query = $db->getQuery ( true );
		$query->select ( 'a.*' );
		$query->from ( '#__bookpro_roomratelog AS a' );
		$query->innerJoin ( '#__bookpro_bustrip AS b ON b.id=a.room_id');
		
		$query->select ( 'dest1.title AS from_name' );
		$query->join ( 'LEFT', '#__bookpro_dest AS dest1 ON b.from = dest1.id' );
		$query->select ( 'dest2.title AS to_name' );
		$query->join ( 'LEFT', '#__bookpro_dest AS dest2 ON b.to = dest2.id' );
		
		if ($this->getState ( 'filter.room_id' ))
			$query->where ( 'a.room_id=' . $this->getState ( 'filter.room_id' ) );
		
		$orderCol = $this->state->get ( 'list.ordering', 'id' );
		$orderDirn = $this->state->get ( 'list.direction', 'DESC' );
		if (empty ( $orderCol ))
			$orderCol = 'id';
		if (empty ( $orderDirn ))
			$orderDirn = 'DESC';
		$query->order ( $db->escape ( $orderCol . ' ' . $orderDirn ) );
		return $query;
	}
	protected function populateState($ordering = null, $direction = null) {
		$room_id = $this->getUserStateFromRequest ( $this->context . '.filter.room_id', 'filter_room_id' );
		$this->setState ( 'filter.room_id', $room_id );
		
		
		
		parent::populateState ( 'a.id', 'ASC' );
	}
	function getRoomsByIDs($Ids) {
		$tid = implode ( ',', $Ids );
		$query = 'SELECT `obj`.* ';
		$query .= 'FROM `' . $this->_table->getTableName () . '` AS `obj` ';
		$query .= 'WHERE id IN (' . $tid . ')';
		return $this->_getList ( $query );
	}
}

?>