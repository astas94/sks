<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bustrip.php  23-06-2012 23:33:14
 **/
defined ( '_JEXEC' ) or die ( 'Restricted access' );
class TableBusTrip extends JTable {
	
	/**
	 * Construct object.
	 *
	 * @param JDatabaseMySQL $db
	 *        	database connector
	 */
	function __construct(& $db) {
		parent::__construct ( '#__' . PREFIX . '_bustrip', 'id', $db );
	}
	function check() {
		if (! $this->id) {
			$this->created_by = JFactory::getUser ()->id;
		}
		if ($this->id) {
			$this->modified_by = JFactory::getUser ()->id;
		}
		return true;
	}
	
	public function rebuild($parent_id = 0, $left = 0, $level = 0, $path = "") {
		// Get the database object
		$db = $this->_db;
		
		// Get all children of this node
		$db->setQuery ( 'SELECT id FROM ' . $this->_tbl . ' WHERE parent_id=' . ( int ) $parent_id . ' ORDER BY parent_id, id' );
		$children = $db->loadColumn ();
		
		// The right value of this node is the left value + 1
		$right = $left + 1;
		
		// Execute this function recursively over all children
		for($i = 0, $n = count ( $children ); $i < $n; $i ++) {
			// $right is the current right value, which is incremented on recursion return
			$right = $this->rebuild ( $children [$i], $right, $level + 1 );
			
			// If there is an update failure, return false to break out of the recursion
			if ($right === false) {
				return false;
			}
		}
		
		// We've got the left value, and now that we've processed
		// the children of this node we also know the right value
		$db->setQuery ( 'UPDATE ' . $this->_tbl . ' SET lft=' . ( int ) $left . ', rgt=' . ( int ) $right . ', level=' . ( int ) $level . ' WHERE id=' . ( int ) $parent_id );
		
		// If there is an update failure, return false to break out of the recursion
		if (! $db->execute ()) {
			return false;
		}
		
		// Return the right value of this node + 1
		return $right + 1;
	}
	
	
	public function publish($pks = null, $state = 1, $userId = 0) {
	    //die;
		$k = $this->_tbl_key;
		//$k1= 'parent_id';
		//$k2= ''
		// Sanitize input.
		JArrayHelper::toInteger ( $pks );
		$userId = ( int ) $userId;
		$state = ( int ) $state;
		
		// If there are no primary keys set check to see if the instance key is set.
		if (empty ( $pks )) {
			if ($this->$k) {
				$pks = array (
						$this->$k 
				);
			} 			// Nothing to set publishing state on, return false.
			else {
				$this->setError ( JText::_ ( 'JLIB_DATABASE_ERROR_NO_ROWS_SELECTED' ) );
				return false;
			}
		}
		
		// Build the WHERE clause for the primary keys.
		//$where = $k . '=' . implode ( ' OR ' . $k . '=', $pks ) . ' OR parent_id='.$this->_tbl_key.' OR associated_parent_id='.$this->_tbl_key;
		
		$where = $k . '=' . implode ( ' OR ' . $k . '=', $pks ) .' OR parent_id='.implode ( ' OR parent_id=', $pks ) .' OR associated_parent_id=' .implode ( ' OR associated_parent_id=', $pks )  ;
		
		//var_dump ($where);die;
		// Determine if there is checkin support for the table.
		if (! property_exists ( $this, 'checked_out' ) || ! property_exists ( $this, 'checked_out_time' )) {
			$checkin = '';
		} else {
			$checkin = ' AND (checked_out = 0 OR checked_out = ' . ( int ) $userId . ')';
		}
		//echo ('UPDATE ' . $this->_db->quoteName ( $this->_tbl ) . ' SET ' . $this->_db->quoteName ( 'state' ) . ' = ' . ( int ) $state . ' WHERE (' . $where . ')' . $checkin );die;
		
		// Update the publishing state for rows with the given primary keys.
		$this->_db->setQuery ( 'UPDATE ' . $this->_db->quoteName ( $this->_tbl ) . ' SET ' . $this->_db->quoteName ( 'state' ) . ' = ' . ( int ) $state . ' WHERE (' . $where . ')' . $checkin );
		
		try {
			$this->_db->execute ();
		} catch ( RuntimeException $e ) {
			$this->setError ( $e->getMessage () );
			return false;
		}
		
		// If checkin is supported and all rows were adjusted, check them in.
		if ($checkin && (count ( $pks ) == $this->_db->getAffectedRows ())) {
			// Checkin the rows.
			foreach ( $pks as $pk ) {
				$this->checkin ( $pk );
			}
		}
		
		// If the JTable instance value is in the list of primary keys that were set, set the instance.
		if (in_array ( $this->$k, $pks )) {
			$this->state = $state;
		}
		
		$this->setError ( '' );
		return true;
	}
}

?>