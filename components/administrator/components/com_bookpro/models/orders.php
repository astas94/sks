<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: orders.php 56 2012-07-21 07:53:28Z quannv $
 **/
defined ( '_JEXEC' ) or die ( 'Restricted access' );
class BookProModelOrders extends JModelList {
	function __construct() {
		parent::__construct ();
	}
	protected function populateState($ordering = null, $direction = null) {
		AImporter::helper('date');
		// Load the filter state.
		$search = $this->getUserStateFromRequest ( $this->context . '.filter.search', 'filter_search' );
		$this->setState ( 'filter.search', $search );
		
		$pay_status = $this->getUserStateFromRequest ( $this->context . '.filter.pay_status', 'filter_pay_status', null, 'string' );
		$this->setState ( 'filter.pay_status', $pay_status );
		
		$order_status = $this->getUserStateFromRequest ( $this->context . '.filter.order_status', 'filter_order_status', null, 'string' );
		$this->setState ( 'filter.order_status', $order_status );
		
		$user_id = $this->getUserStateFromRequest ( $this->context . '.filter.user_id', 'filter_user_id', null, 'int' );
		$this->setState ( 'filter.user_id', $user_id );
		
		$group_id = $this->getUserStateFromRequest ( $this->context . '.filter.group_id', 'filter_group_id', null, 'int' );
		$this->setState ( 'filter.group_id', $group_id );
		
		$range = $this->getUserStateFromRequest ( $this->context . '.filter.range', 'filter_range', null, 'string' );
		$this->setState ( 'filter.range', $range );
		
		
		$from_date = $this->getUserStateFromRequest ( $this->context . '.filter.from_date', 'filter_from_date', null, 'string' );
		
		$this->setState ( 'filter.from_date', $from_date );
		
		$to_date = $this->getUserStateFromRequest ( $this->context . '.filter.to_date', 'filter_to_date', null, 'string' );
		
		
		$this->setState ( 'filter.to_date', $to_date );
		
		$date_type = $this->getUserStateFromRequest ( $this->context . '.filter.date_type', 'filter_date_type', null, 'int' );
		$this->setState ( 'filter.date_type', $date_type );
		
		parent::populateState ( 'a.created', 'DESC' );
	}
	function getListQuery() {
		AImporter::helper('date');
		$db = $this->getDbo ();
		
		$gQuery = $db->getQuery ( true );
		$gQuery->select ( $db->qn('start' ));
		$gQuery->from ( '#__bookpro_passenger' );
		$gQuery->where ( array ('order_id=a.id' 
		));
		$gQuery->order ( 'start ASC limit 0,1' );
		
		$query = $db->getQuery ( true );
		$query->select ( 'a.*,CONCAT(`c`.`firstname`," ",`c`.`lastname`) AS ufirstname, c.firstname,c.lastname,c.email,(' . $gQuery . ') AS depart' );
		$query->from ( '#__bookpro_orders AS a' );
		$query->leftJoin ( '#__bookpro_customer AS c ON c.id=a.user_id' );
		//$query->innerJoin ( '#__bookpro_passenger AS p ON p.order_id=a.id' );
		
		// Filter by search in title
		$search = $this->getState ( 'filter.search' );
		if (! empty ( $search )) {
			if (stripos ( $search, 'id:' ) === 0) {
				$query->where ( 'a.id = ' . ((int)substr ( $search, 3 )));
			} else {
				$search = $db->quote ( '%' . $db->escape ( $search, true ) . '%' );
				$query->where ( '(c.firstname LIKE ' . $search . '  OR c.lastname LIKE ' . $search . ')' );
			}
		}
		
		//$group_id = $this->getState ( 'filter.group_id' );
		
		//if ($group_id) {
			$user_id = $this->getState ( 'filter.user_id' );
			if ($user_id) {
				$query->where ( 'a.user_id=' . $user_id );
			}
		//}
		$pay_status = $this->getState ( 'filter.pay_status' );
		if ($pay_status) {
			$query->where ( 'a.pay_status LIKE ' . $db->quote ( '%' . $pay_status . '%' ) );
		}
		
		$order_status = $this->getState ( 'filter.order_status' );
		if ($order_status) {
			$query->where ( 'a.order_status LIKE ' . $db->quote ( '%' . $order_status . '%' ) );
		}
		
		$type = $this->getState ( 'filter.type' );
		if ($type) {
			$query->where ( 'a.type=' . $db->quote ( $type ) );
		}
		
		$range = $this->getState ( 'filter.range' );
		
		$from_date = $this->getState ( 'filter.from_date');
		
		if ($from_date){
				
			$from_date = JFactory::getDate(DateHelper::createFromFormat($from_date)->getTimestamp())->toSql();
				
		}
		$to_date = $this->getState ( 'filter.to_date' );
		if ($to_date){
			$to_date = JFactory::getDate(DateHelper::createFromFormat($to_date)->getTimestamp())->toSql();
		}
		
		//
		
		// Apply the range filter.
		if ($range) {
			// Get UTC for now.
			$dNow = new JDate ();
			$dStart = clone $dNow;
			
			switch ($range) {
				case 'past_week' :
					$dStart->modify ( '-7 day' );
					break;
				
				case 'past_1month' :
					$dStart->modify ( '-1 month' );
					break;
				
				case 'past_3month' :
					$dStart->modify ( '-3 month' );
					break;
				
				case 'past_6month' :
					$dStart->modify ( '-6 month' );
					break;
				
				case 'today' :
					// Ranges that need to align with local 'days' need special treatment.
					$app = JFactory::getApplication ();
					$offset = $app->get ( 'offset' );
					
					// Reset the start time to be the beginning of today, local time.
					$dStart = new JDate ( 'now', $offset );
					$dStart->setTime ( 0, 0, 0 );
					
					// Now change the timezone back to UTC.
					$tz = new DateTimeZone ( 'GMT' );
					$dStart->setTimezone ( $tz );
					break;
			}
			
			if ($this->getState ( 'filter.date_type' )) {
				$query->where ( 'a.created >= ' . $db->quote ( $dStart->format ( 'Y-m-d H:i:s' ) ) . ' AND a.created <=' . $db->quote ( $dNow->format ( 'Y-m-d H:i:s' ) ) );
			} else {
				$query->having ( 'depart >= ' . $db->quote ( $dStart->format ( 'Y-m-d H:i:s' ) ) . ' AND p.depart <=' . $db->quote ( $dNow->format ( 'Y-m-d H:i:s' ) ) );
			}
		}else if($from_date && $to_date ){
			
			$from_date=JFactory::getDate($from_date);
			$to_date=JFactory::getDate($to_date);
			
			if ($this->getState ( 'filter.date_type' )) {
				$query->where ( 'a.created >= ' . $db->quote ( $from_date->format ( 'Y-m-d H:i:s' ) ) . ' AND a.created <=' . $db->quote ( $to_date->format ( 'Y-m-d H:i:s' ) ) );
			} else {
				$query->having ( 'depart >= ' . $db->quote ( $from_date->format ( 'Y-m-d H:i:s' ) ) . ' AND depart <=' . $db->quote ( $to_date->format ( 'Y-m-d H:i:s' ) ) );
			}
			
		}
		
		$orderCol = $this->state->get ( 'list.ordering', 'created' );
		$orderDirn = $this->state->get ( 'list.direction', 'DESC' );
		if (empty ( $orderCol ))
			$orderCol = 'id';
		if (empty ( $orderDirn ))
			$orderDirn = 'DESC';
		$query->order ( $db->escape ( $orderCol . ' ' . $orderDirn ) );
		//$query->group ( 'a.id' );
		//echo $query->dump();
		return $query;
	}
	
	
	
	function getByOrderNumber($number) {
		$query = 'SELECT `obj`.* FROM `' . $this->_table->getTableName () . '` AS `obj` ';
		$query .= 'WHERE `obj`.`order_number` = ' . (int) $number;
		$this->_db->setQuery ( $query );
		
		if (($object = &$this->_db->loadObject ())) {
			$this->_table->bind ( $object );
			return $this->_table;
		}
		
		return parent::getObject ();
	}
}

?>